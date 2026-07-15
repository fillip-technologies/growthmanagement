{{--
    AWESOME UI: Project List - Premium Dashboard Design
    - Modern glassmorphism effects with gradients
    - Advanced filtering and search functionality
    - Animated stats cards with icons
    - Responsive data table with action buttons
    - Module viewer with tooltips
    - Status timeline indicators
--}}
@extends('admin.include.layout')
@section('heading', 'Projects')
@section('title', 'Project List')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    @keyframes shimmer {
        0% { background-position: -1000px 0; }
        100% { background-position: 1000px 0; }
    }
    .animate-fade-up { animation: fadeInUp 0.5s ease-out; }
    .animate-slide-left { animation: slideInLeft 0.4s ease-out; }
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
        background-color: #fef3c7;
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
        background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(249, 115, 22, 0.3);
    }
    .search-input:focus {
        box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
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
        background: #fb923c;
        border-radius: 10px;
    }
</style>

@php
    $total = $projects->count();
    $ongoing = $projects->where('status', 'ongoing')->count();
    $completed = $projects->where('status', 'completed')->count();
    $pending = $projects->where('status', 'pending')->count();
    $highPriority = $projects->where('priority', 'high')->count();

    $statusColors = [
        'pending' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'dot' => 'bg-amber-500', 'icon' => 'fa-clock'],
        'ongoing' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'dot' => 'bg-blue-500', 'icon' => 'fa-spinner'],
        'completed' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'dot' => 'bg-emerald-500', 'icon' => 'fa-check-circle'],
    ];

    $priorityColors = [
        'low' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'icon' => 'fa-arrow-down'],
        'medium' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-700', 'icon' => 'fa-minus'],
        'high' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'icon' => 'fa-arrow-up'],
    ];
@endphp

@if ($errors->any())
<script>
    Swal.fire({
        icon: 'error',
        title: 'Validation Error',
        html: `{!! implode('<br>', $errors->all()) !!}`,
        confirmButtonColor: '#f97316',
        customClass: { popup: 'rounded-2xl' }
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
        customClass: { popup: 'rounded-2xl' }
    });
