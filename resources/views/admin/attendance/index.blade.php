@extends('admin.include.layout')
@section('content')
    <div class="bg-gradient-to-r from-white to-gray-50 rounded-xl shadow-md mb-8 p-6 border border-gray-100">
        <div class="flex flex-wrap justify-between items-center">
            <div class="mb-4 sm:mb-0">
                <h2 class="text-2xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                    {{ EmpLogin()->name ?? '' }}</h2>
                <p class="text-sm text-gray-500 mt-1 flex items-center gap-1">
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                            clip-rule="evenodd" />
                    </svg>
                   {{ EmpLogin()->designation ?? "" }}
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                {{-- <div class="status">
                    <select name="status" id="statusMark"
                        class="px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-gray-50 hover:bg-white">
                        <option value="">-- Mark Attendance --</option>
                        <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>✅ Present</option>
                        <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>❌ Absent</option>
                        <option value="late" {{ request('status') == 'leave' ? 'selected' : '' }}> Leave</option>
                        <option value="half_day" {{ request('status') == 'half_day' ? 'selected' : '' }}>🌓 Half Day
                        </option>
                    </select>
                </div> --}}
                <button id="startWorkBtn"
                    class="px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2 transform hover:scale-105">
                    <input type="hidden" name="employee_id" id="empID" value="{{ EmpLogin()->id }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span
                        class="font-semibold">{{ optional($eventCount)->event_count == 1 ? 'Working Start' : 'Start Work' }}</span>
                </button>
                <button id="lunchStartBtn"
                    class="px-5 py-2.5 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 text-white font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2 transform hover:scale-105">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span
                        class="font-semibold">{{ optional($eventCount)->lunch_count == 1 ? 'Break Started' : 'Break Start' }}</span>
                </button>
                <button id="lunchOutBtn"
                    class="px-5 py-2.5 bg-gradient-to-r from-sky-400 to-sky-500 hover:from-sky-500 hover:to-sky-600 text-white font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2 transform hover:scale-105">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    <span class="font-semibold">Break Out</span>
                </button>

                @if (optional($eventCount)->event_count == 1)
                    <button id="endWorkBtn"
                        class="px-5 py-2.5 bg-gradient-to-r from-rose-500 to-rose-600 hover:from-rose-600 hover:to-rose-700 text-white font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2 transform hover:scale-105">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path>
                        </svg>
                        <span class="font-semibold">End Work</span>
                    </button>
                @else
                    <button disabled
                        class="px-5 py-2.5 bg-gray-400 cursor-not-allowed text-white font-medium rounded-lg shadow-md flex items-center gap-2 opacity-70">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path>
                        </svg>
                        <span class="font-semibold">Wait For Next Day</span>
                    </button>
                @endif
                <button onclick="OpenLeave()"
                    class="px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2 transform hover:scale-105">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                     Leave
                </button>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md mb-8 p-6 border border-gray-100">
        <div class="flex flex-col md:flex-row justify-between gap-4 items-end">
            <div class="flex-1 w-full">
                <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-1">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filter by Status
                </label>
                <select name="status"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-gray-50 hover:bg-white">
                    <option value="">All Status</option>
                    <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>✅ Present</option>
                    <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>❌ Absent</option>
                    <option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>⏰ Late</option>
                    <option value="half_day" {{ request('status') == 'half_day' ? 'selected' : '' }}>🌓 Half Day</option>
                </select>
            </div>
            <div class="flex gap-3">
                <button type="submit"
                    class="px-6 py-2.5 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Apply Filter
                </button>
                <a href=""
                    class="px-6 py-2.5 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-all duration-200 shadow-md hover:shadow-lg inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Reset
                </a>
            </div>
        </div>
    </div>


    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Employee</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Start
                            Work</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Brack
                            Start</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Brack
                            Out</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">End
                            Work</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total
                            Hours</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Project</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($attendances ?? [] as $attendance)
                        <tr
                            class="hover:bg-gradient-to-r hover:from-emerald-50 hover:to-transparent transition-all duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $attendance->date->format('d-m-Y') ?? '' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-8 h-8 rounded-full bg-gradient-to-r from-emerald-400 to-emerald-600 flex items-center justify-center text-white font-semibold text-sm">
                                        {{ substr(EmpLogin()->name ?? 'N/A', 0, 1) }}
                                    </div>
                                    <span>{{ EmpLogin()->name ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if ($attendance->start_work)
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-green-100 text-green-700">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $attendance->start_work->format('h:i A') }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if ($attendance->lunch_start)
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-amber-100 text-amber-700">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $attendance->lunch_start->format('h:i A') }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if ($attendance->lunch_out)
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-sky-100 text-sky-700">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7" />
                                        </svg>
                                        {{ $attendance->lunch_out->format('h:i A') }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if ($attendance->end_work)
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-rose-100 text-rose-700">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $attendance->end_work->format('h:i A') }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <span
                                    class="inline-flex items-center gap-1 px-2 py-1 rounded-full {{ $attendance->total_hours >= 8 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $attendance->total_hours }} hrs
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold inline-flex items-center gap-1
                                    @if ($attendance->status == 'present') bg-green-100 text-green-800 border border-green-200
                                    @elseif($attendance->status == 'absent') bg-red-100 text-red-800 border border-red-200
                                    @elseif($attendance->status == 'late') bg-orange-100 text-orange-800 border border-orange-200
                                    @elseif($attendance->status == 'half_day') bg-blue-100 text-blue-800 border border-blue-200 @endif">
                                    @if ($attendance->status == 'present')
                                        ✅
                                    @elseif($attendance->status == 'absent')
                                        ❌
                                    @elseif($attendance->status == 'late')
                                        ⏰
                                    @elseif($attendance->status == 'half_day')
                                        🌓
                                    @endif
                                    {{ ucfirst($attendance->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if ($attendance->project)
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-purple-100 text-purple-700">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                        {{ $attendance->project->name }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <button onclick="openModal()"
                                    class="px-4 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2 transform hover:scale-105">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Work Update
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span class="text-gray-500 text-lg">No attendance records found</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $attendances->withQueryString()->links() ?? [] }}
        </div>
    </div>


    <div id="workModal"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50 transition-all duration-300">
        <div
            class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl p-6 relative transform transition-all duration-300 scale-95 opacity-0 animate-modal-in">
            <!-- Close Button -->
            <button onclick="closeModal()"
                class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition-colors duration-200 text-2xl w-8 h-8 rounded-full flex items-center justify-center hover:bg-red-50">
                &times;
            </button>

            <div class="flex items-center gap-3 mb-6 pb-3 border-b border-gray-200">
                <div
                    class="w-10 h-10 rounded-full bg-gradient-to-r from-emerald-500 to-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">
                    Work Update
                </h2>
            </div>

            <form action="{{ route('today.works') }}" method="POST">
                @csrf
                <input type="hidden" name="employee_id" value="{{ EmpLogin()->id ?? 0 }}">

                <div class="mb-6">
                    <label class="block mb-2 text-sm font-semibold text-gray-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        Select Project
                    </label>
                    <select name="project_id"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 bg-gray-50 hover:bg-white">
                        <option value="">Choose Project</option>
                        @foreach ($projects as $p)
                            <option value="{{ $p->project->id }}" class="py-2">
                                {{ $p->project->name }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div class="mb-6">
                    <label class="block mb-2 text-sm font-semibold text-gray-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                        Work Description
                    </label>
                    <textarea name="today_works" id="editor"
                        class="w-full border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200"></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-3 border-t border-gray-200">
                    <button type="button" onclick="closeModal()"
                        class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl transition-all duration-200 font-medium">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-6 py-2.5 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Submit Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="takeLeave"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50 transition-all duration-300">
        <div
            class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl p-6 relative transform transition-all duration-300 scale-95 opacity-0 animate-modal-in">
            <!-- Close Button -->
            <button onclick="leavecloseModal()"
                class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition-colors duration-200 text-2xl w-8 h-8 rounded-full flex items-center justify-center hover:bg-red-50">
                &times;
            </button>

            <div class="flex items-center gap-3 mb-6 pb-3 border-b border-gray-200">
                <div
                    class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">
                    Take Leaves
                </h2>
            </div>

            <form id="takeLeaveForm">
                @csrf

                <input type="hidden" id="employee_id" name="employee_id" value="{{ EmpLogin()->id ?? 0 }}">

                <!-- From Date -->
                <div class="mb-6">
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        From Date
                    </label>

                    <input type="date" name="from_date"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200">
                </div>

                <!-- To Date -->
                <div class="mb-6">
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        To Date
                    </label>

                    <input type="date" name="to_date"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200">
                </div>

                <!-- Reason -->
                <div class="mb-6">
                    <label class="block mb-2 text-sm font-semibold text-gray-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h7" />
                        </svg>

                        Reason
                    </label>

                    <textarea name="reason" rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200"
                        placeholder="Enter leave reason..."></textarea>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end gap-3 pt-3 border-t border-gray-200">


                    <button type="submit"
                        class="px-6 py-2.5 bg-gradient-to-r from-blue-800 to-emerald-600 hover:from-blue-600 hover:to-emerald-700 text-white rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-2">

                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>

                        Apply Leave
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div id="loader" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">

        <div class="bg-white p-4 rounded-xl shadow-lg flex items-center gap-3">
            <div class="w-6 h-6 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
            <span class="text-gray-700 font-medium">Please wait...</span>
        </div>

    </div>
    <style>
        @keyframes modalIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-modal-in {
            animation: modalIn 0.3s ease-out forwards;
        }
    </style>

    <script>



        function takeLeaves() {

            $("#takeLeaveForm").submit(function(e) {

                e.preventDefault();

                let data = $(this).serialize();

                $("#loader").removeClass('hidden');

                $.ajax({
                    url: "{{ route('TakeLeave') }}",
                    type: "POST",
                    data: data,

                    success: function(response) {
                        $("#loader").addClass('hidden');

                        showNotification(response.message, 'success');
                        $("#takeLeaveForm")[0].reset();
                        console.log(response);
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    },
                    error: function(error) {
                        $("#loader").addClass('hidden');
                        console.log(error);
                        if (error.responseJSON.errors) {
                            $.each(error.responseJSON.errors, function(key, value) {
                                showNotification(value[0], 'error');
                            });
                        } else {
                            showNotification('Something went wrong!', 'error');
                        }
                    }
                });

            });

        }

        function statusMarks() {
            $(document).ready(function() {
                $("#statusMark").on('change', function() {
                    let empId = $("#empID").val();
                    let status = $(this).val();
                    $.ajax({
                        type: "POST",
                        url: "{{ route('dailyAttendance') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            empId: empId,
                            status: status
                        },
                        success: function(res) {

                            showNotification(res.message, 'success');
                            setTimeout(() => location.reload(), 1000);
                        },
                        error: function(error) {
                            console.log(error);

                        }
                    });

                });
            });
        }

        function WorkStart() {
            $(document).ready(function() {
                $("#startWorkBtn").on('click', function() {
                    let btn = $(this);
                    let empId = $("#empID").val();

                    // Add loading state
                    const originalText = btn.html();
                    btn.html(
                        '<svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> Processing...'
                    ).prop('disabled', true);

                    $.ajax({
                        type: "POST",
                        url: "{{ route('attendance.start-work') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            empId: empId
                        },
                        success: function(res) {
                            if (res.success == "start") {
                                showNotification(res.message, 'success');
                                btn.html(originalText).prop('disabled', false);
                                setTimeout(() => location.reload(), 1500);
                            } else if (res.event_count == 1) {
                                showNotification(res.message, 'info');
                                btn.html(originalText).prop('disabled', false);
                            } else {
                                btn.html(originalText).prop('disabled', false);
                            }
                        },
                        error: function(error) {
                            showNotification('An error occurred', 'error');
                            btn.html(originalText).prop('disabled', false);
                            console.log(error);
                        }
                    });
                });
            });
        }

        function lunchStrat() {
            $(document).ready(function() {
                $("#lunchStartBtn").on('click', function() {
                    let btn = $(this);
                    let empId = $("#empID").val();

                    const originalText = btn.html();
                    btn.html(
                        '<svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> Processing...'
                    ).prop('disabled', true);

                    $.ajax({
                        type: "POST",
                        url: "{{ route('attendance.lunch-start') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            empId
                        },
                        success: function(res) {
                            if (res.fire == 'start') {
                                showNotification(res.message, 'success');
                                setTimeout(() => location.reload(), 1500);
                            }
                            btn.html(originalText).prop('disabled', false);
                        },
                        error: function(error) {
                            showNotification('An error occurred', 'error');
                            btn.html(originalText).prop('disabled', false);
                            console.log(error);
                        }
                    });
                });
            });
        }

        function lunchOut() {
            $(document).ready(function() {
                $("#lunchOutBtn").on('click', function() {
                    let btn = $(this);
                    let empId = $("#empID").val();

                    const originalText = btn.html();
                    btn.html(
                        '<svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> Processing...'
                    ).prop('disabled', true);

                    $.ajax({
                        type: "POST",
                        url: "{{ route('attendance.lunch-out') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            empId
                        },
                        success: function(res) {
                            if (res.fire == 'out') {
                                showNotification(res.message, 'success');
                                setTimeout(() => location.reload(), 1500);
                            }
                            btn.html(originalText).prop('disabled', false);
                        },
                        error: function(error) {
                            showNotification('An error occurred', 'error');
                            btn.html(originalText).prop('disabled', false);
                            console.log(error);
                        }
                    });
                });
            });
        }

        function WorkEnd() {
            $(document).ready(function() {
                $("#endWorkBtn").on('click', function() {
                    let btn = $(this);
                    let empId = $("#empID").val();

                    const originalText = btn.html();
                    btn.html(
                        '<svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> Processing...'
                    ).prop('disabled', true);

                    $.ajax({
                        type: "POST",
                        url: "{{ route('attendance.end-work') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            empId
                        },
                        success: function(res) {
                            showNotification('Work ended successfully', 'success');
                            setTimeout(() => location.reload(), 1500);
                        },
                        error: function(error) {
                            showNotification('An error occurred', 'error');
                            btn.html(originalText).prop('disabled', false);
                            console.log(error);
                        }
                    });
                });
            });
        }

        function showNotification(message, type = 'success') {
            const colors = {
                success: 'bg-green-500',
                error: 'bg-red-500',
                info: 'bg-blue-500'
            };

            const notification = $(`
                <div class="fixed top-4 right-4 z-50 animate-slide-in-right">
                    <div class="${colors[type]} text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            ${type === 'success' ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>' :
                              type === 'error' ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>' :
                              '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'}
                        </svg>
                        <span>${message}</span>
                    </div>
                </div>
            `);

            $('body').append(notification);
            setTimeout(() => {
                notification.fadeOut(300, function() {
                    $(this).remove();
                });
            }, 3000);
        }

        WorkStart();
        lunchStrat();
        lunchOut();
        WorkEnd();
        statusMarks();
        takeLeaves();
    </script>

    <style>
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .animate-slide-in-right {
            animation: slideInRight 0.3s ease-out;
        }
    </style>


    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    <script>
        function openModal() {
            const modal = document.getElementById('workModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            document.body.style.overflow = 'hidden';
        }

        function OpenLeave() {
            const modal = document.getElementById('takeLeave');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            const modal = document.getElementById('workModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');

            document.body.style.overflow = 'auto';
        }


        function leavecloseModal() {
            const modal = document.getElementById('takeLeave');
            modal.classList.add('hidden');
            modal.classList.remove('flex');

            document.body.style.overflow = 'auto';
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });


        document.getElementById('workModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeModal();
            }
        });
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });


        document.getElementById('takeLeave').addEventListener('click', function(event) {
            if (event.target === this) {
                closeModal();
            }
        });


        ClassicEditor
            .create(document.querySelector('#editor'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote'],
                heading: {
                    options: [{
                            model: 'paragraph',
                            title: 'Paragraph',
                            class: 'ck-heading_paragraph'
                        },
                        {
                            model: 'heading1',
                            view: 'h1',
                            title: 'Heading 1',
                            class: 'ck-heading_heading1'
                        },
                        {
                            model: 'heading2',
                            view: 'h2',
                            title: 'Heading 2',
                            class: 'ck-heading_heading2'
                        }
                    ]
                }
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
