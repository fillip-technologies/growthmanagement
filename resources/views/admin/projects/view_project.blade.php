@extends('admin.include.layout')

@section('heading', 'Projects')
@section('title', 'Project Details')

@section('content')

    {{-- Font Awesome --}}
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    >

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @php
        /*
        |--------------------------------------------------------------------------
        | MODULES
        |--------------------------------------------------------------------------
        */

        $modules = $project->getAttribute('modules') ?? [];

        if (is_string($modules)) {
            $decodedModules = json_decode($modules, true);

            $modules = is_array($decodedModules)
                ? $decodedModules
                : [];
        }

        if (!is_array($modules)) {
            $modules = [];
        }


        /*
        |--------------------------------------------------------------------------
        | STATUS
        |--------------------------------------------------------------------------
        */

        $status = strtolower($project->status ?? 'pending');

        $statusConfig = [
            'pending' => [
                'bg' => 'bg-amber-50',
                'text' => 'text-amber-700',
                'border' => 'border-amber-200',
                'icon' => 'fa-clock',
                'label' => 'Pending',
            ],

            'ongoing' => [
                'bg' => 'bg-blue-50',
                'text' => 'text-blue-700',
                'border' => 'border-blue-200',
                'icon' => 'fa-spinner',
                'label' => 'Ongoing',
            ],

            'completed' => [
                'bg' => 'bg-emerald-50',
                'text' => 'text-emerald-700',
                'border' => 'border-emerald-200',
                'icon' => 'fa-check-circle',
                'label' => 'Completed',
            ],
        ];

        $currentStatus = $statusConfig[$status]
            ?? $statusConfig['pending'];


        /*
        |--------------------------------------------------------------------------
        | PRIORITY
        |--------------------------------------------------------------------------
        */

        $priority = strtolower($project->priority ?? 'medium');

        $priorityConfig = [
            'low' => [
                'bg' => 'bg-green-50',
                'text' => 'text-green-700',
                'border' => 'border-green-200',
                'icon' => 'fa-arrow-down',
                'label' => 'Low Priority',
            ],

            'medium' => [
                'bg' => 'bg-blue-50',
                'text' => 'text-blue-700',
                'border' => 'border-blue-200',
                'icon' => 'fa-minus',
                'label' => 'Medium Priority',
            ],

            'high' => [
                'bg' => 'bg-red-50',
                'text' => 'text-red-700',
                'border' => 'border-red-200',
                'icon' => 'fa-arrow-up',
                'label' => 'High Priority',
            ],
        ];

        $currentPriority = $priorityConfig[$priority]
            ?? $priorityConfig['medium'];


        /*
        |--------------------------------------------------------------------------
        | DATES
        |--------------------------------------------------------------------------
        */

        $startDate = $project->start_date
            ? \Carbon\Carbon::parse($project->start_date)
            : null;

        $endDate = $project->end_date
            ? \Carbon\Carbon::parse($project->end_date)
            : null;

        $createdAt = $project->created_at
            ? \Carbon\Carbon::parse($project->created_at)
            : null;

        $updatedAt = $project->updated_at
            ? \Carbon\Carbon::parse($project->updated_at)
            : null;


        /*
        |--------------------------------------------------------------------------
        | DEADLINE
        |--------------------------------------------------------------------------
        */

        $daysLeft = $endDate
            ? now()->startOfDay()->diffInDays(
                $endDate->startOfDay(),
                false
            )
            : null;

        $isOverdue =
            $endDate &&
            $endDate->isPast() &&
            $status !== 'completed';


        /*
        |--------------------------------------------------------------------------
        | PROGRESS
        |--------------------------------------------------------------------------
        */

        $progress = match ($status) {
            'completed' => 100,
            'ongoing' => 60,
            'pending' => 20,
            default => 0,
        };


        /*
        |--------------------------------------------------------------------------
        | RELATIONSHIPS
        |--------------------------------------------------------------------------
        */

        $humanResources =
            $project->projecthumanresource ?? collect();

        $infraResources =
            $project->projectInfraresource ?? collect();

        $tasks =
            $project->addtask ?? collect();


        $discussions =
            $project->discuss ?? collect();


        /*
        |--------------------------------------------------------------------------
        | TASK COUNTS
        |--------------------------------------------------------------------------
        */

        $totalTasks = $tasks->count();

        $completedTasks = $tasks->filter(function ($task) {

            $taskStatus = strtolower(
                $task->status
                ?? $task->addtask?->status
                ?? ''
            );

            return $taskStatus === 'completed';

        })->count();


        $pendingTasks = max(
            $totalTasks - $completedTasks,
            0
        );


        /*
        |--------------------------------------------------------------------------
        | RESOURCE COUNTS
        |--------------------------------------------------------------------------
        */

        $teamCount =
            $humanResources->count();

        $infraCount =
            $infraResources->count();

    @endphp


    <div class="min-h-screen bg-slate-50">

        {{-- ========================================================= --}}
        {{-- HEADER --}}
        {{-- ========================================================= --}}

        <div class="bg-white border-b border-gray-200">

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

                    {{-- Project Identity --}}
                    <div class="flex items-start gap-4">

                        <div
                            class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-600 to-cyan-500 flex items-center justify-center shadow-lg flex-shrink-0"
                        >
                            <i class="fas fa-folder-open text-white text-2xl"></i>
                        </div>

                        <div>

                            <div class="flex flex-wrap items-center gap-2">

                                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">
                                    {{ $project->name ?? 'Untitled Project' }}
                                </h1>

                            </div>

                            <div class="flex flex-wrap items-center gap-3 mt-2 text-sm text-gray-500">

                                <span class="flex items-center gap-1.5">
                                    <i class="fas fa-hashtag text-blue-500"></i>

                                    Project ID:
                                    <strong class="text-gray-700">
                                        #{{ str_pad($project->id, 4, '0', STR_PAD_LEFT) }}
                                    </strong>
                                </span>

                                @if($project->client_name)

                                    <span class="hidden sm:inline text-gray-300">
                                        |
                                    </span>

                                    <span class="flex items-center gap-1.5">

                                        <i class="fas fa-building text-gray-400"></i>

                                        {{ $project->client_name }}

                                    </span>

                                @endif

                                @if($createdAt)

                                    <span class="hidden sm:inline text-gray-300">
                                        |
                                    </span>

                                    <span class="flex items-center gap-1.5">

                                        <i class="fas fa-calendar text-gray-400"></i>

                                        {{ $createdAt->format('d M, Y') }}

                                    </span>

                                @endif

                            </div>

                        </div>

                    </div>


                    {{-- Status --}}
                    <div class="flex flex-wrap items-center gap-3">

                        <span
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-full border font-semibold text-sm
                            {{ $currentStatus['bg'] }}
                            {{ $currentStatus['text'] }}
                            {{ $currentStatus['border'] }}"
                        >

                            <i class="fas {{ $currentStatus['icon'] }}"></i>

                            {{ $currentStatus['label'] }}

                        </span>


                        <span
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-full border font-semibold text-sm
                            {{ $currentPriority['bg'] }}
                            {{ $currentPriority['text'] }}
                            {{ $currentPriority['border'] }}"
                        >

                            <i class="fas {{ $currentPriority['icon'] }}"></i>

                            {{ $currentPriority['label'] }}

                        </span>

                    </div>

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- MAIN CONTENT --}}
        {{-- ========================================================= --}}

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">


            {{-- ===================================================== --}}
            {{-- QUICK STATS --}}
            {{-- ===================================================== --}}

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">

                {{-- Progress --}}
                <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">

                    <div class="flex items-center gap-3">

                        <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                            <i class="fas fa-chart-line"></i>
                        </div>

                        <div>

                            <p class="text-xs text-gray-500">
                                Progress
                            </p>

                            <p class="text-xl font-bold text-gray-900">
                                {{ $progress }}%
                            </p>

                        </div>

                    </div>

                    <div class="mt-3 h-1.5 bg-gray-100 rounded-full overflow-hidden">

                        <div
                            class="h-full bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full"
                            style="width: {{ $progress }}%"
                        ></div>

                    </div>

                </div>


                {{-- Modules --}}
                <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">

                    <div class="flex items-center gap-3">

                        <div class="w-10 h-10 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center">
                            <i class="fas fa-cubes"></i>
                        </div>

                        <div>

                            <p class="text-xs text-gray-500">
                                Modules
                            </p>

                            <p class="text-xl font-bold text-gray-900">
                                {{ count($modules) }}
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Tasks --}}
                <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">

                    <div class="flex items-center gap-3">

                        <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                            <i class="fas fa-tasks"></i>
                        </div>

                        <div>

                            <p class="text-xs text-gray-500">
                                Tasks
                            </p>

                            <p class="text-xl font-bold text-gray-900">
                                {{ $totalTasks }}
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Completed Tasks --}}
                <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">

                    <div class="flex items-center gap-3">

                        <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <i class="fas fa-check-circle"></i>
                        </div>

                        <div>

                            <p class="text-xs text-gray-500">
                                Completed
                            </p>

                            <p class="text-xl font-bold text-gray-900">
                                {{ $completedTasks }}
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Team --}}
                <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">

                    <div class="flex items-center gap-3">

                        <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            <i class="fas fa-users"></i>
                        </div>

                        <div>

                            <p class="text-xs text-gray-500">
                                Team
                            </p>

                            <p class="text-xl font-bold text-gray-900">
                                {{ $teamCount }}
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Infrastructure --}}
                <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">

                    <div class="flex items-center gap-3">

                        <div class="w-10 h-10 rounded-lg bg-cyan-50 text-cyan-600 flex items-center justify-center">
                            <i class="fas fa-server"></i>
                        </div>

                        <div>

                            <p class="text-xs text-gray-500">
                                Infrastructure
                            </p>

                            <p class="text-xl font-bold text-gray-900">
                                {{ $infraCount }}
                            </p>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- TWO COLUMN LAYOUT --}}
            {{-- ===================================================== --}}

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">


                {{-- ================================================= --}}
                {{-- LEFT --}}
                {{-- ================================================= --}}

                <div class="lg:col-span-2 space-y-6">


                    {{-- ================================================= --}}
                    {{-- PROJECT INFORMATION --}}
                    {{-- ================================================= --}}

                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">

                            <h2 class="font-bold text-gray-800 flex items-center gap-2">

                                <i class="fas fa-info-circle text-blue-500"></i>

                                Project Information

                            </h2>

                        </div>


                        <div class="p-6">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8">


                                {{-- Client --}}
                                <div class="py-3 border-b border-gray-100">

                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                        Client
                                    </p>

                                    <p class="mt-1 text-sm font-medium text-gray-900">

                                        {{ $project->client_name ?? 'Not Available' }}

                                    </p>

                                </div>


                                {{-- Status --}}
                                <div class="py-3 border-b border-gray-100">

                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                        Status
                                    </p>

                                    <p class="mt-1 text-sm font-medium {{ $currentStatus['text'] }}">

                                        {{ $currentStatus['label'] }}

                                    </p>

                                </div>


                                {{-- Priority --}}
                                <div class="py-3 border-b border-gray-100">

                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                        Priority
                                    </p>

                                    <p class="mt-1 text-sm font-medium {{ $currentPriority['text'] }}">

                                        {{ $currentPriority['label'] }}

                                    </p>

                                </div>


                                {{-- Start --}}
                                <div class="py-3 border-b border-gray-100">

                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                        Start Date
                                    </p>

                                    <p class="mt-1 text-sm font-medium text-gray-900">

                                        {{ $startDate?->format('d M, Y') ?? 'Not Set' }}

                                    </p>

                                </div>


                                {{-- End --}}
                                <div class="py-3 border-b border-gray-100">

                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                        End Date
                                    </p>

                                    <p class="mt-1 text-sm font-medium
                                        {{ $isOverdue ? 'text-red-600' : 'text-gray-900' }}"
                                    >

                                        {{ $endDate?->format('d M, Y') ?? 'Not Set' }}

                                    </p>

                                    @if($isOverdue)

                                        <p class="text-xs text-red-500 mt-1">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                            Project is overdue
                                        </p>

                                    @elseif($daysLeft !== null)

                                        <p class="text-xs text-gray-400 mt-1">
                                            {{ $daysLeft }} days remaining
                                        </p>

                                    @endif

                                </div>


                                {{-- Created --}}
                                <div class="py-3 border-b border-gray-100">

                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                        Created
                                    </p>

                                    <p class="mt-1 text-sm font-medium text-gray-900">

                                        {{ $createdAt?->format('d M, Y h:i A') ?? 'N/A' }}

                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- DESCRIPTION --}}
                    {{-- ================================================= --}}

                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">

                            <h2 class="font-bold text-gray-800 flex items-center gap-2">

                                <i class="fas fa-align-left text-blue-500"></i>

                                Project Description

                            </h2>

                        </div>

                        <div class="p-6">

                            @if($project->description)

                                <p class="text-gray-700 leading-7 whitespace-pre-line">
                                    {{ $project->description }}
                                </p>

                            @else

                                <p class="text-gray-400">
                                    No project description available.
                                </p>

                            @endif

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- MODULES --}}
                    {{-- ================================================= --}}

                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">

                            <div class="flex items-center justify-between">

                                <h2 class="font-bold text-gray-800 flex items-center gap-2">

                                    <i class="fas fa-cubes text-purple-500"></i>

                                    Project Modules

                                </h2>

                                <span class="text-xs bg-purple-50 text-purple-700 px-3 py-1 rounded-full">

                                    {{ count($modules) }} Modules

                                </span>

                            </div>

                        </div>


                        <div class="p-6">

                            @if(count($modules))

                                <div class="flex flex-wrap gap-2">

                                    @foreach($modules as $module)

                                        @php

                                            $moduleName = is_array($module)
                                                ? (
                                                    $module['name']
                                                    ?? $module['title']
                                                    ?? 'Module'
                                                )
                                                : $module;

                                        @endphp

                                        <span
                                            class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-blue-50 text-blue-700 border border-blue-100 text-sm font-medium"
                                        >

                                            <i class="fas fa-cube text-blue-400"></i>

                                            {{ $moduleName }}

                                        </span>

                                    @endforeach

                                </div>

                            @else

                                <div class="text-center py-8">

                                    <i class="fas fa-cubes text-4xl text-gray-200"></i>

                                    <p class="text-gray-400 mt-3">
                                        No modules configured.
                                    </p>

                                </div>

                            @endif

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- TASKS --}}
                    {{-- ================================================= --}}

                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">

                            <div class="flex items-center justify-between">

                                <h2 class="font-bold text-gray-800 flex items-center gap-2">

                                    <i class="fas fa-tasks text-amber-500"></i>

                                    Project Tasks

                                </h2>

                                <span class="text-xs bg-amber-50 text-amber-700 px-3 py-1 rounded-full">

                                    {{ $totalTasks }} Tasks

                                </span>

                            </div>

                        </div>


                        <div class="p-6">

                            @if($tasks->count())

                                <div class="space-y-3">

                                    @foreach($tasks as $task)

                                        @php

                                            $taskStatus =
                                                strtolower($task->status ?? 'pending');

                                            $taskStatusClass = match($taskStatus) {

                                                'completed' =>
                                                    'bg-emerald-50 text-emerald-700',

                                                'ongoing',
                                                'in_progress' =>
                                                    'bg-blue-50 text-blue-700',

                                                default =>
                                                    'bg-amber-50 text-amber-700',

                                            };

                                        @endphp


                                        <div
                                            class="flex flex-col md:flex-row md:items-center justify-between gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50/30 transition"
                                        >

                                            <div class="flex items-center gap-3">

                                                <div
                                                    class="w-9 h-9 rounded-lg bg-white border border-gray-200 flex items-center justify-center"
                                                >
                                                    <i class="fas fa-check-square text-blue-500"></i>
                                                </div>

                                                <div>

                                                    <p class="text-sm font-semibold text-gray-800">

                                                        {{ $task->title
                                                            ?? $task->name
                                                            ?? $task->task_name
                                                            ?? 'Task #'.$task->id
                                                        }}

                                                    </p>

                                                    @if($task->user)

                                                        <p class="text-xs text-gray-500 mt-1">

                                                            Assigned to:
                                                            {{ $task->user->name }}

                                                        </p>

                                                    @endif

                                                </div>

                                            </div>


                                            <span
                                                class="self-start md:self-auto px-3 py-1 rounded-full text-xs font-semibold {{ $taskStatusClass }}"
                                            >

                                                {{ ucfirst(str_replace('_', ' ', $taskStatus)) }}

                                            </span>

                                        </div>

                                    @endforeach

                                </div>

                            @else

                                <div class="text-center py-8">

                                    <i class="fas fa-tasks text-4xl text-gray-200"></i>

                                    <p class="text-gray-400 mt-3">
                                        No tasks assigned to this project.
                                    </p>

                                </div>

                            @endif

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- INFRASTRUCTURE --}}
                    {{-- ================================================= --}}

                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">

                            <div class="flex items-center justify-between">

                                <h2 class="font-bold text-gray-800 flex items-center gap-2">

                                    <i class="fas fa-server text-cyan-600"></i>

                                    Infrastructure Resources

                                </h2>

                                <span class="text-xs bg-cyan-50 text-cyan-700 px-3 py-1 rounded-full">

                                    {{ $infraCount }} Resources

                                </span>

                            </div>

                        </div>


                        <div class="p-6">

                            @if($infraResources->count())

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                    @foreach($infraResources as $resource)

                                        @php
                                            $resourceData = $resource->toArray();
                                        @endphp


                                        @foreach($resourceData as $field => $value)

                                            @if(
                                                !in_array($field, [
                                                    'id',
                                                    'project_id',
                                                    'created_at',
                                                    'updated_at'
                                                ])
                                                && filled($value)
                                                && !is_array($value)
                                                && !is_object($value)
                                            )

                                                <div
                                                    class="p-4 bg-gray-50 rounded-xl border border-gray-100 hover:border-cyan-200 hover:bg-cyan-50/30 transition"
                                                >

                                                    <div class="flex items-start gap-3">

                                                        <div
                                                            class="w-9 h-9 rounded-lg bg-cyan-50 text-cyan-600 flex items-center justify-center flex-shrink-0"
                                                        >

                                                            <i class="fas fa-server"></i>

                                                        </div>

                                                        <div class="min-w-0">

                                                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">

                                                                {{ ucwords(
                                                                    str_replace(
                                                                        '_',
                                                                        ' ',
                                                                        $field
                                                                    )
                                                                ) }}

                                                            </p>

                                                            <p class="text-sm font-medium text-gray-800 mt-1 break-words">

                                                                {{ $value }}

                                                            </p>

                                                        </div>

                                                    </div>

                                                </div>

                                            @endif

                                        @endforeach

                                    @endforeach

                                </div>

                            @else

                                <div class="text-center py-8">

                                    <i class="fas fa-server text-4xl text-gray-200"></i>

                                    <p class="text-gray-400 mt-3">
                                        No infrastructure resources configured.
                                    </p>

                                </div>

                            @endif

                        </div>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- RIGHT --}}
                {{-- ================================================= --}}

                <div class="space-y-6">


                    {{-- ================================================= --}}
                    {{-- HUMAN RESOURCES --}}
                    {{-- ================================================= --}}

                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">

                            <div class="flex items-center justify-between">

                                <h2 class="font-bold text-gray-800 flex items-center gap-2">

                                    <i class="fas fa-users text-purple-600"></i>

                                    Team

                                </h2>

                                <span class="text-xs bg-purple-50 text-purple-700 px-3 py-1 rounded-full">

                                    {{ $teamCount }}

                                </span>

                            </div>

                        </div>


                        <div class="p-5 space-y-3">

                            @forelse($humanResources as $resource)

                                @php

                                    $name =
                                        $resource->name
                                        ?? $resource->employee_name
                                        ?? $resource->user?->name
                                        ?? 'Team Member';

                                    $role =
                                        $resource->role
                                        ?? $resource->designation
                                        ?? $resource->position
                                        ?? 'Team Member';

                                    $email =
                                        $resource->email
                                        ?? $resource->user?->email
                                        ?? null;

                                @endphp


                                <div
                                    class="p-4 rounded-xl bg-gray-50 border border-gray-100 hover:border-purple-200 hover:bg-purple-50/30 transition"
                                >

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="w-11 h-11 rounded-full bg-gradient-to-br from-purple-500 to-indigo-600 text-white flex items-center justify-center font-bold"
                                        >

                                            {{ strtoupper(substr($name, 0, 1)) }}

                                        </div>


                                        <div class="min-w-0 flex-1">

                                            <p class="font-semibold text-gray-800 text-sm">

                                                {{ $name }}

                                            </p>

                                            <p class="text-xs text-purple-600 font-medium mt-0.5">

                                                {{ $role }}

                                            </p>

                                            @if($email)

                                                <p class="text-xs text-gray-400 mt-0.5 truncate">

                                                    {{ $email }}

                                                </p>

                                            @endif

                                        </div>

                                    </div>

                                </div>

                            @empty

                                <div class="text-center py-8">

                                    <i class="fas fa-users text-4xl text-gray-200"></i>

                                    <p class="text-gray-400 mt-3">
                                        No team members assigned.
                                    </p>

                                </div>

                            @endforelse

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- PROJECT OWNER --}}
                    {{-- ================================================= --}}

                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">

                            <h2 class="font-bold text-gray-800 flex items-center gap-2">

                                <i class="fas fa-user-circle text-blue-500"></i>

                                Project Owner

                            </h2>

                        </div>


                        <div class="p-5">

                            @if($project->user)

                                <div class="flex items-center gap-4">

                                    <div
                                        class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-cyan-500 text-white flex items-center justify-center font-bold text-lg"
                                    >

                                        {{ strtoupper(
                                            substr(
                                                $project->user->name ?? 'U',
                                                0,
                                                1
                                            )
                                        ) }}

                                    </div>


                                    <div class="min-w-0">

                                        <p class="font-semibold text-gray-800">

                                            {{ $project->user->name }}

                                        </p>

                                        <p class="text-xs text-gray-500 mt-1 break-all">

                                            {{ $project->user->email ?? 'No email available' }}

                                        </p>

                                    </div>

                                </div>

                            @else

                                <p class="text-gray-400 text-sm">
                                    Project owner not available.
                                </p>

                            @endif

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- METADATA --}}
                    {{-- ================================================= --}}

                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">

                            <h2 class="font-bold text-gray-800 flex items-center gap-2">

                                <i class="fas fa-database text-gray-500"></i>

                                Project Metadata

                            </h2>

                        </div>


                        <div class="p-5">

                            <div class="space-y-4">

                                <div>

                                    <p class="text-xs text-gray-500">
                                        Project ID
                                    </p>

                                    <p class="text-sm font-semibold text-gray-800 mt-1">
                                        #{{ $project->id }}
                                    </p>

                                </div>


                                <div>

                                    <p class="text-xs text-gray-500">
                                        Created By
                                    </p>

                                    <p class="text-sm font-semibold text-gray-800 mt-1">

                                        {{ $project->user?->name ?? 'Unknown' }}

                                    </p>

                                </div>


                                <div>

                                    <p class="text-xs text-gray-500">
                                        Created At
                                    </p>

                                    <p class="text-sm font-semibold text-gray-800 mt-1">

                                        {{ $createdAt?->format('d M, Y h:i A') ?? 'N/A' }}

                                    </p>

                                </div>


                                <div>

                                    <p class="text-xs text-gray-500">
                                        Last Updated
                                    </p>

                                    <p class="text-sm font-semibold text-gray-800 mt-1">

                                        {{ $updatedAt?->format('d M, Y h:i A') ?? 'N/A' }}

                                    </p>

                                </div>


                                <div>

                                    <p class="text-xs text-gray-500">
                                        Timezone
                                    </p>

                                    <p class="text-sm font-semibold text-gray-800 mt-1">

                                        {{ config('app.timezone') }}

                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- ACTIONS --}}
                    {{-- ================================================= --}}

                    <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl border border-blue-100 p-5">

                        <div class="space-y-3">

                            {{-- Edit --}}
                            @if(Route::has('project.edit'))

                                <a
                                    href="{{ route('project.edit', $project->id) }}"
                                    class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold transition shadow-sm"
                                >

                                    <i class="fas fa-edit"></i>

                                    Edit Project

                                </a>

                            @endif


                            {{-- Tasks --}}
                            @if(Route::has('project.tasks'))

                                <a
                                    href="{{ route('project.tasks', $project->id) }}"
                                    class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-white hover:bg-gray-50 text-gray-700 font-semibold border border-gray-200 transition"
                                >

                                    <i class="fas fa-tasks"></i>

                                    View Tasks

                                </a>

                            @endif


                            {{-- Back --}}
                            @if(Route::has('project.list'))

                                <a
                                    href="{{ route('project.list') }}"
                                    class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold transition"
                                >

                                    <i class="fas fa-arrow-left"></i>

                                    Back to Projects

                                </a>

                            @endif

                        </div>

                    </div>

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- TIMELINE --}}
            {{-- ===================================================== --}}

            <div class="mt-6 bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">

                    <h2 class="font-bold text-gray-800 flex items-center gap-2">

                        <i class="fas fa-road text-blue-500"></i>

                        Project Timeline

                    </h2>

                </div>


                <div class="p-6">

                    <div class="max-w-5xl mx-auto">

                        <div class="flex items-center gap-3">


                            {{-- START --}}
                            <div class="text-center flex-shrink-0">

                                <div
                                    class="w-10 h-10 rounded-full bg-emerald-500 text-white flex items-center justify-center mx-auto shadow"
                                >

                                    <i class="fas fa-play"></i>

                                </div>

                                <p class="text-xs font-semibold text-gray-700 mt-2">
                                    Start
                                </p>

                                <p class="text-xs text-gray-400">
                                    {{ $startDate?->format('d M, Y') ?? 'Not Set' }}
                                </p>

                            </div>


                            {{-- LINE --}}
                            <div class="flex-1">

                                <div class="h-2 bg-gray-100 rounded-full overflow-hidden">

                                    <div
                                        class="h-full bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full transition-all"
                                        style="width: {{ $progress }}%"
                                    ></div>

                                </div>

                                <div class="flex justify-between mt-2 text-xs">

                                    <span class="text-gray-400">
                                        0%
                                    </span>

                                    <span class="font-semibold text-blue-600">
                                        {{ $progress }}% Complete
                                    </span>

                                    <span class="text-gray-400">
                                        100%
                                    </span>

                                </div>

                            </div>


                            {{-- END --}}
                            <div class="text-center flex-shrink-0">

                                <div
                                    class="w-10 h-10 rounded-full
                                    {{
                                        $status === 'completed'
                                            ? 'bg-emerald-500'
                                            : 'bg-gray-300'
                                    }}
                                    text-white flex items-center justify-center mx-auto shadow"
                                >

                                    <i
                                        class="fas {{
                                            $status === 'completed'
                                                ? 'fa-check'
                                                : 'fa-flag-checkered'
                                        }}"
                                    ></i>

                                </div>

                                <p class="text-xs font-semibold text-gray-700 mt-2">
                                    End
                                </p>

                                <p class="text-xs {{ $isOverdue ? 'text-red-500' : 'text-gray-400' }}">

                                    {{ $endDate?->format('d M, Y') ?? 'Not Set' }}

                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- FOOTER --}}
            {{-- ===================================================== --}}

            <div class="mt-6 flex flex-col sm:flex-row justify-between items-center gap-3 text-xs text-gray-400">

                <span>
                    Project #{{ $project->id }}
                </span>

                <span>
                    Last updated:
                    {{ $updatedAt?->format('d M, Y h:i A') ?? 'N/A' }}
                </span>

            </div>

        </div>

    </div>


    {{-- ============================================================= --}}
    {{-- SIMPLE ANIMATION --}}
    {{-- ============================================================= --}}

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const cards = document.querySelectorAll(
                '.bg-white'
            );

            cards.forEach((card, index) => {

                card.style.opacity = '0';

                card.style.transform = 'translateY(8px)';

                setTimeout(() => {

                    card.style.transition =
                        'opacity 0.35s ease, transform 0.35s ease';

                    card.style.opacity = '1';

                    card.style.transform =
                        'translateY(0)';

                }, Math.min(index * 40, 500));

            });

        });

    </script>

@endsection
