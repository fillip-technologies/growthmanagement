@php

    $dashboard = '';
    $myTaskRoute = '';
    if (Auth::guard('super_admin')->check()) {
        $dashboard = route('admin.dashboard');
    } elseif (Auth::guard('marketing_manager')->check()) {
        $dashboard = route('marketing.dashboard');
    } elseif (Auth::guard('sales_manager')->check()) {
        $dashboard = route('sales_manager.dashboard');
    } elseif (Auth::guard('hr_manager')->check()) {
        $dashboard = route('hr.dashboard');
    } elseif (Auth::guard('employee')->check()) {
        $dashboard = route('employee.dashboard');
        $data = Auth::guard('employee')->user();
        if ($data->department == 'Sales Department') {
            $myTaskRoute = route('salesEmpTask');
        } else {
            $myTaskRoute = route('employee.task');
        }
    } elseif (Auth::guard('project_manager')->check()) {
        $dashboard = route('employee.dashboard');
    } elseif (Auth::guard('team_leader')->check()) {
        $dashboard = route('teamhead.dashboard');
    } elseif (Auth::guard('account_manager')->check()) {
        $dashboard = route('acmanager.dashboard');
    }
@endphp

<nav class="mt-6 flex-1 overflow-y-auto bg-gradient-to-b from-slate-900 via-slate-900 text-white p-2">
    <div class="px-4 mb-6 mt-4">
        <p class="text-xs uppercase text-orange-500 font-bold tracking-wider opacity-80">
            Navigation
        </p>
    </div>
    <a href="{{ $dashboard }}"
        class="flex items-center px-6 py-3 mb-3 rounded-xl shadow-md
              bg-gray-900/60 backdrop-blur-xl border border-gray-800
              hover:bg-orange-600 hover:text-white hover:border-orange-400
              transition-all duration-300 group">
        <i class="fas fa-tachometer-alt mr-4 text-orange-500 group-hover:text-white"></i>
        Dashboard
    </a>


    @if (Auth::guard('super_admin')->check() || Auth::guard('project_manager')->check())
        <div x-data="{ open: false }" class="mb-3">
            <button @click="open = !open"
                class="w-full flex items-center justify-between px-6 py-3 rounded-xl shadow-md
        bg-gray-900/60 backdrop-blur-xl border border-gray-800
        hover:bg-orange-600 hover:text-white hover:border-orange-400
        transition-all duration-300 group">

                <div class="flex items-center">
                    <i class="fa-solid fa-users-gear mr-4 text-orange-500 group-hover:text-white"></i>
                    <span>Management</span>
                </div>

                <i class="fa-solid fa-chevron-down transition-transform duration-300"
                    :class="{ 'rotate-180': open }"></i>
            </button>

            <div x-show="open" x-transition class="mt-2 ml-5 space-y-2">

                <a href="{{ route('attendanceList') }}"
                    class="flex items-center px-5 py-2 rounded-lg bg-gray-800 hover:bg-orange-500 hover:text-white transition">
                    <i class="fa-solid fa-calendar-check mr-3 text-emerald-400 hover:text-white"></i>
                    Attendance
                </a>

                <a href="{{ route('drag.task') }}"
                    class="flex items-center px-5 py-2 rounded-lg bg-gray-800 hover:bg-orange-500 hover:text-white transition">
                    <i class="fa-solid fa-list-check mr-3 text-blue-400 hover:text-white"></i>
                    Drag Task
                </a>

                <a href="{{ route('leaveList') }}"
                    class="flex items-center px-5 py-2 rounded-lg bg-gray-800 hover:bg-orange-500 hover:text-white transition">
                    <i class="fa-solid fa-calendar-xmark mr-3 text-yellow-400"></i>
                    Leaves
                </a>

                <a href="{{ route('admin.clientLeads') }}"
                    class="flex items-center px-5 py-2 rounded-lg bg-gray-800 hover:bg-orange-500 hover:text-white transition">
                    <i class="fa-solid fa-user-plus mr-3 text-pink-400"></i>
                    Leads
                </a>
                <a href="{{ route('employees') }}"
                    class="flex items-center px-5 py-2 rounded-lg bg-gray-800 hover:bg-orange-500 hover:text-white transition">
                    <i class="fa fa-users mr-4 text-orange-500 group-hover:text-white"></i>
                    Employees
                </a>

                <a href="{{ route('project.list') }}"
                    class="flex items-center px-5 py-2 rounded-lg bg-gray-800 hover:bg-orange-500 hover:text-white transition">
                    <i class="fas fa-folder-open mr-4 text-orange-500 group-hover:text-white"></i>
                    Projects
                </a>


            </div>
        </div>


        {{-- <div x-data="{ open: false }" class="mb-3">
            <button @click="open = !open"
                class="w-full flex items-center justify-between px-6 py-3 rounded-xl shadow-md
        bg-gray-900/60 backdrop-blur-xl border border-gray-800
        hover:bg-orange-600 hover:text-white hover:border-orange-400
        transition-all duration-300 group">

                <div class="flex items-center">
                    <i class="fa-solid fa-users mr-4 text-orange-500 group-hover:text-white"></i>
                    <span>IT Teams</span>
                </div>

                <i class="fa-solid fa-chevron-down transition-transform duration-300"
                    :class="{ 'rotate-180': open }"></i>
            </button>
            <div x-show="open" x-transition class="mt-2 ml-5 space-y-2">

                <a href=""
                    class="flex items-center px-5 py-2 rounded-lg bg-gray-800 hover:bg-orange-500 hover:text-white transition">
                    <i class="fa-solid fa-laptop-code mr-3 text-blue-400"></i>
                    Employees
                </a>

                <a href=""
                    class="flex items-center px-5 py-2 rounded-lg bg-gray-800 hover:bg-orange-500 hover:text-white transition">
                    <i class="fa-solid fa-chart-line mr-3 text-green-400"></i>
                    Projects
                </a>

                <a href="{"
                    class="flex items-center px-5 py-2 rounded-lg bg-gray-800 hover:bg-orange-500 hover:text-white transition">
                    <i class="fa-solid fa-bullhorn mr-3 text-pink-400"></i>
                    Report
                </a>

            </div>
        </div> --}}

        {{-- <div x-data="{ open: false }" class="mb-3">
            <button @click="open = !open"
                class="w-full flex items-center justify-between px-6 py-3 rounded-xl shadow-md
        bg-gray-900/60 backdrop-blur-xl border border-gray-800
        hover:bg-orange-600 hover:text-white hover:border-orange-400
        transition-all duration-300 group">

                <div class="flex items-center">
                    <i class="fa-solid fa-users mr-4 text-orange-500 group-hover:text-white"></i>
                    <span>Sales Teams</span>
                </div>

                <i class="fa-solid fa-chevron-down transition-transform duration-300"
                    :class="{ 'rotate-180': open }"></i>
            </button>
            <div x-show="open" x-transition class="mt-2 ml-5 space-y-2">

                <a href=""
                    class="flex items-center px-5 py-2 rounded-lg bg-gray-800 hover:bg-orange-500 hover:text-white transition">
                    <i class="fa-solid fa-laptop-code mr-3 text-blue-400"></i>
                    Employees
                </a>

                <a href=""
                    class="flex items-center px-5 py-2 rounded-lg bg-gray-800 hover:bg-orange-500 hover:text-white transition">
                    <i class="fa-solid fa-chart-line mr-3 text-green-400"></i>
                    Projects
                </a>

                <a href="{"
                    class="flex items-center px-5 py-2 rounded-lg bg-gray-800 hover:bg-orange-500 hover:text-white transition">
                    <i class="fa-solid fa-bullhorn mr-3 text-pink-400"></i>
                    Report
                </a>


            </div>
        </div> --}}
        {{--
        <div x-data="{ open: false }" class="mb-3">
            <button @click="open = !open"
                class="w-full flex items-center justify-between px-6 py-3 rounded-xl shadow-md
        bg-gray-900/60 backdrop-blur-xl border border-gray-800
        hover:bg-orange-600 hover:text-white hover:border-orange-400
        transition-all duration-300 group">

                <div class="flex items-center">
                    <i class="fa-solid fa-users mr-4 text-orange-500 group-hover:text-white"></i>
                    <span>DMRK Teams</span>
                </div>

                <i class="fa-solid fa-chevron-down transition-transform duration-300"
                    :class="{ 'rotate-180': open }"></i>
            </button>
            <div x-show="open" x-transition class="mt-2 ml-5 space-y-2">

                <a href=""
                    class="flex items-center px-5 py-2 rounded-lg bg-gray-800 hover:bg-orange-500 hover:text-white transition">
                    <i class="fa-solid fa-laptop-code mr-3 text-blue-400"></i>
                    Employees
                </a>

                <a href=""
                    class="flex items-center px-5 py-2 rounded-lg bg-gray-800 hover:bg-orange-500 hover:text-white transition">
                    <i class="fa-solid fa-chart-line mr-3 text-green-400"></i>
                    Projects
                </a>

                <a href="{"
                    class="flex items-center px-5 py-2 rounded-lg bg-gray-800 hover:bg-orange-500 hover:text-white transition">
                    <i class="fa-solid fa-bullhorn mr-3 text-pink-400"></i>
                    Report
                </a>

            </div>
        </div> --}}

        <div x-data="{ open: false }" class="mb-3">
            <button @click="open = !open"
                class="w-full flex items-center justify-between px-6 py-3 rounded-xl shadow-md
        bg-gray-900/60 backdrop-blur-xl border border-gray-800
        hover:bg-orange-600 hover:text-white hover:border-orange-400
        transition-all duration-300 group">

                <div class="flex items-center">
                    <i class="fa-solid fa-chart-column mr-4 text-orange-500 group-hover:text-white"></i>
                    <span>Work Reports</span>
                </div>

                <i class="fa-solid fa-chevron-down transition-transform duration-300"
                    :class="{ 'rotate-180': open }"></i>
            </button>

            <div x-show="open" x-transition class="mt-2 ml-5 space-y-2">

                <a href="{{ route('report') }}"
                    class="flex items-center px-5 py-2 rounded-lg bg-gray-800 hover:bg-orange-500 hover:text-white transition">
                    <i class="fa-solid fa-chart-line mr-3 text-green-400"></i>
                    Reports
                </a>

                <a href="{{ route('week.report') }}"
                    class="flex items-center px-5 py-2 rounded-lg bg-gray-800 hover:bg-orange-500 hover:text-white transition">
                    <i class="fa-solid fa-calendar-week mr-3 text-blue-400"></i>
                    Weekly Reports
                </a>

            </div>
        </div>
    @elseif(Auth::guard('employee')->check())
        <a href="{{ route('emp.attendance') }}"
            class="flex items-center px-6 py-3 mb-3 rounded-xl shadow-md
              bg-gray-900/60 backdrop-blur-xl border border-gray-800
              hover:bg-orange-600 hover:text-white hover:border-orange-400
              transition-all duration-300 group">
            <i class="fa-solid fa-clock mr-4 text-orange-500 group-hover:text-white"></i>
            Attendance
        </a>
        <a href="{{ $myTaskRoute }}"
            class="flex items-center px-6 py-3 mb-3 rounded-xl shadow-md
              bg-gray-900/60 backdrop-blur-xl border border-gray-800
              hover:bg-orange-600 hover:text-white hover:border-orange-400
              transition-all duration-300 group">
            <i class="fa-solid fa-chart-line mr-4 text-orange-500 group-hover:text-white"></i>
            My Tasks
        </a>
    @elseif (Auth::guard('team_leader')->check())
        <a href="{{ route('teammember') }}"
            class="flex items-center px-6 py-3 mb-3 rounded-xl shadow-md
              bg-gray-900/60 backdrop-blur-xl border border-gray-800
              hover:bg-orange-600 hover:text-white hover:border-orange-400
              transition-all duration-300 group">
            <i class="fa-solid fa-users mr-4 text-orange-500 group-hover:text-white"></i>
            Team Members
        </a>

        <a href="{{ route('teamhead.employee.task') }}"
            class="flex items-center px-6 py-3 mb-3 rounded-xl shadow-md
              bg-gray-900/60 backdrop-blur-xl border border-gray-800
              hover:bg-orange-600 hover:text-white hover:border-orange-400
              transition-all duration-300 group">
            <i class="fa-solid fa-chart-line mr-4 text-orange-500 group-hover:text-white"></i>
            My Tasks
        </a>

        <a href="{{ route('teamhead.drag.task') }}"
            class="flex items-center px-6 py-3 mb-3 rounded-xl shadow-md
              bg-gray-900/60 backdrop-blur-xl border border-gray-800
              hover:bg-orange-600 hover:text-white hover:border-orange-400
              transition-all duration-300 group">
            <i class="fa-solid fa-people-arrows mr-4 text-orange-500 group-hover:text-white"></i>
            Assingne Tasks
        </a>

        <a href="{{ route('teamhead.report') }}"
            class="flex items-center px-6 py-3 mb-3 rounded-xl shadow-md
              bg-gray-900/60 backdrop-blur-xl border border-gray-800
              hover:bg-orange-600 hover:text-white hover:border-orange-400
              transition-all duration-300 group">
            <i class="fa-solid fa-chart-pie mr-4 text-orange-500 group-hover:text-white"></i>
            Reports
        </a>

        <a href="{{ route('teamhead.attendanceList') }}"
            class="flex items-center px-6 py-3 mb-3 rounded-xl shadow-md
              bg-gray-900/60 backdrop-blur-xl border border-gray-800
              hover:bg-orange-600 hover:text-white hover:border-orange-400
              transition-all duration-300 group">
            <i class="fa-solid fa-clock mr-4 text-orange-500 group-hover:text-white"></i>
            Attendance
        </a>
    @elseif(Auth::guard('account_manager')->check())
        <a href="{{ route('leadedata') }}"
            class="flex items-center px-6 py-3 mb-3 rounded-xl shadow-md
    bg-gray-900/60 backdrop-blur-xl border border-gray-800
    hover:bg-orange-600 hover:text-white hover:border-orange-400
    transition-all duration-300 group">

            <i class="fa-solid fa-user-plus mr-4 text-orange-500 group-hover:text-white"></i>

            All Leads
        </a>

        <a href="{{ route('index') }}"
            class="flex items-center px-6 py-3 mb-3 rounded-xl shadow-md
    bg-gray-900/60 backdrop-blur-xl border border-gray-800
    hover:bg-orange-600 hover:text-white hover:border-orange-400
    transition-all duration-300 group">

            <i class="fa-solid fa-file-lines mr-4 text-orange-500 group-hover:text-white"></i>
            Lead Datas
        </a>

        <a href="{{ route('sales.employee') }}"
            class="flex items-center px-6 py-3 mb-3 rounded-xl shadow-md
              bg-gray-900/60 backdrop-blur-xl border border-gray-800
              hover:bg-orange-600 hover:text-white hover:border-orange-400
              transition-all duration-300 group">
            <i class="fa-solid fa-users mr-4 text-orange-500 group-hover:text-white"></i>
            Team Members
        </a>

        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                class="w-full flex items-center justify-between px-6 py-3 mb-3 rounded-xl shadow-md
                    bg-gray-900/60 backdrop-blur-xl border border-gray-800
                    hover:bg-orange-600 hover:text-white hover:border-orange-400
                    transition-all duration-300 group">

                <span class="flex items-center">
                    <i class="fas fa-folder-open mr-4 text-orange-500 group-hover:text-white"></i>
                    Assign Tasks
                </span>

                <i class="fas fa-chevron-down text-sm transition-transform duration-300"
                    :class="{ 'rotate-180': open }"></i>
            </button>

            <!-- Dropdown -->
            <div x-show="open" @click.away="open = false" x-transition
                class="w-full bg-gray-900 rounded-xl shadow-lg border border-gray-700 overflow-hidden">

                <a href="{{ route('projectuser') }}"
                    class="flex items-center px-6 py-3 hover:bg-orange-600 hover:text-white transition">
                    <i class="fas fa-users mr-3 text-orange-400"></i>
                    Sales Team
                </a>

                <a href="{{ route('headTaskassing') }}"
                    class="flex items-center px-6 py-3 hover:bg-orange-600 hover:text-white transition">
                    <i class="fas fa-laptop-code mr-3 text-blue-400"></i>
                    IT/Marketing Team
                </a>

            </div>

        </div>
        <a href="{{ route('reportforsales') }}"
            class="flex items-center px-6 py-3 mb-3 rounded-xl shadow-md
    bg-gray-900/60 backdrop-blur-xl border border-gray-800
    hover:bg-orange-600 hover:text-white hover:border-orange-400
    transition-all duration-300 group">

            <i class="fa-solid fa-chart-pie mr-4 text-orange-500 group-hover:text-white"></i>
            Reports
        </a>
    @elseif(Auth::guard('marketing_manager')->check())
        <a href="{{ route('marketing.teammember') }}"
            class="flex items-center px-6 py-3 mb-3 rounded-xl shadow-md
    bg-gray-900/60 backdrop-blur-xl border border-gray-800
    hover:bg-orange-600 hover:text-white hover:border-orange-400
    transition-all duration-300 group">

            <i class="fa-solid fa-users mr-4 text-orange-500 group-hover:text-white"></i>
            Team Members
        </a>
        <a href="{{ route('marketing.employee.task') }}"
            class="flex items-center px-6 py-3 mb-3 rounded-xl shadow-md
              bg-gray-900/60 backdrop-blur-xl border border-gray-800
              hover:bg-orange-600 hover:text-white hover:border-orange-400
              transition-all duration-300 group">
            <i class="fa-solid fa-chart-line mr-4 text-orange-500 group-hover:text-white"></i>
            My Tasks
        </a>

        <a href="{{ route('marketing.clientLeads') }}"
            class="flex items-center px-6 py-3 mb-3 rounded-xl shadow-md
    bg-gray-900/60 backdrop-blur-xl border border-gray-800
    hover:bg-orange-600 hover:text-white hover:border-orange-400
    transition-all duration-300 group">

            <i class="fa-solid fa-users mr-4 text-orange-500 group-hover:text-white"></i>
            Leads
        </a>

        <a href="{{ route('marketing.project.list') }}"
            class="flex items-center px-6 py-3 mb-3 rounded-xl shadow-md
              bg-gray-900/60 backdrop-blur-xl border border-gray-800
              hover:bg-orange-600 hover:text-white hover:border-orange-400
              transition-all duration-300 group">
            <i class="fas fa-folder-open mr-4 text-orange-500 group-hover:text-white"></i>
            Projects
        </a>

        <a href="{{ route('marketing.drag.task') }}"
            class="flex items-center px-6 py-3 mb-3 rounded-xl shadow-md
              bg-gray-900/60 backdrop-blur-xl border border-gray-800
              hover:bg-orange-600 hover:text-white hover:border-orange-400
              transition-all duration-300 group">
            <i class="fa-solid fa-people-arrows mr-4 text-orange-500 group-hover:text-white"></i>
            Drag Tasks
        </a>

        <a href="{{ route('marketing.report') }}"
            class="flex items-center px-6 py-3 mb-3 rounded-xl shadow-md
              bg-gray-900/60 backdrop-blur-xl border border-gray-800
              hover:bg-orange-600 hover:text-white hover:border-orange-400
              transition-all duration-300 group">
            <i class="fas fa-folder-open mr-4 text-orange-500 group-hover:text-white"></i>
            Reports
        </a>
    @elseif(Auth::guard('hr_manager')->check())
        <a href="{{ route('hr.attendanceList') }}"
            class="flex items-center px-6 py-3 mb-3 rounded-xl shadow-md
              bg-gray-900/60 backdrop-blur-xl border border-gray-800
              hover:bg-orange-600 hover:text-white hover:border-orange-400
              transition-all duration-300 group">
            <i class="fa-solid fa-clock mr-4 text-orange-500 group-hover:text-white"></i>
            Attendance
        </a>

        <a href="{{ route('hr.leaveList') }}"
            class="flex items-center px-6 py-3 mb-3 rounded-xl shadow-md
              bg-gray-900/60 backdrop-blur-xl border border-gray-800
              hover:bg-orange-600 hover:text-white hover:border-orange-400
              transition-all duration-300 group">
            <i class="fa-solid fa-plane-departure mr-4 text-orange-500 group-hover:text-white"></i>
            Leave Managements
        </a>
    @elseif(Auth::guard('sales_manager')->check())
        <a href=""
            class="flex items-center px-6 py-3 mb-3 rounded-xl shadow-md
    bg-gray-900/60 backdrop-blur-xl border border-gray-800
    hover:bg-orange-600 hover:text-white hover:border-orange-400
    transition-all duration-300 group">

            <i class="fa-solid fa-users mr-4 text-orange-500 group-hover:text-white"></i>
            Leads
        </a>

        <a href="{{ route('bda.employees') }}"
            class="flex items-center px-6 py-3 mb-3 rounded-xl shadow-md
              bg-gray-900/60 backdrop-blur-xl border border-gray-800
              hover:bg-orange-600 hover:text-white hover:border-orange-400
              transition-all duration-300 group">
            <i class="fa-solid fa-users mr-4 text-orange-500 group-hover:text-white"></i>
            Team Members
        </a>

        <a href="{{ route('mytask') }}"
            class="flex items-center px-6 py-3 mb-3 rounded-xl shadow-md
              bg-gray-900/60 backdrop-blur-xl border border-gray-800
              hover:bg-orange-600 hover:text-white hover:border-orange-400
              transition-all duration-300 group">
            <i class="fa-solid fa-chart-line mr-4 text-orange-500 group-hover:text-white"></i>
            My Tasks
        </a>
        <a href="{{ route('sales.reportforsales') }}"
            class="flex items-center px-6 py-3 mb-3 rounded-xl shadow-md
              bg-gray-900/60 backdrop-blur-xl border border-gray-800
              hover:bg-orange-600 hover:text-white hover:border-orange-400
              transition-all duration-300 group">
            <i class="fas fa-folder-open mr-4 text-orange-500 group-hover:text-white"></i>
            Reports
        </a>
    @endif


</nav>
