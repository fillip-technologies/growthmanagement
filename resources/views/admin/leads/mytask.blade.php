@extends('admin.include.layout')
@section('heading', 'My Tasks')
@section('title', 'My Works')
@section('content')

<div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6">
    <h2 class="text-2xl font-bold text-gray-800">
        My Task
    </h2>
    <a href="{{ route('assingform') }}"
        class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white font-medium rounded-lg shadow hover:bg-blue-700 transition duration-200">
        + Assign Task
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 p-6">
    @forelse($leads as $task)
        <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
            <!-- Card Header -->
            <div class="p-4 border-b border-gray-100 flex justify-between items-start">
                <div class="flex items-center space-x-3">
                    <div class="h-12 w-12 flex-shrink-0 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                        <span class="text-white font-semibold text-sm">
                            {{ $task->leaddata ? substr($task->leaddata->name ?? 'NA', 0, 2) : 'NA' }}
                        </span>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900">
                            {{ $task->leaddata->name ?? 'Unknown Lead' }}
                        </h3>
                        <p class="text-xs text-gray-500">
                            {{ $task->leaddata->company_name ?? 'N/A' }}
                        </p>
                        @if($task->leaddata && $task->leaddata->industry)
                            <span class="text-xs text-gray-400">{{ $task->leaddata->industry }}</span>
                        @endif
                    </div>
                </div>
                <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                    {{ $task->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                    {{ $task->status == 'in_progress' ? 'bg-blue-100 text-blue-800' : '' }}
                    {{ $task->status == 'completed' ? 'bg-green-100 text-green-800' : '' }}
                    {{ $task->status == 'overdue' ? 'bg-red-100 text-red-800' : '' }}
                    {{ $task->status == 'on_hold' ? 'bg-gray-100 text-gray-800' : '' }}
                    @if(!$task->status) bg-gray-100 text-gray-800 @endif
                ">
                    {{ ucfirst($task->status ?? 'Pending') }}
                </span>
            </div>

            <!-- Card Body -->
            <div class="p-4 space-y-3">
                <!-- Task Description -->
                <div class="bg-indigo-50 rounded-lg p-3 border border-indigo-100">
                    <div class="flex items-start space-x-2">
                        <svg class="w-4 h-4 text-indigo-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <div>
                            <p class="text-xs font-medium text-indigo-700">Task Description</p>
                            <p class="text-sm text-gray-700 line-clamp-3">
                                {{ $task->task_description ?? 'No description provided' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Task Details -->
                <div class="grid grid-cols-2 gap-2">
                    @if($task->task_type)
                        <div>
                            <p class="text-xs text-gray-500">Task Type</p>
                            <p class="text-sm text-gray-700">{{ ucfirst($task->task_type) }}</p>
                        </div>
                    @endif
                    @if($task->priority)
                        <div>
                            <p class="text-xs text-gray-500">Priority</p>
                            <span class="text-xs font-semibold
                                {{ $task->priority == 'high' ? 'text-red-600' : '' }}
                                {{ $task->priority == 'medium' ? 'text-yellow-600' : '' }}
                                {{ $task->priority == 'low' ? 'text-green-600' : '' }}
                            ">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Due Date & Time -->
                @if($task->due_date)
                    <div class="flex items-center justify-between bg-red-50 rounded-lg p-2.5 border border-red-100">
                        <span class="text-xs text-gray-600">Due Date</span>
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-sm font-medium text-red-700">
                                {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y h:i A') }}
                            </span>
                        </div>
                    </div>
                @endif

                @if($task->leaddata)
                    <div class="border-t border-gray-100 pt-3">
                        <p class="text-xs font-semibold text-gray-500 mb-2">LEAD INFORMATION</p>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span class="text-sm text-gray-600 truncate">{{ $task->leaddata->email ?? 'N/A' }}</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <span class="text-sm text-gray-600">{{ $task->leaddata->phone ?? 'N/A' }}</span>
                            </div>
                        </div>

                        @if($task->leaddata->country || $task->leaddata->city)
                            <div class="flex items-center space-x-2 mt-1">
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="text-xs text-gray-600">
                                    @if($task->leaddata->city) {{ $task->leaddata->city }}, @endif
                                    @if($task->leaddata->state) {{ $task->leaddata->state }}, @endif
                                    @if($task->leaddata->country) {{ $task->leaddata->country }} @endif
                                </span>
                            </div>
                        @endif

                        <div class="flex items-center justify-between mt-2">
                            <div class="flex items-center space-x-2">
                                <span class="text-xs text-gray-500">Lead Status:</span>
                                <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $task->leaddata->lead_status == 'new' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $task->leaddata->lead_status == 'contacted' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $task->leaddata->lead_status == 'in_progress' ? 'bg-purple-100 text-purple-800' : '' }}
                                    {{ $task->leaddata->lead_status == 'converted' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $task->leaddata->lead_status == 'lost' ? 'bg-red-100 text-red-800' : '' }}
                                    @if(!$task->leaddata->lead_status) bg-gray-100 text-gray-800 @endif
                                ">
                                    {{ ucfirst($task->leaddata->lead_status ?? 'New') }}
                                </span>
                            </div>
                            @if($task->leaddata->budget)
                                <span class="text-xs text-green-600 font-medium">
                                    Budget: {{ $task->leaddata->budget }}
                                    @if($task->leaddata->budget_type) ({{ $task->leaddata->budget_type }}) @endif
                                </span>
                            @endif
                        </div>

                        @if($task->leaddata->lead_source)
                            <div class="flex items-center space-x-2 mt-1">
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9.1-1.645M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span class="text-xs text-gray-600">Source: {{ ucfirst(str_replace('_', ' ', $task->leaddata->lead_source)) }}</span>
                            </div>
                        @endif
                    </div>
                @endif

                <div class="flex items-center justify-between text-xs text-gray-400 pt-1 border-t border-gray-100">
                    <span>Assigned: {{ $task->created_at ? $task->created_at->format('M d, Y') : 'N/A' }}</span>
                    <span>#{{ $loop->iteration }}</span>
                </div>
            </div>

            <!-- Card Footer with Actions -->
            <div class="px-4 py-3 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    @if($task->user)
                        <div class="flex items-center space-x-1">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="text-xs text-gray-600">{{ $task->user->name ?? 'N/A' }}</span>
                        </div>
                    @endif
                </div>
                <div class="flex space-x-3">
                    <a href="" class="text-blue-600 hover:text-blue-800 transition-colors" title="View Task">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </a>
                    <a href="" class="text-indigo-600 hover:text-indigo-800 transition-colors" title="Edit Task">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </a>
                    <form action="" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this task?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 transition-colors" title="Delete Task">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
                    @if($task->leaddata)
                        <a href="" class="text-green-600 hover:text-green-800 transition-colors" title="View Lead">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full">
            <div class="bg-white rounded-xl shadow-md p-12 text-center">
                <div class="flex flex-col items-center">
                    <svg class="w-20 h-20 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <p class="text-xl font-medium text-gray-700">No tasks assigned</p>
                    <p class="text-sm text-gray-500 mt-1">You don't have any tasks at the moment</p>
                    <div class="mt-6 flex flex-col sm:flex-row gap-3">
                        <a href="" class="px-6 py-2.5 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-all shadow-md hover:shadow-lg">
                            Go to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination (if needed) -->
@if(method_exists($leads, 'links'))
    <div class="mt-4 px-6">
        {{ $leads->links() }}
    </div>
@endif

@endsection
