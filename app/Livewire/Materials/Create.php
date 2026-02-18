<?php

namespace App\Livewire\Materials;

use App\Models\Course;
use App\Models\Material;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    #[Validate('required|exists:courses,id')]
    public string $course_id = '';

    #[Validate('required|max:255')]
    public string $title = '';

    #[Validate('required|mimes:pdf|max:10240')]
    public $file;

    public function mount(): void
    {
        abort_if(! Auth::user()->hasRole('dosen'), 403);
    }

    public function save(): void
    {
        $this->validate();

        $user = Auth::user();

        $course = Course::findOrFail($this->course_id);
        abort_if($course->lecturer_id !== $user->id, 403);

        $path = $this->file->store('materials', 'public');

        Material::create([
            'course_id' => $this->course_id,
            'title' => $this->title,
            'file_path' => $path,
        ]);

        session()->flash('success', 'Materi berhasil diunggah.');
        $this->reset();
        $this->redirectRoute('materials.index');
    }

    public function render()
    {
        $courses = Auth::user()->taughtCourses()->orderBy('name')->get();

        return view('livewire.materials.create', [
            'courses' => $courses,
        ])->layout('components.layouts.app');
    }
}
