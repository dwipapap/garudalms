<?php

namespace App\Livewire\Discussions;

use App\Models\Discussion;
use App\Models\Reply;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    public Discussion $discussion;

    #[Validate('required|min:3')]
    public string $replyContent = '';

    public function mount(int $id): void
    {
        $this->discussion = Discussion::with(['user', 'course'])->findOrFail($id);

        $user = Auth::user();

        $isEnrolled = $user->enrolledCourses()
            ->where('course_id', $this->discussion->course_id)
            ->exists();

        $isLecturer = $this->discussion->course->lecturer_id === $user->id;

        abort_unless($isEnrolled || $isLecturer, 403);
    }

    public function addReply(): void
    {
        $this->validate();

        $user = Auth::user();

        $isEnrolled = $user->enrolledCourses()
            ->where('course_id', $this->discussion->course_id)
            ->exists();

        $isLecturer = $this->discussion->course->lecturer_id === $user->id;

        abort_unless($isEnrolled || $isLecturer, 403);

        Reply::create([
            'discussion_id' => $this->discussion->id,
            'user_id' => $user->id,
            'content' => $this->replyContent,
        ]);

        $this->reset('replyContent');

        session()->flash('success', 'Balasan berhasil diposting.');
    }

    public function render()
    {
        $replies = Reply::where('discussion_id', $this->discussion->id)
            ->with('user')
            ->oldest()
            ->paginate(10);

        return view('livewire.discussions.show', [
            'replies' => $replies,
        ])->layout('components.layouts.app');
    }
}
