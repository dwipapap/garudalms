<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Materials</h1>

        <div class="flex items-center gap-3">
            <select
                wire:model.live="course_id"
                class="border border-gray-300 rounded-full px-5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            >
                <option value="">Semua Mata Kuliah</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                @endforeach
            </select>

            @if($isDosen)
                <a
                    href="{{ route('materials.create') }}"
                    wire:navigate
                    class="px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-full hover:bg-blue-700 transition-colors"
                >
                    Upload Materi
                </a>
            @endif
        </div>
    </div>

    @if($materials->isEmpty())
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <p class="text-gray-500">Belum ada materi tersedia.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($materials as $material)
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">{{ $material->title }}</h2>
                            <p class="text-sm text-gray-500 mt-1">
                                <span class="font-medium text-gray-700">{{ $material->course->name }}</span>
                                &middot;
                                {{ $material->created_at->format('d M Y') }}
                            </p>
                        </div>
                        <a
                            href="{{ Storage::url($material->file_path) }}"
                            download
                            class="px-6 py-2 bg-gray-200 text-gray-800 rounded-full hover:bg-gray-300 transition-colors text-sm font-medium"
                        >
                            Download
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $materials->links() }}
        </div>
    @endif
</div>
