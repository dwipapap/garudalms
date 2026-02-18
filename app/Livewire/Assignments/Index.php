<?php

namespace App\Livewire\Assignments;

use App\Models\Assignment;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    public function render()
    {
        $user = Auth::user();
        $isDosen = $user->hasRole('dosen');

        $assignments = Assignment::query()
            ->with(['course.lecturer'])
            ->withCount('submissions')
            ->when($isDosen, function ($query) use ($user) {
                $query->whereHas('course', function ($q) use ($user) {
                    $q->where('lecturer_id', $user->id);
                });
            })
            ->when(! $isDosen, function ($query) use ($user) {
                $enrolledCourseIds = $user->enrolledCourses()->pluck('courses.id');
                $query->whereIn('course_id', $enrolledCourseIds);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%'.$this->search.'%')
                        ->orWhereHas('course', function ($cq) {
                            $cq->where('name', 'like', '%'.$this->search.'%');
                        });
                });
            })
            ->orderBy('deadline', 'desc')
            ->paginate(10);

        $submittedAssignmentIds = [];
        if (! $isDosen) {
            $submittedAssignmentIds = $user->submissions()
                ->whereIn('assignment_id', $assignments->pluck('id'))
                ->pluck('assignment_id')
                ->toArray();
        }

        return view('livewire.assignments.index', [
            'assignments' => $assignments,
            'isDosen' => $isDosen,
            'submittedAssignmentIds' => $submittedAssignmentIds,
        ])->layout('components.layouts.app');
    }
}
