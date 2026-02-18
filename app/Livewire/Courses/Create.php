<?php

namespace App\Livewire\Courses;

use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    #[Validate('required|max:255')]
    public string $name = '';

    #[Validate('nullable')]
    public string $description = '';

    public function mount(): void
    {
        abort_if(! Auth::user()->hasRole('dosen'), 403);
    }

    public function save(): void
    {
        $this->validate();

        Course::create([
            'name' => $this->name,
            'description' => $this->description,
            'lecturer_id' => Auth::id(),
        ]);

        session()->flash('success', 'Course berhasil dibuat.');
        $this->redirectRoute('courses.index');
    }

    public function render()
    {
        return view('livewire.courses.create')
            ->layout('components.layouts.app');
    }
}
