@extends('admin.include.layout')
@section('heading', 'Details')
@section('title', 'Sales Works Reports Details')
@section('content')

<!-- Static Data -->
@php
    $user = (object) [
        'id' => 101,
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
        'phone' => '+1 (555) 123-4567',
        'role' => 'Sales Manager',
        'department' => 'Sales & Marketing',
        'created_at' => \Carbon\Carbon::createFromFormat('Y-m-d', '2023-06-15')
    ];

    $project = (object) [
        'id' => 205,
        'name' => 'Enterprise CRM Implementation',
        'status' => 'In Progress',
        'budget' => 125000.00,
        'start_date' => '2024-01-10',
        'end_date' => '2024-06-30',
        'description' => 'Full-scale CRM deployment for enterprise clients with AI integration.'
    ];
@endphp

<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Sales Report Details</h2>
            <p class="text-gray-500 text-sm mt-1">View complete information about the sales report</p>
        </div>
        <a href="#" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition duration-150 shadow-sm hover:shadow-md">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </a>
    </div>
</div>

<!-- User Details Section -->
<div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-8 mb-6 border border-blue-100">
    <div class="flex items-start justify-between">
        <div class="flex items-start space-x-6">
            <!-- Large Avatar -->
            <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center text-white font-bold text-2xl shadow-lg shadow-blue-200">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>

            <div>
                <div class="flex items-center space-x-3 mb-1">
                    <h3 class="text-xl font-bold text-gray-800">{{ $user->name }}</h3>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                        {{ $user->role }}
                    </span>
                    <span class="text-xs text-gray-400">ID: #{{ $user->id }}</span>
                </div>
                <p class="text-gray-600 text-sm">{{ $user->department }}</p>

                <div class="flex flex-wrap gap-6 mt-4">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-sm text-gray-600">{{ $user->email }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span class="text-sm text-gray-600">{{ $user->phone }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-sm text-gray-600">Joined: {{ $user->created_at->format('d F Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Project Details Section -->
<div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl p-8 mb-6 border border-green-100">
    <div class="flex flex-col">
        <!-- Project Header -->
        <div class="flex items-start justify-between mb-6 pb-6 border-b border-green-200/50">
            <div class="flex items-start space-x-4">
                <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg shadow-green-200">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div>
                    <div class="flex items-center space-x-3">
                        <h3 class="text-xl font-bold text-gray-800">{{ $project->name }}</h3>
                        <span class="text-xs text-gray-400">Project #{{ $project->id }}</span>
                    </div>
                    <div class="flex items-center space-x-4 mt-1">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                            {{ $project->status == 'Completed' ? 'bg-green-100 text-green-800 border border-green-200' :
                               ($project->status == 'In Progress' ? 'bg-yellow-100 text-yellow-800 border border-yellow-200' :
                               'bg-gray-100 text-gray-800 border border-gray-200') }}">
                            <span class="w-1.5 h-1.5 rounded-full mr-1.5
                                {{ $project->status == 'Completed' ? 'bg-green-500' :
                                   ($project->status == 'In Progress' ? 'bg-yellow-500 animate-pulse' :
                                   'bg-gray-500') }}"></span>
                            {{ $project->status }}
                        </span>
                        <span class="text-sm text-gray-600">Budget: <strong class="text-green-600">${{ number_format($project->budget, 2) }}</strong></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Project Info Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white/60 backdrop-blur-sm rounded-xl p-4 border border-green-200/50">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">Start Date</p>
                        <p class="text-sm font-semibold text-gray-800">{{ \Carbon\Carbon::parse($project->start_date)->format('d F Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/60 backdrop-blur-sm rounded-xl p-4 border border-green-200/50">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">End Date</p>
                        <p class="text-sm font-semibold text-gray-800">{{ \Carbon\Carbon::parse($project->end_date)->format('d F Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/60 backdrop-blur-sm rounded-xl p-4 border border-green-200/50">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">Duration</p>
                        <p class="text-sm font-semibold text-gray-800">
                            {{ \Carbon\Carbon::parse($project->start_date)->diffInDays(\Carbon\Carbon::parse($project->end_date)) }} days
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description & Progress -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white/60 backdrop-blur-sm rounded-xl p-4 border border-green-200/50">
                <div class="flex items-start space-x-3">
                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">Description</p>
                        <p class="text-sm text-gray-700 mt-0.5">{{ $project->description }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/60 backdrop-blur-sm rounded-xl p-4 border border-green-200/50">
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <span class="text-xs font-medium text-gray-600">Project Progress</span>
                        </div>
                        <span class="text-sm font-bold text-green-600">65%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-gradient-to-r from-green-500 to-emerald-500 h-2.5 rounded-full transition-all duration-1000" style="width: 65%"></div>
                    </div>
                    <p class="text-xs text-gray-400 text-right">Estimated completion: June 2024</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Report Information Bar -->
<div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl p-4 border border-gray-200">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center space-x-6">
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Report ID</p>
                    <p class="text-sm font-semibold text-gray-800">#REP-2024-001</p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Report Date</p>
                    <p class="text-sm font-semibold text-gray-800">{{ now()->format('d F Y') }}</p>
                </div>
            </div>
        </div>
        
    </div>
</div>

@endsection
