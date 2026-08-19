@extends('admin.include.layout')
@section('heading', 'Projects')
@section('title', 'Project Details')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .animate-fade-up {
            animation: fadeInUp 0.5s ease-out;
        }

        .animate-slide-left {
            animation: slideInLeft 0.4s ease-out;
        }

        .detail-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .detail-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.1);
        }

        .info-row {
            display: flex;
            padding: 12px 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            width: 160px;
            flex-shrink: 0;
            font-weight: 600;
            color: #6b7280;
            font-size: 0.875rem;
        }

        .info-value {
            flex: 1;
            color: #1f2937;
            font-size: 0.875rem;
            word-break: break-word;
        }

        .team-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 600;
            color: white;
            flex-shrink: 0;
        }

        .team-avatar.pm {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
        }
        .team-avatar.dev {
            background: linear-gradient(135deg, #22c55e, #16a34a);
        }
        .team-avatar.design {
            background: linear-gradient(135deg, #ec4899, #db2777);
        }
        .team-avatar.qa {
            background: linear-gradient(135deg, #eab308, #ca8a04);
        }

        .team-card {
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .team-card:hover {
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

        .infra-tag {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
            margin: 2px 4px 2px 0;
        }

        .infra-tag.ssl {
            background: #eff6ff;
            color: #1e40af;
            border-color: #bfdbfe;
        }

        .infra-tag.hosting {
            background: #eff6ff;
            color: #92400e;
            border-color: #bfdbfe;
        }

        .infra-tag.domain {
            background: #fce7f3;
            color: #9d174d;
            border-color: #f9a8d4;
        }

        .infra-tag.api {
            background: #ede9fe;
            color: #5b21b6;
            border-color: #c4b5fd;
        }

        .infra-tag.dns {
            background: #dbeafe;
            color: #1e40af;
            border-color: #bfdbfe;
        }

        .infra-tag.cdn {
            background: #fefce8;
            color: #a16207;
            border-color: #bfdbfe;
        }

        .module-chip {
            display: inline-block;
            padding: 6px 16px;
            background: linear-gradient(135deg, #eff6ff, #bfdbfe);
            color: #92400e;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            margin: 3px 5px 3px 0;
            border: 1px solid #fcd34d;
            transition: all 0.2s ease;
        }

        .module-chip:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(251, 191, 36, 0.3);
        }

        .status-badge-large {
            padding: 8px 20px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .progress-ring {
            width: 80px;
            height: 80px;
        }

        .stat-box {
            background: white;
            border-radius: 16px;
            padding: 16px 20px;
            border: 1px solid #f3f4f6;
            transition: all 0.3s ease;
        }

        .stat-box:hover {
            border-color: #60a5fa;
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.08);
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .stat-icon.orange {
            background: #fff7ed;
            color: #2563eb;
        }
        .stat-icon.blue {
            background: #eff6ff;
            color: #3b82f6;
        }
        .stat-icon.green {
            background: #f0fdf4;
            color: #22c55e;
        }
        .stat-icon.purple {
            background: #f5f3ff;
            color: #8b5cf6;
        }
        .stat-icon.red {
            background: #fef2f2;
            color: #ef4444;
        }
    </style>

    @php
        // Static project data
        $project = (object) [
            'id' => 1,
            'name' => 'E-Commerce Platform Development',
            'description' => 'A full-featured e-commerce platform with payment gateway integration, inventory management, user authentication, and real-time order tracking system. The platform will support multiple vendors and provide a seamless shopping experience for customers.',
            'status' => 'ongoing',
            'priority' => 'high',
            'start_date' => '2025-01-15 09:00:00',
            'end_date' => '2025-06-30 18:00:00',
            'project_manager' => 'John Anderson',
            'developer' => 'Sarah Chen, Michael Rodriguez',
            'designer' => 'Emily Davis',
            'qa_engineer' => 'Robert Wilson',
            'domain_name' => 'shopverse.com',
            'domain_registrar' => 'GoDaddy',
            'hosting_provider' => 'AWS (Amazon Web Services)',
            'hosting_account_owner' => 'IT Department',
            'ssl_certificate' => 'active',
            'email_service_provider' => 'Google Workspace',
            'dns_management' => 'Cloudflare',
            'cdn_provider' => 'Cloudflare CDN',
            'third_party_apis' => 'Stripe, PayPal, Google Maps, SendGrid',
            'renewal_date' => '2026-01-15',
            'responsible_team_member' => 'Sarah Johnson (DevOps Lead)',
            'modules' => ['User Authentication', 'Product Catalog', 'Shopping Cart', 'Payment Gateway', 'Order Management', 'Inventory Management', 'Vendor Dashboard', 'Admin Panel', 'Customer Reviews', 'Analytics Dashboard'],
            'created_by' => (object) ['name' => 'Admin User', 'email' => 'admin@example.com'],
            'created_at' => '2025-01-10 10:30:00',
            'updated_at' => '2025-01-25 14:45:00',
        ];

        $modules = $project->modules;
        $statusColors = [
            'pending' => ['bg' => 'bg-cyan-100', 'text' => 'text-amber-700', 'border' => 'border-cyan-200', 'icon' => 'fa-clock', 'label' => 'Pending'],
            'ongoing' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'border' => 'border-blue-200', 'icon' => 'fa-spinner', 'label' => 'Ongoing'],
            'completed' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'icon' => 'fa-check-circle', 'label' => 'Completed'],
        ];
        $priorityColors = [
            'low' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'border' => 'border-green-200', 'icon' => 'fa-arrow-down', 'label' => 'Low Priority'],
            'medium' => ['bg' => 'bg-blue-100', 'text' => 'text-cyan-600', 'border' => 'border-blue-200', 'icon' => 'fa-minus', 'label' => 'Medium Priority'],
            'high' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'border' => 'border-red-200', 'icon' => 'fa-arrow-up', 'label' => 'High Priority'],
        ];
        $currentStatus = $statusColors[$project->status] ?? $statusColors['pending'];
        $currentPriority = $priorityColors[$project->priority] ?? $priorityColors['medium'];

        $teamMembers = [
            ['role' => 'Project Manager', 'key' => 'project_manager', 'icon' => 'fa-user-tie', 'class' => 'pm'],
            ['role' => 'Developer', 'key' => 'developer', 'icon' => 'fa-code', 'class' => 'dev'],
            ['role' => 'Designer', 'key' => 'designer', 'icon' => 'fa-paint-brush', 'class' => 'design'],
            ['role' => 'QA Engineer', 'key' => 'qa_engineer', 'icon' => 'fa-bug', 'class' => 'qa'],
        ];

        $infraFields = [
            ['label' => 'Domain Name', 'key' => 'domain_name', 'icon' => 'fa-globe', 'class' => 'domain'],
            ['label' => 'Domain Registrar', 'key' => 'domain_registrar', 'icon' => 'fa-building', 'class' => 'domain'],
            ['label' => 'Hosting Provider', 'key' => 'hosting_provider', 'icon' => 'fa-cloud', 'class' => 'hosting'],
            ['label' => 'Hosting Account Owner', 'key' => 'hosting_account_owner', 'icon' => 'fa-user-circle', 'class' => 'hosting'],
            ['label' => 'SSL Certificate', 'key' => 'ssl_certificate', 'icon' => 'fa-lock', 'class' => 'ssl'],
            ['label' => 'Email Service Provider', 'key' => 'email_service_provider', 'icon' => 'fa-envelope', 'class' => 'hosting'],
            ['label' => 'DNS Management', 'key' => 'dns_management', 'icon' => 'fa-sitemap', 'class' => 'dns'],
            ['label' => 'CDN Provider', 'key' => 'cdn_provider', 'icon' => 'fa-network-wired', 'class' => 'cdn'],
            ['label' => 'Third Party APIs', 'key' => 'third_party_apis', 'icon' => 'fa-plug', 'class' => 'api'],
            ['label' => 'Renewal Date', 'key' => 'renewal_date', 'icon' => 'fa-calendar-plus', 'class' => 'domain'],
            ['label' => 'Responsible Team Member', 'key' => 'responsible_team_member', 'icon' => 'fa-users', 'class' => 'hosting'],
        ];

        $daysLeft = $project->end_date ? \Carbon\Carbon::parse($project->end_date)->diffInDays(now(), false) : null;
        $isOverdue = $project->end_date && \Carbon\Carbon::parse($project->end_date)->isPast() && $project->status != 'completed';
        $progress = $project->status == 'completed' ? 100 : ($project->status == 'ongoing' ? 60 : 20);
        $hasTeam = false;
        foreach ($teamMembers as $member) {
            if ($project->{$member['key']}) {
                $hasTeam = true;
                break;
            }
        }
        $hasInfra = false;
        foreach ($infraFields as $infra) {
            if ($project->{$infra['key']}) {
                $hasInfra = true;
                break;
            }
        }

        // Format dates
        $startDate = \Carbon\Carbon::parse($project->start_date);
        $endDate = $project->end_date ? \Carbon\Carbon::parse($project->end_date) : null;
        $createdAt = \Carbon\Carbon::parse($project->created_at);
        $updatedAt = \Carbon\Carbon::parse($project->updated_at);
    @endphp

    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-50 to-blue-50/20 py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">

            {{-- Floating Background Elements --}}
            <div class="fixed inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-20 right-10 w-72 h-72 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
                <div class="absolute bottom-20 left-10 w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 2s;"></div>
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-purple-200 rounded-full filter blur-3xl opacity-10 animate-pulse" style="animation-delay: 4s;"></div>
            </div>

            {{-- HEADER SECTION --}}
            <div class="relative mb-6 animate-fade-up">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-blue-500 to-cyan-500 opacity-5 rounded-full transform translate-x-32 -translate-y-32"></div>
                    <div class="relative px-6 py-6 md:px-8 md:py-8">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center shadow-lg transform rotate-3 hover:rotate-6 transition-all duration-300">
                                    <i class="fas fa-folder-open text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h1 class="text-2xl md:text-3xl font-black text-gray-800 tracking-tight">
                                        {{ $project->name }}
                                    </h1>
                                    <p class="text-gray-500 mt-1 flex items-center gap-2">
                                        <i class="fas fa-hashtag text-blue-500 text-sm"></i>
                                        Project ID: #{{ str_pad($project->id, 4, '0', STR_PAD_LEFT) }}
                                        <span class="mx-2">|</span>
                                        <i class="fas fa-calendar-alt text-gray-400 text-sm"></i>
                                        Created: {{ $createdAt->format('d M, Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="status-badge-large {{ $currentStatus['bg'] }} {{ $currentStatus['text'] }} border {{ $currentStatus['border'] }}">
                                    <i class="fas {{ $currentStatus['icon'] }}"></i>
                                    {{ $currentStatus['label'] }}
                                </span>
                                <span class="status-badge-large {{ $currentPriority['bg'] }} {{ $currentPriority['text'] }} border {{ $currentPriority['border'] }}">
                                    <i class="fas {{ $currentPriority['icon'] }}"></i>
                                    {{ $currentPriority['label'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- QUICK STATS --}}
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6 animate-fade-up" style="animation-delay: 0.05s">
                <div class="stat-box">
                    <div class="flex items-center gap-3">
                        <div class="stat-icon orange"><i class="fas fa-chart-line"></i></div>
                        <div>
                            <p class="text-xs text-gray-500 font-medium">Progress</p>
                            <p class="text-xl font-bold text-gray-800">{{ $progress }}%</p>
                        </div>
                    </div>
                    <div class="w-full h-1.5 bg-gray-200 rounded-full mt-3 overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full" style="width: {{ $progress }}%"></div>
                    </div>
                </div>
                <div class="stat-box">
                    <div class="flex items-center gap-3">
                        <div class="stat-icon blue"><i class="fas fa-calendar-check"></i></div>
                        <div>
                            <p class="text-xs text-gray-500 font-medium">Start Date</p>
                            <p class="text-sm font-bold text-gray-800">{{ $startDate->format('d M, Y') }}</p>
                        </div>
                    </div>
                </div>
                <div class="stat-box">
                    <div class="flex items-center gap-3">
                        <div class="stat-icon {{ $isOverdue ? 'red' : 'green' }}"><i class="fas fa-calendar-times"></i></div>
                        <div>
                            <p class="text-xs text-gray-500 font-medium">End Date</p>
                            <p class="text-sm font-bold {{ $isOverdue ? 'text-red-600' : 'text-gray-800' }}">
                                {{ $endDate ? $endDate->format('d M, Y') : 'Not Set' }}
                            </p>
                        </div>
                    </div>
                    @if($endDate && $daysLeft !== null)
                        <p class="text-xs {{ $isOverdue ? 'text-red-500' : ($daysLeft < 7 ? 'text-cyan-500' : 'text-gray-400') }} mt-1">
                            @if($isOverdue)
                                <i class="fas fa-exclamation-triangle"></i> Overdue
                            @elseif($daysLeft < 7)
                                <i class="fas fa-clock"></i> {{ $daysLeft }} days left
                            @else
                                <i class="fas fa-hourglass-half"></i> {{ $daysLeft }} days remaining
                            @endif
                        </p>
                    @endif
                </div>
                <div class="stat-box">
                    <div class="flex items-center gap-3">
                        <div class="stat-icon purple"><i class="fas fa-cubes"></i></div>
                        <div>
                            <p class="text-xs text-gray-500 font-medium">Modules</p>
                            <p class="text-xl font-bold text-gray-800">{{ count($modules) }}</p>
                        </div>
                    </div>
                </div>
                <div class="stat-box">
                    <div class="flex items-center gap-3">
                        <div class="stat-icon blue"><i class="fas fa-users"></i></div>
                        <div>
                            <p class="text-xs text-gray-500 font-medium">Team Members</p>
                            <p class="text-xl font-bold text-gray-800">
                                @php
                                    $teamCount = 0;
                                    foreach ($teamMembers as $member) {
                                        if ($project->{$member['key']}) $teamCount++;
                                    }
                                @endphp
                                {{ $teamCount }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- LEFT COLUMN (2/3 width) --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- DESCRIPTION CARD --}}
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 detail-card">
                        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-blue-50 border-b border-gray-200">
                            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                <i class="fas fa-align-left text-blue-500"></i>
                                Project Description
                            </h3>
                        </div>
                        <div class="p-6">
                            <p class="text-gray-700 leading-relaxed text-base">{{ $project->description }}</p>
                        </div>
                    </div>

                    {{-- MODULES CARD --}}
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 detail-card">
                        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-blue-50 border-b border-gray-200">
                            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                <i class="fas fa-cubes text-blue-500"></i>
                                Project Modules
                                <span class="ml-2 text-sm font-normal text-gray-500">({{ count($modules) }} modules)</span>
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="flex flex-wrap">
                                @foreach($modules as $module)
                                    <span class="module-chip">
                                        <i class="fas fa-microchip text-cyan-500 mr-1"></i>
                                        {{ $module }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- INFRASTRUCTURE RESOURCES CARD --}}
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 detail-card">
                        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-blue-50 border-b border-gray-200">
                            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                <i class="fas fa-server text-blue-600"></i>
                                Infrastructure Resources
                            </h3>
                        </div>
                        <div class="p-6">
                            @if($hasInfra)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($infraFields as $infra)
                                        @if($project->{$infra['key']})
                                            <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-xl hover:bg-blue-50 transition-all duration-200">
                                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center flex-shrink-0">
                                                    <i class="fas {{ $infra['icon'] }} text-blue-600 text-sm"></i>
                                                </div>
                                                <div>
                                                    <p class="text-xs font-semibold text-gray-500">{{ $infra['label'] }}</p>
                                                    <p class="text-sm font-medium text-gray-800">{{ $project->{$infra['key']} }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-400 text-center py-4">No infrastructure resources configured</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- RIGHT COLUMN (1/3 width) --}}
                <div class="lg:col-span-1 space-y-6">

                    {{-- TEAM MEMBERS CARD --}}
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 detail-card sticky top-6">
                        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-blue-50 border-b border-gray-200">
                            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                <i class="fas fa-users text-purple-600"></i>
                                Human Resources
                            </h3>
                        </div>
                        <div class="p-6 space-y-4">
                            @php $hasTeam = false; @endphp
                            @foreach($teamMembers as $member)
                                @if($project->{$member['key']})
                                    @php $hasTeam = true; @endphp
                                    <div class="team-card bg-gradient-to-br from-gray-50 to-gray-100/50 rounded-xl p-4 border border-gray-200 hover:border-purple-300 transition-all duration-200">
                                        <div class="flex items-center gap-4">
                                            <div class="team-avatar {{ $member['class'] }}">
                                                <i class="fas {{ $member['icon'] }}"></i>
                                            </div>
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2">
                                                    <span class="role-badge {{ $member['class'] }}">{{ $member['role'] }}</span>
                                                </div>
                                                <p class="font-semibold text-gray-800 text-sm mt-1">{{ $project->{$member['key']} }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            @if(!$hasTeam)
                                <p class="text-gray-400 text-center py-4">No team members assigned</p>
                            @endif
                        </div>
                    </div>

                    {{-- PROJECT METADATA CARD --}}
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 detail-card">
                        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-blue-50 border-b border-gray-200">
                            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                <i class="fas fa-info-circle text-blue-500"></i>
                                Project Metadata
                            </h3>
                        </div>
                        <div class="p-6 space-y-1">
                            <div class="info-row">
                                <span class="info-label"><i class="fas fa-user text-gray-400 mr-2"></i> Created By</span>
                                <span class="info-value">
                                    <span class="font-medium">{{ $project->created_by->name }}</span>
                                    <span class="text-gray-400 text-xs block">{{ $project->created_by->email }}</span>
                                </span>
                            </div>
                            <div class="info-row">
                                <span class="info-label"><i class="fas fa-calendar-plus text-gray-400 mr-2"></i> Created At</span>
                                <span class="info-value">{{ $createdAt->format('d M, Y h:i A') }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label"><i class="fas fa-edit text-gray-400 mr-2"></i> Last Updated</span>
                                <span class="info-value">{{ $updatedAt->format('d M, Y h:i A') }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label"><i class="fas fa-clock text-gray-400 mr-2"></i> Timezone</span>
                                <span class="info-value">{{ config('app.timezone') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- ACTION BUTTONS CARD --}}
                    <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl p-5 border border-blue-100">
                        <div class="space-y-3">
                            <a href="#" class="w-full inline-flex items-center justify-center gap-2 bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-cyan-500 hover:to-cyan-600 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200">
                                <i class="fas fa-edit"></i>
                                Edit Project
                            </a>
                            <a href="#" class="w-full inline-flex items-center justify-center gap-2 bg-white hover:bg-gray-50 text-gray-700 px-6 py-3 rounded-xl font-semibold border-2 border-gray-200 hover:border-blue-300 transition-all duration-200">
                                <i class="fas fa-tasks"></i>
                                View Tasks
                            </a>
                            <a href="#" class="w-full inline-flex items-center justify-center gap-2 bg-white hover:bg-gray-50 text-gray-700 px-6 py-3 rounded-xl font-semibold border-2 border-gray-200 hover:border-blue-300 transition-all duration-200">
                                <i class="fas fa-chart-pie"></i>
                                View Reports
                            </a>
                            <a href="{{ route('project.list') }}" class="w-full inline-flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-600 px-6 py-3 rounded-xl font-semibold transition-all duration-200">
                                <i class="fas fa-arrow-left"></i>
                                Back to Projects
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- FOOTER TIMELINE --}}
            <div class="mt-6 bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 detail-card">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-blue-50 border-b border-gray-200">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-road text-blue-500"></i>
                        Project Timeline
                    </h3>
                </div>
                <div class="p-6">
                    <div class="relative">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex justify-between items-center">
                                    <div class="text-center">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-r from-green-500 to-green-600 flex items-center justify-center text-white text-xs font-bold mx-auto">
                                            <i class="fas fa-play"></i>
                                        </div>
                                        <p class="text-xs font-semibold text-gray-600 mt-2">Start</p>
                                        <p class="text-xs text-gray-400">{{ $startDate->format('d M, Y') }}</p>
                                    </div>

                                    <div class="flex-1 mx-4">
                                        <div class="relative h-2 bg-gray-200 rounded-full overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-blue-400 to-cyan-500 rounded-full" style="width: {{ $progress }}%"></div>
                                        </div>
                                        <div class="flex justify-between text-xs text-gray-400 mt-1">
                                            <span>0%</span>
                                            <span class="font-medium text-cyan-500">{{ $progress }}% Complete</span>
                                            <span>100%</span>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <div class="w-8 h-8 rounded-full {{ $project->status == 'completed' ? 'bg-gradient-to-r from-emerald-500 to-emerald-600' : 'bg-gray-300' }} flex items-center justify-center text-white text-xs font-bold mx-auto">
                                            <i class="fas {{ $project->status == 'completed' ? 'fa-check' : 'fa-flag-checkered' }}"></i>
                                        </div>
                                        <p class="text-xs font-semibold text-gray-600 mt-2">End</p>
                                        <p class="text-xs {{ $isOverdue ? 'text-red-500 font-semibold' : 'text-gray-400' }}">
                                            {{ $endDate ? $endDate->format('d M, Y') : 'Not Set' }}
                                            @if($isOverdue) <span class="block text-red-500">⚠️ Overdue</span> @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        // Add fade-in animation to elements
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.detail-card, .stat-box, .team-card, .module-chip');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 100 + (index * 50));
            });
        });
    </script>
@endsection
