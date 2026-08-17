<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Growth Management System - Admin Panel')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Quicksand:wght@300..700&family=Red+Hat+Display:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">

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
                        sidebarBg: '#ffffff',
                        sidebarHover: '#eff6ff'
                    },
                    fontFamily: {
                        sans: ['Red Hat Display', 'Montserrat', 'Quicksand', 'ui-sans-serif', 'system-ui', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <style>
        .app-sidebar {
            border-right: 1px solid #e8eef8;
            box-shadow: 18px 0 45px rgba(15, 36, 87, 0.08);
            transition: width 0.25s ease, transform 0.25s ease;
            z-index: 40;
        }

        .app-main {
            transition: margin-left 0.25s ease;
        }

        .app-sidebar-brand {
            background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
        }

        .app-sidebar-menu {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .app-sidebar-menu::-webkit-scrollbar {
            display: none;
        }

        .app-sidebar-menu a,
        .app-sidebar-menu button {
            background: transparent !important;
            border-color: transparent !important;
            box-shadow: none !important;
            color: #52617a !important;
            font-weight: 650;
            letter-spacing: 0;
        }

        .app-sidebar-menu a:hover,
        .app-sidebar-menu button:hover {
            background: #eff6ff !important;
            color: #2563eb !important;
            transform: translateX(2px);
        }

        .app-sidebar-menu > a:first-of-type {
            background: #eff6ff !important;
            color: #2563eb !important;
        }

        .app-sidebar-menu i {
            color: #8a96ad !important;
            min-width: 20px;
            text-align: center;
        }

        .app-sidebar-menu a:hover i,
        .app-sidebar-menu button:hover i,
        .app-sidebar-menu > a:first-of-type i {
            color: #2563eb !important;
        }

        .app-sidebar-menu [x-show] {
            background: #f8fbff;
            border: 1px solid #edf3fb;
            border-radius: 16px;
            margin-left: 0 !important;
            padding: 8px;
        }

        .app-sidebar-user {
            border-top: 1px solid #e8eef8;
            background: #f8fbff;
        }

        .sidebar-collapsed .app-sidebar {
            width: 5rem;
        }

        .sidebar-collapsed .app-main {
            margin-left: 5rem;
        }

        .sidebar-collapsed .brand-copy,
        .sidebar-collapsed .sidebar-user-copy,
        .sidebar-collapsed .sidebar-logout,
        .sidebar-collapsed .app-sidebar-section-title {
            display: none;
        }

        .sidebar-collapsed .app-sidebar-brand {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .sidebar-collapsed .app-sidebar-brand .flex,
        .sidebar-collapsed .app-sidebar-user .flex {
            justify-content: center;
        }

        .sidebar-collapsed .app-sidebar-menu {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .sidebar-collapsed .app-sidebar-menu a,
        .sidebar-collapsed .app-sidebar-menu button {
            justify-content: center;
            padding-left: 0.75rem !important;
            padding-right: 0.75rem !important;
            font-size: 0;
        }

        .sidebar-collapsed .app-sidebar-menu i {
            margin-right: 0 !important;
            font-size: 1.05rem;
        }

        .sidebar-overlay {
            display: none;
        }

        @media (max-width: 767px) {
            .app-sidebar {
                transform: translateX(-100%);
                width: 16rem;
            }

            .app-main {
                margin-left: 0 !important;
            }

            .sidebar-mobile-open .app-sidebar {
                transform: translateX(0);
            }

            .sidebar-mobile-open .sidebar-overlay {
                display: block;
            }

            .sidebar-collapsed .app-sidebar {
                width: 16rem;
            }

            .sidebar-collapsed .brand-copy,
            .sidebar-collapsed .sidebar-user-copy,
            .sidebar-collapsed .sidebar-logout,
            .sidebar-collapsed .app-sidebar-section-title {
                display: block;
            }

            .sidebar-collapsed .app-sidebar-menu a,
            .sidebar-collapsed .app-sidebar-menu button {
                justify-content: flex-start;
                padding-left: 1.5rem !important;
                padding-right: 1.5rem !important;
                font-size: inherit;
            }

            .sidebar-collapsed .app-sidebar-menu i {
                margin-right: 1rem !important;
            }
        }

        .sidebar-link.active {
            background-color: #eff6ff;
            border-left: 4px solid #2563eb;
            color: #2563eb;
        }

        .sidebar-link:hover {
            background-color: #eff6ff;
            color: #2563eb;
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
    <div id="admin-panel" class="min-h-screen flex ">

        <!-- Sidebar -->
        <div id="app-sidebar" class="app-sidebar w-64 bg-sidebarBg h-screen fixed top-0 left-0 flex flex-col text-slate-700">
            <div class="app-sidebar-brand p-5 border-b border-slate-100">
                <div class="flex items-center">
                    <div
                        class="bg-blue-50 w-12 h-12 rounded-2xl flex items-center justify-center text-blue-600 shadow-sm">
                        <i class="fas fa-chart-line text-xl"></i>
                    </div>
                    <div class="brand-copy ml-3">
                        <h2 class="text-xl font-bold tracking-[0.08em] text-slate-950">Growth Management</h2>
                        <p class="text-xs font-semibold tracking-[0.08em] text-blue-500">Business Operating Platform</p>
                    </div>
                </div>
            </div>

            @include('admin.include.sidebar')

            @php
                $rolename = null;
                $name = null;
                $logout = null;
                $profile = null;

                if (Auth::guard('super_admin')->check()) {
                    $rolename = Auth::guard('super_admin')->user()->role ?? '';
                    $name = Auth::guard('super_admin')->user()->name ?? '';
                    $profile = route('autherprofile');
                    $logout = route('admin.logout') ?? '';
                } elseif (Auth::guard('employee')->check()) {
                    $rolename = Auth::guard('employee')->user()->role ?? '';
                    $name = Auth::guard('employee')->user()->name ?? '';
                    $logout = route('employee.logout') ?? '';
                    $profile = route('employee.autherprofile');
                } elseif (Auth::guard('team_leader')->check()) {
                    $rolename = Auth::guard('team_leader')->user()->role ?? '';
                    $name = Auth::guard('team_leader')->user()->name ?? '';
                    $logout = route('teamhead.logout') ?? '';
                    $profile = route('teamhead.autherprofile');
                } elseif (Auth::guard('project_manager')->check()) {
                    $rolename = Auth::guard('project_manager')->user()->role ?? '';
                    $name = Auth::guard('project_manager')->user()->name ?? '';
                    $logout = route('admin.logout') ?? '';
                    $profile = route('autherprofile');

                }elseif (Auth::guard('hr_manager')->check()) {
                    $rolename = Auth::guard('hr_manager')->user()->role ?? '';
                    $name = Auth::guard('hr_manager')->user()->name ?? '';
                    $logout = route('hrmanagerLogout') ?? '';
                    $profile = route('autherprofile');

                }elseif (Auth::guard('marketing_manager')->check()) {
                    $rolename = Auth::guard('marketing_manager')->user()->role ?? '';
                    $name = Auth::guard('marketing_manager')->user()->name ?? '';
                    $logout = route('hrmanagerLogout') ?? '';
                    $profile = route('autherprofile');

                }elseif (Auth::guard('account_manager')->check()) {
                    $rolename = Auth::guard('account_manager')->user()->role ?? '';
                    $name = Auth::guard('account_manager')->user()->name ?? '';
                    $logout = route('acmanagerLogout') ?? '';
                    $profile = route('autherprofile');

                }elseif (Auth::guard('sales_manager')->check()) {
                    $rolename = Auth::guard('sales_manager')->user()->role ?? '';
                    $name = Auth::guard('sales_manager')->user()->name ?? '';
                    $logout = route('sales.logout') ?? '';
                    $profile = route('autherprofile');

                }
            @endphp

            <div class="app-sidebar-user mt-auto p-4">
                <div class="flex items-center">

                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center">
                        <a href="{{$profile}}">
                            <i class="fas fa-user text-blue-600"></i>
                        </a>

                    </div>

                    <div class="sidebar-user-copy ml-3">
                        <a href="{{ route('update.password') }}">
                            <p class="text-sm font-semibold text-slate-800">
                                {{ $name ?? 'User' }}
                            </p>
                            <p class="text-xs text-slate-500">
                                {{ $rolename ?? 'Role' }}
                            </p>
                        </a>
                    </div>

                    <a href="{{ $logout }}" class="sidebar-logout ml-auto text-slate-400 hover:text-blue-600 transition">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>

                </div>
            </div>

        </div>
        <button type="button" id="sidebar-overlay" class="sidebar-overlay fixed inset-0 bg-slate-950/40 backdrop-blur-sm z-30 md:hidden" aria-label="Close sidebar"></button>

        <!-- Main Content -->
        <div class="app-main min-w-0 flex-1 flex flex-col ml-64">
            @include('admin.include.topnav')
            <main class="min-w-0 flex-1 overflow-auto bg-gray-50 p-3 sm:p-5 lg:p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Responsive sidebar toggle
        document.getElementById('sidebar-toggle')?.addEventListener('click', function() {
            if (window.innerWidth < 768) {
                document.body.classList.toggle('sidebar-mobile-open');
                return;
            }

            document.body.classList.toggle('sidebar-collapsed');
        });

        document.getElementById('sidebar-overlay')?.addEventListener('click', function() {
            document.body.classList.remove('sidebar-mobile-open');
        });

        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                document.body.classList.remove('sidebar-mobile-open');
            }
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
