@extends('admin.include.layout')

@section('heading', 'Tasks')
@section('title', 'Edit Task')

@section('content')

    @if (Auth::guard('admin')->user()->role === 'admin')
        <div class="mx-auto mt-10">
            <div class="bg-white shadow-xl rounded-xl p-8">

                <h2 class="text-2xl font-bold mb-6 text-gray-800">
                    Edit Task
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
                            text: '{{ session('success') }}',
                            timer: 2500,
                            showConfirmButton: false
                        });
                    </script>
                @endif

                {{-- FORM --}}
                <form action="{{ route('tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data"
                    class="bg-white p-6 rounded-xl shadow-lg space-y-5">

                    @csrf


                    {{-- Project + Task --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold mb-1">Project Name</label>
                            <input type="text" name="title" value="{{ old('title', $task->title) }}"
                                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-1">Task Name</label>
                            <input type="text" name="task_name" value="{{ old('task_name', $task->task_name) }}"
                                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-500">
                        </div>
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="block text-sm font-semibold mb-1">Description</label>
                        <textarea id="content-editor" name="description" rows="4"
                            class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-500">
           {{ old('description', $task->description) }}
                </textarea>
                    </div>
                    @php
                        $users = App\Models\User::where('role', '!=', 'admin')->get();
                    @endphp
                    {{-- Assigned + Status --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold mb-1">Assigned To</label>
                            <select name="assigned_to"
                                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-500">
                                <option value="">Select User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old('assigned_to', $task->assigned_to) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-1">Status</label>
                            <select name="status"
                                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-500">
                                <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In
                                    Progress
                                </option>
                                <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed
                                </option>
                            </select>
                        </div>
                    </div>

                    {{-- Priority + Deadline --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold mb-1">Priority</label>
                            <select name="priority"
                                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-500">
                                <option value="1" {{ $task->priority == 1 ? 'selected' : '' }}>Low</option>
                                <option value="2" {{ $task->priority == 2 ? 'selected' : '' }}>Medium</option>
                                <option value="3" {{ $task->priority == 3 ? 'selected' : '' }}>High</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-1">Deadline</label>
                            <input type="datetime-local" name="deadline"
                                value="{{ old('deadline', \Carbon\Carbon::parse($task->deadline)->format('Y-m-d\TH:i')) }}"
                                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-500">
                        </div>

                    </div>

                    {{-- Attachments --}}
                    <div>
                        <label class="block text-sm font-semibold mb-1">Attachments</label>
                        <input type="file" name="attachments[]" multiple class="w-full border rounded-lg px-4 py-2">
                        <p class="text-xs text-gray-500 mt-1">
                            Uploading new files will keep existing ones
                        </p>
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
                    </div>

                    {{-- Submit --}}
                    <div class="text-right">
                        <button type="submit"
                            class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-2 rounded-lg transition">
                            Update Task
                        </button>
                    </div>

                </form>
            </div>
        </div>
    @else
        <div class="mx-auto mt-10">
            <div class="bg-white shadow-xl rounded-xl p-8">

                <h2 class="text-2xl font-bold mb-6 text-gray-800">
                    Edit Task
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
                            text: '{{ session('success') }}',
                            timer: 2500,
                            showConfirmButton: false
                        });
                    </script>
                @endif
                @php
                    $user = Auth::guard('admin')->user();
                    $feedback = App\Models\Performances::where('employee_id',$user->id)->select('feedback')->first();

                @endphp
                {{-- FORM --}}
                <form action="{{ route('tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data"
                    class="bg-white p-6 rounded-xl shadow-lg space-y-5">

                    @csrf


                    {{-- Project + Task --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold mb-1">Project Name</label>
                            <input type="text" name="title" value="{{ old('title', $task->title) }}"
                                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-500" readonly>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-1">Task Name</label>
                            <input type="text" name="task_name" value="{{ old('task_name', $task->task_name) }}"
                                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-500" readonly>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="block text-sm font-semibold mb-1">Feedback</label>
                        <textarea id="content-editor" name="feedback" rows="4"
                            class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-500">
                      {{ old('feedback',$feedback->feedback ?? "") }}
                </textarea>
                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold mb-1">Assigned To</label>

                            <!-- Disabled Select for display -->
                            <select disabled class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-500">
                                <option value="{{ $user->id }}" selected>
                                    {{ $user->name }}
                                </option>
                            </select>

                            <!-- Hidden input to actually submit the value -->
                            <input type="hidden" name="assigned_to" value="{{ $user->id }}">
                        </div>



                        <div>
                            <label class="block text-sm font-semibold mb-1">Status</label>
                            <select name="status"
                                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-500">
                                <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In
                                    Progress
                                </option>
                                <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed
                                </option>
                            </select>
                        </div>
                    </div>

                    {{-- Priority + Deadline --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold mb-1">Priority</label>
                            <select name="priority" disabled
                                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-500">
                                <option value="1" {{ $task->priority == 1 ? 'selected' : '' }}>Low</option>
                                <option value="2" {{ $task->priority == 2 ? 'selected' : '' }}>Medium</option>
                                <option value="3" {{ $task->priority == 3 ? 'selected' : '' }}>High</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-1">Deadline</label>
                            <input type="datetime-local" name="deadline"
                                value="{{ old('deadline', \Carbon\Carbon::parse($task->deadline)->format('Y-m-d\TH:i')) }}"
                                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-500" readonly>
                        </div>

                    </div>

                    {{-- Attachments --}}
                    <div>
                        <label class="block text-sm font-semibold mb-1">Attachments</label>
                        <input type="file" id="myFile" name="attachments[]" multiple
                            class="w-full border rounded-lg px-4 py-2" readonly>
                        <p class="text-xs text-gray-500 mt-1">
                            Uploading new files will keep existing ones
                        </p>
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
                    </div>

                    {{-- Submit --}}
                    <div class="text-right">
                        <button type="submit"
                            class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-2 rounded-lg transition">
                            Update Task
                        </button>
                    </div>

                </form>
            </div>
        </div>
        <script>
            // Prevent file input change
            document.getElementById('myFile').addEventListener('click', function(e) {
                e.preventDefault();
                alert('File input is readonly, cannot change.');
            });
        </script>
    @endif

@endsection

{{-- Scripts --}}
@push('scripts')
    <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('content-editor', {
            removeButtons: 'Image,Video,Flash'
        });
    </script>
@endpush
