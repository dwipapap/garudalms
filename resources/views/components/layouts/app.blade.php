<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'GarudaLMS')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-50">
    <!-- Mobile Header -->
    <div class="lg:hidden fixed top-0 left-0 right-0 bg-white border-b border-gray-200 z-40">
        <div class="flex items-center justify-between px-4 py-3">
            <a href="{{ route('dashboard') }}" wire:navigate class="text-lg font-semibold text-gray-800">
                GarudaLMS
            </a>
            <button 
                @click="$store.sidebar.toggle()" 
                class="p-2 text-gray-600 hover:bg-gray-50 rounded-full"
                aria-label="Toggle sidebar"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Sidebar -->
    <aside 
        :class="$store.sidebar.open ? 'translate-x-0' : '-translate-x-full'"
        class="fixed lg:static top-0 left-0 h-screen w-64 bg-white border-r border-gray-200 pt-20 lg:pt-0 transition-transform duration-300 z-30 lg:z-auto overflow-y-auto"
    >
        <!-- Logo (Desktop) -->
        <div class="hidden lg:block px-6 py-4 border-b border-gray-200">
            <a href="{{ route('dashboard') }}" wire:navigate class="text-lg font-semibold text-gray-800 block">
                GarudaLMS
            </a>
        </div>

        <!-- Navigation -->
        <nav class="p-4 space-y-1">
            <!-- Dashboard (All authenticated users) -->
            <a 
                href="{{ route('dashboard') }}"
                wire:navigate
                @class([
                    'flex items-center px-4 py-2.5 text-sm font-medium rounded-full transition-colors',
                    'bg-blue-50 text-blue-700 border-r-4 border-blue-500' => Route::currentRouteName() === 'dashboard',
                    'text-gray-600 hover:bg-gray-50' => Route::currentRouteName() !== 'dashboard'
                ])
            >
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 16l4-4m0 0l4 4m-4-4V5" />
                </svg>
                Dashboard
            </a>

            <!-- Courses (All authenticated users) -->
            <a 
                href="{{ route('courses.index') }}"
                wire:navigate
                @class([
                    'flex items-center px-4 py-2.5 text-sm font-medium rounded-full transition-colors',
                    'bg-blue-50 text-blue-700 border-r-4 border-blue-500' => Str::startsWith(Route::currentRouteName(), 'courses'),
                    'text-gray-600 hover:bg-gray-50' => !Str::startsWith(Route::currentRouteName(), 'courses')
                ])
            >
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747 0-6.002-4.5-10.747-10-10.747z" />
                </svg>
                Courses
            </a>

            <!-- Discussions (All authenticated users) -->
            <a 
                href="{{ route('discussions.index') }}"
                wire:navigate
                @class([
                    'flex items-center px-4 py-2.5 text-sm font-medium rounded-full transition-colors',
                    'bg-blue-50 text-blue-700 border-r-4 border-blue-500' => Str::startsWith(Route::currentRouteName(), 'discussions'),
                    'text-gray-600 hover:bg-gray-50' => !Str::startsWith(Route::currentRouteName(), 'discussions')
                ])
            >
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                Discussions
            </a>

            @if(auth()->user() && auth()->user()->hasRole('dosen'))
                <!-- Materials (Dosen only) -->
                <a 
                    href="{{ route('materials.index') }}"
                    wire:navigate
                    @class([
                        'flex items-center px-4 py-2.5 text-sm font-medium rounded-full transition-colors',
                        'bg-blue-50 text-blue-700 border-r-4 border-blue-500' => Str::startsWith(Route::currentRouteName(), 'materials'),
                        'text-gray-600 hover:bg-gray-50' => !Str::startsWith(Route::currentRouteName(), 'materials')
                    ])
                >
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Materials
                </a>

                <!-- Assignments (Dosen only) -->
                <a 
                    href="{{ route('assignments.index') }}"
                    wire:navigate
                    @class([
                        'flex items-center px-4 py-2.5 text-sm font-medium rounded-full transition-colors',
                        'bg-blue-50 text-blue-700 border-r-4 border-blue-500' => Str::startsWith(Route::currentRouteName(), 'assignments'),
                        'text-gray-600 hover:bg-gray-50' => !Str::startsWith(Route::currentRouteName(), 'assignments')
                    ])
                >
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    Assignments
                </a>

                <!-- Reports (Dosen only) -->
                <button 
                    @click="$store.reports.toggle()" 
                    @class([
                        'w-full flex items-center justify-between px-4 py-2.5 text-sm font-medium rounded-full transition-colors',
                        'bg-blue-50 text-blue-700 border-r-4 border-blue-500' => Str::startsWith(Route::currentRouteName(), 'reports'),
                        'text-gray-600 hover:bg-gray-50' => !Str::startsWith(Route::currentRouteName(), 'reports')
                    ])
                >
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Reports
                    </span>
                    <svg 
                        :class="$store.reports.open ? 'rotate-180' : ''"
                        class="w-4 h-4 transition-transform" 
                        fill="none" 
                        stroke="currentColor" 
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                    </svg>
                </button>

                <!-- Reports Submenu -->
                <div 
                    x-show="$store.reports.open"
                    x-transition
                    class="pl-4 space-y-1"
                >
                    <a 
                        href="{{ route('reports.courses') }}"
                        wire:navigate
                        class="flex items-center px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 rounded-full transition-colors"
                    >
                        Courses
                    </a>
                    <a 
                        href="{{ route('reports.assignments') }}"
                        wire:navigate
                        class="flex items-center px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 rounded-full transition-colors"
                    >
                        Assignments
                    </a>
                </div>
            @endif

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}" class="mt-6 pt-6 border-t border-gray-200">
                @csrf
                <button 
                    type="submit"
                    class="w-full flex items-center justify-center px-6 py-2 text-sm font-medium bg-red-50 text-red-700 hover:bg-red-100 rounded-full transition-colors"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Logout
                </button>
            </form>
        </nav>

        <!-- Close button for mobile -->
        <button 
            @click="$store.sidebar.close()" 
            class="lg:hidden absolute top-4 right-4 p-2 text-gray-600 hover:bg-gray-50 rounded-full"
            aria-label="Close sidebar"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </aside>

    <!-- Main Content -->
    <main class="lg:ml-0 mt-20 lg:mt-0 min-h-screen">
        <!-- Flash Messages -->
        @if($errors->any())
            <div class="mx-4 mt-4 lg:mx-6 lg:mt-6">
                <div class="bg-red-100 border border-red-200 text-red-800 px-4 py-3 rounded flex items-start justify-between">
                    <div>
                        <h3 class="font-semibold mb-1">Error</h3>
                        <ul class="text-sm space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button 
                        @click="$el.parentElement.remove()"
                        class="text-red-600 hover:text-red-800"
                    >
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" />
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="mx-4 mt-4 lg:mx-6 lg:mt-6">
                <div class="bg-green-100 border border-green-200 text-green-800 px-4 py-3 rounded flex items-start justify-between">
                    <div>
                        <h3 class="font-semibold">Success</h3>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                    <button 
                        @click="$el.parentElement.remove()"
                        class="text-green-600 hover:text-green-800"
                    >
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" />
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        <!-- Page Content -->
        <div class="px-4 py-6 lg:px-6 lg:py-8">
            {{ $slot }}
        </div>
    </main>

    <!-- Alpine.js Store for Sidebar and Reports -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('sidebar', {
                open: false,
                toggle() {
                    this.open = !this.open;
                },
                close() {
                    this.open = false;
                }
            });

            Alpine.store('reports', {
                open: false,
                toggle() {
                    this.open = !this.open;
                }
            });
        });
    </script>

    @livewireScripts
</body>
</html>
