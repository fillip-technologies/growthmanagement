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
    <div class="max-w-7xl mx-auto mt-8 bg-white shadow-xl rounded-2xl overflow-hidden">

        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-6 text-white">
            <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">

                <div>
                    <h2 class="text-3xl font-bold">
                        Assigned Task List
                    </h2>

                    <p class="text-sm opacity-80 mt-1">
                        Employee & Project Details
                    </p>
                </div>

                <div class="bg-white/20 px-5 py-3 rounded-xl text-sm font-semibold">
                    Total Tasks : {{ $tasks->count() }}
                </div>

            </div>
        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full text-sm text-left">

                <!-- Head -->
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs tracking-wider">

                    <tr>
                        <th class="p-4">#</th>
                        <th class="p-4">Employee</th>
                        <th class="p-4">Project</th>
                        <th class="p-4">Modules</th>
                        <th class="p-4">Progress</th>
                         <th class="p-4">Action</th>
                    </tr>

                </thead>

                <!-- Body -->
                <tbody class="divide-y divide-gray-200">

                    @forelse ($tasks as $key => $task)
                        @php
                            $project = $task->addtask->project ?? null;
                            $modules = $project->modules ?? [];
                        @endphp

                        <tr class="hover:bg-gray-50 transition duration-200">

                            <!-- ID -->
                            <td class="p-4 font-bold text-gray-700">
                                {{ $key + 1 }}
                            </td>

                            <!-- Employee -->
                            <td class="p-4">

                                <div class="flex items-start gap-3">

                                    <!-- Avatar -->
                                    <div
                                        class="h-12 w-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-lg shrink-0">
                                        {{ strtoupper(substr($task->user->name ?? 'U', 0, 1)) }}
                                    </div>

                                    <!-- Info -->
                                    <div>

                                        <h3 class="font-semibold text-gray-800">
                                            {{ $task->user->name ?? 'N/A' }}
                                        </h3>

                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $task->user->email ?? 'No Email' }}
                                        </p>



                                    </div>

                                </div>

                            </td>


                            <td class="p-4">

                                <div class="space-y-2">

                                    <h3 class="font-semibold text-blue-700">
                                        {{ $project->name ?? 'N/A' }}
                                    </h3>

                                    <div class="text-xs text-gray-600">
                                        <strong>Description :</strong>
                                        {{ $project->description ?? 'N/A' }}
                                    </div>

                                    <div class="text-xs text-gray-600">
                                        <strong>Start Date :</strong>
                                        {{ $project->start_date ?? 'N/A' }}
                                    </div>

                                    <div class="text-xs text-gray-600">
                                        <strong>End Date :</strong>
                                        {{ $project->end_date ?? 'N/A' }}
                                    </div>

                                    <!-- Status -->
                                    <div class="text-xs">

                                        <strong>Status :</strong>

                                        <span
                                            class="px-2 py-1 rounded-full text-xs
                                        {{ ($project->status ?? '') == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">

                                            {{ ucfirst($project->status ?? 'N/A') }}

                                        </span>

                                    </div>

                                    <!-- Priority -->
                                    <div class="text-xs text-gray-600">
                                        <strong>Priority :</strong>
                                        {{ ucfirst($project->priority ?? 'N/A') }}
                                    </div>

                                </div>

                            </td>

                            <!-- Modules -->
                            <td class="p-4">

                                <div class="flex flex-wrap gap-2">

                                    @if (!empty($modules) && count($modules) > 0)
                                        @foreach ($modules as $module)
                                            <span
                                                class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-medium">
                                                {{ $module }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="text-gray-400 text-xs">
                                            No Modules
                                        </span>
                                    @endif

                                </div>

                            </td>


                            <td class="p-4 w-52">

                                <div class="flex justify-between mb-1 text-xs font-medium">
                                    <span>Progress</span>
                                    <span>{{ $task->progress ?? 0 }}%</span>
                                </div>

                                <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">

                                    <div class="h-3 rounded-full transition-all duration-500
                                    {{ ($task->progress ?? 0) < 30
                                        ? 'bg-red-500'
                                        : (($task->progress ?? 0) < 70
                                            ? 'bg-yellow-500'
                                            : 'bg-green-500') }}"
                                        style="width: {{ $task->progress ?? 0 }}%">
                                    </div>

                                </div>

                            </td>

                             <td class="p-4">
                                <form action="{{ route('employee.status') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                                    <select name="status" class="w-full border-2 rounded" onchange="submit()">
                                        <option value="">--Select Status--</option>
                                        <option value="ongoing" @selected($project->status === "ongoing")>OnGoing</option>
                                        <option value="completed" @selected($project->status === "completed")>Completed</option>
                                    </select>
                                </form>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="p-10 text-center text-gray-500">
                                No Tasks Found
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

@endsection
