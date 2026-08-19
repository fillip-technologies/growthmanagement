<!-- Include Alpine.js -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<!-- Topbar -->
<header class="bg-white/95 border-b border-slate-200 shadow-sm sticky top-0 z-20 backdrop-blur-xl"
        x-data="{
            showNotifications: false,
            showProfileMenu: false,
            searchQuery: '',
            notifications: [
                { id: 1, title: 'New task assigned', time: '5 min ago', read: false, icon: 'fas fa-tasks' },
                { id: 2, title: 'Project deadline approaching', time: '1 hour ago', read: false, icon: 'fas fa-clock' },
                { id: 3, title: 'Meeting in 30 minutes', time: '2 hours ago', read: true, icon: 'fas fa-calendar' },
                { id: 4, title: 'New comment on your task', time: '5 hours ago', read: true, icon: 'fas fa-comment' }
            ],
            unreadCount() {
                return this.notifications.filter(n => !n.read).length;
            },
            markAsRead(id) {
                let notification = this.notifications.find(n => n.id === id);
                if (notification) notification.read = true;
            },
            markAllRead() {
                this.notifications.forEach(n => n.read = true);
            }
        }">

    <div class="px-6 py-3 flex items-center justify-between">

        <!-- Left Section - Title & Mobile Menu -->
        <div class="flex items-center space-x-4">
            <button id="sidebar-toggle" class="grid h-10 w-10 place-items-center rounded-xl border border-slate-200 bg-white text-slate-500 shadow-sm transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600" aria-label="Toggle sidebar">
                <i class="fas fa-bars text-xl"></i>
            </button>

            <!-- Page Title with gradient -->
            <div>
                <h1 class="text-xl font-bold text-slate-900">
                    @yield('heading', 'Dashboard')
                </h1>
                <p class="text-xs text-slate-500 hidden sm:block">
                    <i class="fas fa-calendar-alt mr-1"></i>
                    {{ now()->format('l, F j, Y') }}
                </p>
            </div>
        </div>

        <!-- Right Section - Search, Notifications, Profile -->
        <div class="flex items-center space-x-4">

            <!-- Search Bar -->
            <div class="hidden md:block relative">
                <input type="text"
                       x-model="searchQuery"
                       placeholder="Search..."
                       class="w-64 px-4 py-2 pl-10 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-400 focus:ring-4 focus:ring-blue-100 transition-all duration-200">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400 text-sm"></i>

                <!-- Search Results Dropdown -->
                <div x-show="searchQuery.length > 0"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform -translate-y-2"
                     class="absolute top-full right-0 mt-2 w-80 bg-white border border-slate-200 rounded-xl shadow-xl overflow-hidden z-50">
                    <div class="p-2">
                        <div class="text-xs text-slate-400 px-3 py-2">Recent Searches</div>
                        <a href="#" class="flex items-center px-3 py-2 hover:bg-blue-50 rounded-lg transition-colors">
                            <i class="fas fa-tasks text-slate-400 mr-3 text-sm"></i>
                            <span class="text-sm text-slate-600">Tasks</span>
                        </a>
                        <a href="#" class="flex items-center px-3 py-2 hover:bg-blue-50 rounded-lg transition-colors">
                            <i class="fas fa-users text-slate-400 mr-3 text-sm"></i>
                            <span class="text-sm text-slate-600">Employees</span>
                        </a>
                        <a href="#" class="flex items-center px-3 py-2 hover:bg-blue-50 rounded-lg transition-colors">
                            <i class="fas fa-file-alt text-slate-400 mr-3 text-sm"></i>
                            <span class="text-sm text-slate-600">Reports</span>
                        </a>
                    </div>
                </div>
            </div>




        </div>
    </div>

    <!-- Mobile Search Bar (Hidden on Desktop) -->
    <div class="md:hidden px-6 pb-3">
        <div class="relative">
            <input type="text"
                   placeholder="Search..."
                   class="w-full px-4 py-2 pl-10 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:border-blue-400 focus:ring-4 focus:ring-blue-100">
            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400 text-sm"></i>
        </div>
    </div>
</header>

<style>
   
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Smooth transitions */
    .rotate-180 {
        transform: rotate(180deg);
    }

    /* Notification badge pulse animation */
    .notification-badge {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
    }
</style>
