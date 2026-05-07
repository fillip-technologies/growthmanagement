@extends('admin.include.layout')
@section('content')
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
                @foreach ($tasks as $task)
                    <div draggable="true" class="task bg-white border-l-4 border-red-500 p-4 rounded-xl shadow cursor-move">
                        <div class="flex justify-between">
                            <div>
                                <h3 class="font-bold text-lg">
                                    {{ $task->project->name }}
                                </h3>
                                <p class="text-sm text-gray-500">
                                    {{ ucfirst($task->project->priority) }} Priority
                                </p>
                            </div>
                            <form id="deleteTask">
                                @csrf
                                <input type="hidden" name="id" value="{{ $task->project->id }}" id="projectID">
                                <button class="delete-btn text-red-500 text-xl font-bold">
                                    ×
                                </button>
                            </form>


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

        @foreach ($employees as $index => $emp)
            @php
                $bgColor = $colors[$index % count($colors)];
            @endphp

            <div class="bg-white rounded-2xl shadow overflow-hidden">

                <!-- Employee Header -->
                <div class="{{ $bgColor }} text-white p-4">
                    <h2 class="text-2xl font-bold">
                        {{ $emp->name }}
                    </h2>

                    <p class="text-sm opacity-80">
                        {{ $emp->designation }}
                    </p>
                </div>

                <!-- Drop Zone -->
                <div id="employee-{{ $emp->id }}" class="drop-zone min-h-[500px] p-4 space-y-4 bg-gray-50">
                </div>

            </div>
        @endforeach

        {{-- <!-- EMPLOYEE -->
        <div class="bg-white rounded-2xl shadow overflow-hidden">

            <div class="bg-green-600 text-white p-4">
                <h2 class="text-2xl font-bold">
                    Aman
                </h2>

                <p class="text-sm opacity-80">
                    Backend Developer
                </p>
            </div>

            <div id="aman" class="drop-zone min-h-[500px] p-4 space-y-4">
            </div>

        </div>

        <!-- EMPLOYEE -->
        <div class="bg-white rounded-2xl shadow overflow-hidden">

            <div class="bg-purple-600 text-white p-4">
                <h2 class="text-2xl font-bold">
                    Priya
                </h2>

                <p class="text-sm opacity-80">
                    UI/UX Designer
                </p>
            </div>

            <div id="priya" class="drop-zone min-h-[500px] p-4 space-y-4">
            </div>

        </div> --}}

    </div>

    <script>
        let draggedTask = null;

        // ALL TASKS
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

            zone.addEventListener('drop', () => {

                zone.classList.remove('drop-hover');

                if (draggedTask) {

                    zone.appendChild(draggedTask);

                    let taskName =
                        draggedTask.querySelector('h3').innerText;

                    console.log(
                        taskName + " Assigned To " + zone.id
                    );

                }

            });

        });
        document.addEventListener('click', function(e) {

            if (e.target.classList.contains('delete-btn')) {

                e.target.closest('.task').remove();

            }

        });
    </script>
@endsection
