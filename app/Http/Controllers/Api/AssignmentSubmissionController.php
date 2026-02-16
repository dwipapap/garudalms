<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AssignmentSubmissionController extends Controller
{
// Assignments
    public function createAssignment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date|after:now',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $course = Course::find($request->course_id);

        if ($course->lecturer_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Forbidden. You can only create assignments in your own courses.'
            ], 403);
        }

        $assignment = Assignment::create([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
        ]);

        return response()->json([
            'message' => 'Assignment created successfully',
            'data' => $assignment
        ], 201);
    }

//submit assignment
    public function submitAssignment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'assignment_id' => 'required|exists:assignments,id',
            'file' => 'required|file|mimes:pdf,doc,docx,txt,zip|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $assignment = Assignment::find($request->assignment_id);
        $course = $assignment->course;

        if (!$course->students()->where('student_id', $request->user()->id)->exists()) {
            return response()->json([
                'message' => 'Forbidden. You must be enrolled in this course.'
            ], 403);
        }

        $existingSubmission = Submission::where('assignment_id', $request->assignment_id)
            ->where('student_id', $request->user()->id)
            ->first();

        if ($existingSubmission) {
            return response()->json([
                'message' => 'You have already submitted this assignment.'
            ], 400);
        }

        if (now()->greaterThan($assignment->deadline)) {
            return response()->json([
                'message' => 'Submission deadline has passed.'
            ], 400);
        }

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('submissions', $fileName, 'public');

        $submission = Submission::create([
            'assignment_id' => $request->assignment_id,
            'student_id' => $request->user()->id,
            'file_path' => $filePath,
            'score' => null,
        ]);

        return response()->json([
            'message' => 'Assignment submitted successfully',
            'data' => $submission
        ], 201);
    }

//grade submission
    public function gradeSubmission(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'score' => 'required|integer|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $submission = Submission::find($id);

        if (!$submission) {
            return response()->json([
                'message' => 'Submission not found'
            ], 404);
        }

        $course = $submission->assignment->course;

        if ($course->lecturer_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Forbidden. You can only grade submissions in your own courses.'
            ], 403);
        }

        $submission->update([
            'score' => $request->score,
        ]);

        return response()->json([
            'message' => 'Submission graded successfully',
            'data' => $submission
        ]);
    }
}