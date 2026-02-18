<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Login</h2>

        <form wire:submit="login" class="space-y-4">
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

            <!-- Remember Me -->
            <div class="flex items-center">
                <input
                    type="checkbox"
                    id="remember"
                    wire:model="remember"
                    class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                >
                <label for="remember" class="ml-2 block text-sm text-gray-700">Ingat saya</label>
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                class="w-full bg-blue-600 text-white rounded-full py-3 hover:bg-blue-700 font-medium transition"
            >
                Login
            </button>
        </form>

        <!-- Register Link -->
        <p class="text-center text-gray-600 text-sm mt-6">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-medium">Daftar di sini</a>
        </p>
    </div>
</div>
