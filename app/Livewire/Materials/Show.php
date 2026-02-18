<?php

namespace App\Livewire\Materials;

use App\Models\Material;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{
    public Material $material;

    public bool $isDosen = false;

    public function mount(int $id): void
    {
        $this->material = Material::with('course')->findOrFail($id);
        $this->isDosen = Auth::user()->hasRole('dosen');
        
        // Ensure user can access the material
        if ($this->isDosen) {
            abort_if($this->material->course->lecturer_id !== Auth::id(), 403);
        } else {
            abort_if(!Auth::user()->enrolledCourses()->where('courses.id', $this->material->course_id)->exists(), 403);
        }
    }

    public function render()
    {
        return view('livewire.materials.show')
            ->layout('components.layouts.app');
    }
}
