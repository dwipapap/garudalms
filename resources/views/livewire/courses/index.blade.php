<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Course</h1>

        <div class="w-full sm:w-80">
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Cari course..."
                class="w-full border border-gray-300 rounded-full px-5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            />
        </div>
    </div>

    @if($courses->isEmpty())
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <p class="text-gray-500">Tidak ada course ditemukan.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($courses as $course)
                <div class="bg-white rounded-lg shadow p-6 flex flex-col justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">{{ $course->name }}</h2>

                        <p class="text-gray-600 line-clamp-2 mt-2">
                            {{ $course->description ?? 'Tidak ada deskripsi.' }}
                        </p>

                        <div class="mt-4 space-y-1">
                            <p class="text-sm text-gray-500">
                                <span class="font-medium text-gray-700">Dosen:</span>
                                {{ $course->lecturer->name ?? '-' }}
                            </p>
                            <p class="text-sm text-gray-500">
                                <span class="font-medium text-gray-700">Mahasiswa:</span>
                                {{ $course->students_count }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-4 flex items-center justify-between">
                        <a
                            href="{{ route('courses.show', $course->id) }}"
                            wire:navigate
                            class="text-sm text-blue-600 hover:text-blue-800 font-medium"
                        >
                            Lihat Detail
                        </a>

                        @if(in_array($course->id, $enrolledCourseIds))
                            <span class="inline-flex items-center px-4 py-1 bg-green-100 text-green-700 text-sm font-medium rounded-full">
                                Sudah Enroll
                            </span>
                        @else
                            <button
                                wire:click="enroll({{ $course->id }})"
                                wire:loading.attr="disabled"
                                wire:loading.class="opacity-50 cursor-not-allowed"
                                wire:target="enroll({{ $course->id }})"
                                class="px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-full hover:bg-blue-700 transition-colors"
                            >
                                <span wire:loading.remove wire:target="enroll({{ $course->id }})">Enroll</span>
                                <span wire:loading wire:target="enroll({{ $course->id }})">Mengenroll...</span>
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $courses->links() }}
        </div>
    @endif
</div>
