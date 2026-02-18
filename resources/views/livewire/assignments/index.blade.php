<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Assignments</h1>

        <div class="flex items-center gap-3">
            <div class="w-full sm:w-80">
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Cari assignment..."
                    class="w-full border border-gray-300 rounded-full px-5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                />
            </div>

            @if($isDosen)
                <a
                    href="{{ route('assignments.create') }}"
                    wire:navigate
                    class="px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-full hover:bg-blue-700 transition-colors whitespace-nowrap"
                >
                    Buat Assignment
                </a>
            @endif
        </div>
    </div>

    @if($assignments->isEmpty())
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <p class="text-gray-500">Tidak ada assignment ditemukan.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($assignments as $assignment)
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h2 class="text-lg font-semibold text-gray-800">{{ $assignment->title }}</h2>
                            <p class="text-sm text-gray-500 mt-1">
                                Course: {{ $assignment->course->name }} &middot;
                                Lecturer: {{ $assignment->course->lecturer->name }}
                            </p>
                            <p class="text-gray-600 mt-2 line-clamp-2">{{ $assignment->description }}</p>

                            <div class="flex items-center gap-4 mt-3">
                                <p class="text-xs text-gray-500">
                                    Deadline: {{ $assignment->deadline->format('d M Y, H:i') }}
                                </p>

                                @if($isDosen)
                                    <span class="text-xs text-gray-500">
                                        {{ $assignment->submissions_count }} submission(s)
                                    </span>
                                @endif

                                @if(! $isDosen)
                                    @if(in_array($assignment->id, $submittedAssignmentIds))
                                        <span class="inline-flex items-center px-3 py-0.5 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                                            Submitted
                                        </span>
                                    @elseif($assignment->deadline->isPast())
                                        <span class="inline-flex items-center px-3 py-0.5 bg-red-100 text-red-800 text-xs font-medium rounded-full">
                                            Overdue
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-0.5 bg-gray-100 text-gray-800 text-xs font-medium rounded-full">
                                            Pending
                                        </span>
                                    @endif
                                @endif
                            </div>
                        </div>

                        <a
                            href="{{ route('assignments.show', $assignment->id) }}"
                            wire:navigate
                            class="px-6 py-2 bg-gray-200 text-gray-800 rounded-full hover:bg-gray-300 transition-colors text-sm font-medium ml-4"
                        >
                            View
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $assignments->links() }}
        </div>
    @endif
</div>
