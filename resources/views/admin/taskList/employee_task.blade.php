@extends('admin.include.layout')
@section('content')
    <div class="max-w-7xl mx-auto mt-8 bg-white shadow rounded-lg overflow-hidden">

        <div class="p-4 border-b flex justify-between items-center">
            <h2 class="text-xl font-bold">Assing Task List</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left">

                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-3">ID</th>
                        <th class="p-3">Employee</th>
                        <th class="p-3">Task Name</th>
                        <th class="p-3">Project</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Priority</th>
                        <th class="p-3">Deadline</th>
                        <th class="p-3">Modules</th>
                        <th class="p-3">Progress</th>

                    </tr>
                </thead>

                <tbody>

                    @foreach ($tasks as $key => $task)
                        <tr class="border-t hover:bg-gray-50">

                            <td class="p-3">{{ $key + 1 }}</td>
                            <td class="p-3 font-medium text-gray-800">
                                {{ $task->user->name }}
                            </td>

                            <td class="p-3 font-medium text-gray-800">
                                {{ $task->task_name }}
                            </td>

                            <td class="p-3">
                                {{ $task->project->name ?? 'N/A' }}
                            </td>

                            <td class="p-3">
                                <span
                                    class="px-2 py-1 rounded text-xs
                                {{ $task->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
                                    {{ ucfirst($task->status) }}
                                </span>
                            </td>

                            <td class="p-3 capitalize">
                                {{ $task->priority }}
                            </td>

                            <td class="p-3">
                                {{ $task->deadline }}
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $taskmodul = json_decode($task->assingmodul);
                                @endphp
                                <select
                                    class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-orange-400">
                                    <option value="">Modules</option>
                                    @foreach ($taskmodul as $module)
                                        <option value="{{ $module }}">{{ $module }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-3">
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $task->progress }}%">
                                    </div>
                                </div>
                                <small>{{ $task->progress }}%</small>
                            </td>



                        </tr>
                    @endforeach

                </tbody>

            </table>
        </div>

    </div>
@endsection
