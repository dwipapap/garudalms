<?php

namespace App\Livewire\Reports;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $user = Auth::user();

        if (! $user->hasRole('dosen')) {
            abort(403);
        }

        $taughtCourseIds = $user->taughtCourses()->pluck('id')->toArray();

        $stats = [
            'total_courses' => $user->taughtCourses()->count(),
            'total_students' => Course::where('lecturer_id', $user->id)
                ->withCount('students')
                ->get()
                ->sum('students_count'),
            'pending_submissions' => Submission::whereNull('score')
                ->whereIn('assignment_id', Assignment::whereIn('course_id', $taughtCourseIds)->pluck('id'))
                ->count(),
        ];

        return view('livewire.reports.index', compact('stats'))
            ->layout('components.layouts.app');
    }
}
