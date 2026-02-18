<?php

namespace App\Livewire\Assignments;

use App\Models\Assignment;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    #[Validate('required|exists:courses,id')]
    public string $course_id = '';

    #[Validate('required|max:255')]
    public string $title = '';

    #[Validate('required')]
    public string $description = '';

    #[Validate('required|date|after:now')]
    public string $deadline = '';

    public function save(): void
    {
        $this->validate();

        $course = Course::findOrFail($this->course_id);
        abort_if($course->lecturer_id !== Auth::id(), 403, 'You are not the lecturer of this course.');

        Assignment::create([
            'course_id' => $this->course_id,
            'title' => $this->title,
            'description' => $this->description,
            'deadline' => $this->deadline,
        ]);

        session()->flash('success', 'Assignment berhasil dibuat.');
        $this->reset();
        $this->redirectRoute('assignments.index');
    }

    public function render()
    {
        $courses = Course::where('lecturer_id', Auth::id())->orderBy('name')->get();

        return view('livewire.assignments.create', [
            'courses' => $courses,
        ])->layout('components.layouts.app');
    }
}
