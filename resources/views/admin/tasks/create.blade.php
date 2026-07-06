
@extends('admin.include.layout')
@section('heading', 'Tasks')
@section('title', 'Add Tasks')

@section('content')
    {{-- Font Awesome 6 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <div class="min-h-screen bg-gradient-to-br from-slate-100 to-gray-200 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">

            {{-- Header Card --}}
            <div class="relative bg-white rounded-2xl shadow-2xl overflow-hidden mb-8 transform transition duration-500 hover:scale-[1.01]">
                <div class="absolute top-0 right-0 w-40 h-40 bg-orange-100 rounded-full -mr-16 -mt-16 opacity-70"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-blue-100 rounded-full -ml-12 -mb-12 opacity-60"></div>
                <div class="relative p-6 md:p-8">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div>
                            <div class="flex items-center gap-3">
                                <div class="p-3 bg-orange-100 rounded-xl">
                                    <i class="fas fa-tasks text-2xl text-orange-600"></i>
                                </div>
                                <div>
                                    <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">Add New Task</h1>
                                    <p class="text-gray-500 mt-1">Create and assign tasks to team members</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <div class="bg-gray-100 rounded-full px-4 py-2 text-sm text-gray-600">
                                <i class="fas fa-chart-line mr-2"></i> Total Tasks: {{ \App\Models\Tasks::count() ?? '0' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SweetAlert --}}
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            @if ($errors->any())
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: `{!! implode('<br>', $errors->all()) !!}`,
                        confirmButtonColor: '#ea580c',
                    });
                </script>
            @endif

            @if (session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Task Created!',
                        text: "{{ session('success') }}",
                        timer: 2500,
                        showConfirmButton: false,
                    });
                </script>
            @endif

            {{-- Main Form --}}
            <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-white/30">
                <form action="{{ route('add.task') }}" method="POST" enctype="multipart/form-data" id="taskForm">
                    @csrf
                    <div class="p-6 md:p-8 space-y-6">

                        {{-- Row 1: Project Name & Task Name --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Project Name --}}
                            <div class="relative group">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    <i class="fas fa-folder-open mr-2 text-orange-500"></i>Project Name
                                </label>
                                <div class="relative">
                                    <input type="text" name="title" value="{{ old('title') }}"
                                        class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition"
                                        placeholder="E-commerce Website">
                                    <i class="fas fa-folder-open absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                                @error('title')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Task Name --}}
                            <div class="relative group">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    <i class="fas fa-check-circle mr-2 text-orange-500"></i>Task Name
                                </label>
                                <div class="relative">
                                    <input type="text" name="task_name" value="{{ old('task_name') }}"
                                        class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition"
                                        placeholder="Design Homepage">
                                    <i class="fas fa-tag absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                                @error('task_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Row 2: Select Project & Assign To --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Select Project Dropdown --}}
                            <div class="relative group">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    <i class="fas fa-database mr-2 text-orange-500"></i>Select Project
                                </label>
                                <div class="relative">
                                    <select name="project_id" id="getmodules"
                                        class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 appearance-none bg-white">
                                        <option value="">-- Select Project --</option>
                                        @foreach ($projects as $project)
                                            <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                                {{ $project->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <i class="fas fa-project-diagram absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                                @error('project_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Assigned To --}}
                            <div class="relative group">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    <i class="fas fa-user-check mr-2 text-orange-500"></i>Assign To
                                </label>
                                <div class="relative">
                                    <select name="assigned_to"
                                        class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 appearance-none bg-white">
                                        <option value="">-- Select User --</option>
                                        @php
                                            $users = App\Models\User::with('role')->where('role', '!=', 'super_admin')->get();
                                        @endphp
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} @if($user->role) ({{ $user->role }}) @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    <i class="fas fa-users absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                                @error('assigned_to')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Dynamic Modules Section (Hidden until project selected) --}}
                        <div id="moduls_items_container" class="hidden">
                            <div class="bg-orange-50 rounded-xl p-5 border border-orange-100">
                                <label class="block text-sm font-semibold text-gray-700 mb-3">
                                    <i class="fas fa-cubes mr-2 text-orange-500"></i>Select Modules
                                </label>
                                <div id="moduls_items" class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                    {{-- Dynamic checkboxes will appear here --}}
                                </div>
                            </div>
                        </div>

                        {{-- Description (CKEditor) --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                <i class="fas fa-align-left mr-2 text-orange-500"></i>Description
                            </label>
                            <textarea id="content-editor" name="description" rows="5"
                                class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-orange-500">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Row 3: Attachments & Status --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Attachments --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    <i class="fas fa-paperclip mr-2 text-orange-500"></i>Attachments
                                </label>
                                <div class="relative">
                                    <input type="file" name="attachments[]" id="fileInput" multiple
                                        class="w-full py-2 px-3 border border-gray-300 rounded-xl shadow-sm text-sm file:mr-4 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 transition">
                                </div>
                                <div id="filePreview" class="mt-2 flex flex-wrap gap-2"></div>
                                <p class="text-xs text-gray-400 mt-1"><i class="fas fa-info-circle"></i> You can upload multiple files (PDF, DOC, Images)</p>
                                @error('attachments.*')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Status --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    <i class="fas fa-chart-simple mr-2 text-orange-500"></i>Status
                                </label>
                                <select name="status"
                                    class="w-full py-3 px-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 bg-white">
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>🟡 Pending</option>
                                    <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>🔵 In Progress</option>
                                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>🟢 Completed</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Row 4: Priority & Deadline --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Priority with colored badges --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    <i class="fas fa-flag mr-2 text-orange-500"></i>Priority
                                </label>
                                <div class="flex gap-4 flex-wrap">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="priority" value="1" {{ old('priority') == '1' ? 'checked' : '' }} class="w-4 h-4 text-orange-500">
                                        <span class="flex items-center gap-1"><i class="fas fa-arrow-down text-green-500"></i> Low</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="priority" value="2" {{ old('priority') == '2' ? 'checked' : '' }} class="w-4 h-4 text-orange-500" checked>
                                        <span class="flex items-center gap-1"><i class="fas fa-minus text-orange-500"></i> Medium</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="priority" value="3" {{ old('priority') == '3' ? 'checked' : '' }} class="w-4 h-4 text-orange-500">
                                        <span class="flex items-center gap-1"><i class="fas fa-arrow-up text-red-500"></i> High</span>
                                    </label>
                                </div>
                                @error('priority')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Deadline --}}
                            <div class="relative group">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    <i class="fas fa-calendar-alt mr-2 text-orange-500"></i>Deadline
                                </label>
                                <div class="relative">
                                    <input type="datetime-local" name="deadline" value="{{ old('deadline') }}"
                                        class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 transition">
                                    <i class="fas fa-clock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                                @error('deadline')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Info Note --}}
                        <div class="bg-orange-50/50 rounded-xl p-4 border border-orange-100">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-lightbulb text-orange-500 mt-0.5"></i>
                                <div class="text-sm text-gray-600">
                                    <span class="font-semibold">Pro Tip:</span> Assign modules after selecting a project. All fields marked are required for task creation.
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Form Actions --}}
                    <div class="bg-gray-50/80 px-6 md:px-8 py-5 flex flex-col sm:flex-row justify-end gap-3 border-t border-gray-200">
                        <button type="reset"
                            class="px-6 py-2.5 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-100 transition flex items-center justify-center gap-2">
                            <i class="fas fa-eraser"></i> Clear
                        </button>
                        <button type="submit"
                            class="px-8 py-2.5 bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-700 hover:to-orange-600 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i> Create Task
                        </button>
                    </div>
                </form>
            </div>

            <div class="text-center text-gray-400 text-sm mt-8">
                <i class="fas fa-clock mr-1"></i> Tasks are tracked in real-time
            </div>
        </div>
    </div>

    {{-- CKEditor & jQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>

    <script>
        // Initialize CKEditor
        CKEDITOR.replace('content-editor', {
            removeButtons: 'Image,Video,Flash',
            height: 200,
            toolbar: [
                { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat'] },
                { name: 'paragraph', items: ['NumberedList', 'BulletedList', 'Blockquote'] },
                { name: 'links', items: ['Link', 'Unlink'] },
                { name: 'insert', items: ['Table', 'HorizontalRule'] },
                { name: 'styles', items: ['Format', 'FontSize'] }
            ]
        });

        // Dynamic modules based on project selection
        $(document).ready(function() {
            $("#getmodules").on('change', function() {
                var id = $(this).val();

                if (!id) {
                    $("#moduls_items_container").addClass('hidden');
                    return;
                }

                $.ajax({
                    url: "{{ route('get.module') }}",
                    type: "GET",
                    data: { id: id },
                    success: function(res) {
                        let html = '';
                        let modules = res.data?.[0]?.modules || [];

                        if (modules.length === 0) {
                            html = '<p class="text-gray-500 col-span-full text-center py-4"><i class="fas fa-folder-open"></i> No modules found for this project</p>';
                        } else {
                            modules.forEach(function(item, index) {
                                html += `
                                    <label class="flex items-center gap-3 p-3 bg-white rounded-lg border border-gray-200 cursor-pointer hover:border-orange-300 transition">
                                        <input type="checkbox" name="modules[]" value="${item}" class="w-4 h-4 text-orange-500 rounded">
                                        <span class="text-gray-700">${item}</span>
                                    </label>
                                `;
                            });
                        }

                        $("#moduls_items").html(html);
                        $("#moduls_items_container").removeClass('hidden');
                    },
                    error: function(error) {
                        console.error(error);
                        $("#moduls_items_container").addClass('hidden');
                    }
                });
            });

            // File preview for attachments
            $('#fileInput').on('change', function(e) {
                $('#filePreview').empty();
                const files = e.target.files;

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const fileSize = (file.size / 1024).toFixed(1);
                    let icon = 'fa-file';

                    if (file.type.includes('image')) icon = 'fa-file-image';
                    else if (file.type.includes('pdf')) icon = 'fa-file-pdf';
                    else if (file.type.includes('word')) icon = 'fa-file-word';
                    else if (file.type.includes('excel')) icon = 'fa-file-excel';

                    $('#filePreview').append(`
                        <div class="inline-flex items-center gap-2 bg-gray-100 rounded-full px-3 py-1 text-sm">
                            <i class="fas ${icon} text-orange-500"></i>
                            <span>${file.name}</span>
                            <span class="text-xs text-gray-400">(${fileSize} KB)</span>
                        </div>
                    `);
                }
            });
        });
    </script>

    <style>
        input:focus, select:focus, textarea:focus {
            outline: none;
        }
        input[type="file"]::file-selector-button {
            transition: background 0.2s;
            cursor: pointer;
        }
        .radio-group label {
            transition: all 0.2s;
        }
    </style>
@endsection
