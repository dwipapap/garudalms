<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">Assignment Statistics</h1>
        <a
            href="{{ route('reports.index') }}"
            wire:navigate
            class="text-sm text-blue-600 hover:text-blue-800 font-medium"
        >
            Back to Reports
        </a>
    </div>

    @if($assignments->isEmpty())
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <p class="text-gray-500">No assignments found.</p>
        </div>
    @else
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Assignment</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Course</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Submissions</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Graded</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Pending</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">% Complete</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($assignments as $assignment)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-800 font-medium">{{ $assignment['title'] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $assignment['course']->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 text-center">{{ $assignment['total_submissions'] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 text-center">{{ $assignment['graded'] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 text-center">{{ $assignment['pending'] }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex-1 bg-gray-200 rounded-full h-2">
                                        <div
                                            class="bg-blue-600 h-2 rounded-full transition-all"
                                            style="width: {{ $assignment['percentage_graded'] }}%"
                                        ></div>
                                    </div>
                                    <span class="text-xs font-medium text-gray-600 w-10 text-right">{{ $assignment['percentage_graded'] }}%</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
