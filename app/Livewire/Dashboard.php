<?php

namespace App\Livewire;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\Discussion;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public bool $isDosen = false;

    public function mount(): void
    {
        $this->isDosen = Auth::user()->hasRole('dosen');
    }

    public function render()
    {
        $user = Auth::user();

        if ($this->isDosen) {
            return $this->renderDosenDashboard($user);
        }

        return $this->renderMahasiswaDashboard($user);
    }

    private function renderDosenDashboard($user)
    {
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

        $recentCourses = $user->taughtCourses()
            ->withCount('students')
            ->latest()
            ->take(5)
            ->get();

        $pendingGrading = Submission::whereNull('score')
            ->whereIn('assignment_id', Assignment::whereIn('course_id', $taughtCourseIds)->pluck('id'))
            ->with(['assignment.course', 'student'])
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.dashboard', compact('stats', 'recentCourses', 'pendingGrading'))
            ->layout('components.layouts.app');
    }

    private function renderMahasiswaDashboard($user)
    {
        $enrolledCourseIds = $user->enrolledCourses()->pluck('courses.id')->toArray();
        $submittedAssignmentIds = $user->submissions()->pluck('assignment_id')->toArray();

        $stats = [
            'enrolled_courses' => $user->enrolledCourses()->count(),
            'completed_assignments' => count($submittedAssignmentIds),
            'pending_assignments' => Assignment::whereIn('course_id', $enrolledCourseIds)
                ->whereNotIn('id', $submittedAssignmentIds)
                ->count(),
        ];

        $enrolledCourses = $user->enrolledCourses()
            ->with('lecturer')
            ->take(5)
            ->get();

        $upcomingAssignments = Assignment::whereIn('course_id', $enrolledCourseIds)
            ->whereNotIn('id', $submittedAssignmentIds)
            ->where('deadline', '>', now())
            ->with('course')
            ->orderBy('deadline')
            ->take(5)
            ->get();

        $recentDiscussions = Discussion::whereIn('course_id', $enrolledCourseIds)
            ->with(['course', 'user'])
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.dashboard', compact('stats', 'enrolledCourses', 'upcomingAssignments', 'recentDiscussions'))
            ->layout('components.layouts.app');
    }
}
