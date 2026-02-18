<?php

namespace App\Livewire\Courses;

use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Edit extends Component
{
    public Course $course;

    #[Validate('required|max:255')]
    public string $name = '';

    #[Validate('nullable')]
    public string $description = '';

    public function mount(int $id): void
    {
        $this->course = Course::findOrFail($id);

        abort_if($this->course->lecturer_id !== Auth::id(), 403);

        $this->name = $this->course->name;
        $this->description = $this->course->description ?? '';
    }

    public function update(): void
    {
        $this->validate();

        $this->course->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        session()->flash('success', 'Course berhasil diperbarui.');
        $this->redirectRoute('courses.index');
    }

    public function delete(): void
    {
        abort_if($this->course->lecturer_id !== Auth::id(), 403);

        $this->course->delete();

        session()->flash('success', 'Course berhasil dihapus.');
        $this->redirectRoute('courses.index');
    }

    public function render()
    {
        return view('livewire.courses.edit')
            ->layout('components.layouts.app');
    }
}
