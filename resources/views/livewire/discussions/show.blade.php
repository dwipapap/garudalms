<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Discussion</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $discussion->course->name }}</p>
        </div>
        <a
            href="{{ route('discussions.index', ['course_id' => $discussion->course_id]) }}"
            wire:navigate
            class="text-sm text-gray-600 hover:text-gray-800 transition-colors"
        >
            Kembali ke Forum
        </a>
    </div>

    <!-- Original Discussion (Highlighted) -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg shadow p-6">
        <div class="flex items-center gap-2 mb-3">
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
            <span class="text-xs text-gray-400">
                {{ $discussion->created_at->diffForHumans() }}
            </span>
        </div>
        <p class="text-gray-700 whitespace-pre-line">{{ $discussion->content }}</p>
    </div>

    <!-- Replies -->
    <div>
        <h2 class="text-lg font-semibold text-gray-800 mb-4">
            Balasan ({{ $replies->total() }})
        </h2>

        @if($replies->isEmpty())
            <div class="bg-white rounded-lg shadow p-6 text-center ml-8">
                <p class="text-gray-500">Belum ada balasan. Jadilah yang pertama!</p>
            </div>
        @else
            @foreach($replies as $reply)
                <div class="bg-white rounded-lg shadow p-6 mb-4 ml-8">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="font-semibold text-gray-800">{{ $reply->user->name }}</span>
                        @if($reply->user->role === 'dosen')
                            <span class="px-2 py-0.5 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                Dosen
                            </span>
                        @else
                            <span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-xs font-medium rounded-full">
                                Mahasiswa
                            </span>
                        @endif
                        <span class="text-xs text-gray-400">
                            {{ $reply->created_at->diffForHumans() }}
                        </span>
                    </div>
                    <p class="text-gray-600 whitespace-pre-line">{{ $reply->content }}</p>
                </div>
            @endforeach

            <div class="mt-6 ml-8">
                {{ $replies->links() }}
            </div>
        @endif
    </div>

    <!-- Reply Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Tulis Balasan</h2>
        <form wire:submit="addReply">
            <textarea
                wire:model="replyContent"
                rows="3"
                placeholder="Tulis balasan Anda..."
                class="w-full border border-gray-300 rounded-md px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            ></textarea>
            @error('replyContent')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
            <div class="mt-3 flex justify-end">
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    wire:loading.class="opacity-50 cursor-not-allowed"
                    class="px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-full hover:bg-blue-700 transition-colors disabled:opacity-50"
                >
                    <span wire:loading.remove wire:target="addReply">Kirim Balasan</span>
                    <span wire:loading wire:target="addReply">Mengirim...</span>
                </button>
            </div>
        </form>
    </div>
</div>
