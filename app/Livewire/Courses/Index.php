<?php

namespace App\Livewire\Courses;

use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    public function enroll(int $courseId): void
    {
        $user = Auth::user();

        abort_if($user->hasRole('dosen'), 403, 'Dosen tidak dapat enroll ke course.');

        $course = Course::findOrFail($courseId);

        if ($user->enrolledCourses()->where('course_id', $courseId)->exists()) {
            session()->flash('error', 'Anda sudah enroll di course ini.');

            return;
        }

        $user->enrolledCourses()->attach($courseId);

        session()->flash('success', 'Berhasil enroll di '.$course->name.'.');
    }

    public function render()
    {
        $user = Auth::user();
        $enrolledCourseIds = $user->enrolledCourses()->pluck('courses.id')->toArray();

        $courses = Course::query()
            ->with(['lecturer'])
            ->withCount('students')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('description', 'like', '%'.$this->search.'%')
                        ->orWhereHas('lecturer', function ($lq) {
                            $lq->where('name', 'like', '%'.$this->search.'%');
                        });
                });
            })
            ->orderBy('name')
            ->paginate(12);

        return view('livewire.courses.index', [
            'courses' => $courses,
            'enrolledCourseIds' => $enrolledCourseIds,
        ])->layout('components.layouts.app');
    }
}
