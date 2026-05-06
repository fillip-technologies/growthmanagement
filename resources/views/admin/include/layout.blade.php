<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Growth Management System - Admin Panel')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Tailwind Custom Colors -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#e73c7e',
                        secondary: '#10b981',
                        dark: '#1f2937',
                        light: '#f3f4f6',
                        sidebarBg: '#1f1f1f',
                        sidebarHover: '#dc2626'
                    }
                }
            }
        }
    </script>

    <style>
        .sidebar-link.active {
            background-color: #dc2626;
            border-left: 4px solid #f87171;
            color: #fff;
        }

        .sidebar-link:hover {
            background-color: #dc2626;
            color: #fff;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .login-card {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
    </style>

    @stack('styles')
</head>

<body class="bg-gray-100 font-sans">

    <!-- Admin Panel Wrapper -->
    <div id="admin-panel" class="min-h-screen flex">

        <!-- Sidebar -->
        <div class="w-64 bg-sidebarBg shadow-md h-screen fixed top-0 left-0 flex flex-col text-white">
            <div class="p-5 border-b border-gray-700">
                <div class="flex items-center">
                    {{-- <div
                        class="bg-red-700 w-10 h-10 rounded-lg flex items-center justify-center text-white font-bold text-xl">
                        GMS</div> --}}
                    <div class="ml-3">
                        <h2 class="text-xl font-bold text-white text-center">Growth Management</h2>
                        <p class="text-xs text-gray-400">Admin Panel</p>
                    </div>
                </div>
            </div>

            @include('admin.include.sidebar')

            @php
                $rolename = null;
                $name = null;
                $logout = null;

                if (Auth::guard('admin')->check()) {
                    $rolename = Auth::guard('admin')->user()->role->role ?? '';
                    $name = Auth::guard('admin')->user()->name ?? '';
                    $logout = route('admin.logout') ?? "";
                } elseif (Auth::guard('employee')->check()) {
                    $rolename = Auth::guard('employee')->user()->role->role ?? '';
                    $name = Auth::guard('employee')->user()->name ?? '';
                     $logout = route('employee.logout') ?? "";
                }  elseif (Auth::guard('intern')->check()) {
                    $rolename = Auth::guard('intern')->user()->role->role ?? '';
                    $name = Auth::guard('intern')->user()->name ?? '';
                     $logout = route('intern.logout') ?? "";
                }
            @endphp

            <div class="mt-auto p-4 border-t border-gray-700">
                <div class="flex items-center">

                    <div class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center">
                        <i class="fas fa-user text-gray-300"></i>
                    </div>

                    <div class="ml-3">
                        <a href="{{ route('update.password') }}">
                            <p class="text-sm font-medium text-white">
                                {{ $name ?? 'User' }}
                            </p>
                            <p class="text-xs text-gray-400">
                                {{ $rolename ?? 'Role' }}
                            </p>
                        </a>
                    </div>

                    <a href="{{ $logout }}" class="ml-auto text-gray-400 hover:text-red-500 transition">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>

                </div>
            </div>

        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col ml-64">
            @include('admin.include.topnav')
            <main class="flex-1 p-6 overflow-auto bg-gray-50">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Mobile sidebar toggle
        document.getElementById('sidebar-toggle')?.addEventListener('click', function() {
            const sidebar = document.querySelector('.w-64');
            sidebar.classList.toggle('hidden');
            sidebar.classList.toggle('absolute');
            sidebar.classList.toggle('z-50');
        });

        // Active state for sidebar links
        const sidebarLinks = document.querySelectorAll('.sidebar-link');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                sidebarLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
    @include('admin.include.datatable')
    @stack('scripts')
</body>

</html>
