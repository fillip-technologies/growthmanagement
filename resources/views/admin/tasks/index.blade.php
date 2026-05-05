@extends('admin.include.layout')
@section('heading', 'Tasks')
@section('title', 'Task List')

@section('content')

    @if (Auth::guard('admin')->user()->role === 'admin')
        <div class="max-w-7xl mx-auto mt-8">

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Task List</h1>

                <a href="{{ route('task.form') }}"
                    class="inline-block bg-orange-600 hover:bg-orange-700
                  text-white px-5 py-2 rounded-lg font-semibold">
                    + Add Task
                </a>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                        text: '{{ session('success') }}',
                        timer: 2500,
                        showConfirmButton: false
                    });
                </script>
            @endif
            <!-- Table -->
            <div class="bg-white shadow-xl rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                   <table class="min-w-full text-sm text-left">
    <thead class="bg-orange-600 text-white">
        <tr>
            <th class="px-6 py-4">#</th>
            <th class="px-6 py-4">Project</th>
            <th class="px-6 py-4">Task</th>
            <th class="px-6 py-4">Assigned To</th>
            <th class="px-6 py-4">Status</th>
            <th class="px-6 py-4">Deadline</th>
            <th class="px-6 py-4">Progress</th>
            <th class="px-6 py-4">Module</th>
            <th class="px-6 py-4">Attachments</th>
            <th class="px-6 py-4">Action</th>
        </tr>
    </thead>

    <tbody class="divide-y">
        @forelse ($tasks as $task)
        <tr class="hover:bg-gray-50 transition">

            <!-- Index -->
            <td class="px-6 py-4 font-semibold">
                {{ $loop->iteration }}
            </td>

            <!-- Project -->
            <td class="px-6 py-4">
                {{ $task->project->name ?? 'No Project' }}
            </td>

            <!-- Task -->
            <td class="px-6 py-4">
                <a href="{{ route('task.view', $task->id) }}" 
                   class="text-blue-600 font-medium hover:underline">
                    {{ $task->task_name }}
                </a>
            </td>

            <!-- User -->
            <td class="px-6 py-4">
                {{ $task->user->name ?? 'N/A' }}
            </td>

            <!-- Status -->
            <td class="px-6 py-4">
                <span class="px-3 py-1 text-xs font-semibold rounded whitespace-nowrap
                    {{ $task->status === 'completed'
                        ? 'bg-green-600 text-white'
                        : ($task->status === 'in_progress'
                            ? 'bg-blue-600 text-white'
                            : 'bg-gray-600 text-white') }}">
                    {{ ucwords(str_replace('_', ' ', $task->status)) }}
                </span>
            </td>

            <!-- Deadline -->
            <td class="px-6 py-4 text-gray-600">
                {{ $task->deadline ?? '-' }}
            </td>

            <td class="px-6 py-4">
    <div class="w-full bg-gray-200 rounded-full h-3">
        <div class="bg-green-500 h-3 rounded-full"
             style="width: {{ $task->progress ?? 0 }}%">
        </div>
    </div>
    <span class="text-xs">{{ $task->progress ?? 0 }}%</span>
