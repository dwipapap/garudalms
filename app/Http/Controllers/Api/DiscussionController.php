<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Discussion;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiscussionController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $course = Course::find($request->course_id);
        $user = $request->user();

        if ($user->role === 'dosen' && $course->lecturer_id !== $user->id) {
            return response()->json([
                'message' => 'Forbidden. You can only discuss in your own courses.'
            ], 403);
        }

        if ($user->role === 'mahasiswa' && !$course->students()->where('student_id', $user->id)->exists()) {
            return response()->json([
                'message' => 'Forbidden. You must be enrolled in this course.'
            ], 403);
        }

        $discussion = Discussion::create([
            'course_id' => $request->course_id,
            'user_id' => $user->id,
            'content' => $request->content,
        ]);

        return response()->json([
            'message' => 'Discussion created successfully',
            'data' => $discussion->load('user')
        ], 201);
    }

    public function reply(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $discussion = Discussion::find($id);

        if (!$discussion) {
            return response()->json([
                'message' => 'Discussion not found'
            ], 404);
        }

        $course = $discussion->course;
        $user = $request->user();

        // Check access: Dosen must own course, Mahasiswa must be enrolled
        if ($user->role === 'dosen' && $course->lecturer_id !== $user->id) {
            return response()->json([
                'message' => 'Forbidden. You can only reply in your own courses.'
            ], 403);
        }

        if ($user->role === 'mahasiswa' && !$course->students()->where('student_id', $user->id)->exists()) {
            return response()->json([
                'message' => 'Forbidden. You must be enrolled in this course.'
            ], 403);
        }

        $reply = Reply::create([
            'discussion_id' => $id,
            'user_id' => $user->id,
            'content' => $request->content,
        ]);

        return response()->json([
            'message' => 'Reply added successfully',
            'data' => $reply->load('user')
        ], 201);
    }
}