{{--
    AWESOME UI: Edit Project - Premium Design
    - Modern glassmorphism effects with gradients
    - Font Awesome 6 icons throughout
    - Smooth animations and transitions
    - Enhanced form controls with focus effects
    - Dynamic module management with visual feedback
    - Fully responsive layout with sticky sidebar
--}}
@extends('admin.include.layout')
@section('heading', 'Projects')
@section('title', 'Edit Project')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @php
        $modules = $project->modules ?? [];
        $statusColors = [
            'pending' => [
                'bg' => 'bg-yellow-100',
                'text' => 'text-yellow-700',
                'icon' => 'fa-clock',
                'label' => 'Pending',
            ],
            'ongoing' => [
                'bg' => 'bg-blue-100',
                'text' => 'text-blue-700',
                'icon' => 'fa-spinner',
                'label' => 'Ongoing',
            ],
            'completed' => [
                'bg' => 'bg-green-100',
                'text' => 'text-green-700',
                'icon' => 'fa-check-circle',
                'label' => 'Completed',
            ],
        ];
        $currentStatus = $statusColors[$project->status] ?? $statusColors['pending'];
        $priorityColors = [
            'low' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'icon' => 'fa-arrow-down'],
            'medium' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-700', 'icon' => 'fa-minus'],
            'high' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'icon' => 'fa-arrow-up'],
        ];
    @endphp

    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(3deg);
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulseGlow {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(249, 115, 22, 0.4);
            }

            50% {
                box-shadow: 0 0 0 20px rgba(249, 115, 22, 0);
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-slide-in {
            animation: slideIn 0.3s ease-out;
        }

        .animate-fade-up {
            animation: fadeInUp 0.6s ease-out;
        }

        .module-item {
            animation: slideIn 0.3s ease-out;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .module-item:hover {
            transform: translateX(5px);
        }

        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.12);
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.1);
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #fb923c;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #f97316;
        }

        .status-badge {
            transition: all 0.3s ease;
        }

        .status-badge:hover {
            transform: scale(1.05);
        }
    </style>

    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-100 to-orange-50/30 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">

            {{-- Floating Background Elements --}}
            <div class="fixed inset-0 overflow-hidden pointer-events-none">
                <div
                    class="absolute top-20 right-10 w-72 h-72 bg-orange-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float">
                </div>
                <div class="absolute bottom-20 left-10 w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float"
                    style="animation-delay: 2s;"></div>
                <div class="absolute top-1/2 right-1/4 w-64 h-64 bg-purple-200 rounded-full filter blur-3xl opacity-10 animate-float"
                    style="animation-delay: 4s;"></div>
            </div>

            {{-- Header Section --}}
            <div class="relative mb-8 animate-fade-up">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden card-hover">
                    <div
                        class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-orange-500 to-orange-600 opacity-10 rounded-full transform translate-x-32 -translate-y-32">
                    </div>
                    <div class="relative px-6 py-6 md:px-8 md:py-8">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg transform -rotate-3 hover:rotate-0 transition-all duration-300">
                                    <i class="fas fa-edit text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h1 class="text-3xl md:text-4xl font-black text-gray-800 tracking-tight">
                                        Edit Project
                                    </h1>
                                    <p class="text-gray-500 mt-1 flex items-center gap-2">
                                        <i class="fas fa-folder-open text-orange-500"></i>
                                        Updating: <span class="font-semibold text-gray-700">{{ $project->name }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="status-badge px-4 py-2 {{ $currentStatus['bg'] }} rounded-full">
                                    <i class="fas {{ $currentStatus['icon'] }} {{ $currentStatus['text'] }} mr-2"></i>
                                    <span class="text-sm font-semibold {{ $currentStatus['text'] }}">Current:
                                        {{ $currentStatus['label'] }}</span>
                                </div>
                                <div class="px-4 py-2 bg-gray-100 rounded-full">
                                    <i class="fas fa-hashtag text-gray-500 mr-1"></i>
                                    <span class="text-sm font-semibold text-gray-600">ID: {{ $project->id }}</span>
                                </div>
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
                        confirmButtonColor: '#f97316',
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
                        title: 'Project Updated!',
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


            <form action="{{ route('project.update', $project->id) }}" method="POST" class="animate-fade-up"
                style="animation-delay: 0.1s">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    {{-- Main Content Column --}}
                    <div class="lg:col-span-2 space-y-6">

                        {{-- Basic Information Card --}}
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 card-hover">
                            <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-amber-50 border-b border-orange-100">
                                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-info-circle text-orange-500"></i>
                                    Basic Information
                                </h3>
                            </div>
                            <div class="p-6 space-y-5">
                                {{-- Project Title & Status Row --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    {{-- Project Title --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-tag text-orange-500 mr-2"></i>
                                            Project Title <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <input type="text" name="name" placeholder="Enter project title"
                                                value="{{ old('name', $project->name) }}"
                                                class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-400 transition-all duration-200">
                                            <i
                                                class="fas fa-folder-open absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                        </div>
                                        @error('name')
                                            <p class="text-red-500 text-xs mt-1 flex items-center gap-1"><i
                                                    class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- Status --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-chart-line text-orange-500 mr-2"></i>
                                            Status <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <select name="status"
                                                class="w-full pl-12 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-400 appearance-none bg-white cursor-pointer transition-all duration-200">
                                                <option value="pending"
                                                    {{ old('status', $project->status) == 'pending' ? 'selected' : '' }}>
                                                    🟡 Pending
                                                </option>
                                                <option value="ongoing"
                                                    {{ old('status', $project->status) == 'ongoing' ? 'selected' : '' }}>
                                                    🔵 Ongoing
                                                </option>
                                                <option value="completed"
                                                    {{ old('status', $project->status) == 'completed' ? 'selected' : '' }}>
                                                    🟢 Completed
                                                </option>
                                            </select>
                                            <i
                                                class="fas fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                            <i
                                                class="fas fa-chart-simple absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                        </div>
                                        @error('status')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Description --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-align-left text-orange-500 mr-2"></i>
                                        Description <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="description" rows="5"
                                        placeholder="Describe the project scope, objectives, and key deliverables..."
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-400 transition-all duration-200 resize-none">{{ old('description', $project->description) }}</textarea>
                                    @error('description')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Modules Management Card --}}
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 card-hover">
                            <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-amber-50 border-b border-orange-100">
                                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-cubes text-orange-500"></i>
                                    Project Modules
                                </h3>
                            </div>
                            <div class="p-6">
                                <div class="mb-4 flex justify-between items-center flex-wrap gap-3">
                                    <p class="text-sm text-gray-500 flex items-center gap-1">
                                        <i class="fas fa-info-circle text-orange-400"></i>
                                        Manage the main modules/features of this project
                                    </p>
                                    <button type="button" id="add-module"
                                        class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-5 py-2 rounded-xl text-sm font-semibold transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                                        <i class="fas fa-plus"></i>
                                        Add Module
                                    </button>
                                </div>
                                @php
                                    $modules = $project->modules ?? [];
                                @endphp

                                <div id="module-wrapper" class="space-y-3 max-h-80 overflow-y-auto custom-scrollbar pr-2">
                                    @if (count($modules))
                                        @foreach ($modules as $index => $module)
                                            <div
                                                class="module-item flex gap-3 items-center bg-gray-50 rounded-xl p-3 border border-gray-200 hover:border-orange-300 transition-all duration-200 group">
                                                <div class="flex-shrink-0">
                                                    <i class="fas fa-microchip text-orange-400"></i>
                                                </div>

                                                <input type="text" name="modules[]" value="{{ $module }}"
                                                    placeholder="e.g., User Authentication, Payment Gateway"
                                                    class="flex-1 bg-transparent border-0 focus:ring-0 focus:outline-none text-gray-700 placeholder-gray-400 font-medium">

                                                <button type="button"
                                                    class="remove-module w-8 h-8 bg-red-100 hover:bg-red-500 text-red-500 hover:text-white rounded-lg transition-all duration-200 flex items-center justify-center">
                                                    <i class="fas fa-times text-sm"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    @else
                                        <div
                                            class="module-item flex gap-3 items-center bg-gray-50 rounded-xl p-3 border border-gray-200 hover:border-orange-300 transition-all duration-200 group">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-microchip text-orange-400"></i>
                                            </div>

                                            <input type="text" name="modules[]"
                                                placeholder="e.g., User Authentication, Payment Gateway"
                                                class="flex-1 bg-transparent border-0 focus:ring-0 focus:outline-none text-gray-700 placeholder-gray-400 font-medium">

                                            <button type="button"
                                                class="remove-module w-8 h-8 bg-red-100 hover:bg-red-500 text-red-500 hover:text-white rounded-lg transition-all duration-200 flex items-center justify-center">
                                                <i class="fas fa-times text-sm"></i>
                                            </button>
                                        </div>
                                    @endif
                                </div>

                                <div class="mt-4 p-3 bg-orange-50 rounded-xl">
                                    <div class="flex items-center gap-2 text-xs text-orange-700">
                                        <i class="fas fa-lightbulb"></i>
                                        <span>Tip: Add modules like "Frontend", "Backend", "Database", "API Integration",
                                            etc.</span>
                                    </div>
                                </div>

                                @error('modules')
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                                @error('modules.*')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Sidebar Column --}}
                    <div class="lg:col-span-1 space-y-6">

                        {{-- Priority Card --}}
                        <div
                            class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 card-hover sticky top-6">
                            <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-amber-50 border-b border-orange-100">
                                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-flag text-orange-500"></i>
                                    Priority Level
                                </h3>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-3 gap-2">
                                    <label class="cursor-pointer">
                                        <input type="radio" name="priority" value="low" class="hidden peer"
                                            {{ old('priority', $project->priority) == 'low' ? 'checked' : '' }}>
                                        <div
                                            class="border-2 border-gray-200 rounded-xl p-3 text-center peer-checked:border-green-500 peer-checked:bg-green-50 transition-all duration-200">
                                            <i class="fas fa-arrow-down text-green-500 text-xl"></i>
                                            <p class="text-xs font-medium mt-1 text-gray-600">Low</p>
                                        </div>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="priority" value="medium" class="hidden peer"
                                            {{ old('priority', $project->priority) == 'medium' ? 'checked' : '' }}>
                                        <div
                                            class="border-2 border-gray-200 rounded-xl p-3 text-center peer-checked:border-orange-500 peer-checked:bg-orange-50 transition-all duration-200">
                                            <i class="fas fa-minus text-orange-500 text-xl"></i>
                                            <p class="text-xs font-medium mt-1 text-gray-600">Medium</p>
                                        </div>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="priority" value="high" class="hidden peer"
                                            {{ old('priority', $project->priority) == 'high' ? 'checked' : '' }}>
                                        <div
                                            class="border-2 border-gray-200 rounded-xl p-3 text-center peer-checked:border-red-500 peer-checked:bg-red-50 transition-all duration-200">
                                            <i class="fas fa-arrow-up text-red-500 text-xl"></i>
                                            <p class="text-xs font-medium mt-1 text-gray-600">High</p>
                                        </div>
                                    </label>
                                </div>
                                @error('priority')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Timeline Card --}}
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 card-hover">
                            <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-amber-50 border-b border-orange-100">
                                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-calendar-alt text-orange-500"></i>
                                    Project Timeline
                                </h3>
                            </div>
                            <div class="p-6 space-y-5">
                                {{-- Start Date --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-play-circle text-orange-500 mr-2"></i>
                                        Start Date <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="datetime-local" name="start_date"
                                            value="{{ old('start_date', \Carbon\Carbon::parse($project->start_date)->format('Y-m-d\TH:i')) }}"
                                            class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-400 transition-all duration-200">
                                        <i
                                            class="fas fa-calendar-day absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    </div>
                                    @error('start_date')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- End Date --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-stop-circle text-orange-500 mr-2"></i>
                                        End Date
                                    </label>
                                    <div class="relative">
                                        <input type="datetime-local" name="end_date"
                                            value="{{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('Y-m-d\TH:i') : '' }}"
                                            class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-400 transition-all duration-200">
                                        <i
                                            class="fas fa-calendar-week absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    </div>
                                    @error('end_date')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                @if ($project->end_date)
                                    @php
                                        $start = \Carbon\Carbon::parse($project->start_date);
                                        $end = \Carbon\Carbon::parse($project->end_date);
                                        $daysLeft = $end->diffInDays(now());
                                    @endphp
                                    <div
                                        class="mt-4 p-3 {{ $daysLeft < 0 ? 'bg-red-50' : ($daysLeft < 7 ? 'bg-yellow-50' : 'bg-green-50') }} rounded-xl">
                                        <div
                                            class="flex items-center gap-2 text-xs {{ $daysLeft < 0 ? 'text-red-700' : ($daysLeft < 7 ? 'text-yellow-700' : 'text-green-700') }}">
                                            <i
                                                class="fas {{ $daysLeft < 0 ? 'fa-exclamation-triangle' : 'fa-clock' }}"></i>
                                            @if ($daysLeft < 0)
                                                <span>Project has ended</span>
                                            @elseif($daysLeft < 7)
                                                <span>⚠️ Only {{ abs($daysLeft) }} days remaining!</span>
                                            @else
                                                <span>{{ $daysLeft }} days remaining until deadline</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Quick Tips Card --}}
                        <div class="bg-gradient-to-br from-orange-50 to-amber-50 rounded-2xl p-5 border border-orange-100">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm">
                                    <i class="fas fa-lightbulb text-orange-500 text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800 mb-2">Update Tips</h4>
                                    <ul class="text-xs text-gray-600 space-y-1.5">
                                        <li class="flex items-center gap-2"><i
                                                class="fas fa-check-circle text-green-500 text-xs"></i> Keep project title
                                            clear and descriptive</li>
                                        <li class="flex items-center gap-2"><i
                                                class="fas fa-check-circle text-green-500 text-xs"></i> Update status as
                                            project progresses</li>
                                        <li class="flex items-center gap-2"><i
                                                class="fas fa-check-circle text-green-500 text-xs"></i> Add/remove modules
                                            as scope changes</li>
                                        <li class="flex items-center gap-2"><i
                                                class="fas fa-check-circle text-green-500 text-xs"></i> Adjust deadlines if
                                            needed</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Submit Actions --}}
                <div class="mt-8 bg-white rounded-2xl shadow-lg overflow-hidden card-hover">
                    <div class="px-6 py-5 flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <i class="fas fa-shield-alt text-green-500"></i>
                            <span>All changes are saved and tracked</span>
                        </div>
                        <div class="flex gap-3">
                            <a href="{{ route('project.list') }}"
                                class="px-6 py-2.5 rounded-xl border-2 border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 flex items-center gap-2">
                                <i class="fas fa-arrow-left"></i>
                                Cancel
                            </a>
                            <button type="reset"
                                class="px-6 py-2.5 rounded-xl border-2 border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 flex items-center gap-2">
                                <i class="fas fa-undo-alt"></i>
                                Reset
                            </button>
                            <button type="submit"
                                class="px-8 py-2.5 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 transform hover:scale-[1.02] transition-all duration-200 text-white font-bold rounded-xl shadow-md hover:shadow-xl flex items-center gap-2">
                                <i class="fas fa-save"></i>
                                Update Project
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Add Module with Animation
        document.getElementById('add-module').addEventListener('click', function() {
            let wrapper = document.getElementById('module-wrapper');

            let html = `
            <div class="module-item flex gap-3 items-center bg-gray-50 rounded-xl p-3 border border-gray-200 hover:border-orange-300 transition-all duration-200 group animate-slide-in">
                <div class="flex-shrink-0">
                    <i class="fas fa-microchip text-orange-400"></i>
                </div>
                <input type="text" name="modules[]"
                    placeholder="e.g., User Authentication, Payment Gateway"
                    class="flex-1 bg-transparent border-0 focus:ring-0 focus:outline-none text-gray-700 placeholder-gray-400 font-medium">
                <button type="button"
                    class="remove-module w-8 h-8 bg-red-100 hover:bg-red-500 text-red-500 hover:text-white rounded-lg transition-all duration-200 flex items-center justify-center">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>
        `;

            wrapper.insertAdjacentHTML('beforeend', html);

            // Scroll to new module
            let newModule = wrapper.lastElementChild;
            newModule.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });

            // Focus the input
            let newInput = newModule.querySelector('input');
            if (newInput) newInput.focus();
        });

        // Remove Module with minimum one check
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-module')) {
                let moduleItem = e.target.closest('.module-item');
                let moduleItems = document.querySelectorAll('.module-item');

                if (moduleItems.length > 1) {
                    moduleItem.style.opacity = '0';
                    moduleItem.style.transform = 'translateX(-20px)';
                    setTimeout(() => {
                        moduleItem.remove();
                    }, 200);
                } else {
                    // Show notification that at least one module is required
                    Swal.fire({
                        icon: 'warning',
                        title: 'Cannot Remove',
                        text: 'At least one module is required for the project',
                        confirmButtonColor: '#f97316',
                        timer: 2000,
                        showConfirmButton: true
                    });
                }
            }
        });

        // Reset confirmation
        document.querySelector('button[type="reset"]')?.addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Reset Form?',
                text: 'All unsaved changes will be lost',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f97316',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, reset',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.querySelector('form').reset();
                    Swal.fire('Reset!', 'Form has been reset', 'success');
                }
            });
        });

        // Add focus effects
        document.querySelectorAll('input, select, textarea').forEach(element => {
            element.addEventListener('focus', function() {
                this.parentElement?.classList.add('ring-2', 'ring-orange-200', 'rounded-xl');
            });
            element.addEventListener('blur', function() {
                this.parentElement?.classList.remove('ring-2', 'ring-orange-200');
            });
        });
    </script>
@endsection
