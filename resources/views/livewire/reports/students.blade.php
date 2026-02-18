<div class="space-y-6">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="bg-blue-600 p-6">
            <h1 class="text-2xl font-bold text-white">Laporan Perkembangan Mahasiswa</h1>
        </div>
        
        <div class="p-6">
            <div class="flex items-center space-x-4 mb-8">
                <div class="h-16 w-16 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-2xl uppercase">
                    {{ substr($student->name, 0, 1) }}
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">{{ $student->name }}</h2>
                    <p class="text-gray-500">{{ $student->email }}</p>
                </div>
            </div>

            <div class="space-y-8">
                @foreach($courses as $course)
                    <div class="border rounded-lg p-5">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">{{ $course->name }}</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                            <div class="bg-gray-50 p-3 rounded text-center">
                                <span class="block text-xs font-semibold text-gray-500 uppercase tracking-widest">Tugas Selesai</span>
                                <span class="text-xl font-bold text-gray-800">
                                    {{ $course->assignments->filter(fn($a) => $a->submissions->count() > 0)->count() }} / {{ $course->assignments->count() }}
                                </span>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="bg-gray-50 text-gray-700 font-semibold uppercase text-xs">
                                    <tr>
                                        <th class="px-4 py-2 border-b">Nama Tugas</th>
                                        <th class="px-4 py-2 border-b">Status</th>
                                        <th class="px-4 py-2 border-b text-right">Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($course->assignments as $assignment)
                                        @php $submission = $assignment->submissions->first() @endphp
                                        <tr>
                                            <td class="px-4 py-3 border-b">{{ $assignment->title }}</td>
                                            <td class="px-4 py-3 border-b">
                                                @if($submission)
                                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs">Sudah Dikumpul</span>
                                                @else
                                                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs">Belum Dikumpul</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 border-b text-right">
                                                @if($submission && $submission->score !== null)
                                                    <span class="font-bold {{ $submission->score >= 75 ? 'text-green-600' : 'text-red-600' }}">
                                                        {{ $submission->score }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
