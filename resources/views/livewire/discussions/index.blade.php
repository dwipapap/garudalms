<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Forum Discussion</h1>
            @if($course)
                <p class="text-sm text-gray-500 mt-1">{{ $course->name }}</p>
            @else
                <p class="text-sm text-gray-500 mt-1">Discussions from your courses</p>
            @endif
        </div>
        @if($course)
            <a
                href="{{ route('courses.show', $course->id) }}"
                wire:navigate
                class="text-sm text-gray-600 hover:text-gray-800 transition-colors"
            >
                Back to Course
            </a>
        @endif
    </div>

    <!-- New Discussion Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">New Discussion</h2>
        <form wire:submit="createDiscussion" class="space-y-4">
            @if(! $course)
                <div>
                    <label for="course_id" class="block text-sm font-medium text-gray-700 mb-1">Select Course</label>
                    <select 
                        wire:model="selectedCourseId"
                        id="course_id"
                        class="w-full border border-gray-300 rounded-md px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                        <option value="">Choose a course...</option>
                        @foreach($availableCourses as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                    @error('selectedCourseId')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            <div>
                <textarea
                    wire:model="newDiscussionContent"
                    rows="3"
                    placeholder="What would you like to discuss?"
                    class="w-full border border-gray-300 rounded-md px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                ></textarea>
                @error('newDiscussionContent')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end pt-2">
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    class="px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-full hover:bg-blue-700 transition-colors disabled:opacity-50"
                >
                    <span wire:loading.remove wire:target="createDiscussion">Post Discussion</span>
                    <span wire:loading wire:target="createDiscussion">Posting...</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Discussion List -->
    @if($discussions->isEmpty())
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <p class="text-gray-500">No discussions yet.{{ $course ? ' Start the first one!' : '' }}</p>
        </div>
    @else
        @foreach($discussions as $discussion)
            <div class="bg-white rounded-lg shadow p-6 mb-4">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="font-semibold text-gray-800">{{ $discussion->user->name }}</span>
                            @if($discussion->user->role === 'dosen')
                                <span class="px-2 py-0.5 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                    Dosen
                                </span>
                            @else
                                <span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-xs font-medium rounded-full">
                                    Mahasiswa
                                </span>
                            @endif
                        </div>

                        @if(! $course)
                            <p class="text-xs text-blue-600 mb-1">{{ $discussion->course->name }}</p>
                        @endif

                        <p class="text-gray-600 text-sm line-clamp-3">{{ $discussion->content }}</p>

                        <div class="flex items-center gap-4 mt-3">
                            <span class="text-xs text-gray-400">
                                {{ $discussion->created_at->diffForHumans() }}
                            </span>
                            <span class="text-xs text-gray-400">
                                {{ $discussion->replies_count }} {{ $discussion->replies_count === 1 ? 'reply' : 'replies' }}
                            </span>
                        </div>
                    </div>

                    <a
                        href="{{ route('discussions.show', $discussion->id) }}"
                        wire:navigate
                        class="px-6 py-2 bg-gray-200 text-gray-800 rounded-full hover:bg-gray-300 transition-colors text-sm font-medium ml-4 shrink-0"
                    >
                        View
                    </a>
                </div>
            </div>
        @endforeach

        <div class="mt-6">
            {{ $discussions->links() }}
        </div>
    @endif
</div>
