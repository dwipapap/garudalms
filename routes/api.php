<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\MaterialController;
use App\Http\Controllers\Api\AssignmentSubmissionController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Any authenticated user
    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/materials/{id}/download', [MaterialController::class, 'download']);

    // Dosen
    Route::middleware('role:dosen')->group(function () {
        Route::post('/courses', [CourseController::class, 'store']);
        Route::put('/courses/{id}', [CourseController::class, 'update']);
        Route::delete('/courses/{id}', [CourseController::class, 'destroy']);
        Route::post('/materials', [MaterialController::class, 'store']);
        Route::post('/assignments', [AssignmentSubmissionController::class, 'createAssignment']);
        Route::put('/submissions/{id}/grade', [AssignmentSubmissionController::class, 'gradeSubmission']);
    });

    // Mahasiswa
    Route::middleware('role:mahasiswa')->group(function () {
        Route::post('/courses/{id}/enroll', [CourseController::class, 'enroll']);
        Route::post('/submissions', [AssignmentSubmissionController::class, 'submitAssignment']);
    });
});