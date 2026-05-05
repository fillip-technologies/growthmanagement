<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Growth Management System - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#e73c7e', // Yellow from screenshot
                        secondary: '#10b981', // Green from featured tags
                        dark: '#1f2937', // Dark gray for text
                        light: '#f3f4f6' // Light background
                    }
                }
            }
        }
    </script>
    <style>
        .sidebar-link.active {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            color: #b45309;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .login-card {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        video {
            position: fixed !important;
        }
    </style>

</head>

<body class="bg-gray-100 font-sans">
    <!-- Login Screen -->
    <!-- Login Screen -->
    <!-- Login Screen with Video Background -->
    <div id="login-screen" class="relative min-h-screen flex items-center justify-center overflow-hidden">

        <!-- VIDEO BACKGROUND -->
        <video autoplay loop muted playsinline class="absolute inset-0 w-full h-full object-cover">
            <source src="{{ asset('3540184215-preview.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>

        <!-- DARK OVERLAY -->
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

        <!-- LOGIN CARD / CONTENT -->
        <div
            class="relative z-10 w-full max-w-5xl grid grid-cols-1 md:grid-cols-2 rounded-2xl overflow-hidden shadow-2xl">
            <!-- Left Logo -->
            <div
                class="flex flex-col items-center justify-center p-10 bg-white/10 backdrop-blur-xl border-r border-white/20">
                <img src="{{ asset('logo.png') }}" class="w-60 h-60 object-contain drop-shadow-xl mb-6">
                <h1 class="text-4xl font-bold text-white drop-shadow-xl text-center">Growth Management System</h1>
                <p class="text-white/80 mt-3 text-center text-lg">Panel Login</p>
            </div>

            <!-- Right Login Form -->
            <div class="p-10 bg-white/20 backdrop-blur-2xl">



                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf

                    <h2 class="text-white text-3xl font-semibold mb-8 text-center">
                        Welcome Back
                    </h2>
                    <div class="flex justify-center gap-4 mb-6">
                        <label class="cursor-pointer">
                            <input type="radio" name="user_type" value="admin" checked onclick="switchTab('admin')"
                                class="hidden peer">
                            <span
                                class="px-4 py-2 rounded-lg border border-white/30 text-white peer-checked:bg-white/30">
                                Admin
                            </span>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="user_type" value="hr"
                                class="hidden peer">
                            <span
                                class="px-4 py-2 rounded-lg border border-white/30 text-white peer-checked:bg-white/30">
                                HR
                            </span>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="user_type" value="employee"
                                class="hidden peer">
                            <span
                                class="px-4 py-2 rounded-lg border border-white/30 text-white peer-checked:bg-white/30">
                                Employees
                            </span>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="user_type" value="intern" onclick="switchTab('intern')"
                                class="hidden peer">
                            <span
                                class="px-4 py-2 rounded-lg border border-white/30 text-white peer-checked:bg-white/30">
                                Interns
                            </span>
                        </label>
                    </div>
                    <input type="email" name="email" placeholder="admin@gmail.com"
                        class="w-full mb-5 px-4 py-3 rounded-lg bg-white/30 text-white border border-white/40" required>

                    <input type="password" name="password" placeholder="••••••••"
                        class="w-full mb-6 px-4 py-3 rounded-lg bg-white/30 text-white border border-white/40" required>

                    <button type="submit" class="w-full bg-orange-300 hover:bg-orange-400 text-white py-3 rounded-lg">
                        Sign In
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Toggle between login and admin panel
        document.getElementById('login-form').addEventListener('submit', function(e) {
            // e.preventDefault();
            document.getElementById('login-screen').classList.add('hidden');
            document.getElementById('admin-panel').classList.remove('hidden');
        });

        // Mobile sidebar toggle
        document.getElementById('sidebar-toggle').addEventListener('click', function() {
            const sidebar = document.querySelector('.w-64');
            sidebar.classList.toggle('hidden');
            sidebar.classList.toggle('absolute');
            sidebar.classList.toggle('z-50');
        });

        // Set active state for sidebar links
        const sidebarLinks = document.querySelectorAll('.sidebar-link');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                sidebarLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>

</html>
