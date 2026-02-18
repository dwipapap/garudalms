<div class="max-w-2xl mx-auto space-y-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 font-display">Edit Materi</h1>

        <form wire:submit="save" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Judul Materi</label>
                <input type="text" wire:model="title" class="mt-1 block w-full border rounded-md px-3 py-2 shadow-sm focus:ring-blue-500 border-gray-300">
                @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">File Baru (Kosongkan bila tidak ingin mengubah)</label>
                <input type="file" wire:model="newFile" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                @error('newFile') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-between pt-6">
                <a href="{{ route('materials.show', $material->id) }}" wire:navigate class="px-6 py-2 border rounded-full text-gray-600 hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-8 py-2 bg-blue-600 text-white rounded-full font-bold hover:bg-blue-700 transition shadow-lg">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
