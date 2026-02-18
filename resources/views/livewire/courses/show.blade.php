<div class="space-y-6">
    <!-- Course Header -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $course->name }}</h1>
                <p class="text-sm text-gray-500 mt-1">Dosen: {{ $course->lecturer->name }}</p>
                @if($course->description)
                    <p class="text-gray-600 mt-3">{{ $course->description }}</p>
                @endif
            </div>
            <div class="flex items-center gap-3">
                @if($isDosen && $isTeaching)
                    <a
                        href="{{ route('courses.edit', $course->id) }}"
                        wire:navigate
                        class="px-6 py-2 bg-gray-200 text-gray-800 rounded-full hover:bg-gray-300 transition-colors text-sm font-medium"
                    >
                        Edit Course
                    </a>
                @elseif(! $isDosen && ! $isEnrolled)
                    <button
                        wire:click="enroll"
                        wire:loading.attr="disabled"
                        class="px-6 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-colors text-sm font-medium disabled:opacity-50"
                    >
                        <span wire:loading.remove wire:target="enroll">Enroll</span>
                        <span wire:loading wire:target="enroll">Mengenroll...</span>
                    </button>
                @elseif(! $isDosen && $isEnrolled)
                    <span class="px-6 py-2 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                        Enrolled
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-sm text-gray-500 uppercase tracking-wide">Materi</div>
            <div class="text-3xl font-bold text-gray-800 mt-2">{{ $course->materials_count }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-sm text-gray-500 uppercase tracking-wide">Tugas</div>
            <div class="text-3xl font-bold text-gray-800 mt-2">{{ $course->assignments_count }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-sm text-gray-500 uppercase tracking-wide">Mahasiswa</div>
            <div class="text-3xl font-bold text-gray-800 mt-2">{{ $course->students_count }}</div>
        </div>
    </div>

    <!-- Materials Section -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Materi</h2>
            @if($isDosen && $isTeaching)
                <a
                    href="{{ route('materials.create') }}"
                    wire:navigate
                    class="px-6 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-colors text-sm font-medium"
                >
                    Buat Materi
                </a>
            @endif
        </div>

        @if($course->materials->isEmpty())
            <p class="text-gray-500">Belum ada materi tersedia.</p>
        @else
            <div class="space-y-4">
                @foreach($course->materials as $material)
                    <div class="border-b border-gray-200 pb-4 last:border-b-0">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ $material->title }}</h3>
                            </div>
                            @if($isDosen || $isEnrolled)
                                <a
                                    href="{{ route('materials.show', $material->id) }}"
                                    wire:navigate
                                    class="px-6 py-2 bg-gray-200 text-gray-800 rounded-full hover:bg-gray-300 transition-colors text-sm font-medium"
                                >
                                    Unduh
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Assignments Section -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Tugas</h2>
            @if($isDosen && $isTeaching)
                <a
                    href="{{ route('assignments.create') }}"
                    wire:navigate
                    class="px-6 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-colors text-sm font-medium"
                >
                    Buat Tugas
                </a>
            @endif
        </div>

        @if($course->assignments->isEmpty())
            <p class="text-gray-500">Belum ada tugas tersedia.</p>
        @else
            <div class="space-y-4">
                @foreach($course->assignments as $assignment)
                    <div class="border-b border-gray-200 pb-4 last:border-b-0">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ $assignment->title }}</h3>
                                <p class="text-xs text-gray-500 mt-1">
                                    Deadline: {{ $assignment->deadline->format('d M Y, H:i') }}
                                </p>
                                @if(! $isDosen && $isEnrolled)
                                    @if(in_array($assignment->id, $submittedAssignmentIds))
                                        <span class="inline-block mt-1 px-3 py-0.5 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                                            Sudah Dikumpulkan
                                        </span>
                                    @elseif($assignment->deadline->isPast())
                                        <span class="inline-block mt-1 px-3 py-0.5 bg-red-100 text-red-800 rounded-full text-xs font-medium">
                                            Overdue
                                        </span>
                                    @else
                                        <span class="inline-block mt-1 px-3 py-0.5 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">
                                            Pending
                                        </span>
                                    @endif
                                @endif
                            </div>
                            <a
                                href="{{ route('assignments.show', $assignment->id) }}"
                                wire:navigate
                                class="px-6 py-2 bg-gray-200 text-gray-800 rounded-full hover:bg-gray-300 transition-colors text-sm font-medium"
                            >
                                Lihat
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Back Link -->
    <div>
        <a
            href="{{ route('courses.index') }}"
            wire:navigate
            class="text-sm text-gray-600 hover:text-gray-800 transition-colors"
        >
            Kembali ke Daftar Course
        </a>
    </div>
</div>
