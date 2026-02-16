<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function courseStats()
    {
        $stats = Course::withCount('students')
            ->with('lecturer:id,name')
            ->get()
            ->map(function ($course) {
                return [
                    'course_id' => $course->id,
                    'course_name' => $course->name,
                    'lecturer' => $course->lecturer->name,
                    'total_students' => $course->students_count,
                ];
            });

        return response()->json([
            'message' => 'Course statistics retrieved successfully',
            'data' => $stats
        ]);
    }

    public function assignmentStats()
    {
        $totalAssignments = Assignment::count();
        
        $gradedSubmissions = Submission::whereNotNull('score')->count();
        $ungradedSubmissions = Submission::whereNull('score')->count();
        
        $assignmentDetails = Assignment::withCount([
            'submissions as total_submissions',
            'submissions as graded_count' => function ($query) {
                $query->whereNotNull('score');
            },
            'submissions as ungraded_count' => function ($query) {
                $query->whereNull('score');
            }
        ])->with('course:id,name')->get();

        return response()->json([
            'message' => 'Assignment statistics retrieved successfully',
            'summary' => [
                'total_assignments' => $totalAssignments,
                'total_submissions' => $gradedSubmissions + $ungradedSubmissions,
                'graded_submissions' => $gradedSubmissions,
                'ungraded_submissions' => $ungradedSubmissions,
            ],
            'data' => $assignmentDetails->map(function ($assignment) {
                return [
                    'assignment_id' => $assignment->id,
                    'title' => $assignment->title,
                    'course' => $assignment->course->name,
                    'total_submissions' => $assignment->total_submissions,
                    'graded' => $assignment->graded_count,
                    'ungraded' => $assignment->ungraded_count,
                ];
            })
        ]);
    }

    public function studentStats($id)
    {
        $student = User::where('id', $id)->where('role', 'mahasiswa')->first();

        if (!$student) {
            return response()->json([
                'message' => 'Student not found'
            ], 404);
        }

        $submissions = Submission::where('student_id', $id)
            ->with('assignment:id,title,course_id')
            ->get();

        $totalSubmissions = $submissions->count();
        $gradedSubmissions = $submissions->whereNotNull('score');
        $ungradedCount = $submissions->whereNull('score')->count();
        
        $averageScore = $gradedSubmissions->avg('score');
        $highestScore = $gradedSubmissions->max('score');
        $lowestScore = $gradedSubmissions->min('score');

        return response()->json([
            'message' => 'Student statistics retrieved successfully',
            'student' => [
                'id' => $student->id,
                'name' => $student->name,
                'email' => $student->email,
            ],
            'summary' => [
                'total_submissions' => $totalSubmissions,
                'graded' => $gradedSubmissions->count(),
                'ungraded' => $ungradedCount,
                'average_score' => $averageScore ? round($averageScore, 2) : null,
                'highest_score' => $highestScore,
                'lowest_score' => $lowestScore,
            ],
            'submissions' => $submissions->map(function ($submission) {
                return [
                    'assignment_id' => $submission->assignment_id,
                    'assignment_title' => $submission->assignment->title,
                    'score' => $submission->score,
                    'status' => $submission->score !== null ? 'Graded' : 'Pending',
                    'submitted_at' => $submission->created_at,
                ];
            })
        ]);
    }
}