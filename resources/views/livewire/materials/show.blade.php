<div class="space-y-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold text-gray-800">{{ $material->title }}</h1>
            <div class="flex gap-2">
                @if($isDosen)
                    <a href="{{ route('materials.edit', $material->id) }}" wire:navigate class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition">
                        Edit
                    </a>
                @endif
                <a href="{{ route('courses.show', $material->course_id) }}" wire:navigate class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Kembali Ke Mata Kuliah
                </a>
            </div>
        </div>
        
        <div class="border-t pt-4">
            <p class="text-sm text-gray-500">Mata Kuliah: {{ $material->course->name }}</p>
            <p class="text-sm text-gray-500">Diunggah pada: {{ $material->created_at->format('d M Y, H:i') }}</p>
        </div>

        <div class="mt-8 bg-gray-50 rounded p-4 border flex flex-col items-center">
            <div class="flex items-center space-x-4 mb-4">
                <svg class="h-10 w-10 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a1 1 0 011 1v1h3a1 1 0 110 2h-3v10a1 1 0 01-1 1H4a1 1 0 01-1-1V4h3V3a1 1 0 011-1z" />
                </svg>
                <div class="text-lg font-semibold">{{ basename($material->file_path) }}</div>
            </div>
            <a href="{{ Storage::url($material->file_path) }}" target="_blank" class="px-8 py-3 bg-red-600 text-white rounded-full font-bold hover:bg-red-700 transition shadow-lg">
                Unduh PDF
            </a>
        </div>
    </div>
</div>
