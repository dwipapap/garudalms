<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('lecturer')->get();
        return response()->json([
            'message' => 'Courses retrieved successfully',
            'data' => $courses
        ]);
    }

    public function store(Request $request)
    {
        if ($request->user()->role !== 'dosen') {
            return response()->json([
                'message' => 'bukan dosen luwh, gaboleh'
            ], 403);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        $course = Course::create([
            'name' => $request->name,
            'description' => $request->description,
            'lecturer_id' => $request->user()->id,
        ]);
        return response()->json([
            'message' => 'course dibuat',
            'data' => $course
         ], 201);
    }
    //update course
    public function update(Request $request, $id)
    {
        $course = Course::find($id);
        if (!$course) {
            return response()->json([
                'message' => 'Course not found'
            ], 404);
    }
    if ($request->user()->role !== 'dosen' || $course->lecturer_id !== $request->user()->id) {
        return response()->json([
            'message' => 'gaboleh'
        ], 403);
    }
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);
    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422);

}
    $course->update($request->all());
        return response()->json([
            'message' => 'Course updated successfully',
            'data' => $course
        ]);
        }
    //delete course
    public function destroy(Request $request, $id)
    {
        $course = Course::find($id);
        if (!$course) {
            return response()->json([
                'message' => 'Course not found'
            ], 404); }

        if ($request->user()->role !== 'dosen' || $course->lecturer_id !== $request->user()->id) {
            return response()->json([
                'message' => 'error, cumna boleh  delete courses punya kamu sendiri'
            ], 403); }
            $course->delete();
            return response()->json([
                'message' => 'Course deleted successfully'
            ]);
        }

    //enroll student to course
    public function enroll(Request $request, $id)
    {
              if ($request->user()->role !== 'mahasiswa') {
            return response()->json([
                'message' => 'Cuma mahasewa boleh enroll'
            ], 403);
        }

        $course = Course::find($id);

        if (!$course) {
            return response()->json([
                'message' => 'Course not found'
            ], 404);
        }

        if ($course->students()->where('student_id', $request->user()->id)->exists()) {
            return response()->json([
                'message' => 'kamu sudah terdaftar di course ini'
            ], 400);
        }

        $course->students()->attach($request->user()->id);

        return response()->json([
            'message' => 'Successfully enrolled in course',
            'data' => $course
        ]);
    }  
    }