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
        }
    }

    public function createDiscussion(): void
    {
        abort_unless($this->course, 400);

        $this->validate();

        $user = Auth::user();

        $isEnrolled = $user->enrolledCourses()
            ->where('course_id', $this->course->id)
            ->exists();

        $isLecturer = $this->course->lecturer_id === $user->id;

        abort_unless($isEnrolled || $isLecturer, 403);

        Discussion::create([
            'course_id' => $this->course->id,
            'user_id' => $user->id,
            'content' => $this->newDiscussionContent,
        ]);

        $this->reset('newDiscussionContent');

        session()->flash('success', 'Forum berhasil dibuat.');
    }

    public function render()
    {
        $user = Auth::user();

        if ($this->course) {
            $discussions = Discussion::where('course_id', $this->course->id)
                ->with(['user', 'course'])
                ->withCount('replies')
                ->latest()
                ->paginate(10);
        } else {
            $enrolledIds = $user->enrolledCourses()->pluck('courses.id')->toArray();
            $taughtIds = $user->taughtCourses()->pluck('id')->toArray();
            $courseIds = array_merge($enrolledIds, $taughtIds);

            $discussions = Discussion::whereIn('course_id', $courseIds)
                ->with(['user', 'course'])
                ->withCount('replies')
                ->latest()
                ->paginate(10);
        }

        return view('livewire.discussions.index', [
            'discussions' => $discussions,
        ])->layout('components.layouts.app');
    }
}
