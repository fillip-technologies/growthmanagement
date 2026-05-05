@extends('admin.include.layout')

@section('heading', 'Edit Project')
@section('title', 'Edit Project')

@section('content')

<div class="max-w-4xl mx-auto mt-10">

    <div class="bg-white shadow-xl rounded-xl p-8">

        <h2 class="text-2xl font-bold mb-6">Edit Project</h2>

        <form action="{{ route('projects.update', $project->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Project Name -->
            <div class="mb-4">
                <label class="block mb-1">Project Name</label>
                <input type="text" name="name"
                       value="{{ $project->name }}"
                       class="w-full border p-2 rounded">
            </div>

            <!-- Assign Employee -->
            <div class="mb-4">
                <label class="block mb-1">Assign To</label>

                <select name="employee_id" class="w-full border p-2 rounded">
                    <option value="">Select Employee</option>

                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}"
                            {{ $project->employee_id == $emp->id ? 'selected' : '' }}>
                            {{ $emp->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label class="block mb-1">Description</label>
                <textarea name="description"
                          class="w-full border p-2 rounded">{{ $project->description }}</textarea>
            </div>

            <!-- Dates -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label>Start Date</label>
                    <input type="date" name="start_date"
                           value="{{ $project->start_date }}"
                           class="w-full border p-2 rounded">
                </div>

                <div>
                    <label>End Date</label>
                    <input type="date" name="end_date"
                           value="{{ $project->end_date }}"
                           class="w-full border p-2 rounded">
                </div>
            </div>

            <!-- Button -->
            <div class="mt-6 text-right">
                <button class="bg-orange-600 text-white px-6 py-2 rounded">
                    Update Project
                </button>
            </div>

        </form>

    </div>
    <hr class="my-6">

<div class="bg-gray-50 p-6 rounded-xl">

    <h2 class="text-lg font-bold mb-4">Add Module</h2>

    <form action="{{ route('module.store') }}" method="POST">
        @csrf

        <!-- Project ID -->
        <input type="hidden" name="project_id" value="{{ $project->id }}">

        <!-- Module Name -->
        <input type="text" name="name"
               placeholder="Module Name"
               class="w-full border p-2 mb-3 rounded">

        <!-- Assign Employee -->
        <select name="assigned_to" class="w-full border p-2 mb-3 rounded">
            <option value="">Assign Employee</option>
            @foreach($employees as $emp)
                <option value="{{ $emp->id }}">{{ $emp->name }}</option>
            @endforeach
        </select>

        <button class="bg-green-600 text-white px-4 py-2 rounded">
            Add Module
        </button>
    </form>

</div>
<div class="bg-white p-6 rounded-xl mt-4">

    <h2 class="text-lg font-bold mb-4">Modules</h2>

    @forelse($project->modules as $module)
        <div class="border p-3 rounded mb-2 flex justify-between">

            <div>
                <p class="font-semibold">{{ $module->name }}</p>
                <p class="text-sm text-gray-500">
                    Assigned: {{ $module->user->name ?? 'N/A' }}
                </p>
            </div>

            <span class="bg-blue-500 text-white px-2 py-1 rounded text-sm">
                {{ $module->progress ?? 0 }}%
            </span>

        </div>
    @empty
        <p class="text-gray-400">No modules added</p>
    @endforelse

</div>

</div>

@endsection