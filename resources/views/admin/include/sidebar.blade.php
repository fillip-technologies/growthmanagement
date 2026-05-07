@php
    $adminUser = Auth::guard('admin')->user();
    $hrUser = Auth::guard('hr')->user();
    $employeeUser = Auth::guard('employee')->user();
    $internUser = Auth::guard('intern')->user();

    $isAdminOrHR =
        (Auth::guard('admin')->check() && $adminUser?->role?->role === 'admin') ||
        (Auth::guard('hr')->check() && $hrUser?->role?->role === 'hr');

    $isEmployee = Auth::guard('employee')->check() && $employeeUser?->role?->role === 'employee';

    $isIntern = Auth::guard('intern')->check() && $internUser?->role?->role === 'intern';

    if ($isAdminOrHR) {
        $route = route('admin.dashboard');
    } elseif ($isEmployee) {
        $route = route('employee.dashboard');
    } else {
        $route = route('intern.dashboard');
    }
@endphp
<nav class="mt-6 flex-1 overflow-y-auto bg-gradient-to-b from-black to-gray-900 text-white p-2">

    <div class="px-4 mb-6 mt-4">
        <p class="text-xs uppercase text-orange-500 font-bold tracking-wider opacity-80">
            Navigation
        </p>
    </div>

    <a href="{{ $route }}"
        class="flex items-center px-6 py-3 mb-3 rounded-xl shadow-md
              bg-gray-900/60 backdrop-blur-xl border border-gray-800
              hover:bg-orange-600 hover:text-white hover:border-orange-400
              transition-all duration-300 group">
        <i class="fas fa-tachometer-alt mr-4 text-orange-500 group-hover:text-white"></i>
        Dashboard
    </a>

    @if ($isAdminOrHR)
        <a href="{{ route('employees') }}"
            class="flex items-center px-6 py-3 mb-3 rounded-xl shadow-md
              bg-gray-900/60 backdrop-blur-xl border border-gray-800
              hover:bg-orange-600 hover:text-white hover:border-orange-400
              transition-all duration-300 group">
            <i class="fa fa-users mr-4 text-orange-500 group-hover:text-white"></i>
            Employees
        </a>
         <a href="{{ route('drag.task') }}"
            class="flex items-center px-6 py-3 mb-3 rounded-xl shadow-md
              bg-gray-900/60 backdrop-blur-xl border border-gray-800
              hover:bg-orange-600 hover:text-white hover:border-orange-400
              transition-all duration-300 group">
            <i class="fa-solid fa-chart-line mr-4 text-orange-500 group-hover:text-white"></i>
            Drag Tasks
        </a>

        <a href="{{ route('task') }}"
            class="flex items-center px-6 py-3 mb-3 rounded-xl shadow-md
              bg-gray-900/60 backdrop-blur-xl border border-gray-800
              hover:bg-orange-600 hover:text-white hover:border-orange-400
              transition-all duration-300 group">
            <i class="fa-solid fa-chart-line mr-4 text-orange-500 group-hover:text-white"></i>
            Tasks
        </a>

        <a href="{{ route('project.list') }}"
            class="flex items-center px-6 py-3 mb-3 rounded-xl shadow-md
              bg-gray-900/60 backdrop-blur-xl border border-gray-800
              hover:bg-orange-600 hover:text-white hover:border-orange-400
              transition-all duration-300 group">
            <i class="fas fa-folder-open mr-4 text-orange-500 group-hover:text-white"></i>
            Projects
        </a>

        <a href="{{ route('week.report') }}"
            class="flex items-center px-6 py-3 mb-3 rounded-xl shadow-md
              bg-gray-900/60 backdrop-blur-xl border border-gray-800
              hover:bg-orange-600 hover:text-white hover:border-orange-400
              transition-all duration-300 group">
            <i class="fa-solid fa-file-alt mr-4 text-orange-500 group-hover:text-white"></i>
            Weekly Reports
        </a>
    @elseif ($isEmployee)
        <a href="{{ route('employee.task') }}"
            class="flex items-center px-6 py-3 mb-3 rounded-xl shadow-md
              bg-gray-900/60 backdrop-blur-xl border border-gray-800
              hover:bg-orange-600 hover:text-white hover:border-orange-400
              transition-all duration-300 group">
            <i class="fa-solid fa-chart-line mr-4 text-orange-500 group-hover:text-white"></i>
            My Tasks
        </a>
    @elseif ($isIntern)
        <a href="{{ route('intern.task') }}"
            class="flex items-center px-6 py-3 mb-3 rounded-xl shadow-md
              bg-gray-900/60 backdrop-blur-xl border border-gray-800
              hover:bg-orange-600 hover:text-white hover:border-orange-400
              transition-all duration-300 group">
            <i class="fa-solid fa-chart-line mr-4 text-orange-500 group-hover:text-white"></i>
            My Tasks
        </a>
    @endif

</nav>
