<?php

namespace App\Livewire\Courses;

use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{
    public Course $course;

    public bool $isEnrolled = false;

    public bool $isDosen = false;

    public bool $isTeaching = false;

    public function mount(int $id): void
    {
        $this->course = Course::with(['lecturer', 'materials', 'assignments', 'students'])
            ->withCount(['materials', 'assignments', 'students'])
            ->findOrFail($id);

        $user = Auth::user();
        $this->isDosen = $user->hasRole('dosen');

        if ($this->isDosen) {
            $this->isTeaching = $this->course->lecturer_id === $user->id;
            abort_if(! $this->isTeaching, 403);
        } else {
            $this->isEnrolled = $user->enrolledCourses()
                ->where('course_id', $this->course->id)
                ->exists();
            abort_if(! $this->isEnrolled, 403);
        }
    }

    public function enroll(): void
    {
        $user = Auth::user();

        if ($user->hasRole('dosen')) {
            session()->flash('error', 'Dosen tidak dapat enroll ke course.');

            return;
        }

        if ($this->isEnrolled) {
            session()->flash('error', 'Anda sudah enroll di course ini.');

            return;
        }

        $user->enrolledCourses()->attach($this->course->id);
        $this->isEnrolled = true;
        $this->course->loadCount('students');

        session()->flash('success', 'Berhasil enroll di '.$this->course->name.'.');
    }

    public function render()
    {
        $user = Auth::user();

        $submittedAssignmentIds = [];
        if (! $this->isDosen && $this->isEnrolled) {
            $submittedAssignmentIds = $user->submissions()
                ->whereIn('assignment_id', $this->course->assignments->pluck('id'))
                ->pluck('assignment_id')
                ->toArray();
        }

        return view('livewire.courses.show', [
            'submittedAssignmentIds' => $submittedAssignmentIds,
        ])->layout('components.layouts.app');
    }
}
