<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Growth Management System - Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Quicksand:wght@300..700&family=Red+Hat+Display:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <script>
        tailwind = {
            config: {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Red Hat Display', 'Montserrat', 'Quicksand', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        },
                    },
                },
            },
        };
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="min-h-screen overflow-x-hidden bg-[#071329] font-sans text-slate-100 antialiased">
    <main class="relative min-h-screen overflow-hidden bg-[radial-gradient(circle_at_18%_14%,rgba(37,99,235,0.20),transparent_32%),radial-gradient(circle_at_85%_20%,rgba(6,182,212,0.16),transparent_34%),linear-gradient(135deg,#071329_0%,#0B1933_48%,#102A4A_100%)] px-4 py-5 sm:px-6 lg:px-8">
        <section class="flex min-h-[calc(100vh-40px)] items-center justify-center">
            <div class="grid w-[min(86vw,1320px)] overflow-hidden rounded-[30px] border border-white/20 bg-white/[0.07] shadow-[0_28px_80px_rgba(2,6,23,0.58)] backdrop-blur-xl lg:h-[min(84vh,780px)] lg:max-h-[calc(100vh-40px)] lg:min-h-[620px] lg:grid-cols-[52%_48%]">
                <aside class="relative flex min-h-[500px] flex-col justify-between overflow-hidden border-b border-white/10 bg-cover bg-center bg-no-repeat p-7 sm:min-h-[540px] sm:p-10 lg:min-h-0 lg:border-b-0 lg:border-r lg:p-12"
                    style="background-image: url('{{ asset('background-login.png') }}');">
                    <div class="pointer-events-none absolute inset-0 bg-gradient-to-r from-[#06152D]/20 via-[#06152D]/8 to-transparent"></div>

                    <div class="relative z-10">
                        <div class="flex items-center gap-4">
                            <div class="grid h-14 w-14 place-items-center rounded-2xl bg-white text-blue-600 shadow-lg shadow-blue-950/25 sm:h-16 sm:w-16">
                                <i class="fas fa-chart-line text-2xl"></i>
                            </div>
                            <div>
                                <h1 class="text-xl font-bold tracking-[0.08em] text-white sm:text-2xl">Growth Management</h1>
                                <p class="mt-1 text-xs font-semibold tracking-[0.12em] text-cyan-200 sm:text-sm">Business Operating Platform</p>
                            </div>
                        </div>

                        <div class="mt-12 max-w-[520px] sm:mt-14 lg:mt-16">
                            <h2 class="text-4xl font-bold leading-[1.06] tracking-normal text-white sm:text-5xl xl:text-[54px]">
                                Everything your team needs.<br>
                                One connected workspace.
                            </h2>
                            <p class="mt-7 max-w-[500px] text-base leading-[1.7] text-slate-300 sm:text-lg">
                                Manage people, projects, tasks, performance, and daily operations from one powerful platform.
                            </p>
                            <p class="mt-4 text-xs font-bold uppercase tracking-[0.28em] text-cyan-200/90">
                                BY FILLIP TECHNOLOGIES
                            </p>
                        </div>
                    </div>

                </aside>

                <section class="flex min-h-[600px] items-center justify-center overflow-hidden bg-white/[0.97] px-6 py-9 text-slate-900 backdrop-blur-xl sm:px-10 lg:min-h-0 lg:px-12 xl:px-16">
                    <div class="w-full max-w-[560px]">
                        <div class="mb-7 text-left">
                            <div class="mb-5 grid h-14 w-14 place-items-center rounded-[18px] bg-blue-50 text-blue-600 shadow-sm">
                                <i class="fas fa-chart-line text-2xl"></i>
                            </div>
                            <h2 class="text-[36px] font-bold leading-[1.1] tracking-normal text-slate-950 sm:text-[42px]">Welcome Back</h2>
                            <p class="mt-3 text-lg text-slate-500">Sign in to access your dashboard</p>
                        </div>

                        @if ($errors->any())
                        <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                            <ul class="space-y-1">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @if (session('success'))
                        <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                            {{ session('success') }}
                        </div>
                        @endif

                        @if (session('error'))
                        <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                            {{ session('error') }}
                        </div>
                        @endif

                        <form method="POST" action="{{ route('admin.login') }}" id="loginForm" class="space-y-5">
                            @csrf

                            <div>
                                <label for="email" class="mb-2 block text-base font-bold text-slate-700">Email address</label>
                                <div class="relative">
                                    <span class="absolute left-5 top-1/2 grid h-10 w-10 -translate-y-1/2 place-items-center rounded-xl bg-blue-50 text-blue-600">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="admin@gmail.com" autocomplete="email"
                                        class="h-16 w-full rounded-2xl border border-blue-100 bg-[#F1F6FF] pl-20 pr-5 text-base text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-blue-200 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100 sm:text-lg">
                                </div>
                            </div>

                            <div>
                                <label for="password" class="mb-2 block text-base font-bold text-slate-700">Password</label>
                                <div class="relative">
                                    <span class="absolute left-5 top-1/2 grid h-10 w-10 -translate-y-1/2 place-items-center rounded-xl bg-blue-50 text-blue-600">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input id="password" type="password" name="password" placeholder="Password" autocomplete="current-password"
                                        class="h-16 w-full rounded-2xl border border-blue-100 bg-[#F1F6FF] pl-20 pr-16 text-base text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-blue-200 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100 sm:text-lg">
                                    <button type="button" onclick="togglePassword()"
                                        class="absolute right-5 top-1/2 grid h-10 w-10 -translate-y-1/2 place-items-center rounded-xl text-slate-500 transition hover:bg-slate-200/70 hover:text-blue-600 focus:outline-none focus:ring-4 focus:ring-blue-100"
                                        aria-label="Toggle password visibility">
                                        <i id="passwordToggleIcon" class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="flex flex-col gap-3 pt-1 text-base sm:flex-row sm:items-center sm:justify-between">
                                <label class="flex cursor-pointer items-center gap-3 text-slate-600">
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}
                                        class="h-5 w-5 rounded border-slate-300 accent-blue-600 focus:ring-blue-500">
                                    <span>Remember me</span>
                                </label>
                                <a href="#" class="font-semibold text-blue-600 transition hover:text-blue-700">
                                    Forgot Password?
                                </a>
                            </div>

                            <button type="submit" id="submitBtn"
                                class="group flex h-16 w-full items-center justify-center gap-3 rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-500 text-xl font-extrabold text-white shadow-[0_16px_34px_rgba(37,99,235,0.28)] transition hover:-translate-y-0.5 hover:shadow-[0_22px_46px_rgba(6,182,212,0.28)] focus:outline-none focus:ring-4 focus:ring-blue-100 disabled:translate-y-0 disabled:cursor-progress disabled:opacity-75">
                                <span id="btnText">Sign In</span>
                                <span id="btnSpinner" class="hidden h-5 w-5 animate-spin rounded-full border-2 border-white/40 border-t-white"></span>
                                <i id="btnIcon" class="fas fa-arrow-right transition group-hover:translate-x-1"></i>
                            </button>
                        </form>

                        <div class="my-7 grid grid-cols-[1fr_auto_1fr] items-center gap-5 text-sm font-semibold text-slate-400">
                            <div class="h-px bg-slate-200"></div>
                            <span></span>
                            <div class="h-px bg-slate-200"></div>
                        </div>

                    </div>
                </section>
            </div>
        </section>
    </main>

    <script>
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

        document.getElementById('loginForm').addEventListener('submit', function() {
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const btnSpinner = document.getElementById('btnSpinner');
            const btnIcon = document.getElementById('btnIcon');

            btnText.textContent = 'Signing In...';
            btnSpinner.classList.remove('hidden');
            btnIcon.classList.add('hidden');
            submitBtn.disabled = true;

            setTimeout(() => {
                if (submitBtn.disabled) {
                    btnText.textContent = 'Sign In';
                    btnSpinner.classList.add('hidden');
                    btnIcon.classList.remove('hidden');
                    submitBtn.disabled = false;
                }
            }, 30000);
        });
    </script>
</body>

</html>
