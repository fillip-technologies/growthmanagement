{{--
    AWESOME UI: Edit Project - Premium Design
    - Modern glassmorphism effects with gradients
    - Font Awesome 6 icons throughout
    - Smooth animations and transitions
    - Enhanced form controls with focus effects
    - Dynamic module management with visual feedback
    - Fully responsive layout with sticky sidebar
    - Complete Human Resources & Infrastructure sections
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
            'medium' => ['bg' => 'bg-blue-100', 'text' => 'text-cyan-600', 'icon' => 'fa-minus'],
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
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #60a5fa;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #2563eb;
        }

        .status-badge {
            transition: all 0.3s ease;
        }

        .status-badge:hover {
            transform: scale(1.05);
        }

        .input-group-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            pointer-events: none;
        }

        .input-group {
            position: relative;
        }

        .input-group input,
        .input-group select {
            padding-left: 42px;
            width: 100%;
        }

        .team-member-card {
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .team-member-card:hover {
            border-color: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.12);
        }

        .role-badge {
            padding: 2px 12px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .role-badge.pm {
            background: #dbeafe;
            color: #1e40af;
        }

        .role-badge.dev {
            background: #d1fae5;
            color: #065f46;
        }

        .role-badge.design {
            background: #fce7f3;
            color: #9d174d;
        }

        .role-badge.qa {
            background: #eff6ff;
            color: #92400e;
        }
    </style>

    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-100 to-blue-50/30 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">

            {{-- Floating Background Elements --}}
            <div class="fixed inset-0 overflow-hidden pointer-events-none">
                <div
                    class="absolute top-20 right-10 w-72 h-72 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float">
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
                        class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-blue-500 to-cyan-500 opacity-10 rounded-full transform translate-x-32 -translate-y-32">
                    </div>
                    <div class="relative px-6 py-6 md:px-8 md:py-8">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center shadow-lg transform -rotate-3 hover:rotate-0 transition-all duration-300">
                                    <i class="fas fa-edit text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h1 class="text-3xl md:text-4xl font-black text-gray-800 tracking-tight">
                                        Edit Project
                                    </h1>
                                    <p class="text-gray-500 mt-1 flex items-center gap-2">
                                        <i class="fas fa-folder-open text-blue-500"></i>
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
                        confirmButtonColor: '#2563eb',
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

            @php
                $updateRoute = null;
                if (Auth::guard('super_admin')->check() || Auth::guard("project_manager")->check()) {
                    $updateRoute = route('project.update', $project->id);
                } elseif (Auth::guard('marketing_manager')->check()) {
                    $updateRoute = route('marketing.project.update', $project->id);
                }
            @endphp

            <form action="{{ $updateRoute }}" method="POST" class="animate-fade-up" style="animation-delay: 0.1s">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    {{-- Main Content Column --}}
                    <div class="lg:col-span-2 space-y-6">

                        {{-- Basic Information Card --}}
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 card-hover">
                            <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-cyan-50 border-b border-blue-100">
                                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-info-circle text-blue-500"></i>
                                    Basic Information
                                </h3>
                            </div>
                            <div class="p-6 space-y-5">
                                {{-- Project Title & Status Row --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    {{-- Project Title --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-tag text-blue-500 mr-2"></i>
                                            Project Title <span class="text-red-500">*</span>
                                        </label>
                                        <div class="input-group">
                                            <input type="text" name="name" placeholder="Enter project title"
                                                value="{{ old('name', $project->name) }}"
                                                class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-400 transition-all duration-200">
                                            <i class="fas fa-folder-open input-group-icon"></i>
                                        </div>
                                        @error('name')
                                            <p class="text-red-500 text-xs mt-1 flex items-center gap-1"><i
                                                    class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                                        @enderror
                                    </div>

                                     <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-tag text-blue-500 mr-2"></i>
                                        Client Name <span class="text-red-500">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="text" name="client_name"
                                            placeholder="Enter Client Name"
                                            value="{{ old('client_name',$project->client_name ?? "") }}"
                                            class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-400 transition-all duration-200">
                                        <i class="fas fa-user input-group-icon"></i>
                                    </div>
                                    @error('client_name')
                                        <p class="text-red-500 text-xs mt-1 flex items-center gap-1"><i
                                                class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                                    @enderror
                                </div>

                                    {{-- Status --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-chart-line text-blue-500 mr-2"></i>
                                            Status <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <select name="status"
                                                class="w-full pl-12 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-400 appearance-none bg-white cursor-pointer transition-all duration-200">
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
                                        <i class="fas fa-align-left text-blue-500 mr-2"></i>
                                        Description <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="description" rows="5"
                                        placeholder="Describe the project scope, objectives, and key deliverables..."
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-400 transition-all duration-200 resize-none">{{ old('description', $project->description) }}</textarea>
                                    @error('description')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        @php
                            $humanResource = $project->projecthumanresource->first();
                        @endphp
                        {{-- Project Human Resources Card --}}
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 card-hover">
                            <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-pink-50 border-b border-purple-100">
                                <div class="flex justify-between items-center">
                                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                        <i class="fas fa-users text-purple-600"></i>
                                        Human Resources
                                    </h3>
                                    <span
                                        class="text-xs text-purple-600 font-medium bg-white px-3 py-1 rounded-full shadow-sm">
                                        <i class="fas fa-user-plus mr-1"></i> Team Assignment
                                    </span>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <!-- Project Manager -->
                                    <div
                                        class="team-member-card bg-gradient-to-br from-blue-50 to-blue-100/50 rounded-xl p-4 border border-blue-200">
                                        <div class="flex items-start gap-3">
                                            <div
                                                class="w-10 h-10 bg-blue-500 rounded-xl flex items-center justify-center shadow-md flex-shrink-0">
                                                <i class="fas fa-user-tie text-white text-lg"></i>
                                            </div>
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <label class="text-sm font-bold text-gray-700">
                                                        Project Manager
                                                    </label>
                                                    <span class="role-badge pm">PM</span>
                                                </div>
                                                <div class="input-group">
                                                    <input type="text" name="project_manager"
                                                        placeholder="e.g., John Smith, Sarah Johnson"
                                                        value="{{ old('project_manager', $humanResource->project_manager ?? '') }}"
                                                        class="w-full pl-10 pr-3 py-2.5 bg-white border-2 border-blue-200 rounded-lg focus:border-blue-500 transition-all duration-200 text-sm">
                                                    <i class="fas fa-user-tie input-group-icon text-blue-400 text-sm"></i>
                                                </div>
                                                @error('project_manager')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Developer -->
                                    <div
                                        class="team-member-card bg-gradient-to-br from-green-50 to-green-100/50 rounded-xl p-4 border border-green-200">
                                        <div class="flex items-start gap-3">
                                            <div
                                                class="w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center shadow-md flex-shrink-0">
                                                <i class="fas fa-code text-white text-lg"></i>
                                            </div>
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <label class="text-sm font-bold text-gray-700">
                                                        Developer
                                                    </label>
                                                    <span class="role-badge dev">DEV</span>
                                                </div>
                                                <div class="input-group">
                                                    <input type="text" name="developer"
                                                        placeholder="e.g., Mike Chen, Anna Rodriguez"
                                                        value="{{ old('developer', $humanResource->developer ?? '') }}"
                                                        class="w-full pl-10 pr-3 py-2.5 bg-white border-2 border-green-200 rounded-lg focus:border-green-500 transition-all duration-200 text-sm">
                                                    <i class="fas fa-code input-group-icon text-green-400 text-sm"></i>
                                                </div>
                                                @error('developer')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Designer -->
                                    <div
                                        class="team-member-card bg-gradient-to-br from-pink-50 to-pink-100/50 rounded-xl p-4 border border-pink-200">
                                        <div class="flex items-start gap-3">
                                            <div
                                                class="w-10 h-10 bg-pink-500 rounded-xl flex items-center justify-center shadow-md flex-shrink-0">
                                                <i class="fas fa-paint-brush text-white text-lg"></i>
                                            </div>
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <label class="text-sm font-bold text-gray-700">
                                                        Designer
                                                    </label>
                                                    <span class="role-badge design">UI/UX</span>
                                                </div>
                                                <div class="input-group">
                                                    <input type="text" name="designer"
                                                        placeholder="e.g., Emily Davis, Alex Kim"
                                                        value="{{ old('designer', $humanResource->designer ?? '') }}"
                                                        class="w-full pl-10 pr-3 py-2.5 bg-white border-2 border-pink-200 rounded-lg focus:border-pink-500 transition-all duration-200 text-sm">
                                                    <i
                                                        class="fas fa-paint-brush input-group-icon text-pink-400 text-sm"></i>
                                                </div>
                                                @error('designer')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- QA Engineer -->
                                    <div
                                        class="team-member-card bg-gradient-to-br from-yellow-50 to-yellow-100/50 rounded-xl p-4 border border-yellow-200">
                                        <div class="flex items-start gap-3">
                                            <div
                                                class="w-10 h-10 bg-yellow-500 rounded-xl flex items-center justify-center shadow-md flex-shrink-0">
                                                <i class="fas fa-bug text-white text-lg"></i>
                                            </div>
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <label class="text-sm font-bold text-gray-700">
                                                        QA Engineer
                                                    </label>
                                                    <span class="role-badge qa">QA</span>
                                                </div>
                                                <div class="input-group">
                                                    <input type="text" name="qa_engineer"
                                                        placeholder="e.g., Robert Wilson, Lisa Park"
                                                        value="{{ old('qa_engineer', $humanResource->qa_engineer ?? '') }}"
                                                        class="w-full pl-10 pr-3 py-2.5 bg-white border-2 border-yellow-200 rounded-lg focus:border-yellow-500 transition-all duration-200 text-sm">
                                                    <i class="fas fa-bug input-group-icon text-yellow-400 text-sm"></i>
                                                </div>
                                                @error('qa_engineer')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="mt-5 p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl border border-purple-100">
                                    <div class="flex items-start gap-3">
                                        <i class="fas fa-lightbulb text-purple-500 mt-0.5"></i>
                                        <div class="text-xs text-purple-700">
                                            <p class="font-semibold mb-1">Team Management Tips:</p>
                                            <ul class="space-y-1 list-disc list-inside">
                                                <li>Assign a dedicated project manager for better coordination</li>
                                                <li>Specify developers based on required tech stack</li>
                                                <li>Include designers for UI/UX planning</li>
                                                <li>QA engineers ensure quality assurance throughout development</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            $Infrastructure = $project->projectInfraresource->first();
                        @endphp
                        {{-- Project Infrastructure Resources Card --}}
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 card-hover">
                            <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-blue-100">
                                <div class="flex justify-between items-center">
                                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                        <i class="fas fa-server text-blue-600"></i>
                                        Infrastructure Resources
                                    </h3>
                                    <button type="button" id="toggle-infrastructure"
                                        class="text-sm text-blue-600 hover:text-blue-800 font-semibold toggle-advanced flex items-center gap-2 bg-white px-4 py-2 rounded-lg shadow-sm">
                                        <i class="fas fa-chevron-down" id="toggle-icon"></i>
                                        <span id="toggle-text">Hide Advanced</span>
                                    </button>
                                </div>
                            </div>
                            <div class="p-6" id="infrastructure-content">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <!-- Domain Name -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-globe text-blue-500 mr-2"></i>
                                            Domain Name
                                        </label>
                                        <div class="input-group">
                                            <input type="text" name="domain_name" placeholder="e.g., example.com"
                                                value="{{ old('domain_name', $Infrastructure->domain_name ?? '') }}"
                                                class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-400 transition-all duration-200">
                                            <i class="fas fa-globe input-group-icon"></i>
                                        </div>
                                        @error('domain_name')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Domain Registrar -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-building text-blue-500 mr-2"></i>
                                            Domain Registrar
                                        </label>
                                        <div class="input-group">
                                            <input type="text" name="domain_registrar"
                                                placeholder="e.g., GoDaddy, Namecheap"
                                                value="{{ old('domain_registrar', $Infrastructure->domain_registrar ?? '') }}"
                                                class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-400 transition-all duration-200">
                                            <i class="fas fa-building input-group-icon"></i>
                                        </div>
                                        @error('domain_registrar')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Hosting Provider -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-cloud text-blue-500 mr-2"></i>
                                            Hosting Provider
                                        </label>
                                        <div class="input-group">
                                            <input type="text" name="hosting_provider"
                                                placeholder="e.g., AWS, DigitalOcean, Bluehost"
                                                value="{{ old('hosting_provider', $Infrastructure->hosting_provider ?? '') }}"
                                                class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-400 transition-all duration-200">
                                            <i class="fas fa-cloud input-group-icon"></i>
                                        </div>
                                        @error('hosting_provider')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Hosting Account Owner -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-user-circle text-blue-500 mr-2"></i>
                                            Hosting Account Owner
                                        </label>
                                        <div class="input-group">
                                            <input type="text" name="hosting_account_owner"
                                                placeholder="e.g., John Doe, IT Department"
                                                value="{{ old('hosting_account_owner', $Infrastructure->hosting_account_owner ?? '') }}"
                                                class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-400 transition-all duration-200">
                                            <i class="fas fa-user-circle input-group-icon"></i>
                                        </div>
                                        @error('hosting_account_owner')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- SSL Certificate -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-lock text-blue-500 mr-2"></i>
                                            SSL Certificate
                                        </label>
                                        <div class="input-group">
                                            <select name="ssl_certificate"
                                                class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-400 appearance-none bg-white cursor-pointer transition-all duration-200">
                                                <option value="">Select SSL Status</option>
                                                <option value="active"
                                                    {{ old('ssl_certificate', $Infrastructure->ssl_certificate ?? '') == 'active' ? 'selected' : '' }}>
                                                    🔒 Active</option>
                                                <option value="expiring"
                                                    {{ old('ssl_certificate', $Infrastructure->ssl_certificate ?? '') == 'expiring' ? 'selected' : '' }}>
                                                    ⚠️ Expiring Soon</option>
                                                <option value="inactive"
                                                    {{ old('ssl_certificate', $Infrastructure->ssl_certificate ?? '') == 'inactive' ? 'selected' : '' }}>
                                                    🔓 Inactive</option>
                                                <option value="not_installed"
                                                    {{ old('ssl_certificate', $Infrastructure->ssl_certificate ?? '') == 'not_installed' ? 'selected' : '' }}>
                                                    ❌ Not Installed</option>
                                            </select>
                                            <i
                                                class="fas fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                            <i class="fas fa-lock input-group-icon"></i>
                                        </div>
                                        @error('ssl_certificate')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Email Service Provider -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-envelope text-blue-500 mr-2"></i>
                                            Email Service Provider
                                        </label>
                                        <div class="input-group">
                                            <input type="text" name="email_service_provider"
                                                placeholder="e.g., Google Workspace, Zoho, Mailgun"
                                                value="{{ old('email_service_provider', $Infrastructure->email_service_provider ?? '') }}"
                                                class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-400 transition-all duration-200">
                                            <i class="fas fa-envelope input-group-icon"></i>
                                        </div>
                                        @error('email_service_provider')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- DNS Management -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-sitemap text-blue-500 mr-2"></i>
                                            DNS Management
                                        </label>
                                        <div class="input-group">
                                            <input type="text" name="dns_management"
                                                placeholder="e.g., Cloudflare, AWS Route 53, GoDaddy"
                                                value="{{ old('dns_management', $Infrastructure->dns_management ?? '') }}"
                                                class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-400 transition-all duration-200">
                                            <i class="fas fa-sitemap input-group-icon"></i>
                                        </div>
                                        @error('dns_management')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- CDN Provider -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-network-wired text-blue-500 mr-2"></i>
                                            CDN Provider
                                        </label>
                                        <div class="input-group">
                                            <input type="text" name="cdn_provider"
                                                placeholder="e.g., Cloudflare, Akamai, Fastly"
                                                value="{{ old('cdn_provider', $Infrastructure->cdn_provider ?? '') }}"
                                                class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-400 transition-all duration-200">
                                            <i class="fas fa-network-wired input-group-icon"></i>
                                        </div>
                                        @error('cdn_provider')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Third Party APIs -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-plug text-blue-500 mr-2"></i>
                                            Third Party APIs
                                        </label>
                                        <div class="input-group">
                                            <input type="text" name="third_party_apis"
                                                placeholder="e.g., Stripe, PayPal, Google Maps"
                                                value="{{ old('third_party_apis', $Infrastructure->third_party_apis ?? '') }}"
                                                class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-400 transition-all duration-200">
                                            <i class="fas fa-plug input-group-icon"></i>
                                        </div>
                                        @error('third_party_apis')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Renewal Date -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-calendar-plus text-blue-500 mr-2"></i>
                                            Renewal Date
                                        </label>
                                        @php
                                            $renewaldate = $Infrastructure->renewal_date ?? '';
                                        @endphp
                                        <div class="input-group">
                                            <input type="date" name="renewal_date"
                                                value="{{ old('renewal_date', $renewaldate ? \Carbon\Carbon::parse($renewaldate)->format('Y-m-d') : '') }}"
                                                class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-400 transition-all duration-200">
                                            <i class="fas fa-calendar-plus input-group-icon"></i>
                                        </div>
                                        @error('renewal_date')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Responsible Team Member -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-users text-blue-500 mr-2"></i>
                                            Responsible Team Member
                                        </label>
                                        <div class="input-group">
                                            <input type="text" name="responsible_team_member"
                                                placeholder="e.g., Sarah Johnson, DevOps Team"
                                                value="{{ old('responsible_team_member', $Infrastructure->responsible_team_member ?? '') }}"
                                                class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-400 transition-all duration-200">
                                            <i class="fas fa-users input-group-icon"></i>
                                        </div>
                                        @error('responsible_team_member')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mt-5 p-4 bg-blue-50 rounded-xl border border-blue-100">
                                    <div class="flex items-start gap-3">
                                        <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                                        <div class="text-xs text-blue-700">
                                            <p class="font-semibold mb-1">Infrastructure Notes:</p>
                                            <ul class="space-y-1 list-disc list-inside">
                                                <li>Provide domain details for better project tracking</li>
                                                <li>Include hosting and email service provider information</li>
                                                <li>Add SSL certificate status for security compliance</li>
                                                <li>Specify responsible team members for accountability</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Modules Management Card --}}
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 card-hover">
                            <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-cyan-50 border-b border-blue-100">
                                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-cubes text-blue-500"></i>
                                    Project Modules
                                </h3>
                            </div>
                            <div class="p-6">
                                <div class="mb-4 flex justify-between items-center flex-wrap gap-3">
                                    <p class="text-sm text-gray-500 flex items-center gap-1">
                                        <i class="fas fa-info-circle text-blue-400"></i>
                                        Manage the main modules/features of this project
                                    </p>
                                    <button type="button" id="add-module"
                                        class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-5 py-2 rounded-xl text-sm font-semibold transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                                        <i class="fas fa-plus"></i>
                                        Add Module
                                    </button>
                                </div>
                                @php
                                    $modules = is_array($project->modules)
                                        ? $project->modules
                                        : json_decode($project->modules, true);

                                    $modules = $modules ?? [];
                                @endphp


                                <div id="module-wrapper" class="space-y-3 max-h-80 overflow-y-auto custom-scrollbar pr-2">
                                    @if (!empty($modules))
                                        @foreach ($modules ?? [] as $index => $module)
                                            <div
                                                class="module-item flex gap-3 items-center bg-gray-50 rounded-xl p-3 border border-gray-200 hover:border-blue-300 transition-all duration-200 group">
                                                <div class="flex-shrink-0">
                                                    <i class="fas fa-microchip text-blue-400"></i>
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
                                            class="module-item flex gap-3 items-center bg-gray-50 rounded-xl p-3 border border-gray-200 hover:border-blue-300 transition-all duration-200 group">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-microchip text-blue-400"></i>
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

                                <div class="mt-4 p-3 bg-blue-50 rounded-xl">
                                    <div class="flex items-center gap-2 text-xs text-cyan-600">
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
                            <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-cyan-50 border-b border-blue-100">
                                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-flag text-blue-500"></i>
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
                                            class="border-2 border-gray-200 rounded-xl p-3 text-center peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all duration-200">
                                            <i class="fas fa-minus text-blue-500 text-xl"></i>
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
                            <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-cyan-50 border-b border-blue-100">
                                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-calendar-alt text-blue-500"></i>
                                    Project Timeline
                                </h3>
                            </div>
                            <div class="p-6 space-y-5">
                                {{-- Start Date --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-play-circle text-blue-500 mr-2"></i>
                                        Start Date <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="datetime-local" name="start_date"
                                            value="{{ old('start_date', \Carbon\Carbon::parse($project->start_date)->format('Y-m-d\TH:i')) }}"
                                            class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-400 transition-all duration-200">
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
                                        <i class="fas fa-stop-circle text-blue-500 mr-2"></i>
                                        End Date
                                    </label>
                                    <div class="relative">
                                        <input type="datetime-local" name="end_date"
                                            value="{{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('Y-m-d\TH:i') : '' }}"
                                            class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-400 transition-all duration-200">
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
                        <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl p-5 border border-blue-100">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-sm">
                                    <i class="fas fa-lightbulb text-blue-500 text-lg"></i>
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
                                        <li class="flex items-center gap-2"><i
                                                class="fas fa-check-circle text-green-500 text-xs"></i> Update team members
                                            as project evolves</li>
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
                                class="px-8 py-2.5 bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-cyan-500 hover:to-cyan-600 transform hover:scale-[1.02] transition-all duration-200 text-white font-bold rounded-xl shadow-md hover:shadow-xl flex items-center gap-2">
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
        // Toggle Infrastructure Section
        document.getElementById('toggle-infrastructure')?.addEventListener('click', function() {
            const content = document.getElementById('infrastructure-content');
            const icon = document.getElementById('toggle-icon');
            const text = document.getElementById('toggle-text');

            if (content.style.display === 'none') {
                content.style.display = 'block';
                icon.className = 'fas fa-chevron-up';
                text.textContent = 'Hide Advanced';
            } else {
                content.style.display = 'none';
                icon.className = 'fas fa-chevron-down';
                text.textContent = 'Show Advanced';
            }
        });

        // Add Module with Animation
        document.getElementById('add-module').addEventListener('click', function() {
            let wrapper = document.getElementById('module-wrapper');

            let html = `
            <div class="module-item flex gap-3 items-center bg-gray-50 rounded-xl p-3 border border-gray-200 hover:border-blue-300 transition-all duration-200 group animate-slide-in">
                <div class="flex-shrink-0">
                    <i class="fas fa-microchip text-blue-400"></i>
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
                        confirmButtonColor: '#2563eb',
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
                confirmButtonColor: '#2563eb',
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
                this.parentElement?.classList.add('ring-2', 'ring-blue-200', 'rounded-xl');
            });
            element.addEventListener('blur', function() {
                this.parentElement?.classList.remove('ring-2', 'ring-blue-200');
            });
        });
    </script>
@endsection
