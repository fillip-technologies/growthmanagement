@extends('admin.include.layout')
@section('heading', 'Projects')
@section('title', 'Add Project')

@section('content')
    <div class="p-4 md:p-6 max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 tracking-tight">Project Details</h1>
                <p class="text-sm text-gray-500 mt-1 flex items-center gap-1">
                    <span class="inline-block w-1.5 h-1.5 rounded-full bg-blue-500 mr-1"></span>
                    View complete project and employee information
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href=""
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition-all duration-200 text-sm font-medium shadow-sm hover:shadow">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Projects
                </a>
            </div>
        </div>

        <!-- Project Overview Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-5 mb-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 transition-all hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div class="text-sm font-medium text-gray-400 uppercase tracking-wider">Project Name</div>
                    <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="text-lg font-semibold text-gray-800 truncate mt-1">{{ $data->project->name ?? 'N/A' }}</div>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 transition-all hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div class="text-sm font-medium text-gray-400 uppercase tracking-wider">Status</div>
                    <div class="w-8 h-8 rounded-full bg-green-50 flex items-center justify-center text-green-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-1">
                    <span
                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                    @if ($data->project->status == 'completed') bg-emerald-100 text-emerald-800
                    @elseif($data->project->status == 'in-progress') bg-blue-100 text-blue-800
                    @elseif($data->project->status == 'on-hold') bg-amber-100 text-amber-800
                    @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst($data->project->status ?? 'N/A') }}
                    </span>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 transition-all hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div class="text-sm font-medium text-gray-400 uppercase tracking-wider">Employees</div>
                    <div class="w-8 h-8 rounded-full bg-violet-50 flex items-center justify-center text-violet-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="text-2xl font-bold text-gray-800 mt-1">{{ $data->employee->count() ?? 0 }}</div>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 transition-all hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div class="text-sm font-medium text-gray-400 uppercase tracking-wider">Duration</div>
                    <div class="w-8 h-8 rounded-full bg-amber-50 flex items-center justify-center text-amber-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="text-sm font-semibold text-gray-800 mt-1">
                    {{ \Carbon\Carbon::parse($data->project->start_date)->format('M d, Y') }} -
                    {{ $data->project->end_date ? \Carbon\Carbon::parse($data->project->end_date)->format('M d, Y') : 'Ongoing' }}
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Project Details + Progress -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Project Details -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                            <span class="w-1 h-6 bg-blue-500 rounded-full"></span>
                            Project Information
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="text-xs font-medium text-gray-400 uppercase tracking-wider">Project ID</label>
                                <p class="text-base font-medium text-gray-900 mt-1">
                                    {{ $data->project->project_id ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-400 uppercase tracking-wider">Project
                                    Type</label>
                                <p class="text-base font-medium text-gray-900 mt-1">{{ $data->project->type ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-400 uppercase tracking-wider">Start Date</label>
                                <p class="text-base font-medium text-gray-900 mt-1">
                                    {{ \Carbon\Carbon::parse($data->project->start_date)->format('F d, Y') }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-400 uppercase tracking-wider">End Date</label>
                                <p class="text-base font-medium text-gray-900 mt-1">
                                    {{ $data->project->end_date ? \Carbon\Carbon::parse($data->project->end_date)->format('F d, Y') : 'Ongoing' }}
                                </p>
                            </div>
                            <div class="sm:col-span-2">
                                <label class="text-xs font-medium text-gray-400 uppercase tracking-wider">Project
                                    Description</label>
                                <p class="text-base text-gray-700 mt-1 leading-relaxed">
                                    {{ $data->project->description ?? 'No description provided' }}</p>
                            </div>
                            <div class="sm:col-span-2">
                                <label class="text-xs font-medium text-gray-400 uppercase tracking-wider">Today's
                                    Works</label>
                                <div class="text-base text-gray-700 mt-1 leading-relaxed prose prose-sm max-w-none">
                                    {!! $data->today_works !!}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Project Progress -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                            <span class="w-1 h-6 bg-emerald-500 rounded-full"></span>
                            Project Progress
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700">Completion</span>
                                <span class="text-sm font-bold text-gray-800">{{ $data->project->progress ?? 0 }}%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                                <div class="bg-gradient-to-r from-blue-500 to-emerald-400 h-3 rounded-full transition-all duration-700 ease-out"
                                    style="width: {{ $data->project->progress ?? 0 }}%"></div>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-4 pt-2">
                            <div class="text-center p-3 bg-blue-50/50 rounded-xl">
                                <div class="text-2xl font-bold text-blue-600">{{ $data->project->tasks_completed ?? 0 }}
                                </div>
                                <div class="text-xs font-medium text-gray-500 mt-0.5">Completed</div>
                            </div>
                            <div class="text-center p-3 bg-amber-50/50 rounded-xl">
                                <div class="text-2xl font-bold text-amber-600">{{ $data->project->tasks_pending ?? 0 }}
                                </div>
                                <div class="text-xs font-medium text-gray-500 mt-0.5">Pending</div>
                            </div>
                            <div class="text-center p-3 bg-emerald-50/50 rounded-xl">
                                <div class="text-2xl font-bold text-emerald-600">
                                    {{ ($data->project->tasks_completed ?? 0) + ($data->project->tasks_pending ?? 0) }}
                                </div>
                                <div class="text-xs font-medium text-gray-500 mt-0.5">Total</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Employee Information -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-6">
                    <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-indigo-50/50 to-blue-50/50">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                            <span class="w-1 h-6 bg-indigo-500 rounded-full"></span>
                            Employee Information
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-6">
                            <div
                                class="h-20 w-20 rounded-2xl bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center shadow-inner">
                                <span class="text-2xl font-bold text-indigo-700">
                                    {{ substr($data->employee->name ?? 'N/A', 0, 2) }}
                                </span>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-xl font-bold text-gray-900">{{ $data->employee->name ?? 'N/A' }}</h3>
                                <p class="text-sm text-gray-500">{{ $data->employee->designation ?? 'N/A' }}</p>
                                <span
                                    class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                    {{ $data->employee->status ?? 'Active' }}
                                </span>
                            </div>
                        </div>

                        <div class="space-y-5">
                            <div class="border-t border-gray-100 pt-5">
                                <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Personal
                                    Details</h4>
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center border-b border-gray-50 pb-2">
                                        <span class="text-xs text-gray-400">Email</span>
                                        <span
                                            class="text-sm font-medium text-gray-800">{{ $data->employee->email ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center border-b border-gray-50 pb-2">
                                        <span class="text-xs text-gray-400">Phone</span>
                                        <span
                                            class="text-sm font-medium text-gray-800">{{ $data->employee->phone ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center border-b border-gray-50 pb-2">
                                        <span class="text-xs text-gray-400">Department</span>
                                        <span
                                            class="text-sm font-medium text-gray-800">{{ $data->employee->department ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-gray-400">Employee ID</span>
                                        <span
                                            class="text-sm font-medium text-gray-800">{{ $data->employee->employeeID ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-gray-100 pt-5">
                                <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Attendance
                                </h4>
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center border-b border-gray-50 pb-2">
                                        <span class="text-xs text-gray-400">Date</span>
                                        <span
                                            class="text-sm font-medium text-gray-800">{{ \Carbon\Carbon::parse($data->attendance_date)->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center border-b border-gray-50 pb-2">
                                        <span class="text-xs text-gray-400">Check In</span>
                                        <span class="text-sm font-medium text-gray-800">
                                            {{ $data->start_work ? \Carbon\Carbon::parse($data->start_work)->format('l, h:i A') : 'N/A' }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center border-b border-gray-50 pb-2">
                                        <span class="text-xs text-gray-400">Check Out</span>
                                        <span
                                            class="text-sm font-medium text-gray-800">{{ $data->end_work ? \Carbon\Carbon::parse($data->end_work)->format('l, h:i A') : 'N/A' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center border-b border-gray-50 pb-2">
                                        <span class="text-xs text-gray-400">Hours</span>
                                        <span
                                            class="text-sm font-medium text-gray-800">{{ $data->total_hours ? \Carbon\Carbon::parse($data->total_hours)->format('l, h:i A') : 'N/A' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-gray-400">Status</span>
                                        <span
                                            class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if ($data->status == 'present') bg-emerald-100 text-emerald-800
                                        @elseif($data->status == 'absent') bg-red-100 text-red-800
                                        @elseif($data->status == 'late') bg-amber-100 text-amber-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($data->status ?? 'N/A') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Styles -->
    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
            }

            .shadow-sm,
            .shadow {
                box-shadow: none !important;
            }

            .rounded-2xl,
            .rounded-xl {
                border-radius: 0 !important;
            }

            .border {
                border-color: #e5e7eb !important;
            }

            .bg-gray-50\50,
            .bg-indigo-50\50,
            .bg-blue-50\50 {
                background: #f9fafb !important;
            }
        }
    </style>
@endsection