</td>

            <td>
            {{ $task->module->name ?? 'No Module' }}

               <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                 <div class="bg-blue-500 h-2 rounded"
                style="width: {{ $task->module->progress ?? 0 }}%">
                 </div>
            </div>

           <span class="text-xs">
              {{ $task->module->progress ?? 0 }}%
            </span>
           </td>
            <!-- Attachments -->
            <td class="px-6 py-4">
                @php
                    $files = is_array($task->attachments) 
                        ? $task->attachments 
                        : json_decode($task->attachments, true);
                @endphp

                @if (!empty($files))
                    <div class="flex gap-2 flex-wrap">
                        @foreach ($files as $file)
                            @php
                                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                            @endphp

                            @if (in_array($ext, ['jpg','jpeg','png','webp']))
                                <img src="{{ asset($file) }}"
                                     class="w-14 h-14 rounded object-cover border">
                            @elseif ($ext === 'pdf')
                                <a href="{{ asset($file) }}" target="_blank"
                                   class="text-red-600 text-xs underline">PDF</a>
                            @else
                                <a href="{{ asset($file) }}" target="_blank"
                                   class="text-blue-600 text-xs underline">File</a>
                            @endif
                        @endforeach
                    </div>
                @else
                    <span class="text-gray-400">No Files</span>
                @endif
            </td>

            <!-- Actions -->
            <td class="px-6 py-4">
                <div class="flex gap-2">

                    <a href="{{ route('task.edit', $task->id) }}"
                       class="px-3 py-1 text-xs text-white bg-blue-600 rounded hover:bg-blue-700">
                        Edit
                    </a>

                    @if ($task->status === 'completed')
                        <a href="{{ route('report', ['id'=>$task->id,'uid'=>$task->assigned_to]) }}"
                           class="px-3 py-1 text-xs text-white bg-pink-600 rounded hover:bg-pink-700">
                            Report
                        </a>
                    @endif

                    <form action="{{ route('tasks.delete', $task->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button
                            class="px-3 py-1 text-xs text-white bg-red-600 rounded hover:bg-red-700">
                            Delete
                        </button>
                    </form>

                </div>
            </td>

        </tr>
        @empty
        <tr>
            <td colspan="8" class="text-center py-6 text-gray-500">
                No Tasks Found.
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
    @else
        <div class="max-w-7xl mx-auto mt-8">

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Task List</h1>

                {{-- <a href="{{ route('task.form') }}"
                    class="inline-block bg-orange-600 hover:bg-orange-700
                  text-white px-5 py-2 rounded-lg font-semibold">
                    + Add Task
                </a> --}}
            </div>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                        text: '{{ session('success') }}',
                        timer: 2500,
                        showConfirmButton: false
                    });
                </script>
            @endif
            <!-- Table -->
            <div class="bg-white shadow-xl rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-orange-600 text-white">
                            <tr>
                                <th class="px-6 py-4">#</th>
                                <th class="px-6 py-4">Project Name</th>
                                <th class="px-6 py-4">Task Name</th>
                                <th class="px-6 py-4">Assigned_To</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Deadline</th>
                                <th class="px-6 py-4">Attachments</th>
                                <th class="px-6 py-4">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse ($tasks as $task)
                                @php
                                    $data = App\Models\User::where('id', $task->assigned_to)->select('name')->first();
                                    $user_name = $data->name;
                                @endphp
                                <tr class="hover:bg-gray-50 transition">

                                    <td class="px-6 py-4 font-semibold">
                                        {{ $loop->iteration }}
                                    </td>
                                    <!-- Project Name -->
                                     <td>
                                        {{ $task->project_id->name ?? 'No Project' }}
                                     </td>

                                    <td class="px-6 py-4">
                                        {{ $task->title }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $task->task_name }}
                                    </td>

                                    <!-- Priority -->
                                    <td class="px-6 py-4">
                                        {{ $user_name }}
                                    </td>

                                    <!-- Status -->
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded
                                {{ $task->status === 'completed'
                                    ? 'bg-green-600 text-white'
                                    : ($task->status === 'in_progress'
                                        ? 'bg-blue-600 text-white'
                                        : 'bg-gray-600 text-white') }}">
                                            {{ ucwords(str_replace('_', ' ', $task->status)) }}
                                        </span>
                                    </td>

                                    <!-- Deadline -->
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $task->deadline ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4">
                                        @php
                                            $files = is_array($task->attachments)
                                                ? $task->attachments
                                                : json_decode($task->attachments, true);
                                        @endphp

                                        @if (!empty($files))
                                            <div class="space-y-2">
                                                @foreach ($files as $file)
                                                    @php
                                                        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                                    @endphp

                                                    {{-- IMAGE --}}
                                                    @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                        <a href="{{ asset($file) }}" target="_blank">
                                                            <img src="{{ asset($file) }}"
                                                                class="w-20 h-20 object-cover rounded border hover:scale-105 transition"
                                                                alt="Attachment">
                                                        </a>
                                                    @elseif ($extension === 'pdf')
                                                        <a href="{{ asset($file) }}" target="_blank"
                                                            class="flex items-center gap-2 text-red-600 hover:underline">
                                                            📄 <span>View PDF</span>
                                                        </a>
                                                    @else
                                                        <a href="{{ asset($file) }}" target="_blank"
                                                            class="text-blue-600 hover:underline">
                                                            📎 Download File
                                                        </a>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-gray-400">No Files</span>
                                        @endif
                                    </td>


                                    <!-- Action -->
                                    <td class="px-6 py-4">
                                        <div class="flex gap-2">

                                            <a href="{{ route('task.edit', $task->id) }}"
                                                class="px-3 py-1 text-xs text-white bg-blue-600 rounded hover:bg-blue-700">
                                                Edit
                                            </a>

                                            {{-- <a href=""
                                                class="px-3 py-1 text-xs font-semibold text-white bg-pink-600 rounded hover:bg-pink-700">
                                                Report
                                            </a> --}}


                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-6 text-gray-500">
                                        No Tasks Found.
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


    @endif



@endsection
