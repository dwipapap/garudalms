<div class="space-y-6">
    <h1 class="text-2xl font-bold text-gray-800">Upload Materi</h1>

    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        <form wire:submit="save" class="space-y-4">
            <!-- Course Selection -->
            <div>
                <label for="course_id" class="block text-sm font-medium text-gray-700 mb-1">Mata Kuliah</label>
                <select
                    id="course_id"
                    wire:model="course_id"
                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:border-blue-500 focus:ring-blue-500 focus:outline-none"
                >
                    <option value="">Pilih Mata Kuliah</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
                @error('course_id')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Materi</label>
                <input
                    type="text"
                    id="title"
                    wire:model="title"
                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:border-blue-500 focus:ring-blue-500 focus:outline-none"
                    placeholder="Masukkan judul materi"
                >
                @error('title')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- File Upload -->
            <div>
                <label for="file" class="block text-sm font-medium text-gray-700 mb-1">File (PDF, maks. 10MB)</label>
                <input
                    type="file"
                    id="file"
                    wire:model="file"
                    accept=".pdf"
                    class="w-full border border-gray-300 rounded-md px-4 py-2 text-sm text-gray-600 file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                >
                @error('file')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror

                <!-- Upload Progress -->
                <div
                    wire:loading
                    wire:target="file"
                    class="mt-2"
                >
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full animate-pulse" style="width: 100%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Mengunggah file...</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4 pt-2">
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    wire:loading.class="opacity-50 cursor-not-allowed"
                    wire:target="save"
                    class="bg-blue-600 text-white rounded-full px-6 py-2 hover:bg-blue-700 font-medium transition-colors"
                >
                    <span wire:loading.remove wire:target="save">Upload Materi</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </button>
                <a
                    href="{{ route('materials.index') }}"
                    wire:navigate
                    class="text-gray-600 hover:text-gray-800 text-sm font-medium"
                >
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
