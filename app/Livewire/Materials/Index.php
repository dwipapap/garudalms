<?php

namespace App\Livewire\Materials;

use App\Models\Material;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url]
    public string $course_id = '';

    public function render()
    {
        $user = Auth::user();
        $isDosen = $user->hasRole('dosen');

        if ($isDosen) {
            $accessibleCourses = $user->taughtCourses()->orderBy('name')->get();
        } else {
            $accessibleCourses = $user->enrolledCourses()->orderBy('name')->get();
        }

        $accessibleCourseIds = $accessibleCourses->pluck('id')->toArray();

        $materials = Material::query()
            ->with('course')
            ->whereIn('course_id', $accessibleCourseIds)
            ->when($this->course_id, function ($query) {
                $query->where('course_id', $this->course_id);
            })
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('livewire.materials.index', [
            'materials' => $materials,
            'courses' => $accessibleCourses,
            'isDosen' => $isDosen,
        ])->layout('components.layouts.app');
    }
}
