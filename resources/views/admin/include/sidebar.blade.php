<nav class="mt-6 flex-1 overflow-y-auto bg-gradient-to-b from-black to-gray-900 text-white p-2">

    <!-- Section Title -->
    <div class="px-4 mb-6 mt-4">
        <p class="text-xs uppercase text-orange-500 font-bold tracking-wider opacity-80">
            Navigation
        </p>
    </div>

    <!-- Dashboard -->
    <a href="{{ url('/admin/dashboard') }}"
        class="flex items-center px-6 py-3 mb-3 rounded-xl shadow-md
              bg-gray-900/60 backdrop-blur-xl border border-gray-800
              hover:bg-orange-600 hover:text-white hover:border-orange-400
              transition-all duration-300 group">
        <i class="fas fa-tachometer-alt mr-4 text-orange-500 group-hover:text-white"></i>
        Dashboard
    </a>

    @if (Auth::guard('admin')->user()->role->role == 'admin' || Auth::guard('hr')->user()->role->role == 'hr')
        <a href="{{ route('employees') }}"
            class="flex items-center px-6 py-3 mb-3 rounded-xl shadow-md
              bg-gray-900/60 backdrop-blur-xl border border-gray-800
              hover:bg-orange-600 hover:text-white hover:border-orange-400
              transition-all duration-300 group">
            <i class="fa fa-users mr-4 text-orange-500 group-hover:text-white"></i>
            Employees
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
            <span>Projects</span>
        </a>

        <a href="{{ route('daily.work') }}"
            class="flex items-center px-6 py-3 mb-3 rounded-xl shadow-md
              bg-gray-900/60 backdrop-blur-xl border border-gray-800
              hover:bg-orange-600 hover:text-white hover:border-orange-400
              transition-all duration-300 group">
            <i class="fa-solid fa-file-alt mr-4 text-orange-500 group-hover:text-white"></i>
            Daily Logs
        </a>

        <a href="{{ route('task') }}"
            class="flex items-center px-6 py-3 mb-3 rounded-xl shadow-md
              bg-gray-900/60 backdrop-blur-xl border border-gray-800
              hover:bg-orange-600 hover:text-white hover:border-orange-400
              transition-all duration-300 group">
            <i class="fa-solid fa-chart-line mr-4 text-orange-500 group-hover:text-white"></i>
            Tasks
        </a>
    @endif

</nav>
