<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Daftar Akun</h2>

        <form wire:submit="register" class="space-y-4">
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input
                    type="text"
                    id="name"
                    wire:model="name"
                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:border-blue-500 focus:ring-blue-500 focus:outline-none"
                    placeholder="Nama lengkap"
                >
                @error('name')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input
                    type="email"
                    id="email"
                    wire:model="email"
                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:border-blue-500 focus:ring-blue-500 focus:outline-none"
                    placeholder="example@email.com"
                >
                @error('email')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input
                    type="password"
                    id="password"
                    wire:model="password"
                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:border-blue-500 focus:ring-blue-500 focus:outline-none"
                    placeholder="••••••••"
                >
                @error('password')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password Confirmation -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                <input
                    type="password"
                    id="password_confirmation"
                    wire:model="password_confirmation"
                    class="w-full border border-gray-300 rounded-md px-4 py-2 focus:border-blue-500 focus:ring-blue-500 focus:outline-none"
                    placeholder="••••••••"
                >
                @error('password_confirmation')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Role Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Peran</label>
                <div class="space-y-2">
                    <div class="flex items-center">
                        <input
                            type="radio"
                            id="role_mahasiswa"
                            wire:model="role"
                            value="mahasiswa"
                            class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                        >
                        <label for="role_mahasiswa" class="ml-2 block text-sm text-gray-700">Mahasiswa</label>
                    </div>
                    <div class="flex items-center">
                        <input
                            type="radio"
                            id="role_dosen"
                            wire:model="role"
                            value="dosen"
                            class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                        >
                        <label for="role_dosen" class="ml-2 block text-sm text-gray-700">Dosen</label>
                    </div>
                </div>
                @error('role')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                class="w-full bg-blue-600 text-white rounded-full py-3 hover:bg-blue-700 font-medium transition"
            >
                Daftar
            </button>
        </form>

        <!-- Login Link -->
        <p class="text-center text-gray-600 text-sm mt-6">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium">Login di sini</a>
        </p>
    </div>
</div>
