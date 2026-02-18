<?php

namespace App\Livewire\Materials;

use App\Models\Course;
use App\Models\Material;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public Material $material;

    #[Validate('required|max:255')]
    public string $title = '';

    #[Validate('nullable|mimes:pdf|max:10240')]
    public $newFile;

    public function mount(int $id): void
    {
        $this->material = Material::findOrFail($id);
        
        // Ensure user is the lecturer for the material's course
        abort_if(Auth::user()->id !== $this->material->course->lecturer_id, 403);
        
        $this->title = $this->material->title;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'title' => $this->title,
        ];

        if ($this->newFile) {
            // Delete old file
            if ($this->material->file_path && Storage::disk('public')->exists($this->material->file_path)) {
                Storage::disk('public')->delete($this->material->file_path);
            }
            $data['file_path'] = $this->newFile->store('materials', 'public');
        }

        $this->material->update($data);

        $this->redirect(route('materials.show', $this->material->id), navigate: true);
    }

    public function render()
    {
        return view('livewire.materials.edit')
            ->layout('components.layouts.app');
    }
}
