@extends('admin.include.layout')
@section('heading', 'Task Assignment')
@section('title', 'Drag & Drop Task Assignment')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulseGlow {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(249, 115, 22, 0.4);
            }

            50% {
                box-shadow: 0 0 0 20px rgba(249, 115, 22, 0);
            }
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        .animate-slide-in {
            animation: slideIn 0.4s ease-out;
        }

        .task-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: grab;
        }

        .task-card:active {
            cursor: grabbing;
        }

        .task-card.dragging {
            opacity: 0.5;
            transform: scale(0.98) rotate(2deg);
            cursor: grabbing;
        }

        .task-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15);
        }

        .drop-zone {
            transition: all 0.2s ease;
            min-height: 500px;
        }

        .drop-zone.drop-hover {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: 2px dashed #f97316;
            border-radius: 16px;
        }

        .employee-card {
            transition: all 0.3s ease;
            animation: fadeIn 0.5s ease-out;
        }

        .employee-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 30px -12px rgba(0, 0, 0, 0.2);
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #fb923c;
            border-radius: 10px;
        }

        .floating-bg {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            z-index: 0;
        }

        .floating-bg div {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.15;
        }

        .status-badge {
            transition: all 0.2s ease;
        }

        .status-badge:hover {
            transform: scale(1.05);
        }

        .delete-btn {
            transition: all 0.2s ease;
        }

        .delete-btn:hover {
            transform: scale(1.1);
        }

        .task-count {
            font-size: 0.7rem;
            background: rgba(255, 255, 255, 0.3);
            padding: 2px 8px;
            border-radius: 20px;
        }
    </style>



    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonColor: '#f97316',
                customClass: {
                    popup: 'rounded-2xl'
                }
            });
        </script>
    @endif

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Task Assigned!',
                text: "{{ session('success') }}",
                timer: 2500,
                showConfirmButton: false,
                background: '#fff',
                customClass: {
                    popup: 'rounded-2xl'
                }
            });
        </script>
    @endif

    <div class="relative z-10 min-h-screen py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">

            {{-- Header Section --}}
            <div class="relative mb-8 animate-fade-in">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-orange-500 to-orange-600 opacity-5 rounded-full transform translate-x-32 -translate-y-32">
                    </div>
                    <div class="relative px-6 py-6 md:px-8 md:py-8">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg transform -rotate-3 hover:rotate-0 transition-all duration-300">
                                    <i class="fas fa-arrows-alt text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h1 class="text-3xl md:text-4xl font-black text-gray-800 tracking-tight">
                                        Drag & Drop Task Assignment
                                    </h1>
                                    <p class="text-gray-500 mt-1 flex items-center gap-2">
                                        <i class="fas fa-hand-peace text-orange-500"></i>
                                        Simply drag tasks and drop them onto employee cards to assign
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="px-4 py-2 bg-orange-50 rounded-full">
                                    <i class="fas fa-tasks text-orange-500 mr-2"></i>
                                    <span class="text-sm font-semibold text-orange-600">{{ $tasks->count() ?? 0 }} Tasks
                                        Available</span>
                                </div>
                                <div class="px-4 py-2 bg-emerald-50 rounded-full">
                                    <i class="fas fa-users text-emerald-500 mr-2"></i>
                                    <span class="text-sm font-semibold text-emerald-600">{{ $employees->count() }} Team
                                        Members</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Success/Error Messages --}}
            <div id="message"
                class="hidden mb-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 px-5 py-3 rounded-xl shadow-sm animate-slide-in">
            </div>
            <div id="assingmessage"
                class="hidden mb-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 px-5 py-3 rounded-xl shadow-sm animate-slide-in">
            </div>

            {{-- Grid Layout --}}
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 animate-fade-in" style="animation-delay: 0.1s">

                {{-- TASKS COLUMN --}}
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden employee-card">
                    <div class="bg-gradient-to-r from-gray-800 to-gray-900 text-white p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-xl font-bold flex items-center gap-2">
                                    <i class="fas fa-tasks"></i>
                                    Available Tasks
                                </h2>
                                <p class="text-xs text-gray-300 mt-1">Drag any task to assign</p>
                            </div>
                            <div class="bg-white/20 rounded-full px-3 py-1">
                                <span class="text-sm font-bold">{{ $tasks->count() }}</span>
                            </div>
                        </div>
                    </div>

                    <div id="taskBox" class="drop-zone p-4 space-y-3 bg-gray-50 custom-scrollbar"
                        style="min-height: 550px; max-height: 70vh; overflow-y: auto;">
                        @forelse ($tasks as $task)
                            @php
                                $priorityColors = [
                                    'low' => [
                                        'bg' => 'bg-green-100',
                                        'text' => 'text-green-700',
                                        'border' => 'border-green-400',
                                        'icon' => 'fa-arrow-down',
                                    ],
                                    'medium' => [
                                        'bg' => 'bg-orange-100',
                                        'text' => 'text-orange-700',
                                        'border' => 'border-orange-400',
                                        'icon' => 'fa-minus',
                                    ],
                                    'high' => [
                                        'bg' => 'bg-red-100',
                                        'text' => 'text-red-700',
                                        'border' => 'border-red-400',
                                        'icon' => 'fa-arrow-up',
                                    ],
                                ];
                                $priority = strtolower($task->project->priority);
                                $priorityStyle = $priorityColors[$priority] ?? $priorityColors['medium'];
                            @endphp

                            <div draggable="true"
                                class="task-card bg-white border-l-4 {{ $priorityStyle['border'] }} p-4 rounded-xl shadow-md cursor-grab"
                                data-task-id="{{ $task->id }}">
                                <div class="flex justify-between items-start gap-3">
                                    <div class="flex-1">
                                        <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                            <i class="fas fa-folder-open text-orange-500 text-sm"></i>
                                            {{ $task->project->name }}
                                        </h3>
                                        <div class="mt-2 flex items-center gap-2">
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold {{ $priorityStyle['bg'] }} {{ $priorityStyle['text'] }}">
                                                <i class="fas {{ $priorityStyle['icon'] }} text-xs"></i>
                                                {{ ucfirst($priority) }} Priority
                                            </span>
                                        </div>
                                        <div class="mt-2 flex items-center gap-2 text-xs text-gray-500">
                                            <i class="fas fa-calendar-alt"></i>
                                            <span>Deadline:
                                                {{ $task->project->end_date ? \Carbon\Carbon::parse($task->project->end_date)->format('d M Y') : 'Not set' }}</span>
                                        </div>
                                    </div>
                                    <button type="button"
                                        class="delete-task-btn w-8 h-8 flex items-center justify-center rounded-full bg-red-100 text-red-500 hover:bg-red-500 hover:text-white transition-all duration-200"
                                        data-task-id="{{ $task->id }}" data-task-name="{{ $task->project->name }}">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <i class="fas fa-inbox text-gray-300 text-5xl mb-3"></i>
                                <p class="text-gray-400 text-sm">No tasks available</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- EMPLOYEE COLUMNS --}}
                @php
                    $colors = [
                        'from-blue-600 to-blue-700',
                        'from-emerald-600 to-emerald-700',
                        'from-purple-600 to-purple-700',
                        'from-rose-600 to-rose-700',
                        'from-amber-600 to-amber-700',
                        'from-teal-600 to-teal-700',
                        'from-indigo-600 to-indigo-700',
                        'from-cyan-600 to-cyan-700',
                        'from-pink-600 to-pink-700',
                        'from-orange-600 to-orange-700',
                    ];
                @endphp

                @foreach ($employees as $index => $emp)
                    @php
                        $gradient = $colors[$index % count($colors)];
                        $assignedTasks = $asingTask->where('employee_id', $emp->id);
                        $taskCount = $assignedTasks->count();
                    @endphp

                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden employee-card">
                        <div class="bg-gradient-to-r {{ $gradient }} text-white p-5">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-lg font-bold flex items-center gap-2">
                                        <i class="fas fa-user-circle"></i>
                                        {{ $emp->name }}
                                    </h2>
                                    <p class="text-xs opacity-90 mt-0.5">
                                        <i class="fas fa-briefcase mr-1"></i>
                                        {{ $emp->designation ?? 'Team Member' }}
                                    </p>
                                </div>
                                <div class="bg-white/20 rounded-full px-2.5 py-1">
                                    <span class="text-sm font-bold">{{ $taskCount }}</span>
                                </div>
                            </div>
                        </div>

                        <div id="employee-{{ $emp->id }}" data-employee-id="{{ $emp->id }}"
                            class="drop-zone p-3 space-y-3 bg-gray-50 custom-scrollbar"
                            style="min-height: 550px; max-height: 70vh; overflow-y: auto;">

                            @foreach ($assignedTasks as $astask)
                                @php
                                    $status = strtolower($astask->addtask->project->status);
                                    $statusColors = [
                                        'pending' => [
                                            'bg' => 'bg-yellow-100',
                                            'text' => 'text-yellow-700',
                                            'border' => 'border-yellow-400',
                                            'icon' => 'fa-clock',
                                        ],
                                        'ongoing' => [
                                            'bg' => 'bg-blue-100',
                                            'text' => 'text-blue-700',
                                            'border' => 'border-blue-400',
                                            'icon' => 'fa-spinner',
                                        ],
                                        'completed' => [
                                            'bg' => 'bg-green-100',
                                            'text' => 'text-green-700',
                                            'border' => 'border-green-400',
                                            'icon' => 'fa-check-circle',
                                        ],
                                    ];
                                    $statusStyle = $statusColors[$status] ?? $statusColors['pending'];

                                    $priority = strtolower($astask->addtask->project->priority);
                                    $priorityColors = [
                                        'low' => 'text-green-600',
                                        'medium' => 'text-orange-500',
                                        'high' => 'text-red-600',
                                    ];
                                    $priorityIcon = [
                                        'low' => 'fa-arrow-down',
                                        'medium' => 'fa-minus',
                                        'high' => 'fa-arrow-up',
                                    ];
                                @endphp

                                <div draggable="true"
                                    class="task-card bg-white border-l-4 {{ $statusStyle['border'] }} p-3 rounded-xl shadow-sm cursor-grab hover:shadow-md transition-all"
                                    data-task-id="{{ $astask->id }}">
                                    <div class="flex justify-between items-start gap-2">
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-gray-800 text-sm flex items-center gap-1">
                                                <i class="fas fa-folder-open text-orange-500 text-xs"></i>
                                                {{ Str::limit($astask->addtask->project->name, 25) }}
                                            </h3>
                                            <div class="mt-1.5 flex flex-wrap items-center gap-1.5">
                                                <span
                                                    class="inline-flex items-center gap-0.5 text-xs {{ $priorityColors[$priority] }}">
                                                    <i class="fas {{ $priorityIcon[$priority] }} text-xs"></i>
                                                    {{ ucfirst($priority) }}
                                                </span>
                                                <span class="text-xs text-gray-400">•</span>
                                                <span
                                                    class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-full text-xs font-medium {{ $statusStyle['bg'] }} {{ $statusStyle['text'] }}">
                                                    <i class="fas {{ $statusStyle['icon'] }} text-xs"></i>
                                                    {{ ucfirst($status) }}
                                                </span>
                                            </div>
                                            @if ($astask->addtask->project->end_date)
                                                <div class="mt-1 flex items-center gap-1 text-xs text-gray-400">
                                                    <i class="fas fa-calendar-alt text-gray-300"></i>
                                                    <span>{{ \Carbon\Carbon::parse($astask->addtask->project->end_date)->format('d M Y') }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <button type="button"
                                            class="delete-assigned-btn w-7 h-7 flex items-center justify-center rounded-full bg-red-50 text-red-400 hover:bg-red-500 hover:text-white transition-all duration-200 flex-shrink-0"
                                            data-assin-id="{{ $astask->id }}"
                                            data-task-name="{{ $astask->addtask->project->name }}"
                                            data-employee-name="{{ $emp->name }}">
                                            <i class="fas fa-times text-xs"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach

                            @if ($taskCount == 0)
                                <div class="text-center py-8 opacity-50">
                                    <i class="fas fa-inbox text-gray-300 text-3xl mb-2"></i>
                                    <p class="text-gray-400 text-xs">Drop tasks here</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 text-center text-gray-400 text-sm">
                <i class="fas fa-info-circle mr-1"></i>
                Drag any task card and drop it onto an employee's column to assign
            </div>
        </div>
    </div>

    <form id="assignForm"
        action="{{ Auth::guard('team_leader')->check()
            ? route('teamhead.assignDragTask')
            : (Auth::guard('marketing_manager')->check()
                ? route('marketing.assignDragTask')
                : route('assignDragTask')) }}"
        method="POST" style="display: none;">
        @csrf
        @php
            $id = null;
            if (Auth::guard('team_leader')->check()) {
                $id = Auth::guard('team_leader')->id();
            } elseif (Auth::guard('project_manager')->check()) {
                $id = Auth::guard('project_manager')->id();
            } elseif (Auth::guard('super_admin')->check()) {
                $id = Auth::guard('super_admin')->id();
            } elseif (Auth::guard('marketing_manager')->check()) {
                $id = Auth::guard('marketing_manager')->id();
            }
        @endphp
        <input type="hidden" name="task_id" id="task_id">
        <input type="hidden" name="assigned_by" value="{{ $id }}">
        <input type="hidden" name="employee_id" id="employee_id">
    </form>

    <script>
        let draggedTask = null;
        let dragSourceContainer = null;

        // Drag & Drop Functions
        function initDrag() {
            const tasks = document.querySelectorAll('.task-card');

            tasks.forEach(task => {
                task.setAttribute('draggable', 'true');

                task.addEventListener('dragstart', function(e) {
                    draggedTask = this;
                    dragSourceContainer = this.parentElement;
                    this.classList.add('dragging');
                    e.dataTransfer.effectAllowed = 'move';
                    e.dataTransfer.setData('text/plain', this.dataset.taskId);
                });

                task.addEventListener('dragend', function() {
                    this.classList.remove('dragging');
                    draggedTask = null;
                    dragSourceContainer = null;
                });
            });
        }

        // Initialize drag on page load and after DOM changes
        function initDragAndDrop() {
            const dropZones = document.querySelectorAll('.drop-zone');

            dropZones.forEach(zone => {
                zone.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    e.dataTransfer.dropEffect = 'move';
                    zone.classList.add('drop-hover');
                });

                zone.addEventListener('dragleave', () => {
                    zone.classList.remove('drop-hover');
                });

                zone.addEventListener('drop', (e) => {
                    e.preventDefault();
                    zone.classList.remove('drop-hover');

                    if (draggedTask) {
                        // Check if dropping in same container
                        if (dragSourceContainer === zone) {
                            return;
                        }

                        const taskId = draggedTask.dataset.taskId;
                        const employeeId = zone.dataset.employeeId;

                        if (taskId && employeeId) {
                            document.getElementById('task_id').value = taskId;
                            document.getElementById('employee_id').value = employeeId;
                            document.getElementById('assignForm').submit();
                        }
                    }
                });
            });
        }

        // Delete Task from Available Tasks
        $(document).ready(function() {
            var msg = $("#message");
            msg.hide();

            $(document).on('click', '.delete-task-btn', function() {
                var id = $(this).data('task-id');
                var taskName = $(this).data('task-name');

                Swal.fire({
                    title: 'Delete Task?',
                    html: `Are you sure you want to delete <strong class="text-orange-600">${taskName}</strong>?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="fas fa-trash-alt mr-2"></i>Yes, delete it!',
                    cancelButtonText: '<i class="fas fa-times mr-2"></i>Cancel',
                    background: '#fff',
                    customClass: {
                        popup: 'rounded-2xl'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('deleteAddTask') }}",
                            type: "GET",
                            data: {
                                id: id
                            },
                            success: function(res) {
                                if (res.status == true) {
                                    msg.text(res.message).removeClass('hidden')
                                        .fadeIn();
                                    setTimeout(function() {
                                        location.reload();
                                    }, 1000);
                                }
                            },
                            error: function(error) {
                                console.log(error);
                                Swal.fire('Error!', 'Something went wrong', 'error');
                            }
                        });
                    }
                });
            });
        });

        // Delete Assigned Task
        $(document).ready(function() {
            var msg = $("#assingmessage");
            msg.hide();

            $(document).on('click', '.delete-assigned-btn', function() {

                var id = $(this).data('assin-id');
                var taskName = $(this).data('task-name');
                var employeeName = $(this).data('employee-name');
                @if (Auth::guard('team_leader')->check())
                    let deleteUrl = "{{ route('teamhead.assingdeletetask') }}";
                @elseif (Auth::guard('project_manager')->check() || Auth::guard('super_admin')->check())
                    let deleteUrl = "{{ route('assingdeletetask') }}";
                    @elseif (Auth::guard('marketing_manager')->check())
                    let deleteUrl = "{{ route('marketing.assingdeletetask') }}";
                @endif



                Swal.fire({
                    title: 'Remove Assignment?',
                    html: `Remove <strong class="text-orange-600">${taskName}</strong> from <strong class="text-blue-600">${employeeName}</strong>?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#f97316',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="fas fa-check mr-2"></i>Yes, remove it',
                    cancelButtonText: '<i class="fas fa-times mr-2"></i>Cancel',
                    background: '#fff',
                    customClass: {
                        popup: 'rounded-2xl'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: deleteUrl,
                            type: "GET",
                            data: {
                                id: id
                            },
                            success: function(res) {
                                msg.text('Task removed successfully').removeClass(
                                    'hidden').fadeIn();
                                setTimeout(function() {
                                    location.reload();
                                }, 800);
                            },
                            error: function(error) {
                                console.log(error);
                                Swal.fire('Error!', 'Something went wrong', 'error');
                            }
                        });
                    }
                });
            });

            // Initialize drag after any dynamic content
            setTimeout(() => {
                initDrag();
                initDragAndDrop();
            }, 100);
        });

        // Reinitialize drag after page load
        window.addEventListener('load', function() {
            initDrag();
            initDragAndDrop();
        });

        // Observe for DOM changes to reinitialize drag on new tasks
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.addedNodes.length > 0) {
                    initDrag();
                    initDragAndDrop();
                }
            });
        });

        observer.observe(document.querySelector('#taskBox'), {
            childList: true,
            subtree: true
        });
        document.querySelectorAll('[id^="employee-"]').forEach(zone => {
            observer.observe(zone, {
                childList: true,
                subtree: true
            });
        });
    </script>
@endsection
