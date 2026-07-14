<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Growth Management System - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#e73c7e',
                        secondary: '#10b981',
                        dark: '#1f2937',
                        light: '#f3f4f6'
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 3s ease-in-out infinite',
                        'shimmer': 'shimmer 2s infinite',
                        'gradient': 'gradient 8s ease infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': {
                                transform: 'translateY(0px)'
                            },
                            '50%': {
                                transform: 'translateY(-20px)'
                            },
                        },
                        shimmer: {
                            '0%': {
                                backgroundPosition: '-1000px 0'
                            },
                            '100%': {
                                backgroundPosition: '1000px 0'
                            },
                        },
                        gradient: {
                            '0%, 100%': {
                                backgroundPosition: '0% 50%'
                            },
                            '50%': {
                                backgroundPosition: '100% 50%'
                            },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes glowPulse {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(245, 158, 11, 0.3);
            }

            50% {
                box-shadow: 0 0 40px rgba(245, 158, 11, 0.6);
            }
        }

        @keyframes borderGlow {

            0%,
            100% {
                border-color: rgba(255, 255, 255, 0.2);
            }

            50% {
                border-color: rgba(245, 158, 11, 0.6);
            }
        }

        .animate-fade-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .animate-slide-left {
            animation: slideInLeft 0.6s ease-out forwards;
        }

        .animate-slide-right {
            animation: slideInRight 0.6s ease-out forwards;
        }

        .video-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -2;
        }

        .overlay-gradient {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.5) 100%);
            backdrop-filter: blur(8px);
            z-index: -1;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 32px;
        }

        .input-field {
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .input-field:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: #f59e0b;
            box-shadow: 0 0 20px rgba(245, 158, 11, 0.2);
            transform: translateY(-2px);
        }

        .input-field:focus+.input-icon {
            color: #f59e0b;
            transform: translateY(-2px);
        }

        .input-icon {
            transition: all 0.3s ease;
        }

        .radio-tab {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .radio-tab::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .radio-tab:hover::before {
            width: 300px;
            height: 300px;
        }

        .radio-tab.active {
            background: rgba(245, 158, 11, 0.3);
            border-color: #f59e0b;
            box-shadow: 0 0 15px rgba(245, 158, 11, 0.3);
        }

        .submit-btn {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            background-size: 200% 200%;
            animation: gradient 3s ease infinite;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(245, 158, 11, 0.4);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .floating-shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.3;
            animation: float 8s ease-in-out infinite;
            z-index: -1;
        }

        .shape-1 {
            top: 10%;
            left: -10%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, #f59e0b, transparent);
        }

        .shape-2 {
            bottom: 10%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, #e73c7e, transparent);
            animation-delay: 2s;
        }

        .shape-3 {
            top: 50%;
            left: 50%;
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, #10b981, transparent);
            animation-delay: 4s;
            transform: translate(-50%, -50%);
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .loading-spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: rotate 0.8s linear infinite;
        }

        .particle {
            position: absolute;
            background: rgba(245, 158, 11, 0.3);
            border-radius: 50%;
            pointer-events: none;
            animation: float 12s ease-in-out infinite;
        }
    </style>
</head>

<body class="font-sans overflow-hidden">

    @if ($errors->any())
        <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Login Failed',
                    html: `{!! implode('<br>', $errors->all()) !!}`,
                    confirmButtonColor: '#f59e0b',
                });
        </script>
    @endif

    @if (session('success'))
        <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    timer: 3000,
                    showConfirmButton: false
                });

        </script>
    @endif

    @if (session('error'))
        <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Errors!',
                    text: "{{ session('error') }}",
                    timer: 3000,
                    showConfirmButton: false
                });

        </script>
    @endif

    <!-- Video Background -->
    <video autoplay loop muted playsinline class="video-background">
        <source src="{{ asset('3540184215-preview.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <!-- Gradient Overlay -->
    <div class="overlay-gradient"></div>

    <!-- Floating Shapes -->
    <div class="floating-shape shape-1"></div>
    <div class="floating-shape shape-2"></div>
    <div class="floating-shape shape-3"></div>

    <!-- Particles Container -->
    <div id="particles"></div>

    <!-- Login Container -->
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-6xl mx-auto">

            <!-- Main Card -->
            <div class="glass-card overflow-hidden shadow-2xl">
                <div class="grid grid-cols-1 lg:grid-cols-2">

                    <!-- Left Side - Branding -->
                    <div
                        class="relative p-8 lg:p-12 flex flex-col items-center justify-center text-center border-b lg:border-b-0 lg:border-r border-white/10 backdrop-blur-sm">
                        <div
                            class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-orange-500/10 to-purple-500/10">
                        </div>

                        <div class="relative z-10 animate-float">
                            <div
                                class="w-32 h-32 lg:w-40 lg:h-40 mx-auto mb-6 bg-gradient-to-br from-orange-500 to-orange-600 rounded-3xl flex items-center justify-center shadow-2xl transform rotate-6 hover:rotate-12 transition-all duration-500">
                                <i class="fas fa-chart-line text-white text-5xl lg:text-6xl"></i>
                            </div>
                        </div>

                        <h1 class="text-3xl lg:text-4xl font-bold text-white mb-3 animate-slide-left">
                            Growth Management
                        </h1>
                        <p class="text-orange-300 text-lg font-medium mb-4 animate-slide-left"
                            style="animation-delay: 0.1s">
                            System
                        </p>
                        <div class="w-20 h-1 bg-gradient-to-r from-orange-500 to-orange-300 rounded-full mx-auto mb-6">
                        </div>
                        <p class="text-white/70 text-sm max-w-xs animate-slide-left" style="animation-delay: 0.2s">
                            Your all-in-one solution for managing projects, tasks, employees, and tracking growth
                            metrics.
                        </p>

                        <div class="mt-8 flex gap-3 animate-slide-left" style="animation-delay: 0.3s">
                            <div class="flex items-center gap-2 text-white/60 text-xs">
                                <i class="fas fa-check-circle text-green-500"></i>
                                <span>Secure Access</span>
                            </div>
                            <div class="flex items-center gap-2 text-white/60 text-xs">
                                <i class="fas fa-check-circle text-green-500"></i>
                                <span>24/7 Support</span>
                            </div>
                            <div class="flex items-center gap-2 text-white/60 text-xs">
                                <i class="fas fa-check-circle text-green-500"></i>
                                <span>Real-time Updates</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side - Login Form -->
                    <div class="p-8 lg:p-12 animate-fade-up">
                        <div class="text-center mb-8">
                            <h2 class="text-2xl lg:text-3xl font-bold text-white mb-2">
                                Welcome Back
                            </h2>
                            <p class="text-white/60 text-sm">
                                Sign in to access your dashboard
                            </p>
                        </div>

                        <form method="POST" action="{{ route('admin.login') }}" id="loginForm">
                            @csrf

                            <!-- User Type Tabs -->
                            <!-- Role Selection -->
                            <div class="mb-5">
                                <label for="roleSelect"
                                    class="mb-2 flex items-center text-sm font-semibold text-white">
                                    <i class="fas fa-user-tag text-white mr-2"></i>
                                    I am a
                                </label>

                                <div class="relative">
                                    <select id="roleSelect" name="role" required
                                        class="w-full appearance-none rounded-xl border border-gray-300  px-4 py-3 pr-12 text-gray-700 shadow-sm transition-all duration-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 focus:outline-none hover:border-indigo-400">

                                        <option value="" disabled selected>— Select your role —</option>
                                        <option value="super_admin">👑 Super Admin</option>
                                        <option value="project_manager">📋 Project Manager</option>
                                        <option value="team_leader">📈 Development Head</option>
                                        <option value="marketing_manager">📊 Marketing Manager</option>
                                        <option value="hr_manager">📊 HR Manager</option>
                                        <option value="account_manager">📊 Account Manager</option>
                                        <option value="employee">🧑‍💻 Employee</option>
                                    </select>

                                    <!-- Dropdown Arrow -->
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>

                                <p class="mt-2 text-xs text-gray-300">
                                    Select your login role to continue.
                                </p>
                            </div>

                            <!-- Email Field -->
                            <div class="relative mb-5 group">
                                <div class="relative">
                                    <i
                                        class="fas fa-envelope input-icon absolute left-4 top-1/2 transform -translate-y-1/2 text-white/50 group-focus-within:text-orange-400 transition-all"></i>
                                    <input type="email" name="email" placeholder="Email Address"
                                        class="input-field w-full pl-12 pr-4 py-3 rounded-xl text-white placeholder-white/50 focus:outline-none transition-all">
                                </div>
                            </div>

                            <!-- Password Field -->
                            <div class="relative mb-6 group">
                                <div class="relative">
                                    <i
                                        class="fas fa-lock input-icon absolute left-4 top-1/2 transform -translate-y-1/2 text-white/50 group-focus-within:text-orange-400 transition-all"></i>
                                    <input type="password" name="password" id="password" placeholder="Password"
                                        class="input-field w-full pl-12 pr-12 py-3 rounded-xl text-white placeholder-white/50 focus:outline-none transition-all">
                                    <button type="button" onclick="togglePassword()"
                                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white/50 hover:text-orange-400 transition-all">
                                        <i id="passwordToggleIcon" class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="flex justify-between items-center mb-8">
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="checkbox" name="remember"
                                        class="w-4 h-4 rounded border-white/30 bg-white/10 checked:bg-orange-500 focus:ring-orange-500">
                                    <span class="text-white/70 text-sm group-hover:text-white transition-colors">
                                        Remember me
                                    </span>
                                </label>
                                <a href="#"
                                    class="text-orange-400 text-sm hover:text-orange-300 transition-colors">
                                    Forgot Password?
                                </a>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" id="submitBtn"
                                class="submit-btn w-full py-3 rounded-xl text-white font-semibold flex items-center justify-center gap-2 transition-all">
                                <span id="btnText">Sign In</span>
                                <span id="btnSpinner" class="loading-spinner"></span>
                                <i id="btnIcon" class="fas fa-arrow-right"></i>
                            </button>
                        </form>

                        <!-- Divider -->
                        <div class="relative my-8">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-white/20"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-4 bg-transparent text-white/50 text-xs">Secure Login</span>
                            </div>
                        </div>

                        <!-- Footer Text -->
                        <div class="text-center text-white/40 text-xs">
                            <i class="fas fa-shield-alt mr-1"></i>
                            Protected by advanced encryption
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Note -->
            <div class="text-center mt-8 text-white/40 text-xs">
                © 2024 Growth Management System. All rights reserved.
            </div>
        </div>
    </div>

    <script>
        // Toggle Password Visibility
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const icon = document.getElementById('passwordToggleIcon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Switch User Type Tab
        function switchTab(radio) {
            const tabs = document.querySelectorAll('.radio-tab');
            const value = radio.value;

            tabs.forEach(tab => {
                const parent = tab.parentElement;
                const input = parent.querySelector('input');
                if (input && input.value === value && input.checked) {
                    tab.classList.add('active');
                } else if (tab.classList.contains('active')) {
                    tab.classList.remove('active');
                }
            });
        }

        // Form Submit with Loading Animation
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const btnSpinner = document.getElementById('btnSpinner');
            const btnIcon = document.getElementById('btnIcon');

            // Don't prevent default, just show loading
            btnText.textContent = 'Signing In...';
            btnSpinner.style.display = 'inline-block';
            btnIcon.style.display = 'none';
            submitBtn.disabled = true;

            // Re-enable after 30 seconds if stuck (safety)
            setTimeout(() => {
                if (submitBtn.disabled) {
                    btnText.textContent = 'Sign In';
                    btnSpinner.style.display = 'none';
                    btnIcon.style.display = 'inline-block';
                    submitBtn.disabled = false;
                }
            }, 30000);
        });

        // Create floating particles
        function createParticles() {
            const container = document.getElementById('particles');
            const particleCount = 50;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                const size = Math.random() * 4 + 2;
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 10 + 's';
                particle.style.animationDuration = Math.random() * 10 + 8 + 's';
                container.appendChild(particle);
            }
        }

        // Initialize on load
        document.addEventListener('DOMContentLoaded', function() {
            createParticles();

            // Check for saved user type preference
            const savedType = localStorage.getItem('lastUserType');
            if (savedType) {
                const radio = document.querySelector(`input[value="${savedType}"]`);
                if (radio) {
                    radio.checked = true;
                    switchTab(radio);
                }
            }

            // Save user type on change
            document.querySelectorAll('input[name="user_type"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.checked) {
                        localStorage.setItem('lastUserType', this.value);
                    }
                });
            });

            // Animate elements on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.animate-on-scroll').forEach(el => {
                observer.observe(el);
            });
        });

        // Add floating effect to input fields
        document.querySelectorAll('.input-field').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('ring-2', 'ring-orange-500/50', 'rounded-xl');
            });
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('ring-2', 'ring-orange-500/50');
            });
        });
    </script>

    <style>
        /* Additional styles for better appearance */
        .glass-card {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.08);
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-background-clip: text;
            -webkit-text-fill-color: white;
            transition: background-color 5000s ease-in-out 0s;
            background-color: transparent !important;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(245, 158, 11, 0.5);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(245, 158, 11, 0.8);
        }

        .radio-tab.active {
            background: rgba(245, 158, 11, 0.3);
            border: 1px solid rgba(245, 158, 11, 0.5);
        }
    </style>
</body>

</html>
