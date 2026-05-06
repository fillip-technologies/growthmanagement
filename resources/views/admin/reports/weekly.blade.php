@extends('admin.include.layout')
@section('content')
    <div class="max-w-7xl mx-auto mt-6">

        {{-- HEADER --}}
        <div class="mb-5">
            <h1 class="text-2xl font-bold text-gray-800">Weekly Task Report</h1>
            <p class="text-sm text-gray-500">All employee and assigned task details in one view</p>
        </div>

        {{-- TABLE CARD --}}
        <div class="bg-white border rounded-xl shadow-sm overflow-hidden">

            <table class="w-full text-sm">

                {{-- HEADER --}}
                <thead class="bg-gray-50 text-gray-600 text-xs uppercase">
                    <tr>
                        <th class="p-3 text-left">Employee</th>
                        <th class="p-3 text-left">Contact</th>
                        <th class="p-3 text-left">Designation</th>

                        <th class="p-3 text-left">Task</th>
                        <th class="p-3 text-left">Priority</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-left">Progress</th>
                        <th class="p-3 text-left">Deadline</th>
                        <th class="p-3 text-left">Action</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody class="divide-y">

                    @forelse($tasks as $task)
                        <tr class="hover:bg-gray-50 transition">

                            {{-- EMPLOYEE --}}
                            <td class="p-3">
                                <div class="flex items-center gap-3">

                                    <img src="{{ asset($task->user->profile ?? '') }}"
                                        class="w-10 h-10 rounded-full object-cover border">

                                    <div>
                                        <div class="font-semibold text-gray-800">
                                            {{ $task->user->name ?? 'N/A' }}
                                        </div>

                                        <div class="text-xs text-gray-500">
                                            ID: {{ $task->user->id ?? '' }}
                                        </div>
                                    </div>

                                </div>
                            </td>

                            {{-- CONTACT --}}
                            <td class="p-3 text-gray-600">
                                <div>{{ $task->user->email ?? '' }}</div>
                                <div class="text-xs text-gray-500">
                                    {{ $task->user->phone ?? '' }}
                                </div>
                            </td>

                            {{-- DESIGNATION --}}
                            <td class="p-3 text-gray-600">
                                {{ $task->user->designation ?? '' }}
                            </td>

                            {{-- TASK --}}
                            <td class="p-3">
                                <div class="font-medium text-gray-800">
                                    {{ $task->task_name }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $task->title }}
                                </div>
                            </td>

                            {{-- PRIORITY --}}
                            <td class="p-3">
                                <span
                                    class="px-2 py-1 text-xs rounded-full
                                {{ $task->priority == 'high' ? 'bg-red-100 text-red-600' : '' }}
                                {{ $task->priority == 'medium' ? 'bg-yellow-100 text-yellow-600' : '' }}
                                {{ $task->priority == 'low' ? 'bg-green-100 text-green-600' : '' }}">
                                    {{ ucfirst($task->priority) }}
                                </span>
                            </td>

                            {{-- STATUS --}}
                            <td class="p-3">
                                <span
                                    class="px-2 py-1 text-xs rounded-full
                                {{ $task->status == 'completed' ? 'bg-green-100 text-green-600' : '' }}
                                {{ $task->status == 'pending' ? 'bg-yellow-100 text-yellow-600' : '' }}
                                {{ $task->status == 'in_progress' ? 'bg-blue-100 text-blue-600' : '' }}">
                                    {{ ucfirst($task->status) }}
                                </span>
                            </td>

                            {{-- PROGRESS --}}
                            <td class="p-3">
                                <div class="w-24 bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $task->progress }}%"></div>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $task->progress }}%
                                </div>
                            </td>

                            {{-- DEADLINE --}}
                            <td class="p-3 text-gray-600">
                                {{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}
                            </td>

                            {{-- ACTION --}}
                            <td class="p-3 flex gap-2">

                                {{-- 🔔 NOTIFICATION --}}
                                <button class="px-2 py-1 text-xs bg-blue-100 text-blue-600 rounded hover:bg-blue-200"
                                    title="View Notification">

                                    🔔 Notify
                                </button>

                                {{-- 🔁 RE-ASSIGN --}}
                                <button class="px-2 py-1 text-xs bg-orange-100 text-orange-600 rounded hover:bg-orange-200"
                                    title="Re-assign Task">

                                    🔁 Re-assign
                                </button>

                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-6 text-gray-500">
                                No data found
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>
@endsection
