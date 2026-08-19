@extends('admin.include.layout')
@section('heading', 'Projects')
@section('title', 'Project List')

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

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
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
            animation: fadeInUp 0.5s ease-out;
        }

        .animate-slide-left {
            animation: slideInLeft 0.4s ease-out;
        }

        .stat-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.1);
        }

        .table-row {
            transition: all 0.2s ease;
        }

        .table-row:hover {
            background-color: #eff6ff;
            transform: scale(1.01);
        }

        .action-btn {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .action-btn:hover {
            transform: translateY(-2px);
        }

        .status-badge {
            transition: all 0.2s ease;
        }

        .status-badge:hover {
            transform: scale(1.05);
        }

        .filter-active {
            background: linear-gradient(135deg, #2563eb 0%, #06b6d4 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.22);
        }

        .search-input:focus {
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #60a5fa;
            border-radius: 10px;
        }

        .team-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
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

        .infra-tag {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 500;
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .infra-tag.ssl {
            background: #eff6ff;
            color: #1e40af;
            border-color: #bfdbfe;
        }

        .infra-tag.hosting {
            background: #eff6ff;
            color: #1d4ed8;
            border-color: #bfdbfe;
        }

        @media (max-width: 767px) {
            #projectsTable thead {
                display: none;
            }

            #projectsTable,
            #projectsTable tbody,
            #projectsTable tr,
            #projectsTable td {
                display: block;
                width: 100%;
            }

            #projectsTable tr {
                margin-bottom: 1rem;
                border: 1px solid #e2e8f0;
                border-radius: 1rem;
                background: #fff;
                box-shadow: 0 12px 30px rgba(15, 36, 87, 0.08);
                overflow: hidden;
            }

            #projectsTable td {
                border: 0;
                padding: 0.85rem 1rem;
                white-space: normal !important;
            }

            #projectsTable td::before {
                content: attr(data-label);
                display: block;
                margin-bottom: 0.35rem;
                color: #64748b;
                font-size: 0.72rem;
                font-weight: 800;
                letter-spacing: 0.08em;
                text-transform: uppercase;
            }

            #projectsTable td:last-child {
                border-top: 1px solid #eef2f7;
            }

            .project-actions {
                justify-content: flex-start !important;
                flex-wrap: wrap;
            }
        }

        .infra-tag.domain {
            background: #fce7f3;
            color: #9d174d;
            border-color: #f9a8d4;
        }
    </style>

    @php
        $total = $projects->count();
        $ongoing = $projects->where('status', 'ongoing')->count();
        $completed = $projects->where('status', 'completed')->count();
        $pending = $projects->where('status', 'pending')->count();
        $highPriority = $projects->where('priority', 'high')->count();

        $statusColors = [
            'pending' => [
                'bg' => 'bg-amber-100',
                'text' => 'text-amber-700',
                'dot' => 'bg-amber-500',
                'icon' => 'fa-clock',
            ],
            'ongoing' => [
                'bg' => 'bg-blue-100',
                'text' => 'text-blue-700',
                'dot' => 'bg-blue-500',
                'icon' => 'fa-spinner',
            ],
            'completed' => [
                'bg' => 'bg-emerald-100',
                'text' => 'text-emerald-700',
                'dot' => 'bg-emerald-500',
                'icon' => 'fa-check-circle',
            ],
        ];

        $priorityColors = [
            'low' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'icon' => 'fa-arrow-down'],
            'medium' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'icon' => 'fa-minus'],
            'high' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'icon' => 'fa-arrow-up'],
        ];
    @endphp

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonColor: '#2563eb',
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
                title: 'Success!',
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
        $createProject = null;
        $editRoute = null;
        if (Auth::guard('marketing_manager')->check()) {
            $createProject = route('marketing.project.create');
        } elseif (Auth::guard('super_admin')->check()) {
            $createProject = route('project.create');
        } elseif (Auth::guard('project_manager')->check()) {
            $createProject = route('project.create');
        }
    @endphp

    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/40 to-cyan-50/20 py-4 px-3 sm:px-5 lg:px-8">
        <div class="max-w-[1500px] mx-auto">

            {{-- Floating Background Elements --}}
            <div class="fixed inset-0 overflow-hidden pointer-events-none">
                <div
                    class="absolute top-20 right-10 w-72 h-72 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse">
                </div>
                <div class="absolute bottom-20 left-10 w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"
                    style="animation-delay: 2s;"></div>
            </div>

            {{-- HEADER SECTION --}}
            <div class="relative mb-8 animate-fade-up">
                <div class="flex flex-col items-stretch justify-end gap-3 sm:flex-row sm:items-center">
                    <a href="{{ $createProject }}"
                        class="group inline-flex w-full items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white px-6 py-3 rounded-xl text-sm font-semibold shadow-lg transition-all duration-200 transform hover:scale-[1.02] sm:w-auto">
                        <i class="fas fa-plus"></i>
                        <span>Create New Project</span>
                        <i
                            class="fas fa-arrow-right opacity-0 group-hover:opacity-100 transition-all duration-200 translate-x-0 group-hover:translate-x-1"></i>
                    </a>

                    @if ($projects->hasPages())
                        <div class="inline-flex justify-center overflow-hidden rounded-xl bg-blue-600 shadow-lg shadow-blue-600/20 ring-1 ring-blue-500/30">
                            @if ($projects->onFirstPage())
                                <span class="grid h-12 w-12 place-items-center text-blue-200/70">
                                    <i class="fas fa-chevron-left"></i>
                                </span>
                            @else
                                <a href="{{ $projects->previousPageUrl() }}"
                                    class="grid h-12 w-12 place-items-center text-white transition hover:bg-cyan-500">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            @endif

                            @for ($page = 1; $page <= $projects->lastPage(); $page++)
                                @if ($page == $projects->currentPage())
                                    <span class="grid h-12 min-w-12 place-items-center bg-cyan-500 px-4 text-white">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $projects->url($page) }}"
                                        class="grid h-12 min-w-12 place-items-center px-4 text-blue-50 transition hover:bg-cyan-500 hover:text-white">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endfor

                            @if ($projects->hasMorePages())
                                <a href="{{ $projects->nextPageUrl() }}"
                                    class="grid h-12 w-12 place-items-center text-white transition hover:bg-cyan-500">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            @else
                                <span class="grid h-12 w-12 place-items-center text-blue-200/70">
                                    <i class="fas fa-chevron-right"></i>
                                </span>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            {{-- STATS CARDS --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5 mb-8 animate-fade-up"
                style="animation-delay: 0.1s">
                <div class="stat-card bg-white rounded-2xl shadow-lg border border-gray-100 p-5 cursor-pointer"
                    onclick="filterByStatus('all')">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Projects</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $total }}</p>
                            <p class="text-xs text-green-500 mt-1"><i class="fas fa-chart-line"></i> All projects</p>
                        </div>
                        <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl p-3 shadow-md">
                            <i class="fas fa-folder-open text-white text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card bg-white rounded-2xl shadow-lg border border-gray-100 p-5 cursor-pointer"
                    onclick="filterByStatus('ongoing')">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">In Progress</p>
                            <p class="text-3xl font-bold text-blue-600 mt-1">{{ $ongoing }}</p>
                            <p class="text-xs text-blue-500 mt-1"><i class="fas fa-play-circle"></i> Active projects</p>
                        </div>
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-3 shadow-md">
                            <i class="fas fa-spinner fa-pulse text-white text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card bg-white rounded-2xl shadow-lg border border-gray-100 p-5 cursor-pointer"
                    onclick="filterByStatus('completed')">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Completed</p>
                            <p class="text-3xl font-bold text-emerald-600 mt-1">{{ $completed }}</p>
                            <p class="text-xs text-emerald-500 mt-1"><i class="fas fa-trophy"></i> Successfully delivered
                            </p>
                        </div>
                        <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl p-3 shadow-md">
                            <i class="fas fa-check-circle text-white text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card bg-white rounded-2xl shadow-lg border border-gray-100 p-5 cursor-pointer"
                    onclick="filterByStatus('pending')">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Pending</p>
                            <p class="text-3xl font-bold text-amber-600 mt-1">{{ $pending }}</p>
                            <p class="text-xs text-amber-500 mt-1"><i class="fas fa-hourglass-half"></i> Awaiting start</p>
                        </div>
                        <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl p-3 shadow-md">
                            <i class="fas fa-clock text-white text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card bg-white rounded-2xl shadow-lg border border-gray-100 p-5 cursor-pointer"
                    onclick="filterByPriority('high')">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">High Priority</p>
                            <p class="text-3xl font-bold text-red-600 mt-1">{{ $highPriority }}</p>
                            <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-triangle"></i> Urgent
                                attention</p>
                        </div>
                        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl p-3 shadow-md">
                            <i class="fas fa-flag text-white text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SEARCH AND FILTER BAR --}}
            <div class="bg-white rounded-2xl shadow-lg p-4 mb-6 animate-fade-up" style="animation-delay: 0.15s">
                <div class="flex flex-col xl:flex-row gap-4">
                    <div class="flex-1 relative">
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" id="searchInput"
                            placeholder="Search projects by name, description, modules, team members, or domain..."
                            class="search-input w-full pl-11 pr-4 py-3 border-2 border-slate-200 rounded-xl focus:border-blue-400 transition-all duration-200">
                    </div>
                    <div class="grid grid-cols-1 gap-2 sm:grid-cols-[1fr_1fr_auto] xl:flex xl:flex-wrap">
                        <select id="statusFilter"
                            class="px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-blue-400 bg-white">
                            <option value="all">📊 All Status</option>
                            <option value="pending">🟡 Pending</option>
                            <option value="ongoing">🔵 Ongoing</option>
                            <option value="completed">🟢 Completed</option>
                        </select>
                        <select id="priorityFilter"
                            class="px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-blue-400 bg-white">
                            <option value="all">🎯 All Priority</option>
                            <option value="low">🟢 Low</option>
                            <option value="medium">🟠 Medium</option>
                            <option value="high">🔴 High</option>
                        </select>
                        <button onclick="resetFilters()"
                            class="px-4 py-3 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-xl transition">
                            <i class="fas fa-redo-alt"></i>
                        </button>
                    </div>
                </div>
            </div>

            {{-- TABLE CARD --}}
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden animate-fade-up border border-slate-100" style="animation-delay: 0.2s">
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="min-w-full divide-y divide-slate-200 md:min-w-[1180px]" id="projectsTable">
                        <thead class="bg-gradient-to-r from-slate-50 to-blue-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                    <i class="fas fa-hashtag mr-1"></i> #
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                    <i class="fas fa-project-diagram mr-1"></i> Project
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                    <i class="fas fa-project-diagram mr-1"></i> Client Name
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                    <i class="fas fa-users mr-1"></i> Assigned To
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                    <i class="fas fa-calendar-alt mr-1"></i> Timeline
                                </th>
                                {{-- <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                    <i class="fas fa-flag mr-1"></i> Priority
                                </th> --}}
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                    <i class="fas fa-chart-line mr-1"></i> Status
                                </th>

                                {{-- <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                    <i class="fas fa-user mr-1"></i> Created By
                                </th> --}}
                                {{-- <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                    <i class="fas fa-chart-line mr-1"></i> Date
                                </th> --}}
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">
                                    <i class="fas fa-bolt mr-1"></i> Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100" id="tableBody">
                            @forelse($projects as $key => $p)
                                @php
                                    $modules = is_array($p->modules) ? $p->modules : json_decode($p->modules, true);
                                    $daysLeft = $p->end_date
                                        ? \Carbon\Carbon::parse($p->end_date)->diffInDays(now(), false)
                                        : null;
                                    $isOverdue =
                                        $p->end_date &&
                                        \Carbon\Carbon::parse($p->end_date)->isPast() &&
                                        $p->status != 'completed';
                                    $progress = $p->status == 'completed' ? 100 : ($p->status == 'ongoing' ? 60 : 20);

                                    // Human Resources
                                    $teamMembers = [
                                        [
                                            'role' => 'PM',
                                            'name' => $p->project_manager,
                                            'class' => 'pm',
                                            'icon' => 'fa-user-tie',
                                        ],
                                        [
                                            'role' => 'DEV',
                                            'name' => $p->developer,
                                            'class' => 'dev',
                                            'icon' => 'fa-code',
                                        ],
                                        [
                                            'role' => 'DESIGN',
                                            'name' => $p->designer,
                                            'class' => 'design',
                                            'icon' => 'fa-paint-brush',
                                        ],
                                        [
                                            'role' => 'QA',
                                            'name' => $p->qa_engineer,
                                            'class' => 'qa',
                                            'icon' => 'fa-bug',
                                        ],
                                    ];
                                    $hasTeam = false;
                                    foreach ($teamMembers as $member) {
                                        if ($member['name']) {
                                            $hasTeam = true;
                                            break;
                                        }
                                    }

                                    // Infrastructure
                                    $infraFields = [
                                        ['label' => 'Domain', 'value' => $p->domain_name, 'class' => 'domain'],
                                        ['label' => 'Hosting', 'value' => $p->hosting_provider, 'class' => 'hosting'],
                                        ['label' => 'SSL', 'value' => $p->ssl_certificate, 'class' => 'ssl'],
                                    ];
                                    $hasInfra = false;
                                    foreach ($infraFields as $infra) {
                                        if ($infra['value']) {
                                            $hasInfra = true;
                                            break;
                                        }
                                    }
                                @endphp
                                @php
                                    $editRoute = null;
                                    $deleteRoute = null;
                                    $viewRoute = null;
                                    if (Auth::guard('marketing_manager')->check()) {
                                        $editRoute = route('marketing.project.edit', $p->id);
                                        $deleteRoute = route('marketing.project.delete', $p->id);
                                        $viewRoute = route('marketing.view.project', $p->id);
                                    } elseif (Auth::guard('super_admin')->check()) {
                                        $editRoute = route('project.edit', $p->id);
                                        $deleteRoute = route('project.delete', $p->id);
                                        $viewRoute = route('admin.view.project', $p->id);
                                    } elseif (Auth::guard('project_manager')->check()) {
                                        $editRoute = route('project.edit', $p->id);
                                        $deleteRoute = route('project.delete', $p->id);
                                        $viewRoute = route('admin.view.project', $p->id);
                                    }
                                @endphp
                                <tr class="table-row hover:bg-blue-50/50 transition-all duration-200"
                                    data-status="{{ $p->status }}" data-priority="{{ $p->priority }}"
                                    data-name="{{ strtolower($p->name) }}"
                                    data-description="{{ strtolower($p->description) }}"
                                    data-project-manager="{{ strtolower($p->project_manager ?? '') }}"
                                    data-developer="{{ strtolower($p->developer ?? '') }}"
                                    data-designer="{{ strtolower($p->designer ?? '') }}"
                                    data-qa-engineer="{{ strtolower($p->qa_engineer ?? '') }}"
                                    data-domain="{{ strtolower($p->domain_name ?? '') }}">
                                    <td class="px-6 py-4 whitespace-nowrap" data-label="#">
                                        <span
                                            class="text-sm font-semibold text-gray-500 bg-gray-100 px-2 py-1 rounded-lg">{{ $key + 1 }}</span>
                                    </td>

                                    <td class="px-6 py-4" data-label="Project">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-50 to-cyan-100 flex items-center justify-center shadow-sm">
                                                <i class="fas fa-folder-open text-blue-600 text-lg"></i>
                                            </div>
                                            <div>
                                                <a href="{{ $viewRoute }}">
                                                    <span class="font-bold text-gray-800">{{ $p->name }}</span>
                                                    <div class="flex items-center gap-2 mt-1">
                                                        <div class="w-16 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                                            <div class="h-full bg-gradient-to-r from-blue-600 to-cyan-500 rounded-full"
                                                                style="width: {{ $progress }}%"></div>
                                                        </div>
                                                        <span class="text-xs text-gray-400">{{ $progress }}%</span>
                                                    </div>
                                                </a>

                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap" data-label="Client Name">
                                        <div class="space-y-1">
                                            <div class="flex items-center gap-1.5 text-xs ">
                                                <p class="font-bold text-md">{{ $p->client_name ?? 'N/A' }}</p>
                                            </div>

                                        </div>
                                    </td>
                                    <td class="px-6 py-4" data-label="Handle Project">
                                        <div class="space-y-2">

                                            <div class="flex items-center gap-3">
                                                <div class="team-avatar {{ $member['class'] ?? 'bg-gray-500' }}">
                                                    <i
                                                        class="fas {{ $member['icon'] ?? 'fa-user' }} text-white text-[10px]"></i>
                                                </div>

                                                <div>
                                                    <p class="text-sm font-semibold text-gray-900">
                                                        {{ $p->projecthumanresource->first()->project_manager ?? '' }}
                                                    </p>

                                                </div>
                                            </div>

                                        </div>
                                    </td>



                                    <td class="px-6 py-4 whitespace-nowrap" data-label="Timeline">
                                        <div class="space-y-1">
                                            <div class="flex items-center gap-1.5 text-xs text-gray-500">
                                                <i class="fas fa-play-circle text-green-500"></i>
                                                <span>{{ \Carbon\Carbon::parse($p->start_date)->format('d M, Y') }}</span>
                                            </div>
                                            @if ($p->end_date)
                                                <div class="flex items-center gap-1.5 text-xs">
                                                    <i
                                                        class="fas fa-stop-circle {{ $isOverdue ? 'text-red-500' : 'text-gray-400' }}"></i>
                                                    <span
                                                        class="{{ $isOverdue ? 'text-red-600 font-semibold' : 'text-gray-500' }}">
                                                        {{ \Carbon\Carbon::parse($p->end_date)->format('d M, Y') }}
                                                    </span>
                                                    @if ($isOverdue)
                                                        <span class="text-red-500 text-xs ml-1 animate-pulse">⚠️
                                                            Overdue</span>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- <td class="px-6 py-4 whitespace-nowrap" data-label="Priority">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold {{ $priorityColors[$p->priority]['bg'] }} {{ $priorityColors[$p->priority]['text'] }}">
                                            <i class="fas {{ $priorityColors[$p->priority]['icon'] }} text-xs"></i>
                                            {{ ucfirst($p->priority) }}
                                        </span>
                                    </td> --}}

                                    <td class="px-6 py-4 whitespace-nowrap" data-label="Status">
                                        <span
                                            class="status-badge inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold {{ $statusColors[$p->status]['bg'] }} {{ $statusColors[$p->status]['text'] }}">
                                            <span
                                                class="w-1.5 h-1.5 rounded-full {{ $statusColors[$p->status]['dot'] }} animate-pulse"></span>
                                            <i class="fas {{ $statusColors[$p->status]['icon'] }} text-xs"></i>
                                            {{ ucfirst($p->status) }}
                                        </span>
                                    </td>





                                    <td class="px-6 py-4 whitespace-nowrap" data-label="Created By">
                                        <div class="space-y-1">
                                            <div class="flex items-center gap-1.5 text-xs text-gray-500">
                                                <p class="font-medium">{{ $p->user->name ?? 'N/A' }}</p>
                                            </div>
                                            <div class="flex items-center gap-1.5 text-xs text-gray-400">
                                                <i class="fas fa-envelope"></i>
                                                <p>{{ $p->user->email ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- <td class="px-6 py-4 whitespace-nowrap" data-label="Date">
                                        <span
                                            class="status-badge inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold {{ $statusColors[$p->status]['bg'] }} {{ $statusColors[$p->status]['text'] }}">
                                            {{ \Carbon\Carbon::parse($p->created_at)->format('d M, Y') }}
                                        </span>
                                    </td> --}}

                                    <td class="px-6 py-4 whitespace-nowrap" data-label="Actions">

                                        <div class="project-actions flex items-center justify-center gap-1.5">
                                            <a href="{{ $editRoute }}"
                                                class="action-btn group p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all duration-200"
                                                title="Edit Project">
                                                <i class="fas fa-edit text-sm"></i>
                                            </a>
                                            <a href="{{ $viewRoute }}"
                                                class="action-btn group p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all duration-200"
                                                title="View Project">
                                                <i class="fas fa-eye text-sm"></i> </a>
                                            <form action="{{ $deleteRoute }}" method="POST" class="delete-form inline"
                                                data-name="{{ $p->name }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="action-btn delete-btn p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-500 hover:text-white transition-all duration-200"
                                                    title="Delete Project">
                                                    <i class="fas fa-trash-alt text-sm"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('addtotask', $p->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="action-btn p-2 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-500 hover:text-white transition-all duration-200"
                                                    title="Add to Task">
                                                    <i class="fas fa-tasks text-sm"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-4">
                                            <div
                                                class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center">
                                                <i class="fas fa-folder-open text-gray-400 text-4xl"></i>
                                            </div>
                                            <div>
                                                <p class="text-gray-500 text-lg font-medium">No projects found</p>
                                                <p class="text-gray-400 text-sm mt-1">Get started by creating your first
                                                    project</p>
                                            </div>
                                            <a href="{{ $createProject }}"
                                                class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-cyan-500 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all">
                                                <i class="fas fa-plus"></i>
                                                Create Project
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="relative z-10 mt-4 rounded-2xl bg-white p-3 shadow-sm border border-slate-100">
                {{ $projects->links() }}
            </div>
        </div>
    </div>

    <script>
        // Filter functions
        function filterByStatus(status) {
            document.getElementById('statusFilter').value = status;
            applyFilters();
        }

        function filterByPriority(priority) {
            document.getElementById('priorityFilter').value = priority;
            applyFilters();
        }

        function resetFilters() {
            document.getElementById('statusFilter').value = 'all';
            document.getElementById('priorityFilter').value = 'all';
            document.getElementById('searchInput').value = '';
            applyFilters();
        }

        function applyFilters() {
            const status = document.getElementById('statusFilter').value;
            const priority = document.getElementById('priorityFilter').value;
            const search = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#tableBody tr');

            rows.forEach(row => {
                const rowStatus = row.getAttribute('data-status');
                const rowPriority = row.getAttribute('data-priority');
                const rowName = row.getAttribute('data-name') || '';
                const rowDesc = row.getAttribute('data-description') || '';
                const rowPM = row.getAttribute('data-project-manager') || '';
                const rowDev = row.getAttribute('data-developer') || '';
                const rowDesigner = row.getAttribute('data-designer') || '';
                const rowQA = row.getAttribute('data-qa-engineer') || '';
                const rowDomain = row.getAttribute('data-domain') || '';

                let show = true;

                if (status !== 'all' && rowStatus !== status) show = false;
                if (priority !== 'all' && rowPriority !== priority) show = false;
                if (search && !rowName.includes(search) && !rowDesc.includes(search) &&
                    !rowPM.includes(search) && !rowDev.includes(search) &&
                    !rowDesigner.includes(search) && !rowQA.includes(search) &&
                    !rowDomain.includes(search)) {
                    show = false;
                }

                row.style.display = show ? '' : 'none';
            });
        }

        // Search input listener
        document.getElementById('searchInput').addEventListener('keyup', applyFilters);
        document.getElementById('statusFilter').addEventListener('change', applyFilters);
        document.getElementById('priorityFilter').addEventListener('change', applyFilters);

        // Delete confirmation with SweetAlert
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                const form = this.closest('.delete-form');
                const projectName = form.getAttribute('data-name');

                Swal.fire({
                    title: 'Delete Project?',
                    html: `Are you sure you want to delete <strong class="text-blue-600">${projectName}</strong>?<br>This action cannot be undone.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="fas fa-trash-alt mr-2"></i>Yes, delete it!',
                    cancelButtonText: '<i class="fas fa-times mr-2"></i>Cancel',
                    background: '#fff',
                    customClass: {
                        popup: 'rounded-2xl'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Add fade-in animation to new rows
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                mutation.addedNodes.forEach((node) => {
                    if (node.nodeType === 1 && node.tagName === 'TR') {
                        node.style.opacity = '0';
                        node.style.transform = 'translateX(-20px)';
                        setTimeout(() => {
                            node.style.transition = 'all 0.3s ease';
                            node.style.opacity = '1';
                            node.style.transform = 'translateX(0)';
                        }, 10);
                    }
                });
            });
        });

        observer.observe(document.getElementById('tableBody'), {
            childList: true
        });
    </script>

    <style>
        .table-row {
            transition: all 0.2s ease;
        }

        .action-btn {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .action-btn:hover {
            transform: translateY(-2px);
        }

        .status-badge {
            transition: all 0.2s ease;
        }

        .stat-card {
            cursor: pointer;
        }
    </style>
@endsection
