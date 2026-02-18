<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">Course Statistics</h1>
        <a
            href="{{ route('reports.index') }}"
            wire:navigate
            class="text-sm text-blue-600 hover:text-blue-800 font-medium"
        >
            Back to Reports
        </a>
    </div>

    @if($courses->isEmpty())
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <p class="text-gray-500">You haven't created any courses yet.</p>
        </div>
    @else
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Course Name</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Students</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Assignments</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Materials</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($courses as $course)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-800 font-medium">
                                <a
                                    href="{{ route('courses.show', $course->id) }}"
                                    wire:navigate
                                    class="text-blue-600 hover:text-blue-800"
                                >
                                    {{ $course->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $course->students_count }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $course->assignments_count }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $course->materials_count }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $courses->links() }}
        </div>
    @endif
</div>
