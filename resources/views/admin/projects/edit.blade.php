@extends('admin.include.layout')

@section('heading', 'Edit Project')
@section('title', 'Edit Project')

@section('content')

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: `{!! implode('<br>', $errors->all()) !!}`,
        });
    });
</script>
@endif

<div class="max-w-4xl mx-auto mt-10">

    <div class="bg-white shadow-2xl rounded-2xl p-8 border">

        <!-- Heading -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Edit Project</h2>
            <p class="text-sm text-gray-500">Update project details</p>
        </div>

        <form action="{{ route('project.update', $project->id) }}" method="POST">
            @csrf
          
            <!-- Project Name -->
            <div class="mb-5">
                <label class="block mb-2 font-medium text-gray-700">Project Name</label>
                <input type="text" name="name" value="{{ $project->name }}"
                    class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-orange-500 outline-none">
            </div>

            <!-- Description -->
            <div class="mb-5">
                <label class="block mb-2 font-medium text-gray-700">Description</label>
                <textarea name="description" rows="4"
                    class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-orange-500 outline-none">{{ $project->description }}</textarea>
            </div>

            <!-- Dates -->
            <div class="grid md:grid-cols-2 gap-5 mb-5">
                <div>
                    <label class="block mb-2 font-medium text-gray-700">Start Date</label>
                    <input type="date" name="start_date" value="{{ $project->start_date }}"
                        class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-orange-500 outline-none">
                </div>

                <div>
                    <label class="block mb-2 font-medium text-gray-700">End Date</label>
                    <input type="date" name="end_date" value="{{ $project->end_date }}"
                        class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-orange-500 outline-none">
                </div>
            </div>

            <!-- Status -->
            <div class="mb-6">
                <label class="block mb-2 font-medium text-gray-700">Status</label>
                <select name="status"
                    class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-orange-500 outline-none">

                    <option value="pending" {{ $project->status == 'pending' ? 'selected' : '' }}>Pending</option>

                    <option value="ongoing" {{ $project->status == 'ongoing' ? 'selected' : '' }}>Ongoing</option>

                    <option value="completed" {{ $project->status == 'completed' ? 'selected' : '' }}>Completed</option>

                </select>
            </div>

            <!-- Buttons -->
            <div class="flex justify-between items-center mt-8">

                <a href="{{ route('project.list') }}"
                    class="text-gray-600 hover:underline">
                    ← Back
                </a>

                <button type="submit"
                    class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-3 rounded-xl font-semibold shadow">
                    Update Project
                </button>

            </div>

        </form>
    </div>

</div>
@endsection
