<!-- Include Alpine.js -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<!-- Topbar -->
<header class="bg-black text-white shadow-sm py-4 px-6 flex items-center justify-between" x-data="{ showNotifications: false }">
    <div class="flex items-center">
        <button id="sidebar-toggle" class="text-gray-500 mr-4 md:hidden">
            <i class="fas fa-bars text-xl"></i>
        </button>
        <h1 class="text-xl font-semibold text-white">@yield('heading', 'Dashboard')</h1>
    </div>

    <div class="flex items-center space-x-4">
        <!-- Notification Bell -->
        <div class="relative" @click.away="showNotifications = false">
            <button @click="showNotifications = !showNotifications" class="text-gray-500 hover:text-dark relative">
                <i class="fas fa-bell text-xl"></i>
                <span class="absolute top-0 right-0 w-3 h-3 bg-red-500 rounded-full"></span>
            </button>

            <!-- Dropdown Box -->
            <div x-show="showNotifications"
                x-transition
                class="absolute right-0 mt-3 w-72 bg-white rounded-lg shadow-lg border border-gray-200 z-50"
            >
                <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-sm font-semibold text-gray-700">Notifications</h3>
                    <button @click="showNotifications = false" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <ul class="max-h-64 overflow-y-auto">
                    <li class="px-4 py-3 hover:bg-gray-50 text-gray-600 text-sm">
                        No new notifications 🎉
                    </li>
                    <!-- Example notification item:
                    <li class="px-4 py-3 hover:bg-gray-50 text-gray-600 text-sm">
                        Order #1234 has been shipped 🚚
                    </li>
                    -->
                </ul>

                <div class="p-3 text-center border-t border-gray-200">
                    <a href="#" class="text-primary text-sm hover:underline">View all</a>
                </div>
            </div>
        </div>

    </div>
</header>
