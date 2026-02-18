<div class="space-y-8">
    @if($isDosen)
        <!-- Dosen Dashboard -->
        <div>
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard Dosen</h1>
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Courses -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-sm text-gray-500 uppercase tracking-wide">Total Courses</div>
                    <div class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['total_courses'] }}</div>
                </div>
                
                <!-- Total Students -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-sm text-gray-500 uppercase tracking-wide">Total Students</div>
                    <div class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['total_students'] }}</div>
                </div>
                
                <!-- Pending Submissions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-sm text-gray-500 uppercase tracking-wide">Pending Submissions</div>
                    <div class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['pending_submissions'] }}</div>
                </div>
            </div>
            
            <!-- Recent Courses -->
            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Recent Courses</h2>
                @if($recentCourses->isEmpty())
                    <p class="text-gray-500">No courses created yet.</p>
                @else
                    <div class="space-y-4">
                        @foreach($recentCourses as $course)
                            <div class="border-b border-gray-200 pb-4 last:border-b-0">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-semibold text-gray-800">{{ $course->name }}</h3>
                                        <p class="text-sm text-gray-500">{{ $course->students_count }} students</p>
                                    </div>
                                    <a 
                                        href="{{ route('courses.show', $course->id) }}"
                                        wire:navigate
                                        class="px-6 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-colors text-sm font-medium"
                                    >
                                        View
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            
            <!-- Pending Grading -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Pending Grading</h2>
                @if($pendingGrading->isEmpty())
                    <p class="text-gray-500">No submissions to grade.</p>
                @else
                    <div class="space-y-4">
                        @foreach($pendingGrading as $submission)
                            <div class="border-b border-gray-200 pb-4 last:border-b-0">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-semibold text-gray-800">{{ $submission->assignment->title }}</h3>
                                        <p class="text-sm text-gray-600">{{ $submission->student->name }}</p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            Due: {{ $submission->assignment->deadline->format('M d, Y H:i') }}
                                        </p>
                                    </div>
                                    <a 
                                        href="{{ route('assignments.show', $submission->assignment->id) }}"
                                        wire:navigate
                                        class="px-6 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-colors text-sm font-medium"
                                    >
                                        Grade
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @else
        <!-- Mahasiswa Dashboard -->
        <div>
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard Mahasiswa</h1>
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Enrolled Courses -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-sm text-gray-500 uppercase tracking-wide">Enrolled Courses</div>
                    <div class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['enrolled_courses'] }}</div>
                </div>
                
                <!-- Completed Assignments -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-sm text-gray-500 uppercase tracking-wide">Completed Assignments</div>
                    <div class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['completed_assignments'] }}</div>
                </div>
                
                <!-- Pending Assignments -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-sm text-gray-500 uppercase tracking-wide">Pending Assignments</div>
                    <div class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['pending_assignments'] }}</div>
                </div>
            </div>
            
            <!-- My Courses -->
            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">My Courses</h2>
                @if($enrolledCourses->isEmpty())
                    <p class="text-gray-500">You are not enrolled in any courses yet.</p>
                @else
                    <div class="space-y-4">
                        @foreach($enrolledCourses as $course)
                            <div class="border-b border-gray-200 pb-4 last:border-b-0">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-semibold text-gray-800">{{ $course->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $course->lecturer->name }}</p>
                                    </div>
                                    <a 
                                        href="{{ route('courses.show', $course->id) }}"
                                        wire:navigate
                                        class="px-6 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-colors text-sm font-medium"
                                    >
                                        View
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            
            <!-- Upcoming Assignments -->
            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Upcoming Assignments</h2>
                @if($upcomingAssignments->isEmpty())
                    <p class="text-gray-500">No pending assignments.</p>
                @else
                    <div class="space-y-4">
                        @foreach($upcomingAssignments as $assignment)
                            <div class="border-b border-gray-200 pb-4 last:border-b-0">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-semibold text-gray-800">{{ $assignment->title }}</h3>
                                        <p class="text-sm text-gray-600">{{ $assignment->course->name }}</p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            Due: {{ $assignment->deadline->format('M d, Y H:i') }}
                                        </p>
                                    </div>
                                    <a 
                                        href="{{ route('assignments.show', $assignment->id) }}"
                                        wire:navigate
                                        class="px-6 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-colors text-sm font-medium"
                                    >
                                        Submit
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            
            <!-- Recent Discussions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Recent Discussions</h2>
                @if($recentDiscussions->isEmpty())
                    <p class="text-gray-500">No discussions yet.</p>
                @else
                    <div class="space-y-4">
                        @foreach($recentDiscussions as $discussion)
                            <div class="border-b border-gray-200 pb-4 last:border-b-0">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-semibold text-gray-800">{{ $discussion->course->name }}</h3>
                                        <p class="text-sm text-gray-600 truncate">{{ $discussion->content }}</p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            by {{ $discussion->user->name }}
                                        </p>
                                    </div>
                                    <a 
                                        href="{{ route('discussions.show', $discussion->id) }}"
                                        wire:navigate
                                        class="px-6 py-2 bg-gray-200 text-gray-800 rounded-full hover:bg-gray-300 transition-colors text-sm font-medium"
                                    >
                                        View
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
