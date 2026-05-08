@extends('admin.include.layout')

@section('content')
    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: `{!! implode('<br>', $errors->all()) !!}`
            });
        </script>
    @endif

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
                timer: 2500,
                showConfirmButton: false
            });
        </script>
    @endif

    <style>
        .dragging {
            opacity: 0.5;
            transform: scale(1.05);
        }

        .drop-hover {
            background: #dbeafe;
            border: 2px dashed #2563eb;
        }
    </style>

    <h1 class="text-4xl font-bold text-center mb-10">
        Drag & Drop Task Assignment
    </h1>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

        <!-- TASKS -->
        <div class="bg-white rounded-2xl shadow overflow-hidden">

            <div class="bg-black text-white p-4">
                <h2 class="text-2xl font-bold">
                    Tasks
                </h2>
            </div>

            <div id="taskBox" class="drop-zone min-h-[500px] p-4 space-y-4">

                <div id="message" class="hidden bg-green-100 text-green-700 px-4 py-2 rounded mb-3">
                </div>

                @foreach ($tasks as $task)
                    <div draggable="true" class="task bg-white border-l-4 border-red-500 p-4 rounded-xl shadow cursor-move"
                        data-task-id="{{ $task->id }}">

                        <div class="flex justify-between items-start">

                            <div>
                                <h3 class="font-bold text-lg">
                                    {{ $task->project->name }}
                                </h3>

                                <p class="text-sm text-gray-500">
                                    {{ ucfirst($task->project->priority) }} Priority
                                </p>
                            </div>

                            <button id="deleteTask"
                                class="delete-btn w-8 h-8 flex items-center justify-center rounded-full bg-red-100 text-red-600 hover:bg-red-600 hover:text-white transition"
                                data-task-id="{{ $task->id }}">
                                ×
                            </button>



                        </div>

                    </div>
                @endforeach

            </div>

        </div>
        @php
            $colors = [
                'bg-blue-600',
                'bg-green-600',
                'bg-red-600',
                'bg-purple-600',
                'bg-pink-600',
                'bg-yellow-500',
                'bg-indigo-600',
                'bg-teal-600',
                'bg-orange-600',
                'bg-cyan-600',
            ];
        @endphp
    <div id="assingmessage" class="hidden bg-green-100 text-green-700 px-4 py-2 rounded mb-3">
                </div>

        @foreach ($employees as $index => $emp)
            @php
                $bgColor = $colors[$index % count($colors)];
            @endphp

            <div class="bg-white rounded-2xl shadow overflow-hidden">


                <div class="{{ $bgColor }} text-white p-4">

                    <h2 class="text-2xl font-bold">
                        {{ $emp->name }}
                    </h2>

                    <p class="text-sm opacity-80">
                        {{ $emp->designation }}
                    </p>

                </div>

                <div id="employee-{{ $emp->id }}" data-employee-id="{{ $emp->id }}"
                    class="drop-zone min-h-[500px] p-4 space-y-4 bg-gray-50 rounded-2xl">

                    @foreach ($asingTask->where('employee_id', $emp->id) as $astask)
                        @php
                            $status = strtolower($astask->addtask->project->status);

                            $statusColor = match ($status) {
                                'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-400',
                                'ongoing' => 'bg-blue-100 text-blue-700 border-blue-400',
                                'completed' => 'bg-green-100 text-green-700 border-green-400',
                                default => 'bg-gray-100 text-gray-700 border-gray-400',
                            };

                            $taskBorder = match ($status) {
                                'pending' => 'border-yellow-500',
                                'ongoing' => 'border-blue-500',
                                'completed' => 'border-green-500',
                                default => 'border-gray-500',
                            };
                        @endphp

                        <div draggable="true"
                            class="task bg-white border-l-4 {{ $taskBorder }} p-4 rounded-xl shadow cursor-move hover:shadow-lg transition"
                            data-task-id="{{ $astask->id }}">

                            <div class="flex justify-between items-start gap-3">

                                <div class="flex-1">

                                    <!-- Project Name -->
                                    <h3 class="font-bold text-lg text-gray-800">
                                        {{ $astask->addtask->project->name }}
                                    </h3>

                                    <!-- Priority -->
                                    <p class="text-sm text-gray-500 mt-1">
                                        <strong>Priority :</strong>
                                        {{ ucfirst($astask->addtask->project->priority) }}
                                    </p>

                                    <!-- Deadline -->
                                    <p class="text-sm text-gray-500 mt-1">
                                        <strong>Deadline :</strong>
                                        {{ \Carbon\Carbon::parse($astask->addtask->project->end_date)->format('d M Y h:i A') }}
                                    </p>

                                    <!-- Status -->
                                    <div class="mt-3">
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full border {{ $statusColor }}">
                                            {{ ucfirst($status) }}
                                        </span>
                                    </div>

                                </div>

                                <!-- Delete Button -->
                                <button id="assingtaskDelete" data-assin-id="{{ $astask->id }}"
                                    class="delete-btn w-8 h-8 flex items-center justify-center rounded-full bg-red-100 text-red-600 hover:bg-red-600 hover:text-white transition">
                                    ×
                                </button>

                            </div>

                        </div>
                    @endforeach

                </div>

            </div>
        @endforeach

    </div>
    <form id="assignForm" action="{{ route('assignDragTask') }}" method="POST">
        @csrf
        <input type="hidden" name="task_id" id="task_id">
        <input type="hidden" name="employee_id" id="employee_id">
    </form>
    <script>
        let draggedTask = null;

        function initDrag() {

            const tasks = document.querySelectorAll('.task');

            tasks.forEach(task => {

                task.addEventListener('dragstart', () => {

                    draggedTask = task;

                    setTimeout(() => {
                        task.classList.add('dragging');
                    }, 0);

                });

                task.addEventListener('dragend', () => {

                    task.classList.remove('dragging');

                });

            });

        }

        initDrag();



        const dropZones = document.querySelectorAll('.drop-zone');

        dropZones.forEach(zone => {

            zone.addEventListener('dragover', (e) => {

                e.preventDefault();

                zone.classList.add('drop-hover');

            });

            zone.addEventListener('dragleave', () => {

                zone.classList.remove('drop-hover');

            });

            zone.addEventListener('drop', (e) => {

                e.preventDefault();

                zone.classList.remove('drop-hover');

                if (draggedTask) {


                    zone.appendChild(draggedTask);


                    let taskId = draggedTask.dataset.taskId;

                    let employeeId = zone.dataset.employeeId;

                    document.getElementById('task_id').value = taskId;
                    document.getElementById('employee_id').value = employeeId;

                    document.getElementById('assignForm').submit();

                }

            });

        });


        $(document).ready(function() {

            var msg = $("#message");
            msg.hide();

            $("#deleteTask").on('click', function() {

                var id = $(this).data('task-id');

                $.ajax({
                    url: "{{ route('deleteAddTask') }}",
                    type: "GET",

                    data: {
                        id: id
                    },
                    success: function(res) {

                        if (res.status == true) {
                            msg
                                .text(res.message)
                                .removeClass('hidden')
                                .show();

                            $("#task-" + id).remove();
                            setTimeout(function() {
                                location.reload();
                            }, 1000);

                        }

                    },
                    error: function(error) {
                        console.log(error);
                    }
                });

            });

        });

        $(document).ready(function() {
            var msg = $("#assingmessage");
            msg.hide();
            $('#assingtaskDelete').on('click', function() {
                var id = $(this).data('assin-id');
                $.ajax({
                    url: "{{ route('assingdeletetask') }}",
                    type: "GET",

                    data: {
                        id: id
                    },
                    success: function(res) {

                            setTimeout(function() {
                                location.reload();
                            }, 1000);

                        },
                    error: function(error) {
                        console.log(error);
                    }
                });
            })
        });
    </script>
@endsection
