<?php

namespace App\Livewire\Assignments;

use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Show extends Component
{
    use WithFileUploads;

    public Assignment $assignment;

    public bool $isDosen = false;

    public bool $isEnrolled = false;

    public bool $hasSubmitted = false;

    #[Validate('required|file|max:10240')]
    public $file;

    public array $scores = [];

    public function mount(int $id): void
    {
        $this->assignment = Assignment::with(['course.lecturer', 'submissions.student'])
            ->findOrFail($id);

        $user = Auth::user();
        $this->isDosen = $user->hasRole('dosen');

        if ($this->isDosen) {
            abort_if(
                $this->assignment->course->lecturer_id !== $user->id,
                403,
                'You are not the lecturer of this course.'
            );

            foreach ($this->assignment->submissions as $submission) {
                $this->scores[$submission->id] = $submission->score;
            }
        } else {
            $this->isEnrolled = $user->enrolledCourses()
                ->where('course_id', $this->assignment->course_id)
                ->exists();

            $this->hasSubmitted = Submission::where('assignment_id', $this->assignment->id)
                ->where('student_id', $user->id)
                ->exists();
        }
    }

    public function submit(): void
    {
        $user = Auth::user();
        abort_if($user->hasRole('dosen'), 403);
        abort_if(! $this->isEnrolled, 403, 'You must be enrolled in this course.');

        if ($this->hasSubmitted) {
            session()->flash('error', 'Anda sudah mengumpulkan tugas ini.');

            return;
        }

        $this->validate();

        $path = $this->file->store('submissions', 'public');

        Submission::create([
            'assignment_id' => $this->assignment->id,
            'student_id' => $user->id,
            'file_path' => $path,
        ]);

        $this->hasSubmitted = true;
        $this->reset('file');
        $this->assignment->load('submissions.student');

        session()->flash('success', 'Tugas berhasil dikumpulkan.');
    }

    public function grade(int $submissionId): void
    {
        $user = Auth::user();
        abort_if(! $user->hasRole('dosen'), 403);
        abort_if(
            $this->assignment->course->lecturer_id !== $user->id,
            403,
            'You are not the lecturer of this course.'
        );

        $this->validate([
            "scores.{$submissionId}" => 'required|integer|min:0|max:100',
        ]);

        $submission = Submission::where('id', $submissionId)
            ->where('assignment_id', $this->assignment->id)
            ->firstOrFail();

        $submission->update([
            'score' => $this->scores[$submissionId],
        ]);

        $this->assignment->load('submissions.student');

        session()->flash('success', 'Nilai berhasil disimpan.');
    }

    public function render()
    {
        return view('livewire.assignments.show')
            ->layout('components.layouts.app');
    }
}
