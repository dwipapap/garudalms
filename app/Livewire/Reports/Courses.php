<?php

namespace App\Livewire\Reports;

use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Courses extends Component
{
    use WithPagination;

    public function render()
    {
        $user = Auth::user();

        if (! $user->hasRole('dosen')) {
            abort(403);
        }

        $courses = Course::query()
            ->where('lecturer_id', $user->id)
            ->with(['students', 'assignments', 'materials'])
            ->withCount(['students', 'assignments', 'materials'])
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.reports.courses', [
            'courses' => $courses,
        ])->layout('components.layouts.app');
    }
}
