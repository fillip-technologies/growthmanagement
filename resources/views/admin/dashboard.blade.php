
@extends('admin.include.layout')
@section('title', 'Dashboard')
@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
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

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulseGlow {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.4);
            }

            50% {
                box-shadow: 0 0 0 20px rgba(59, 130, 246, 0);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }

            100% {
                background-position: 1000px 0;
            }
        }

        .animate-fade-up {
            animation: fadeInUp 0.6s ease-out;
        }

        .animate-slide-left {
            animation: slideInLeft 0.5s ease-out;
        }

        .animate-slide-right {
            animation: slideInRight 0.5s ease-out;
        }

        .stat-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .stat-card:hover::before {
            left: 100%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 30px -12px rgba(0, 0, 0, 0.15);
        }

        .icon-wrapper {
            transition: all 0.3s ease;
        }

        .stat-card:hover .icon-wrapper {
            transform: scale(1.1) rotate(5deg);
        }

        .floating-bg {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            z-index: 0;
        }

        .floating-bg div {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.1;
        }

        .greeting-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
        }

        .greeting-card::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 80%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            transform: rotate(25deg);
        }

        .activity-item {
            transition: all 0.2s ease;
        }

        .activity-item:hover {
            background-color: #f8fafc;
            transform: translateX(5px);
        }

        .quick-action-btn {
            transition: all 0.2s ease;
        }

        .quick-action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.15);
        }

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
    </style>

    @php

        $currentHour = date('H');
        if ($currentHour < 12) {
            $greeting = 'Good Morning';
            $greetingIcon = 'fas fa-sun';
            $greetingColor = 'text-yellow-400';
        } elseif ($currentHour < 17) {
            $greeting = 'Good Afternoon';
            $greetingIcon = 'fas fa-cloud-sun';
            $greetingColor = 'text-orange-400';
        } elseif ($currentHour < 20) {
            $greeting = 'Good Evening';
            $greetingIcon = 'fas fa-moon';
            $greetingColor = 'text-indigo-300';
        } else {
            $greeting = 'Good Night';
            $greetingIcon = 'fas fa-star';
            $greetingColor = 'text-blue-300';
        }

        $currentDate = date('l, F j, Y');
        $adminName = "";
        if(Auth::guard('super_admin')->check()){
        $adminName= SuperAdminLogin()->name;
        }elseif (Auth::guard('team_leader')->check()) {
            $adminName= TeamLeaderLogin()->name;
        }elseif (Auth::guard('project_manager')->check()) {
            $adminName= ProjectManagerLogin()->name;
        }elseif (Auth::guard('employee')->check()) {
            $adminName= EmpLogin()->name;
        }


        // Stats with realistic data (you can replace with actual DB counts)
        $totalUsers = \App\Models\User::count() ?? 0;
        $totalTask = \App\Models\AddTask::count() ?? 0;
        $totalProducts = \App\Models\Project::count() ?? 0;
        $totalOrders = \App\Models\AssingTask::count() ?? 0;
        $totalReveneu = \App\Models\LeadCreate::where('lead_status','converted')->sum('budget');

        // Calculate percentage changes (mock data - replace with actual logic)
        $userGrowth = $totalUsers > 0 ? rand(5, 20) : 0;
        $bookingGrowth = $totalTask > 0 ? rand(3, 15) : 0;
        $productGrowth = $totalProducts > 0 ? rand(2, 10) : 0;
        $orderGrowth = $totalOrders > 0 ? rand(1, 8) : 0;
    @endphp



    <div class="relative z-10 min-h-screen py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">

            {{-- Greeting Section --}}
            <div class="greeting-card rounded-2xl shadow-xl mb-8 overflow-hidden animate-fade-up">
                <div class="px-6 py-6 md:px-8 md:py-8">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                                <i class="{{ $greetingIcon }} text-3xl {{ $greetingColor }}"></i>
                            </div>
                            <div>
                                <h1 class="text-2xl md:text-3xl font-bold text-white">
                                    {{ $greeting }}, {{ $adminName }}!
                                </h1>
                                <p class="text-white/80 mt-1 flex items-center gap-2">
                                    <i class="fas fa-calendar-alt text-sm"></i>
                                    {{ $currentDate }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="bg-white/20 backdrop-blur-sm rounded-full px-4 py-2">
                                <i class="fas fa-chart-line text-white mr-2"></i>
                                <span class="text-white text-sm font-medium">Welcome to your dashboard</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(Auth::guard('super_admin')->check())


            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Users Card -->
                <div class="stat-card bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-500 animate-slide-left"
                    style="animation-delay: 0.1s">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm font-medium uppercase tracking-wide">Total Users</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $totalUsers ?? 0 }}</h3>
                            <div class="mt-3 flex items-center gap-1">
                                <span class="text-xs text-green-600 bg-green-100 px-2 py-0.5 rounded-full">
                                    <i class="fas fa-arrow-up text-xs"></i> {{ $userGrowth }}%
                                </span>
                                <span class="text-xs text-gray-400">vs last month</span>
                            </div>
                        </div>
                        <div
                            class="icon-wrapper w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg">
                            <i class="fas fa-users text-white text-xl"></i>
                        </div>
                    </div>
                    
                </div>

                <div class="stat-card bg-white rounded-2xl shadow-lg p-6 border-l-4 border-emerald-500 animate-slide-left"
                    style="animation-delay: 0.2s">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm font-medium uppercase tracking-wide">Total Projects</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $totalProducts ?? 0 }}</h3>
                            <div class="mt-3 flex items-center gap-1">
                                <span class="text-xs text-green-600 bg-green-100 px-2 py-0.5 rounded-full">
                                    <i class="fas fa-arrow-up text-xs"></i> {{ $bookingGrowth }}%
                                </span>
                                <span class="text-xs text-gray-400">vs last month</span>
                            </div>
                        </div>
                        <div
                            class="icon-wrapper w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-lg">
                            <i class="fas fa-calendar-check text-white text-xl"></i>
                        </div>
                    </div>

                </div>

                <!-- Total Projects Card -->
                <div class="stat-card bg-white rounded-2xl shadow-lg p-6 border-l-4 border-purple-500 animate-slide-left"
                    style="animation-delay: 0.3s">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm font-medium uppercase tracking-wide">Total Revenue</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $totalReveneu}}</h3>
                            <div class="mt-3 flex items-center gap-1">
                                <span class="text-xs text-green-600 bg-green-100 px-2 py-0.5 rounded-full">
                                    <i class="fas fa-arrow-up text-xs"></i> {{ $productGrowth }}%
                                </span>
                                <span class="text-xs text-gray-400">vs last month</span>
                            </div>
                        </div>
                        <div
                            class="icon-wrapper w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center shadow-lg">
                            <i class="fas fa-project-diagram text-white text-xl"></i>
                        </div>
                    </div>

                </div>

                <!-- Total Tasks Card -->
                <div class="stat-card bg-white rounded-2xl shadow-lg p-6 border-l-4 border-orange-500 animate-slide-left"
                    style="animation-delay: 0.4s">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm font-medium uppercase tracking-wide">Total Tasks</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-2">{{    $totalTask  ?? 0  }}</h3>
                            <div class="mt-3 flex items-center gap-1">
                                <span class="text-xs text-green-600 bg-green-100 px-2 py-0.5 rounded-full">
                                    <i class="fas fa-arrow-up text-xs"></i> {{ $orderGrowth }}%
                                </span>
                                <span class="text-xs text-gray-400">vs last month</span>
                            </div>
                        </div>
                        <div
                            class="icon-wrapper w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center shadow-lg">
                            <i class="fas fa-tasks text-white text-xl"></i>
                        </div>
                    </div>

                </div>
            </div>
            @else
               <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Users Card -->
                <div class="stat-card bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-500 animate-slide-left"
                    style="animation-delay: 0.1s">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm font-medium uppercase tracking-wide">Total Users</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-2">0</h3>
                            <div class="mt-3 flex items-center gap-1">
                                <span class="text-xs text-green-600 bg-green-100 px-2 py-0.5 rounded-full">
                                    <i class="fas fa-arrow-up text-xs"></i> {{ $userGrowth }}%
                                </span>
                                <span class="text-xs text-gray-400">vs last month</span>
                            </div>
                        </div>
                        <div
                            class="icon-wrapper w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg">
                            <i class="fas fa-users text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-100">
                        <a href="#"
                            class="text-xs text-blue-600 hover:text-blue-700 font-medium flex items-center gap-1">
                            View all users <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- Active Bookings Card -->
                <div class="stat-card bg-white rounded-2xl shadow-lg p-6 border-l-4 border-emerald-500 animate-slide-left"
                    style="animation-delay: 0.2s">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm font-medium uppercase tracking-wide">Active Bookings</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-2">0</h3>
                            <div class="mt-3 flex items-center gap-1">
                                <span class="text-xs text-green-600 bg-green-100 px-2 py-0.5 rounded-full">
                                    <i class="fas fa-arrow-up text-xs"></i> {{ $bookingGrowth }}%
                                </span>
                                <span class="text-xs text-gray-400">vs last month</span>
                            </div>
                        </div>
                        <div
                            class="icon-wrapper w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-lg">
                            <i class="fas fa-calendar-check text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-100">
                        <a href="#"
                            class="text-xs text-emerald-600 hover:text-emerald-700 font-medium flex items-center gap-1">
                            Manage bookings <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- Total Projects Card -->
                <div class="stat-card bg-white rounded-2xl shadow-lg p-6 border-l-4 border-purple-500 animate-slide-left"
                    style="animation-delay: 0.3s">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm font-medium uppercase tracking-wide">Total Projects</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-2">0</h3>
                            <div class="mt-3 flex items-center gap-1">
                                <span class="text-xs text-green-600 bg-green-100 px-2 py-0.5 rounded-full">
                                    <i class="fas fa-arrow-up text-xs"></i> {{ $productGrowth }}%
                                </span>
                                <span class="text-xs text-gray-400">vs last month</span>
                            </div>
                        </div>
                        <div
                            class="icon-wrapper w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center shadow-lg">
                            <i class="fas fa-project-diagram text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-100">
                        <a href="{{ route('project.list') }}"
                            class="text-xs text-purple-600 hover:text-purple-700 font-medium flex items-center gap-1">
                            View projects <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- Total Tasks Card -->
                <div class="stat-card bg-white rounded-2xl shadow-lg p-6 border-l-4 border-orange-500 animate-slide-left"
                    style="animation-delay: 0.4s">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm font-medium uppercase tracking-wide">Total Tasks</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-2">0</h3>
                            <div class="mt-3 flex items-center gap-1">
                                <span class="text-xs text-green-600 bg-green-100 px-2 py-0.5 rounded-full">
                                    <i class="fas fa-arrow-up text-xs"></i> {{ $orderGrowth }}%
                                </span>
                                <span class="text-xs text-gray-400">vs last month</span>
                            </div>
                        </div>
                        <div
                            class="icon-wrapper w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center shadow-lg">
                            <i class="fas fa-tasks text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-100">
                        <a href="#"
                            class="text-xs text-orange-600 hover:text-orange-700 font-medium flex items-center gap-1">
                            View tasks <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endif



            {{-- Charts and Activity Section --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

                {{-- Chart Card --}}
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg p-6 animate-fade-up" style="animation-delay: 0.2s">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Analytics Overview</h3>
                            <p class="text-sm text-gray-500">Task completion trends over time</p>
                        </div>
                        <div class="flex gap-2">
                            <button
                                class="px-3 py-1 text-xs bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition">Weekly</button>
                            <button
                                class="px-3 py-1 text-xs bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition">Monthly</button>
                            <button
                                class="px-3 py-1 text-xs bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition">Yearly</button>
                        </div>
                    </div>
                    <canvas id="analyticsChart" height="250"></canvas>
                </div>

                {{-- Quick Actions Card --}}
                <div class="bg-white rounded-2xl shadow-lg p-6 animate-fade-up" style="animation-delay: 0.3s">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-bolt text-orange-500"></i>
                        Quick Actions
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('project.create') }}"
                            class="quick-action-btn flex items-center gap-3 p-3 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl hover:from-blue-100 hover:to-blue-200 transition group">
                            <div class="w-10 h-10 rounded-xl bg-blue-500 flex items-center justify-center shadow-sm">
                                <i class="fas fa-folder-open text-white text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800">Create New Project</p>
                                <p class="text-xs text-gray-500">Start a new project today</p>
                            </div>
                            <i
                                class="fas fa-arrow-right text-gray-400 group-hover:text-blue-500 group-hover:translate-x-1 transition"></i>
                        </a>

                        <a href=""
                            class="quick-action-btn flex items-center gap-3 p-3 bg-gradient-to-r from-emerald-50 to-emerald-100 rounded-xl hover:from-emerald-100 hover:to-emerald-200 transition group">
                            <div class="w-10 h-10 rounded-xl bg-emerald-500 flex items-center justify-center shadow-sm">
                                <i class="fas fa-plus-circle text-white text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800">Add New Task</p>
                                <p class="text-xs text-gray-500">Assign tasks to team members</p>
                            </div>
                            <i
                                class="fas fa-arrow-right text-gray-400 group-hover:text-emerald-500 group-hover:translate-x-1 transition"></i>
                        </a>

                        <a href=""
                            class="quick-action-btn flex items-center gap-3 p-3 bg-gradient-to-r from-purple-50 to-purple-100 rounded-xl hover:from-purple-100 hover:to-purple-200 transition group">
                            <div class="w-10 h-10 rounded-xl bg-purple-500 flex items-center justify-center shadow-sm">
                                <i class="fas fa-user-plus text-white text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800">Add Employee</p>
                                <p class="text-xs text-gray-500">Onboard new team members</p>
                            </div>
                            <i
                                class="fas fa-arrow-right text-gray-400 group-hover:text-purple-500 group-hover:translate-x-1 transition"></i>
                        </a>

                        <a href=""
                            class="quick-action-btn flex items-center gap-3 p-3 bg-gradient-to-r from-orange-50 to-orange-100 rounded-xl hover:from-orange-100 hover:to-orange-200 transition group">
                            <div class="w-10 h-10 rounded-xl bg-orange-500 flex items-center justify-center shadow-sm">
                                <i class="fas fa-arrows-alt text-white text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800">Drag & Drop Assignment</p>
                                <p class="text-xs text-gray-500">Quick task assignment</p>
                            </div>
                            <i
                                class="fas fa-arrow-right text-gray-400 group-hover:text-orange-500 group-hover:translate-x-1 transition"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Recent Activity & Notifications --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Recent Activity Feed --}}
                <div class="bg-white rounded-2xl shadow-lg p-6 animate-fade-up" style="animation-delay: 0.4s">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-history text-blue-500"></i>
                            Recent Activity
                        </h3>
                        <a href="#" class="text-xs text-blue-600 hover:text-blue-700">View all</a>
                    </div>
                    <div class="space-y-3 max-h-80 overflow-y-auto custom-scrollbar">
                        <div class="activity-item flex items-start gap-3 p-3 rounded-xl transition">
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check-circle text-green-600 text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800">Task completed</p>
                                <p class="text-xs text-gray-400">2 minutes ago</p>
                            </div>
                        </div>

                        <div class="activity-item flex items-start gap-3 p-3 rounded-xl transition">
                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-user-plus text-blue-600 text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800">New employee added</p>
                                <p class="text-xs text-gray-400">1 hour ago</p>
                            </div>
                        </div>

                        <div class="activity-item flex items-start gap-3 p-3 rounded-xl transition">
                            <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-folder-open text-orange-600 text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800">New project created: "E-Commerce Platform"</p>
                                <p class="text-xs text-gray-400">3 hours ago</p>
                            </div>
                        </div>

                        <div class="activity-item flex items-start gap-3 p-3 rounded-xl transition">
                            <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-tasks text-purple-600 text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800">Task assigned to John Doe</p>
                                <p class="text-xs text-gray-400">Yesterday</p>
                            </div>
                        </div>

                        <div class="activity-item flex items-start gap-3 p-3 rounded-xl transition">
                            <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-clock text-yellow-600 text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800">Pending deadline: "Mobile App Development"</p>
                                <p class="text-xs text-gray-400">2 days ago</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Quick Stats / Progress Card --}}
                <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl shadow-lg p-6 animate-fade-up"
                    style="animation-delay: 0.5s">
                    <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-chart-pie text-orange-400"></i>
                        Project Status Overview
                    </h3>
                    <div class="space-y-4">
                        @php
                            $totalProjects = $totalProducts;
                            $ongoing = \App\Models\Project::where('status', 'ongoing')->count();
                            $completed = \App\Models\Project::where('status', 'completed')->count();
                            $pending = \App\Models\Project::where('status', 'pending')->count();
                            $ongoingPercent = $totalProjects > 0 ? round(($ongoing / $totalProjects) * 100) : 0;
                            $completedPercent = $totalProjects > 0 ? round(($completed / $totalProjects) * 100) : 0;
                            $pendingPercent = $totalProjects > 0 ? round(($pending / $totalProjects) * 100) : 0;
                        @endphp

                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-300">Ongoing Projects</span>
                                <span class="text-blue-400 font-semibold">{{ $ongoingPercent }}%</span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full transition-all duration-500"
                                    style="width: {{ $ongoingPercent }}%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-300">Completed Projects</span>
                                <span class="text-emerald-400 font-semibold">{{ $completedPercent }}%</span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-2">
                                <div class="bg-emerald-500 h-2 rounded-full transition-all duration-500"
                                    style="width: {{ $completedPercent }}%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-300">Pending Projects</span>
                                <span class="text-orange-400 font-semibold">{{ $pendingPercent }}%</span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-2">
                                <div class="bg-orange-500 h-2 rounded-full transition-all duration-500"
                                    style="width: {{ $pendingPercent }}%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-700">
                        <div class="flex justify-between text-sm">
                            <div class="text-center flex-1">
                                <p class="text-2xl font-bold text-white">{{ $ongoing }}</p>
                                <p class="text-xs text-gray-400">Ongoing</p>
                            </div>
                            <div class="text-center flex-1">
                                <p class="text-2xl font-bold text-white">{{ $completed }}</p>
                                <p class="text-xs text-gray-400">Completed</p>
                            </div>
                            <div class="text-center flex-1">
                                <p class="text-2xl font-bold text-white">{{ $pending }}</p>
                                <p class="text-xs text-gray-400">Pending</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer Note --}}
            <div class="mt-8 text-center text-gray-400 text-sm">
                <i class="fas fa-chart-line mr-1"></i>
                Dashboard updated in real-time • Last sync: {{ now()->format('h:i A') }}
            </div>

        </div>
    </div>

    <script>
        // Analytics Chart
        const ctx = document.getElementById('analyticsChart').getContext('2d');
        const analyticsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Tasks Completed',
                    data: [12, 19, 15, 17, 14, 23, 28, 35, 42, 48, 55, 62],
                    borderColor: '#f97316',
                    backgroundColor: 'rgba(249, 115, 22, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#f97316',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }, {
                    label: 'Tasks In Progress',
                    data: [8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30],
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#3b82f6',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 8,
                            font: {
                                size: 11
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        titleColor: '#f97316',
                        bodyColor: '#fff',
                        borderColor: '#f97316',
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: true
                    }
                },
                scales: {
                    y: {
                        grid: {
                            color: '#e5e7eb',
                            drawBorder: false
                        },
                        ticks: {
                            stepSize: 10,
                            font: {
                                size: 10
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });

        // Animate numbers on load
        document.addEventListener('DOMContentLoaded', function() {
            const numbers = document.querySelectorAll('.stat-card h3');
            numbers.forEach(number => {
                const finalValue = parseInt(number.innerText);
                let currentValue = 0;
                const duration = 1000;
                const step = finalValue / (duration / 16);

                const timer = setInterval(() => {
                    currentValue += step;
                    if (currentValue >= finalValue) {
                        number.innerText = finalValue.toLocaleString();
                        clearInterval(timer);
                    } else {
                        number.innerText = Math.floor(currentValue).toLocaleString();
                    }
                }, 16);
            });
        });
    </script>

    <style>
        .stat-card h3 {
            transition: all 0.3s ease;
        }

        canvas {
            max-height: 280px;
        }
    </style>

@endsection