</script>
@endif

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-50 to-orange-50/20 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        {{-- Floating Background Elements --}}
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-20 right-10 w-72 h-72 bg-orange-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
            <div class="absolute bottom-20 left-10 w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 2s;"></div>
        </div>

        {{-- HEADER SECTION --}}
        <div class="relative mb-8 animate-fade-up">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-orange-500 to-orange-600 opacity-5 rounded-full transform translate-x-32 -translate-y-32"></div>
                <div class="relative px-6 py-6 md:px-8 md:py-8">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg transform rotate-3 hover:rotate-6 transition-all duration-300">
                                <i class="fas fa-project-diagram text-white text-2xl"></i>
                            </div>
                            <div>
                                <h1 class="text-2xl md:text-3xl font-black text-gray-800 tracking-tight">
                                    Project Dashboard
                                </h1>
                                <p class="text-gray-500 mt-1 flex items-center gap-2">
                                    <i class="fas fa-chart-line text-orange-500 text-sm"></i>
                                    Manage and track all your projects in one centralized dashboard
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('projectform') }}"
                            class="group inline-flex items-center gap-2 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-6 py-3 rounded-xl text-sm font-semibold shadow-lg transition-all duration-200 transform hover:scale-[1.02]">
                            <i class="fas fa-plus"></i>
                            <span>Create New Project</span>
                            <i class="fas fa-arrow-right opacity-0 group-hover:opacity-100 transition-all duration-200 translate-x-0 group-hover:translate-x-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- STATS CARDS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5 mb-8 animate-fade-up" style="animation-delay: 0.1s">
            <div class="stat-card bg-white rounded-2xl shadow-lg border border-gray-100 p-5 cursor-pointer" onclick="filterByStatus('all')">
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

            <div class="stat-card bg-white rounded-2xl shadow-lg border border-gray-100 p-5 cursor-pointer" onclick="filterByStatus('ongoing')">
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

            <div class="stat-card bg-white rounded-2xl shadow-lg border border-gray-100 p-5 cursor-pointer" onclick="filterByStatus('completed')">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Completed</p>
                        <p class="text-3xl font-bold text-emerald-600 mt-1">{{ $completed }}</p>
                        <p class="text-xs text-emerald-500 mt-1"><i class="fas fa-trophy"></i> Successfully delivered</p>
                    </div>
                    <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl p-3 shadow-md">
                        <i class="fas fa-check-circle text-white text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card bg-white rounded-2xl shadow-lg border border-gray-100 p-5 cursor-pointer" onclick="filterByStatus('pending')">
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

            <div class="stat-card bg-white rounded-2xl shadow-lg border border-gray-100 p-5 cursor-pointer" onclick="filterByPriority('high')">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">High Priority</p>
                        <p class="text-3xl font-bold text-red-600 mt-1">{{ $highPriority }}</p>
                        <p class="text-xs text-red-500 mt-1"><i class="fas fa-exclamation-triangle"></i> Urgent attention</p>
                    </div>
                    <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl p-3 shadow-md">
                        <i class="fas fa-flag text-white text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- SEARCH AND FILTER BAR --}}
        <div class="bg-white rounded-2xl shadow-lg p-4 mb-6 animate-fade-up" style="animation-delay: 0.15s">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" id="searchInput" placeholder="Search projects by name, description, or modules..."
                        class="search-input w-full pl-11 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-400 transition-all duration-200">
                </div>
                <div class="flex gap-2">
                    <select id="statusFilter" class="px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-400 bg-white">
                        <option value="all">📊 All Status</option>
                        <option value="pending">🟡 Pending</option>
                        <option value="ongoing">🔵 Ongoing</option>
                        <option value="completed">🟢 Completed</option>
                    </select>
                    <select id="priorityFilter" class="px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-400 bg-white">
                        <option value="all">🎯 All Priority</option>
                        <option value="low">🟢 Low</option>
                        <option value="medium">🟠 Medium</option>
                        <option value="high">🔴 High</option>
                    </select>
                    <button onclick="resetFilters()" class="px-4 py-3 bg-gray-100 hover:bg-gray-200 rounded-xl transition">
                        <i class="fas fa-redo-alt"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- TABLE CARD --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden animate-fade-up" style="animation-delay: 0.2s">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="min-w-full divide-y divide-gray-200" id="projectsTable">
                    <thead class="bg-gradient-to-r from-gray-50 to-orange-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-hashtag mr-1"></i> #
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-project-diagram mr-1"></i> Project
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-align-left mr-1"></i> Description
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-calendar-alt mr-1"></i> Timeline
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-flag mr-1"></i> Priority
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-chart-line mr-1"></i> Status
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-cubes mr-1"></i> Modules
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-bolt mr-1"></i> Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100" id="tableBody">
                        @forelse($projects as $key => $p)
                            @php
                                $modules = is_array($p->modules) ? $p->modules : json_decode($p->modules, true);
                                $daysLeft = $p->end_date ? \Carbon\Carbon::parse($p->end_date)->diffInDays(now(), false) : null;
                                $isOverdue = $p->end_date && \Carbon\Carbon::parse($p->end_date)->isPast() && $p->status != 'completed';
                                $progress = $p->status == 'completed' ? 100 : ($p->status == 'ongoing' ? 60 : 20);
                            @endphp
                            <tr class="table-row hover:bg-orange-50/50 transition-all duration-200" data-status="{{ $p->status }}" data-priority="{{ $p->priority }}" data-name="{{ strtolower($p->name) }}" data-description="{{ strtolower($p->description) }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-semibold text-gray-500 bg-gray-100 px-2 py-1 rounded-lg">{{ $key + 1 }}</span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-orange-100 to-orange-200 flex items-center justify-center shadow-sm">
                                            <i class="fas fa-folder-open text-orange-600 text-lg"></i>
                                        </div>
                                        <div>
                                            <span class="font-bold text-gray-800">{{ $p->project_name }}</span>
                                            <div class="flex items-center gap-2 mt-1">
                                                <div class="w-16 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                                    <div class="h-full bg-gradient-to-r from-orange-500 to-orange-600 rounded-full" style="width: {{ $progress }}%"></div>
                                                </div>
                                                <span class="text-xs text-gray-400">{{ $progress }}%</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="group relative">
                                        <p class="text-sm text-gray-600 max-w-xs truncate cursor-help">
                                            {{ Str::limit($p->what_be_do, 50) }}
                                        </p>
                                        @if(strlen($p->description) > 50)
                                            <div class="absolute left-0 bottom-full mb-2 hidden group-hover:block bg-gray-800 text-white text-xs rounded-lg p-2 z-10 whitespace-normal max-w-sm shadow-lg">
                                                {{ $p->description }}
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-1.5 text-xs text-gray-500">
                                            <i class="fas fa-play-circle text-green-500"></i>
                                            <span>{{ \Carbon\Carbon::parse($p->start_date)->format('d M, Y') }}</span>
                                        </div>
                                        @if($p->end_date)
                                            <div class="flex items-center gap-1.5 text-xs">
                                                <i class="fas fa-stop-circle {{ $isOverdue ? 'text-red-500' : 'text-gray-400' }}"></i>
                                                <span class="{{ $isOverdue ? 'text-red-600 font-semibold' : 'text-gray-500' }}">
                                                    {{ \Carbon\Carbon::parse($p->end_date)->format('d M, Y') }}
                                                </span>
                                                @if($isOverdue)
                                                    <span class="text-red-500 text-xs ml-1 animate-pulse">⚠️ Overdue</span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold {{ $priorityColors[$p->priority]['bg'] }} {{ $priorityColors[$p->priority]['text'] }}">
                                        <i class="fas {{ $priorityColors[$p->priority]['icon'] }} text-xs"></i>
                                        {{ ucfirst($p->priority) }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="status-badge inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold {{ $statusColors[$p->status]['bg'] }} {{ $statusColors[$p->status]['text'] }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $statusColors[$p->status]['dot'] }} animate-pulse"></span>
                                        <i class="fas {{ $statusColors[$p->status]['icon'] }} text-xs"></i>
                                        {{ ucfirst($p->status) }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    @if($modules && count($modules) > 0)
                                        <div class="relative group">
                                            <button class="text-sm text-orange-600 hover:text-orange-700 font-medium flex items-center gap-1">
                                                <i class="fas fa-cubes"></i>
                                                {{ count($modules) }} Module(s)
                                                <i class="fas fa-chevron-down text-xs"></i>
                                            </button>
                                            <div class="absolute left-0 top-full mt-2 hidden group-hover:block bg-white border border-gray-200 rounded-xl shadow-xl z-10 min-w-[200px] p-2">
                                                @foreach($modules as $module)
                                                    <div class="px-3 py-1.5 text-sm text-gray-700 hover:bg-orange-50 rounded-lg flex items-center gap-2">
                                                        <i class="fas fa-microchip text-orange-400 text-xs"></i>
                                                        {{ $module }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm">—</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <a href="{{ route('mrk.editproduct', $p->id) }}"
                                            class="action-btn group p-2 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white transition-all duration-200"
                                            title="Edit Project">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>

                                        <form action="" method="POST" class="delete-form inline" data-name="{{ $p->name }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="action-btn delete-btn p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-500 hover:text-white transition-all duration-200"
                                                title="Delete Project">
                                                <i class="fas fa-trash-alt text-sm"></i>
                                            </button>
                                        </form>

                                        <form action="" method="POST" class="inline">
                                            @csrf
                                            <a href="{{ asset($p->attechment) }}" type="submit"
                                                class="action-btn p-2 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-500 hover:text-white transition-all duration-200"
                                                title="Add to Task">
                                                <i class="fas fa-eye text-sm"></i>
                                        </a>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center gap-4">
                                        <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center">
                                            <i class="fas fa-folder-open text-gray-400 text-4xl"></i>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 text-lg font-medium">No projects found</p>
                                            <p class="text-gray-400 text-sm mt-1">Get started by creating your first project</p>
                                        </div>
                                        <a href="{{ route('projectform') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all">
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

            let show = true;

            if (status !== 'all' && rowStatus !== status) show = false;
            if (priority !== 'all' && rowPriority !== priority) show = false;
            if (search && !rowName.includes(search) && !rowDesc.includes(search)) show = false;

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
                html: `Are you sure you want to delete <strong class="text-orange-600">${projectName}</strong>?<br>This action cannot be undone.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash-alt mr-2"></i>Yes, delete it!',
                cancelButtonText: '<i class="fas fa-times mr-2"></i>Cancel',
                background: '#fff',
                customClass: { popup: 'rounded-2xl' }
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

    observer.observe(document.getElementById('tableBody'), { childList: true });
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
