@extends('admin.include.layout')
@section('heading', 'Tasks')
@section('title', 'Add Tasks ')

@section('content')
    <div class=" mx-auto mt-10">

        <div class="bg-white shadow-xl rounded-xl p-8">

            <h2 class="text-2xl font-bold mb-6 text-gray-800">Add Tasks

            </h2>

            {{-- SweetAlert --}}
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
                        text: "{ session('success') }}",
                        timer: 2500,
                        showConfirmButton: false
                    });
                </script>
            @endif

            {{-- Form --}}
            <form action="{{ route('add.task') }}" method="POST" enctype="multipart/form-data"
                class="bg-white p-6 rounded-xl shadow-lg space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-semibold mb-1">Project Name</label>
                    <input type="text" name="title"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-500">

                </div>


                <div>
                    <label class="block text-sm font-semibold mb-1">Task Name</label>
                    <input type="text" name="task_name"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-500">
                </div>
                <div class="mb-4">
    <label>Select Project</label>

    <select name="project_id" class="w-full border p-2">
        <option value="">Select Project</option>

        @foreach($projects as $project)
            <option value="{{ $project->id }}">
                {{ $project->name }}
            </option>
        @endforeach
    </select>
</div>









                <div>
                    <label class="block text-sm font-semibold mb-1">Description</label>
                    <textarea id="content-editor" name="description" rows="4"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-500"></textarea>
                </div>


                <div>
                    <label class="block text-sm font-semibold mb-1">Assigned To</label>
                    <select name="assigned_to"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-500">
                        @php
                            $user = App\Models\User::where('role', '!=', 'admin')->get();
                        @endphp
                        <option value="">Select User</option>
                        @foreach ($user as $us)
                            <option value="{{ $us->id }}">{{ $us->name }}</option>
                        @endforeach
                    </select>
                </div>


                <div>
                    <label class="block text-sm font-semibold mb-1">Attachments</label>
                    <input type="file" name="attachments[]" class="w-full border rounded-lg px-4 py-2" multiple>
                    <p class="text-xs text-gray-500 mt-1">You can upload multiple files</p>
                </div>


                <div>
                    <label class="block text-sm font-semibold mb-1">Status</label>
                    <select name="status" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-500">
                        <option value="pending">Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>


                <div>
                    <label class="block text-sm font-semibold mb-1">Priority</label>
                    <select name="priority" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-500">
                        <option value="1">Low</option>
                        <option value="2" selected>Medium</option>
                        <option value="3">High</option>
                    </select>
                </div>


                <div>
                    <label class="block text-sm font-semibold mb-1">Deadline</label>
                    <input type="datetime-local" name="deadline"
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-500">
                </div>



                <div class="text-right">
                    <button type="submit"
                        class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-2 rounded-lg transition">
                        Save Task
                    </button>
                </div>
            </form>

        </div>
    </div>
    <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('content-editor', {
            removeButtons: 'Image,Video,Flash' // optional
        });
    </script>
@endsection
