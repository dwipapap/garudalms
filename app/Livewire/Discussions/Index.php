<?php

namespace App\Livewire\Discussions;

use App\Models\Course;
use App\Models\Discussion;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public ?Course $course = null;

    #[Validate('required|min:3')]
    public string $newDiscussionContent = '';

    public ?int $selectedCourseId = null;

    protected function rules(): array
    {
        return [
            'newDiscussionContent' => 'required|min:3',
            'selectedCourseId' => $this->course ? 'nullable' : 'required|exists:courses,id',
        ];
    }

    public function mount(?int $course_id = null): void
    {
        $user = Auth::user();

        if ($course_id) {
            $this->course = Course::findOrFail($course_id);

            $isEnrolled = $user->enrolledCourses()
                ->where('course_id', $this->course->id)
                ->exists();

            $isLecturer = $this->course->lecturer_id === $user->id;

            abort_unless($isEnrolled || $isLecturer, 403);
            $this->selectedCourseId = $this->course->id;
        }
    }

    public function createDiscussion(): void
    {
        $this->validate();

        $user = Auth::user();
        $courseId = $this->course ? $this->course->id : $this->selectedCourseId;

        $targetCourse = Course::findOrFail($courseId);

        $isEnrolled = $user->enrolledCourses()
            ->where('course_id', $targetCourse->id)
            ->exists();

        $isLecturer = $targetCourse->lecturer_id === $user->id;

        abort_unless($isEnrolled || $isLecturer, 403);

        Discussion::create([
            'course_id' => $targetCourse->id,
            'user_id' => $user->id,
            'content' => $this->newDiscussionContent,
        ]);

        $this->reset(['newDiscussionContent', 'selectedCourseId']);
        if ($this->course) {
            $this->selectedCourseId = $this->course->id;
        }

        session()->flash('success', 'Forum berhasil dibuat.');
    }

    public function render()
    {
        $user = Auth::user();
        $availableCourses = collect();

        if ($this->course) {
            $discussions = Discussion::where('course_id', $this->course->id)
                ->with(['user', 'course'])
                ->withCount('replies')
                ->latest()
                ->paginate(10);
        } else {
            $enrolledCourses = $user->enrolledCourses()->get();
            $taughtCourses = $user->taughtCourses()->get();
            $availableCourses = $enrolledCourses->concat($taughtCourses);
            
            $courseIds = $availableCourses->pluck('id')->toArray();

            $discussions = Discussion::whereIn('course_id', $courseIds)
                ->with(['user', 'course'])
                ->withCount('replies')
                ->latest()
                ->paginate(10);
        }

        return view('livewire.discussions.index', [
            'discussions' => $discussions,
            'availableCourses' => $availableCourses,
        ])->layout('components.layouts.app');
    }
}
