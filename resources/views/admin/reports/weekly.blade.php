@extends('admin.include.layout')

@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header Section -->
        <div
            class="bg-gradient-to-br from-indigo-600 via-indigo-500 to-purple-600 rounded-2xl p-8 mb-8 shadow-xl relative overflow-hidden">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-48 h-48 bg-purple-400/20 rounded-full blur-2xl"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-5">
                <div>
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <span class="text-white/80 text-sm font-medium tracking-wide uppercase">Weekly Overview</span>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">
                        Weekly Report
                    </h1>
                    <p class="text-indigo-100 text-base">
                        Track all projects, progress, priorities & deadlines at a glance
                    </p>
                </div>

                <div class="bg-white/10 backdrop-blur-lg border border-white/20 rounded-2xl px-6 py-4 shadow-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-indigo-100 text-xs font-medium tracking-wide">CURRENT WEEK</p>
                            <h3 class="text-white font-bold text-lg">
                                {{ now()->startOfWeek()->format('d M') }} - {{ now()->endOfWeek()->format('d M Y') }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            <div
                class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 transition-all duration-300 hover:shadow-md hover:scale-[1.02]">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Total Projects</p>
                        <h2 class="text-3xl font-bold text-gray-800">{{ $tasks->count() }}</h2>
                        <p class="text-xs text-gray-400 mt-2">Active this week</p>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center">
                        <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 transition-all duration-300 hover:shadow-md hover:scale-[1.02]">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Completed</p>
                        <h2 class="text-3xl font-bold text-emerald-600">{{ $tasks->where('status', 'completed')->count() }}
                        </h2>
                        <p class="text-xs text-gray-400 mt-2">Successfully delivered</p>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center">
                        <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 transition-all duration-300 hover:shadow-md hover:scale-[1.02]">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium mb-1">Pending</p>
                        <h2 class="text-3xl font-bold text-amber-600">{{ $tasks->where('status', 'pending')->count() }}</h2>
                        <p class="text-xs text-gray-400 mt-2">Awaiting completion</p>
                    </div>
                    <div class="w-14 h-14 rounded-2xl bg-amber-50 flex items-center justify-center">
                        <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <!-- Table Header -->
            <div
                class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 p-6 border-b border-gray-100 bg-gray-50/50">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Project Reports</h2>
                    <p class="text-gray-500 text-sm mt-0.5">Overview of all weekly project activities</p>
                </div>
                <div class="relative">
                    <input type="text" placeholder="Search project..."
                        class="w-full md:w-80 border border-gray-200 rounded-xl pl-11 pr-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                    <svg class="absolute left-3.5 top-3 w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-[1100px]">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Project</th>
                            <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Description</th>
                            <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Modules</th>
                            <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Timeline</th>
                            <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Priority</th>
                            <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($tasks as $task)
                            <tr class="hover:bg-indigo-50/30 transition duration-200 group">
                                <!-- Project -->
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-11 h-11 rounded-xl bg-gradient-to-br from-indigo-100 to-indigo-200 flex items-center justify-center font-bold text-indigo-700 text-base shadow-sm">
                                            {{ strtoupper(substr($task->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <h3
                                                class="font-semibold text-gray-800 text-sm group-hover:text-indigo-600 transition">
                                                {{ $task->name }}
                                            </h3>
                                            <p class="text-xs text-gray-400 mt-0.5">Project Task</p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Description -->
                                <td class="px-6 py-5">
                                    <p class="text-gray-600 text-sm leading-relaxed max-w-xs line-clamp-2">
                                        {{ Str::limit($task->description, 80) }}
                                    </p>
                                </td>

                                <!-- Modules -->
                                <td class="px-6 py-5">
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach (array_slice($task->modules ?? [], 0, 2) as $module)
                                            <span
                                                class="bg-indigo-50 text-indigo-700 px-2.5 py-1 rounded-lg text-xs font-medium">
                                                {{ $module }}
                                            </span>
                                        @endforeach
                                        @if (count($task->modules ?? []) > 2)
                                            <span
                                                class="bg-gray-100 text-gray-600 px-2.5 py-1 rounded-lg text-xs font-medium">
                                                +{{ count($task->modules) - 2 }}
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Timeline -->
                                <td class="px-6 py-5">
                                    <div class="space-y-1.5">
                                        <div class="flex items-center gap-2 text-xs">
                                            <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                            <span
                                                class="text-gray-600">{{ \Carbon\Carbon::parse($task->start_date)->format('d M Y') }}</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-xs">
                                            <div class="w-2 h-2 rounded-full bg-rose-500"></div>
                                            <span
                                                class="text-gray-600">{{ \Carbon\Carbon::parse($task->end_date)->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Priority -->
                                <td class="px-6 py-5">
                                    @if ($task->priority == 'high')
                                        <span
                                            class="inline-flex items-center gap-1.5 bg-rose-50 text-rose-700 px-3 py-1.5 rounded-lg text-xs font-semibold">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                            High
                                        </span>
                                    @elseif($task->priority == 'medium')
                                        <span
                                            class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-700 px-3 py-1.5 rounded-lg text-xs font-semibold">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                                            </svg>
                                            Medium
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 px-3 py-1.5 rounded-lg text-xs font-semibold">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Low
                                        </span>
                                    @endif
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-5">
                                    @if ($task->status == 'completed')
                                        <span
                                            class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 px-3 py-1.5 rounded-lg text-xs font-semibold">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Completed
                                        </span>
                                    @elseif($task->status == 'pending')
                                        <span
                                            class="inline-flex items-center gap-1.5 bg-gray-100 text-gray-600 px-3 py-1.5 rounded-lg text-xs font-semibold">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Pending
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg text-xs font-semibold">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                            {{ ucfirst($task->status) }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-20 h-20 rounded-full bg-indigo-50 flex items-center justify-center mb-4">
                                            <svg class="w-10 h-10 text-indigo-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-700 mb-1">No Weekly Report Found</h3>
                                        <p class="text-gray-400 text-sm">No project activities available for this week.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
