@extends('admin.include.layout')

@section('heading','Daily Work')
@section('title','Daily Work Dashboard')

@section('content')

<div class="max-w-7xl mx-auto mt-8">

    <!-- Add Work Form -->
    <div class="bg-white p-6 rounded-xl shadow mb-6">

        <h2 class="text-xl font-bold mb-4">Add Daily Work</h2>

        <form action="{{ route('daily.work.store') }}" method="POST">
            @csrf

            <!-- Project -->
            <select name="project_id" class="border p-2 w-full mb-3 rounded">
                <option value="">Select Project</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}">
                        {{ $project->name }}
                    </option>
                @endforeach
            </select>
                <!-- Module -->
                <select name="module_id" class="border p-2 w-full mb-3 rounded">
                    <option value="">Select Module</option>
                    @foreach($modules as $module)
                        <option value="{{ $module->id }}">
                            {{ $module->name }}  ({{ $module->project->name }})
                        </option>
                    @endforeach
            <!-- Date -->
            <input type="date" name="work_date"
                   class="border p-2 w-full mb-3 rounded">

            <!-- Work -->
            <textarea name="work_done"
                      placeholder="What you worked on..."
                      class="border p-2 w-full mb-3 rounded"></textarea>

            <!-- Progress -->
            <input type="number" name="progress"
                   placeholder="Progress %"
                   min="0" max="100"
                   class="border p-2 w-full mb-3 rounded">

            <!-- Submit -->
            <button class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded">
                Submit
            </button>
        </form>
    </div>

    <!-- Work Logs -->
    <div class="bg-white p-6 rounded-xl shadow">

        <h2 class="text-xl font-bold mb-4">Work History</h2>

        @forelse($logs as $log)
        <div class="border p-4 rounded mb-3 hover:shadow transition">

            <!-- Header -->
            <div class="flex justify-between items-center">

                <div>
                    <p class="font-semibold text-gray-800">
                        {{ $log->user->name }}
                    </p>

                    <p class="text-sm text-gray-500">
                        {{ $log->project->name }} | {{ $log->work_date }}
                    </p>
                </div>

                <!--  Edit Button -->
                @if(Auth::guard('admin')->id() == $log->user_id 
                    || Auth::guard('admin')->user()->role === 'admin')

                    <a href="{{ route('daily.work.edit', $log->id) }}"
                       class="text-blue-600 text-sm underline hover:text-blue-800">
                        Edit
                    </a>
                @endif
            </div>

            <!-- Work Description -->
            <p class="mt-3 text-gray-700">
                {{ $log->work_done }}
            </p>

            <!-- Progress -->
            <div class="mt-3">

                @php
                    $progress = $log->progress ?? 0;
                @endphp

                <!-- Bar -->
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="h-2 rounded-full transition-all duration-500
                        {{ $progress == 100
                            ? 'bg-green-500'
                            : ($progress >= 50
                                ? 'bg-blue-500'
                                : 'bg-yellow-500') }}"
                        style="width: {{ $progress }}%">
                    </div>
                </div>

                <!-- Text -->
                <p class="text-xs text-gray-600 mt-1">
                    {{ $progress }}%
                </p>
            </div>

        </div>
        @empty
            <p class="text-gray-400 text-center">No work logs found</p>
        @endforelse

    </div>

</div>

@endsection