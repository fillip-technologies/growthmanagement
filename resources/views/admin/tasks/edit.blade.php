@extends('admin.include.layout')
@section('heading', 'Tasks')
@section('title', 'Edit Task')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @php
        $isAdmin = Auth::guard('admin')->user()->role === 'admin';
        $currentUser = Auth::guard('admin')->user();
        $feedbackRecord = App\Models\Performances::where('employee_id', $currentUser->id)
            ->where('task_id', $task->id)
            ->first();
        $existingFeedback = $feedbackRecord->feedback ?? '';
        $files = is_array($task->attachments) ? $task->attachments : json_decode($task->attachments, true);
        $themeColor = $isAdmin ? 'orange' : 'emerald';
        $gradientFrom = $isAdmin ? 'from-orange-500' : 'from-emerald-500';
        $gradientTo = $isAdmin ? 'to-orange-600' : 'to-emerald-600';
        $bgLight = $isAdmin ? 'bg-orange-50' : 'bg-emerald-50';
        $textAccent = $isAdmin ? 'text-orange-600' : 'text-emerald-600';
        $ringColor = $isAdmin ? 'focus:ring-orange-500' : 'focus:ring-emerald-500';
        $borderAccent = $isAdmin ? 'border-orange-200' : 'border-emerald-200';
    @endphp

    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes pulse-glow {

            0%,
            100% {
                opacity: 0.6;
            }

            50% {
                opacity: 1;
            }
        }

        .animate-float {
            animation: float 4s ease-in-out infinite;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .attachment-card:hover {
            transform: translateY(-3px);
            transition: all 0.3s ease;
        }

        .gradient-border {
            position: relative;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>

    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-100 to-slate-200 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">

            {{-- Floating Background Elements --}}
            <div class="fixed inset-0 overflow-hidden pointer-events-none">
                <div
                    class="absolute top-20 left-10 w-72 h-72 bg-{{ $isAdmin ? 'orange' : 'emerald' }}-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float">
                </div>
                <div class="absolute bottom-20 right-10 w-96 h-96 bg-{{ $isAdmin ? 'blue' : 'teal' }}-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float"
                    style="animation-delay: 2s;"></div>
            </div>

            {{-- Header Section --}}
            <div class="relative mb-8">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br {{ $gradientFrom }} {{ $gradientTo }} opacity-10 rounded-full transform translate-x-32 -translate-y-32">
                    </div>
                    <div class="relative px-6 py-6 md:px-8 md:py-8">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-16 h-16 bg-gradient-to-br {{ $gradientFrom }} {{ $gradientTo }} rounded-2xl flex items-center justify-center shadow-lg transform rotate-3 hover:rotate-6 transition">
                                    <i class="fas {{ $isAdmin ? 'fa-edit' : 'fa-comment-dots' }} text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h1 class="text-3xl md:text-4xl font-black text-gray-800 tracking-tight">
                                        {{ $isAdmin ? 'Edit Task' : 'Task Feedback' }}
                                    </h1>
                                    <p class="text-gray-500 mt-1 flex items-center gap-2">
                                        <i
                                            class="fas {{ $isAdmin ? 'fa-shield-alt' : 'fa-user-check' }} {{ $textAccent }}"></i>
                                        {{ $isAdmin ? 'Administrator access — full control' : 'Update progress and submit feedback' }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="px-4 py-2 {{ $bgLight }} rounded-full">
                                    <i class="fas fa-tasks {{ $textAccent }} mr-2"></i>
                                    <span class="text-sm font-semibold {{ $textAccent }}">Task ID:
                                        #{{ $task->id }}</span>
                                </div>
                                <a href=""
                                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-full transition flex items-center gap-2 text-gray-700">
                                    <i class="fas fa-arrow-left"></i>
                                    <span class="hidden sm:inline">Back to Tasks</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Error/Success Alerts --}}
            @if ($errors->any())
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: `{!! implode('<br>', $errors->all()) !!}`,
                        confirmButtonColor: '{{ $isAdmin ? '#ea580c' : '#10b981' }}',
                        background: '#fff',
                        customClass: {
                            popup: 'rounded-2xl'
                        }
                    });
                </script>
            @endif

            @if (session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: '{{ $isAdmin ? 'Task Updated!' : 'Feedback Submitted!' }}',
                        text: "{{ session('success') }}",
                        timer: 2500,
                        showConfirmButton: false,
                        background: '#fff',
                        customClass: {
                            popup: 'rounded-2xl'
                        }
                    });
                </script>
            @endif

            {{-- Main Form --}}
            <form action="{{ route('tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data"
                id="taskForm">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    {{-- Main Content Column --}}
                    <div class="lg:col-span-2 space-y-6">

                        {{-- Basic Information Card --}}
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                            <div class="px-6 py-4 {{ $bgLight }} border-b {{ $borderAccent }}">
                                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-info-circle {{ $textAccent }}"></i>
                                    Basic Information
                                </h3>
                            </div>
                            <div class="p-6 space-y-5">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-folder-open {{ $textAccent }} mr-2"></i>Project Name
                                        </label>
                                        <div class="relative">
                                            <input type="text" name="title" value="{{ old('title', $task->title) }}"
                                                class="w-full pl-4 pr-4 py-3 border-2 border-gray-200 rounded-xl {{ $ringColor }} focus:border-transparent transition shadow-sm"
                                                {{ !$isAdmin ? 'readonly' : '' }}
                                                style="{{ !$isAdmin ? 'background-color:#f9fafb;cursor:not-allowed;' : '' }}">
                                            @if (!$isAdmin)
                                                <div
                                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                                    <i class="fas fa-lock"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-tasks {{ $textAccent }} mr-2"></i>Task Name
                                        </label>
                                        <div class="relative">
                                            <input type="text" name="task_name"
                                                value="{{ old('task_name', $task->task_name) }}"
                                                class="w-full pl-4 pr-4 py-3 border-2 border-gray-200 rounded-xl {{ $ringColor }} focus:border-transparent transition shadow-sm"
                                                {{ !$isAdmin ? 'readonly' : '' }}
                                                style="{{ !$isAdmin ? 'background-color:#f9fafb;cursor:not-allowed;' : '' }}">
                                            @if (!$isAdmin)
                                                <div
                                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                                    <i class="fas fa-lock"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @if ($isAdmin)
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-align-left {{ $textAccent }} mr-2"></i>Description
                                        </label>
                                        <textarea id="editor-description" name="description" rows="6"
                                            class="w-full border-2 border-gray-200 rounded-xl px-4 py-2 {{ $ringColor }} focus:border-transparent transition">{!! old('description', $task->description) !!}</textarea>
                                    </div>
                                @else
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-comment-dots {{ $textAccent }} mr-2"></i>Your Feedback
                                        </label>
                                        <textarea id="editor-feedback" name="feedback" rows="8"
                                            class="w-full border-2 border-gray-200 rounded-xl px-4 py-2 {{ $ringColor }} focus:border-transparent transition"
                                            placeholder="Share your progress, challenges, and notes...">{!! old('feedback', $existingFeedback) !!}</textarea>
                                        <p class="text-xs text-gray-400 mt-2 flex items-center gap-1">
                                            <i class="fas fa-lightbulb text-yellow-500"></i>
                                            Provide detailed feedback about your work on this task
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Assignment & Status Card --}}
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                            <div class="px-6 py-4 {{ $bgLight }} border-b {{ $borderAccent }}">
                                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-cog {{ $textAccent }}"></i>
                                    Assignment & Progress
                                </h3>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-user-check {{ $textAccent }} mr-2"></i>Assigned To
                                        </label>
                                        @if ($isAdmin)
                                            <div class="relative">
                                                <select name="assigned_to"
                                                    class="w-full pl-4 pr-10 py-3 border-2 border-gray-200 rounded-xl {{ $ringColor }} focus:border-transparent appearance-none bg-white shadow-sm">
                                                    <option value="">-- Select Team Member --</option>
                                                    @php $teamMembers = App\Models\User::where('role', '!=', 'admin')->get(); @endphp
                                                    @foreach ($teamMembers as $member)
                                                        <option value="{{ $member->id }}"
                                                            {{ old('assigned_to', $task->assigned_to) == $member->id ? 'selected' : '' }}>
                                                            <i class="fas fa-user"></i> {{ $member->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <i
                                                    class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                            </div>
                                        @else
                                            <div class="relative">
                                                <select disabled
                                                    class="w-full pl-4 pr-10 py-3 border-2 border-gray-200 rounded-xl bg-gray-50 text-gray-600 cursor-not-allowed">
                                                    <option>{{ $currentUser->name }}</option>
                                                </select>
                                                <input type="hidden" name="assigned_to" value="{{ $currentUser->id }}">
                                                <i
                                                    class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                            </div>
                                        @endif
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-chart-line {{ $textAccent }} mr-2"></i>Status
                                        </label>
                                        <select name="status"
                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl {{ $ringColor }} focus:border-transparent bg-white shadow-sm">
                                            <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>🟡
                                                Pending</option>
                                            <option value="in_progress"
                                                {{ $task->status == 'in_progress' ? 'selected' : '' }}>🔵 In Progress
                                            </option>
                                            <option value="completed"
                                                {{ $task->status == 'completed' ? 'selected' : '' }}>🟢 Completed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Priority & Deadline Card --}}
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                            <div class="px-6 py-4 {{ $bgLight }} border-b {{ $borderAccent }}">
                                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-calendar-alt {{ $textAccent }}"></i>
                                    Timeline & Priority
                                </h3>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-flag {{ $textAccent }} mr-2"></i>Priority Level
                                        </label>
                                        @if ($isAdmin)
                                            <div class="flex gap-4 flex-wrap">
                                                <label
                                                    class="flex items-center gap-2 cursor-pointer px-4 py-2 rounded-xl border-2 border-gray-200 hover:border-{{ $themeColor }}-300 transition">
                                                    <input type="radio" name="priority" value="1"
                                                        {{ $task->priority == 1 ? 'checked' : '' }}
                                                        class="w-4 h-4 text-green-500">
                                                    <span><i class="fas fa-arrow-down text-green-500"></i> Low</span>
                                                </label>
                                                <label
                                                    class="flex items-center gap-2 cursor-pointer px-4 py-2 rounded-xl border-2 border-gray-200 hover:border-{{ $themeColor }}-300 transition">
                                                    <input type="radio" name="priority" value="2"
                                                        {{ $task->priority == 2 ? 'checked' : '' }}
                                                        class="w-4 h-4 text-orange-500">
                                                    <span><i class="fas fa-minus text-orange-500"></i> Medium</span>
                                                </label>
                                                <label
                                                    class="flex items-center gap-2 cursor-pointer px-4 py-2 rounded-xl border-2 border-gray-200 hover:border-{{ $themeColor }}-300 transition">
                                                    <input type="radio" name="priority" value="3"
                                                        {{ $task->priority == 3 ? 'checked' : '' }}
                                                        class="w-4 h-4 text-red-500">
                                                    <span><i class="fas fa-arrow-up text-red-500"></i> High</span>
                                                </label>
                                            </div>
                                        @else
                                            <div class="px-4 py-3 bg-gray-50 rounded-xl border-2 border-gray-200">
                                                @if ($task->priority == 1)
                                                    <span class="text-green-600 font-medium"><i
                                                            class="fas fa-arrow-down"></i> Low Priority</span>
                                                @elseif($task->priority == 2)
                                                    <span class="text-orange-500 font-medium"><i class="fas fa-minus"></i>
                                                        Medium Priority</span>
                                                @else
                                                    <span class="text-red-500 font-medium"><i class="fas fa-arrow-up"></i>
                                                        High Priority</span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-clock {{ $textAccent }} mr-2"></i>Deadline
                                        </label>
                                        <input type="datetime-local" name="deadline"
                                            value="{{ old('deadline', \Carbon\Carbon::parse($task->deadline)->format('Y-m-d\TH:i')) }}"
                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl {{ $ringColor }} focus:border-transparent transition shadow-sm"
                                            {{ !$isAdmin ? 'readonly' : '' }}
                                            style="{{ !$isAdmin ? 'background-color:#f9fafb;cursor:not-allowed;' : '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Sidebar Column --}}
                    <div class="lg:col-span-1 space-y-6">

                        {{-- Attachments Card --}}
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 sticky top-6">
                            <div class="px-6 py-4 {{ $bgLight }} border-b {{ $borderAccent }}">
                                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-paperclip {{ $textAccent }}"></i>
                                    Attachments
                                </h3>
                            </div>
                            <div class="p-6 space-y-4">
                                @if ($isAdmin)
                                    <div>
                                        <input type="file" name="attachments[]" id="fileInput" multiple
                                            class="w-full py-2 px-3 border-2 border-gray-200 rounded-xl shadow-sm text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-{{ $themeColor }}-50 file:text-{{ $themeColor }}-700 hover:file:bg-{{ $themeColor }}-100 transition cursor-pointer">
                                        <div id="filePreview" class="mt-3 flex flex-wrap gap-2"></div>
                                        <p class="text-xs text-gray-400 mt-2"><i class="fas fa-info-circle"></i> Upload
                                            new files (images, PDFs, documents)</p>
                                    </div>
                                @endif

                                @if (!empty($files) && is_array($files))
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                                            <i class="fas fa-database {{ $textAccent }} mr-2"></i>
                                            Current Files ({{ count($files) }})
                                        </label>
                                        <div class="space-y-2 max-h-96 overflow-y-auto custom-scrollbar">
                                            @foreach ($files as $file)
                                                @php
                                                    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                                    $fileName = basename($file);
                                                @endphp
                                                <a href="{{ asset($file) }}" target="_blank"
                                                    class="attachment-card block p-3 bg-gray-50 rounded-xl hover:shadow-md transition-all duration-200 group">
                                                    <div class="flex items-center gap-3">
                                                        @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                            <div
                                                                class="w-12 h-12 bg-gradient-to-br from-purple-400 to-pink-500 rounded-lg flex items-center justify-center shadow-sm">
                                                                <i class="fas fa-image text-white text-lg"></i>
                                                            </div>
                                                            <div class="flex-1">
                                                                <p
                                                                    class="text-sm font-medium text-gray-800 group-hover:text-{{ $themeColor }}-600 transition">
                                                                    {{ Str::limit($fileName, 30) }}</p>
                                                                <p class="text-xs text-gray-400">Image file</p>
                                                            </div>
                                                        @elseif ($extension === 'pdf')
                                                            <div
                                                                class="w-12 h-12 bg-gradient-to-br from-red-400 to-red-600 rounded-lg flex items-center justify-center shadow-sm">
                                                                <i class="fas fa-file-pdf text-white text-lg"></i>
                                                            </div>
                                                            <div class="flex-1">
                                                                <p
                                                                    class="text-sm font-medium text-gray-800 group-hover:text-{{ $themeColor }}-600 transition">
                                                                    {{ Str::limit($fileName, 30) }}</p>
                                                                <p class="text-xs text-gray-400">PDF Document</p>
                                                            </div>
                                                        @else
                                                            <div
                                                                class="w-12 h-12 bg-gradient-to-br from-gray-400 to-gray-600 rounded-lg flex items-center justify-center shadow-sm">
                                                                <i class="fas fa-file-alt text-white text-lg"></i>
                                                            </div>
                                                            <div class="flex-1">
                                                                <p
                                                                    class="text-sm font-medium text-gray-800 group-hover:text-{{ $themeColor }}-600 transition">
                                                                    {{ Str::limit($fileName, 30) }}</p>
                                                                <p class="text-xs text-gray-400">Download file</p>
                                                            </div>
                                                        @endif
                                                        <i
                                                            class="fas fa-external-link-alt text-gray-300 group-hover:text-{{ $themeColor }}-400 transition"></i>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center py-8">
                                        <i class="fas fa-folder-open text-gray-300 text-5xl mb-3"></i>
                                        <p class="text-gray-400 text-sm">No attachments uploaded yet</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Info Card --}}
                        <div
                            class="bg-gradient-to-br {{ $isAdmin ? 'from-orange-50 to-amber-50' : 'from-emerald-50 to-teal-50' }} rounded-2xl p-5 border border-{{ $themeColor }}-100">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm">
                                    <i class="fas fa-lightbulb {{ $textAccent }} text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800 mb-1">Quick Tips</h4>
                                    <ul class="text-xs text-gray-600 space-y-1">
                                        @if ($isAdmin)
                                            <li><i class="fas fa-check-circle {{ $textAccent }} mr-1"></i> Update task
                                                details as requirements change</li>
                                            <li><i class="fas fa-check-circle {{ $textAccent }} mr-1"></i> Reassign
                                                tasks to balance workload</li>
                                            <li><i class="fas fa-check-circle {{ $textAccent }} mr-1"></i> Add clear
                                                descriptions for better understanding</li>
                                        @else
                                            <li><i class="fas fa-check-circle {{ $textAccent }} mr-1"></i> Provide
                                                honest progress updates</li>
                                            <li><i class="fas fa-check-circle {{ $textAccent }} mr-1"></i> Flag any
                                                blockers or challenges</li>
                                            <li><i class="fas fa-check-circle {{ $textAccent }} mr-1"></i> Update status
                                                as you make progress</li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Submit Actions --}}
                <div class="mt-8 bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="px-6 py-5 flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <i class="fas fa-shield-alt text-green-500"></i>
                            <span>All changes are securely saved and tracked</span>
                        </div>
                        <div class="flex gap-3">
                            <button type="reset"
                                class="px-6 py-2.5 rounded-xl border-2 border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 hover:border-gray-400 transition flex items-center gap-2">
                                <i class="fas fa-undo-alt"></i> Reset
                            </button>
                            <button type="submit"
                                class="px-8 py-2.5 bg-gradient-to-r {{ $gradientFrom }} {{ $gradientTo }} hover:shadow-xl transform hover:scale-[1.02] transition-all duration-200 text-white font-bold rounded-xl shadow-md flex items-center gap-2">
                                <i class="fas fa-save"></i>
                                {{ $isAdmin ? 'Update Task' : 'Submit Feedback' }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Scripts --}}
    <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            @if ($isAdmin)
                CKEDITOR.replace('editor-description', {
                    removeButtons: 'Image,Video,Flash,Save,NewPage,Preview,Print,Templates',
                    height: 250,
                    toolbar: [{
                            name: 'basicstyles',
                            items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat']
                        },
                        {
                            name: 'paragraph',
                            items: ['NumberedList', 'BulletedList', 'Blockquote']
                        },
                        {
                            name: 'links',
                            items: ['Link', 'Unlink']
                        },
                        {
                            name: 'insert',
                            items: ['Table', 'HorizontalRule']
                        },
                        {
                            name: 'styles',
                            items: ['Format', 'FontSize']
                        }
                    ]
                });

                $('#fileInput').on('change', function(e) {
                    $('#filePreview').empty();
                    const files = e.target.files;
                    for (let i = 0; i < files.length; i++) {
                        const file = files[i];
                        const fileSize = (file.size / 1024).toFixed(1);
                        let icon = 'fa-file';
                        let color = 'text-gray-500';
                        if (file.type.includes('image')) {
                            icon = 'fa-file-image';
                            color = 'text-blue-500';
                        } else if (file.type.includes('pdf')) {
                            icon = 'fa-file-pdf';
                            color = 'text-red-500';
                        }
                        $('#filePreview').append(`
                    <div class="inline-flex items-center gap-2 bg-gray-100 rounded-full px-3 py-1.5 text-sm">
                        <i class="fas ${icon} ${color}"></i>
                        <span>${file.name.length > 20 ? file.name.substring(0, 20) + '...' : file.name}</span>
                        <span class="text-xs text-gray-400">(${fileSize} KB)</span>
                    </div>
                `);
                    }
                });
            @else
                CKEDITOR.replace('editor-feedback', {
                    removeButtons: 'Image,Video,Flash,Save,NewPage,Preview,Print,Templates',
                    height: 200,
                    toolbar: [{
                            name: 'basicstyles',
                            items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat']
                        },
                        {
                            name: 'paragraph',
                            items: ['NumberedList', 'BulletedList', 'Blockquote']
                        },
                        {
                            name: 'links',
                            items: ['Link', 'Unlink']
                        }
                    ]
                });
            @endif
        });
    </script>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
        }

        .cke_chrome {
            border-radius: 12px !important;
            overflow: hidden !important;
            border: 2px solid #e5e7eb !important;
        }

        .cke_top {
            background: #f9fafb !important;
            border-bottom-color: #e5e7eb !important;
        }
    </style>
@endsection
