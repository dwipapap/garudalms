<div>
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Buat Assignment Baru</h1>

    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        <form wire:submit="save" class="space-y-4">
            <!-- Course Select -->
            <div>
                <label for="course_id" class="block text-sm font-medium text-gray-700 mb-1">Course</label>
                <select
                    id="course_id"
                    wire:model="course_id"
                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:border-blue-500 focus:ring-blue-500 focus:outline-none"
                >
                    <option value="">-- Pilih Course --</option>
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
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Assignment</label>
                <input
                    type="text"
                    id="title"
                    wire:model="title"
                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:border-blue-500 focus:ring-blue-500 focus:outline-none"
                    placeholder="Masukkan judul assignment"
                >
                @error('title')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea
                    id="description"
                    wire:model="description"
                    rows="5"
                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:border-blue-500 focus:ring-blue-500 focus:outline-none"
                    placeholder="Jelaskan detail tugas yang harus dikerjakan"
                ></textarea>
                @error('description')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Deadline -->
            <div>
                <label for="deadline" class="block text-sm font-medium text-gray-700 mb-1">Deadline</label>
                <input
                    type="datetime-local"
                    id="deadline"
                    wire:model="deadline"
                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:border-blue-500 focus:ring-blue-500 focus:outline-none"
                >
                @error('deadline')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4 pt-2">
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    wire:loading.class="opacity-50 cursor-not-allowed"
                    class="bg-blue-600 text-white rounded-full px-6 py-2 hover:bg-blue-700 font-medium transition-colors disabled:opacity-50"
                >
                    <span wire:loading.remove wire:target="save">Buat Assignment</span>
                    <span wire:loading wire:target="save">Menyimpan...</span>
                </button>
                <a
                    href="{{ route('assignments.index') }}"
                    wire:navigate
                    class="text-gray-600 hover:text-gray-800 text-sm font-medium"
                >
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
