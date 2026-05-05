@extends('admin.include.layout')
@section('heading', 'Reports')
@section('title', 'Information')
@section('content')
    <div class="container mx-auto px-6 py-6">

        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Employee Performance Reports</h1>
            <p class="text-sm text-gray-500">Task & Performance Overview</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

            <!-- Completed -->
            <div class="bg-green-100 border-l-4 border-green-500 p-5 rounded-xl shadow">
                <h3 class="text-sm font-semibold text-green-700">Completed Tasks</h3>
                <p class="text-3xl font-bold text-green-800 mt-2">
                    {{ $completedCount ?? 0 }}
                </p>
            </div>

            <!-- In Progress -->
            <div class="bg-blue-100 border-l-4 border-blue-500 p-5 rounded-xl shadow">
                <h3 class="text-sm font-semibold text-blue-700">In Progress</h3>
                <p class="text-3xl font-bold text-blue-800 mt-2">
                    {{ $inProgressCount ?? 0 }}
                </p>
            </div>

            <!-- Pending -->
            <div class="bg-yellow-100 border-l-4 border-yellow-500 p-5 rounded-xl shadow">
                <h3 class="text-sm font-semibold text-yellow-700">Pending Tasks</h3>
                <p class="text-3xl font-bold text-yellow-800 mt-2">
                    {{ $pendingCount ?? 0 }}
                </p>
            </div>

        </div>

        <!-- Report Details -->
        <div class="bg-white rounded-xl shadow p-6 mb-8">
            <h2 class="text-lg font-semibold mb-4 text-gray-700">Latest Task Report</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500">Employee Name</p>
                    <p class="font-semibold">
                        {{ $get_report->employee->name ?? 'N/A' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Task Name</p>
                    <p class="font-semibold">
                        {{ $get_report->task->task_name ?? 'N/A' }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Deadline</p>
                    <p class="font-semibold text-red-600">
                        @php
                            use Carbon\Carbon;
                            $deadlineObj = Carbon::parse($deadline);
                        @endphp
                        {{ $deadlineObj->format('d/m/y h:i A') }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Submitted At</p>
                    <p class="font-semibold text-green-600">
                        @php
                            $submittedObj = Carbon::parse($created_at);
                        @endphp
                        {{ $submittedObj->format('d/m/y h:i A') }}
                    </p>
                </div>
            </div>

            <div class="mt-6">
                <p class="text-sm text-gray-500">Time Difference</p>
                <p class="font-bold text-lg">
                    @php

                        // Calculate difference in minutes (negative = early)
                        $diffInMinutes = $deadlineObj->diffInMinutes($submittedObj, false);

                        $isEarly = $diffInMinutes < 0;
                        $diffInMinutes = abs($diffInMinutes);

                        $days = intdiv($diffInMinutes, 60 * 24); // total days
                        $hours = intdiv($diffInMinutes % (60 * 24), 60); // remaining hours
                        $minutes = $diffInMinutes % 60; // remaining minutes
                    @endphp

                    @if ($diffInMinutes == 0)
                        <span class="text-blue-600 font-semibold">On Time</span>
                    @elseif ($isEarly)
                        <span class="text-green-600">
                            Early by
                            @if ($days > 0)
                                {{ $days }}d
                            @endif
                            @if ($hours > 0)
                                {{ $hours }}h
                            @endif
                            @if ($minutes > 0)
                                {{ $minutes }}m
                            @endif
                        </span>
                    @else
                        <span class="text-red-600">
                            Delayed by
                            @if ($days > 0)
                                {{ $days }}d
                            @endif
                            @if ($hours > 0)
                                {{ $hours }}h
                            @endif
                            @if ($minutes > 0)
                                {{ $minutes }}m
                            @endif
                        </span>
                    @endif


                </p>
            </div>
        </div>

        <!-- Completed Task Table -->
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold mb-4 text-gray-700">Completed Tasks List</h2>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left text-sm text-gray-600">
                            <th class="p-3">#</th>
                            <th class="p-3">Project Name</th>
                            <th class="p-3">Task</th>
                            <th class="p-3">Deadline</th>
                            <th class="p-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($completedTasks as $cmpdata)
                            <tr class="{{ $loop->even ? 'bg-indigo-100' : 'bg-orange-200' }} border-black-200">
                                <td class="p-3">{{ $loop->iteration }}</td>
                                <td class="p-3">{{ $cmpdata->title }}</td>
                                <td class="p-3">{{ $cmpdata->task_name }}</td>
                                <td class="p-3">
                                    {{ \Carbon\Carbon::parse($cmpdata->deadline)->format('d/m/y h:i A') }}
                                </td>
                                <td class="p-3">{{ $cmpdata->status }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>

        <!-- In-Progress Tasks -->
        <div class="bg-white rounded-xl shadow p-6 mt-8">
            <h2 class="text-lg font-semibold mb-4 text-blue-700">In-Progress Tasks</h2>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-blue-50 text-left text-sm text-blue-600">
                            <th class="p-3">#</th>
                            <th class="p-3">Project_name</th>
                            <th class="p-3">Task</th>
                            <th class="p-3">Deadline</th>
                            <th class="p-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inProgressTasks as $cmpdata)
                            <tr class="{{ $loop->even ? 'bg-pink-100' : 'bg-orange-200' }} border-black-200">
                                <td class="p-3">{{ $loop->iteration }}</td>
                                <td class="p-3">{{ $cmpdata->title }}</td>
                                <td class="p-3">{{ $cmpdata->task_name }}</td>
                                <td class="p-3">
                                    {{ \Carbon\Carbon::parse($cmpdata->deadline)->format('d/m/y h:i A') }}
                                </td>
                                <td class="p-3">{{ $cmpdata->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pending Tasks -->
        <div class="bg-white rounded-xl shadow p-6 mt-8">
            <h2 class="text-lg font-semibold mb-4 text-yellow-700">Pending Tasks</h2>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-yellow-50 text-left text-sm text-yellow-600">
                            <th class="p-3">#</th>
                            <th class="p-3">Project_name</th>
                            <th class="p-3">Task</th>
                            <th class="p-3">Deadline</th>
                            <th class="p-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendingTasks as $cmpdata)
                            <tr class="{{ $loop->even ? 'bg-blue-100' : 'bg-red-200' }} border-black-200">
                                <td class="p-3">{{ $loop->iteration }}</td>
                                <td class="p-3">{{ $cmpdata->title }}</td>
                                <td class="p-3">{{ $cmpdata->task_name }}</td>
                                <td class="p-3">
                                    {{ \Carbon\Carbon::parse($cmpdata->deadline)->format('d/m/y h:i A') }}
                                </td>
                                <td class="p-3">{{ $cmpdata->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
