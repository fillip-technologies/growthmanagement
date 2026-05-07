@extends('admin.include.layout')

@section('heading', 'Tasks')
@section('title', 'Task List')

@section('content')

    <div class="max-w-7xl mx-auto mt-8">


        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

            <div>
                <h1 class="text-2xl font-semibold text-gray-800">Task Management</h1>
                <p class="text-sm text-gray-500">Manage and track all assigned tasks</p>
            </div>

            <a href="{{ route('task.form') }}"
                class="inline-flex items-center gap-2 bg-gray-900 hover:bg-gray-800 text-white px-5 py-2 rounded-lg text-sm font-medium shadow-sm transition">
                + Add Task
            </a>

        </div>


        <div class="bg-white border rounded-xl shadow-sm overflow-hidden">

            <div class="overflow-x-auto">

                <table class="min-w-full text-sm">


                    <thead class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-4 py-3 text-left">#</th>
                            <th class="px-4 py-3 text-left">Task</th>
                            <th class="px-4 py-3 text-left">Project</th>
                            <th class="px-4 py-3 text-left">Assigned To</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Deadline</th>
                            <th class="px-4 py-3 text-left">Modules</th>
                            <th class="px-4 py-3 text-center">Action</th>
                        </tr>
                    </thead>

                    {{-- BODY --}}
                    <tbody class="divide-y divide-gray-100">

                        @forelse ($tasks as $task)

                            <tr class="hover:bg-gray-50 transition">

                                {{-- INDEX --}}
                                <td class="px-4 py-3 text-gray-500">
                                    {{ $loop->iteration }}
                                </td>

                                {{-- TASK --}}
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-800">
                                        {{ $task->task_name }}
                                    </div>
                                </td>

                                {{-- PROJECT --}}
                                <td class="px-4 py-3 text-gray-600">
                                    {{ $task->project->name ?? '-' }}
                                </td>


                                <td class="px-4 py-3 text-gray-600">
                                    {{ $task->user->name ?? 'N/A' }}
                                </td>

                                <td class="px-4 py-3">

                                    <span
                                        class="px-2 py-1 text-xs rounded-full font-medium
                                    {{ $task->status === 'completed'
                                        ? 'bg-green-50 text-green-600'
                                        : ($task->status === 'in_progress'
                                            ? 'bg-blue-50 text-blue-600'
                                            : 'bg-gray-100 text-gray-600') }}">

                                        {{ ucwords(str_replace('_', ' ', $task->status)) }}

                                    </span>

                                </td>


                                <td class="px-4 py-3 text-gray-600">
                                    {{ $task->deadline ?? '-' }}
                                </td>
                                <td class="px-4 py-3">
                                     @php
                                           $taskmodul =  json_decode($task->assingmodul);
                                        @endphp
                                    <select
                                        class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-orange-400">
                                        <option value="">Modules</option>
                                        @foreach ($taskmodul as $module)

                                            <option value="{{ $module }}">{{ $module }}</option>
                                        @endforeach
                                    </select>
                                </td>

                                <td class="px-4 py-3">

                                    <div class="flex justify-center items-center gap-2">


                                        <a href="{{ route('task.edit', $task->id) }}"
                                            class="p-2 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-900 hover:text-white transition"
                                            title="Edit">

                                            <i class="fa-solid fa-pen"></i>
                                        </a>


                                        <form action="{{ route('tasks.delete', $task->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this task?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="p-2 rounded-lg bg-gray-100 text-red-500 hover:bg-red-500 hover:text-white transition"
                                                title="Delete">

                                                <i class="fa-solid fa-trash"></i>
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="text-center py-10 text-gray-400">
                                    No tasks found
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            <div class="p-4 border-t bg-gray-50">
                {{ $tasks->links() }}
            </div>

        </div>

    </div>

@endsection
