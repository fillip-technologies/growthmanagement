@extends('admin.include.layout')

@section('heading', 'Tasks')
@section('title', 'Task List')

@section('content')

    <div class="max-w-7xl mx-auto mt-8">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Task List</h1>

            <a href="{{ route('task.form') }}"
                class="bg-orange-600 hover:bg-orange-700 text-white px-5 py-2 rounded-lg font-semibold shadow">
                + Add Task
            </a>
        </div>

        <div class="bg-white shadow rounded-xl overflow-hidden">

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">

                    <!-- Header -->
                    <thead class="bg-orange-600 text-white">
                        <tr>
                            <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3">Task</th>
                            <th class="px-4 py-3">Project</th>
                            <th class="px-4 py-3">Assigned To</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Deadline</th>
                            <th class="px-4 py-3">Action</th>

                        </tr>
                    </thead>

                    <!-- Body -->
                    <tbody class="divide-y">
                        @forelse ($tasks as $task)
                            <tr class="hover:bg-gray-50">

                                <td class="px-4 py-3">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-4 py-3 font-medium text-gray-800">
                                    {{ $task->task_name }}
                                </td>

                                <td class="px-4 py-3 text-gray-600">
                                    {{ $task->project->name ?? '-' }}
                                </td>

                                <td class="px-4 py-3 text-gray-600">
                                    {{ $task->user->name ?? 'N/A' }}
                                </td>

                                <td class="px-4 py-3">
                                    <span
                                        class="px-2 py-1 text-xs rounded
                                    {{ $task->status === 'completed'
                                        ? 'bg-green-600 text-white'
                                        : ($task->status === 'in_progress'
                                            ? 'bg-blue-600 text-white'
                                            : 'bg-gray-600 text-white') }}">
                                        {{ ucwords(str_replace('_', ' ', $task->status)) }}
                                    </span>
                                </td>

                                <td class="px-4 py-3 text-gray-600">
                                    {{ $task->deadline ?? '-' }}
                                </td>

                                <td class="px-4 py-3 flex gap-2">

                                    <!-- Edit -->
                                    <a href="{{ route('task.edit', $task->id) }}"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs">
                                        Edit
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('tasks.delete', $task->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                                            Delete
                                        </button>
                                    </form>

                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-6 text-gray-400">
                                    No Tasks Found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4 border-t">
                {{ $tasks->links() }}
            </div>

        </div>

    </div>

@endsection
