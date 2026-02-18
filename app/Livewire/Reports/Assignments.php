<?php

namespace App\Livewire\Reports;

use App\Models\Assignment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Assignments extends Component
{
    use WithPagination;

    public function render()
    {
        $user = Auth::user();

        if (! $user->hasRole('dosen')) {
            abort(403);
        }

        $taughtCourseIds = $user->taughtCourses()->pluck('id')->toArray();

        $assignments = Assignment::whereIn('course_id', $taughtCourseIds)
            ->with('course')
            ->withCount([
                'submissions as total_submissions',
                'submissions as graded_submissions' => function ($query) {
                    $query->whereNotNull('score');
                },
            ])
            ->get()
            ->map(function ($assignment) {
                $pendingSubmissions = $assignment->total_submissions - $assignment->graded_submissions;
                $percentageGraded = $assignment->total_submissions > 0
                    ? round(($assignment->graded_submissions / $assignment->total_submissions) * 100, 2)
                    : 0;

                return [
                    'id' => $assignment->id,
                    'title' => $assignment->title,
                    'course' => $assignment->course,
                    'total_submissions' => $assignment->total_submissions,
                    'graded' => $assignment->graded_submissions,
                    'pending' => $pendingSubmissions,
                    'percentage_graded' => $percentageGraded,
                ];
            });

        return view('livewire.reports.assignments', compact('assignments'))
            ->layout('components.layouts.app');
    }
}
