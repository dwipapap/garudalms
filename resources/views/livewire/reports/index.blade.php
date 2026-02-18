<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Reports</h1>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Courses Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <div>
                <p class="text-sm text-gray-500 uppercase">Total Courses</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['total_courses'] }}</p>
            </div>

            <div class="mt-6">
                <a
                    href="{{ route('reports.courses') }}"
                    wire:navigate
                    class="inline-block px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-full hover:bg-blue-700 transition-colors"
                >
                    View Details
                </a>
            </div>
        </div>

        <!-- Total Students Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <div>
                <p class="text-sm text-gray-500 uppercase">Total Students</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['total_students'] }}</p>
            </div>

            <div class="mt-6">
                <a
                    href="{{ route('reports.courses') }}"
                    wire:navigate
                    class="inline-block px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-full hover:bg-blue-700 transition-colors"
                >
                    View Details
                </a>
            </div>
        </div>

        <!-- Pending Submissions Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <div>
                <p class="text-sm text-gray-500 uppercase">Pending Submissions to Grade</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['pending_submissions'] }}</p>
            </div>

            <div class="mt-6">
                <a
                    href="{{ route('reports.assignments') }}"
                    wire:navigate
                    class="inline-block px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-full hover:bg-blue-700 transition-colors"
                >
                    View Details
                </a>
            </div>
        </div>
    </div>
</div>
