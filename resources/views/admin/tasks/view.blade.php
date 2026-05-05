@extends('admin.include.layout')

@section('heading', 'Task Details')
@section('title', 'View Task')

@section('content')

<div class="max-w-5xl mx-auto mt-10">

    <div class="bg-white shadow-xl rounded-xl p-8">

        <!-- Title -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                {{ $task->task_name }}
            </h2>
            <p class="text-gray-500 text-sm mt-1">
                {{ $task->project->name ?? 'No Project Assigned' }}
            </p>
        </div>

        <!-- Info Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

            <!-- Assigned To -->
            <div>
                <label class="text-sm text-gray-500">Assigned To</label>
                <p class="font-semibold text-gray-800">
                    {{ $task->user->name ?? 'N/A' }}
                </p>
            </div>

            <!-- Status -->
            <div>
                <label class="text-sm text-gray-500">Status</label>
                <p>
                    <span class="px-3 py-1 text-xs font-semibold rounded
                        {{ $task->status === 'completed'
                            ? 'bg-green-600 text-white'
                            : ($task->status === 'in_progress'
                                ? 'bg-blue-600 text-white'
                                : 'bg-gray-600 text-white') }}">
                        {{ ucwords(str_replace('_', ' ', $task->status)) }}
                    </span>
                </p>
            </div>

            <!-- Priority -->
            <div>
                <label class="text-sm text-gray-500">Priority</label>
                <p class="font-semibold text-gray-800">
                    {{ ucfirst($task->priority) }}
                </p>
            </div>

            <!-- Deadline -->
            <div>
                <label class="text-sm text-gray-500">Deadline</label>
                <p class="font-semibold text-gray-800">
                    {{ $task->deadline ?? 'No Deadline' }}
                </p>
            </div>

        </div>

        <!-- Description -->
        <div class="mb-6">
            <label class="text-sm text-gray-500">Description</label>
            <div class="mt-2 p-4 border rounded-lg bg-gray-50">
                {!! $task->description !!}
            </div>
        </div>

        <!-- Attachments -->
        <div class="mb-6">
            <label class="text-sm text-gray-500">Attachments</label>

            @php
                $files = is_array($task->attachments)
                    ? $task->attachments
                    : json_decode($task->attachments, true);
            @endphp

            @if (!empty($files))
                <div class="flex flex-wrap gap-4 mt-3">
                    @foreach ($files as $file)
                        @php
                            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                        @endphp

                        <!-- Image -->
                        @if (in_array($ext, ['jpg','jpeg','png','webp']))
                            <a href="{{ asset($file) }}" target="_blank">
                                <img src="{{ asset($file) }}"
                                     class="w-32 h-32 object-cover rounded-lg border hover:scale-105 transition">
                            </a>

                        <!-- PDF -->
                        @elseif ($ext === 'pdf')
                            <a href="{{ asset($file) }}" target="_blank"
                               class="bg-red-100 text-red-600 px-4 py-2 rounded-lg text-sm hover:bg-red-200">
                                📄 View PDF
                            </a>

                        <!-- Other -->
                        @else
                            <a href="{{ asset($file) }}" target="_blank"
                               class="bg-blue-100 text-blue-600 px-4 py-2 rounded-lg text-sm hover:bg-blue-200">
                                📎 Download File
                            </a>
                        @endif
                    @endforeach
                </div>
            @else
                <p class="text-gray-400 mt-2">No attachments available</p>
            @endif
        </div>
         <!--  ADD UPDATE FORM -->
        <hr class="my-6">

        <h3 class="text-lg font-bold mb-3">Add Work Update</h3>

        <form action="{{ route('task.update.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="task_id" value="{{ $task->id }}">

            <textarea name="description" placeholder="What work you did..."
                class="w-full border p-3 rounded-lg mb-3"></textarea>

            <input type="file" name="files[]" multiple class="mb-3">

            <!--  IMPORTANT -->
            <input type="number" name="progress" min="0" max="100"
                placeholder="Progress %" class="w-full border p-2 rounded-lg mb-3">

            <button class="bg-orange-600 text-white px-4 py-2 rounded">
                Submit Update
            </button>
        </form>

        <!--  SHOW UPDATES -->
        <h3 class="mt-6 font-bold">Work Updates</h3>
         @forelse($task->updates as $update)
        <div class="border p-4 rounded-lg mb-3 mt-3">

            <p class="font-semibold">{{ $update->user->name }}</p>

            <p>{{ $update->description }}</p>

            <p class="text-sm text-gray-500">
                Progress: {{ $update->progress ?? 0 }}%
            </p>

            @php
                $files = json_decode($update->files, true);
            @endphp

            @if($files)
                <div class="flex gap-2 mt-2">
                    @foreach($files as $file)
                        <img src="{{ asset($file) }}"
                             class="w-20 h-20 rounded border">
                    @endforeach
                </div>
            @endif

        </div>
        @empty
            <p class="text-gray-400 mt-3">No updates yet</p>
             @endforelse















    <!-- Buttons -->
        <div class="flex justify-between mt-8">

            <a href="{{ url()->previous() }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">
                ← Back
            </a>

            <a href="{{ route('task.edit', $task->id) }}"
               class="bg-orange-600 hover:bg-orange-700 text-white px-5 py-2 rounded-lg">
                Edit Task
            </a>

        </div>

    </div>
</div>

@endsection