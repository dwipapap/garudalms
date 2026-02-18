<div class="space-y-6">
    <!-- Assignment Header -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $assignment->title }}</h1>
                <p class="text-sm text-gray-500 mt-1">
                    Course: {{ $assignment->course->name }} &middot;
                    Lecturer: {{ $assignment->course->lecturer->name }}
                </p>
            </div>
            <div class="text-right">
                @if($assignment->deadline->isPast())
                    <span class="inline-flex items-center px-4 py-1 bg-red-100 text-red-800 text-sm font-medium rounded-full">
                        Overdue
                    </span>
                @else
                    <span class="inline-flex items-center px-4 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">
                        Open
                    </span>
                @endif
                <p class="text-xs text-gray-500 mt-2">Deadline: {{ $assignment->deadline->format('d M Y, H:i') }}</p>
            </div>
        </div>

        <div class="mt-4 pt-4 border-t border-gray-200">
            <h3 class="text-sm font-medium text-gray-700 mb-2">Deskripsi</h3>
            <p class="text-gray-600 whitespace-pre-line">{{ $assignment->description }}</p>
        </div>
    </div>

    @if(! $isDosen && $isEnrolled)
        <!-- Mahasiswa: Submission Form -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Kumpulkan Tugas</h2>

            @if($hasSubmitted)
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center px-4 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">
                        Submitted
                    </span>
                    <p class="text-sm text-gray-500">Anda sudah mengumpulkan tugas ini.</p>
                </div>
            @else
                <form wire:submit="submit" class="space-y-4">
                    <div>
                        <label for="file" class="block text-sm font-medium text-gray-700 mb-1">Upload File</label>
                        <input
                            type="file"
                            id="file"
                            wire:model="file"
                            class="w-full border border-gray-300 rounded-md px-4 py-2 focus:border-blue-500 focus:ring-blue-500 focus:outline-none text-sm"
                        >
                        @error('file')
                            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror

                        <div wire:loading wire:target="file" class="text-sm text-blue-600 mt-1">
                            Uploading...
                        </div>
                    </div>

                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        wire:loading.class="opacity-50 cursor-not-allowed"
                        class="bg-blue-600 text-white rounded-full px-6 py-2 hover:bg-blue-700 font-medium transition-colors"
                    >
                        <span wire:loading.remove wire:target="submit">Kumpulkan</span>
                        <span wire:loading wire:target="submit">Mengirim...</span>
                    </button>
                </form>
            @endif
        </div>
    @elseif(! $isDosen && ! $isEnrolled)
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <p class="text-gray-500">Anda harus enroll di course ini untuk mengumpulkan tugas.</p>
            <a
                href="{{ route('courses.show', $assignment->course_id) }}"
                wire:navigate
                class="inline-block mt-3 px-6 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 font-medium transition-colors text-sm"
            >
                Lihat Course
            </a>
        </div>
    @endif

    @if($isDosen)
        <!-- Dosen: Submissions & Grading -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">
                Submissions ({{ $assignment->submissions->count() }})
            </h2>

            @if($assignment->submissions->isEmpty())
                <p class="text-gray-500">Belum ada submission.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="text-left px-4 py-3 text-sm font-medium text-gray-700 border-b border-gray-200">Mahasiswa</th>
                                <th class="text-left px-4 py-3 text-sm font-medium text-gray-700 border-b border-gray-200">File</th>
                                <th class="text-left px-4 py-3 text-sm font-medium text-gray-700 border-b border-gray-200">Waktu Submit</th>
                                <th class="text-left px-4 py-3 text-sm font-medium text-gray-700 border-b border-gray-200">Status</th>
                                <th class="text-left px-4 py-3 text-sm font-medium text-gray-700 border-b border-gray-200">Nilai</th>
                                <th class="text-left px-4 py-3 text-sm font-medium text-gray-700 border-b border-gray-200">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($assignment->submissions as $submission)
                                <tr class="border-b border-gray-200 last:border-b-0">
                                    <td class="px-4 py-3 text-sm text-gray-800">{{ $submission->student->name }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        <a
                                            href="{{ Storage::url($submission->file_path) }}"
                                            target="_blank"
                                            class="text-blue-600 hover:text-blue-800 underline"
                                        >
                                            Download
                                        </a>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $submission->created_at->format('d M Y, H:i') }}</td>
                                    <td class="px-4 py-3">
                                        @if($submission->score !== null)
                                            <span class="inline-flex items-center px-3 py-0.5 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                                Graded
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-0.5 bg-gray-100 text-gray-800 text-xs font-medium rounded-full">
                                                Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <input
                                            type="number"
                                            min="0"
                                            max="100"
                                            wire:model="scores.{{ $submission->id }}"
                                            class="w-20 border border-gray-300 rounded-md px-2 py-1 text-sm text-center focus:border-blue-500 focus:ring-blue-500 focus:outline-none"
                                            placeholder="0-100"
                                        >
                                        @error("scores.{$submission->id}")
                                            <span class="text-red-600 text-xs block mt-1">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td class="px-4 py-3">
                                        <button
                                            wire:click="grade({{ $submission->id }})"
                                            wire:loading.attr="disabled"
                                            class="bg-blue-600 text-white rounded-full px-4 py-1 text-sm hover:bg-blue-700 font-medium transition-colors disabled:opacity-50"
                                        >
                                            <span wire:loading.remove wire:target="grade({{ $submission->id }})">Simpan</span>
                                            <span wire:loading wire:target="grade({{ $submission->id }})">...</span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    @endif

    <!-- Back Link -->
    <div>
        <a
            href="{{ route('assignments.index') }}"
            wire:navigate
            class="text-sm text-gray-600 hover:text-gray-800 transition-colors"
        >
            Back to Assignments
        </a>
    </div>
</div>
