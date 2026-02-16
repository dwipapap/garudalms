<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MaterialController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,txt,zip|max:10240', // 10MB max
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
                'message' => 'Forbidden. You can only upload to your own courses.'
            ], 403);
        }

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('materials', $fileName, 'public');

        $material = Material::create([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'file_path' => $filePath,
        ]);

        return response()->json([
            'message' => 'Material uploaded successfully',
            'data' => $material
        ], 201);
    }

// Dpwmnload material
    public function download(Request $request, $id)
    {
        $material = Material::find($id);

        if (!$material) {
            return response()->json([
                'message' => 'Material not found'
            ], 404);
        }

        $user = $request->user();
        $course = $material->course;

        if ($user->role === 'mahasiswa') {
            if (!$course->students()->where('student_id', $user->id)->exists()) {
                return response()->json([
                    'message' => 'Forbidden. You must be enrolled in this course.'
                ], 403);
            }
        } elseif ($user->role === 'dosen') {
            if ($course->lecturer_id !== $user->id) {
                return response()->json([
                    'message' => 'Forbidden. This is not your course.'
                ], 403);
            }
        }

        if (!Storage::disk('public')->exists($material->file_path)) {
            return response()->json([
                'message' => 'File not found on server'
            ], 404);
        }

        $filePath = Storage::disk('public')->path($material->file_path);

        return response()->download($filePath, basename($material->file_path));
    }
}