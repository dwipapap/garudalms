<?php

namespace App\Livewire\Reports;

use App\Models\User;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Students extends Component
{
    public User $student;
    
    public function mount(int $id): void
    {
        // Must be a dosen to view student reports
        abort_if(!Auth::user()->hasRole('dosen'), 403);
        
        $this->student = User::whereHas('enrolledCourses', function($q) {
            $q->where('lecturer_id', Auth::id());
        })->findOrFail($id);
    }

    public function render()
    {
        $courses = Course::where('lecturer_id', Auth::id())
            ->whereHas('students', function($q) {
                $q->where('users.id', $this->student->id);
            })
            ->with(['assignments.submissions' => function($q) {
                $q->where('student_id', $this->student->id);
            }])
            ->get();
            
        return view('livewire.reports.students', [
            'courses' => $courses,
        ])->layout('components.layouts.app');
    }
}
