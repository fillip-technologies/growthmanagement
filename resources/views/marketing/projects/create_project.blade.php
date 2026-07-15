@extends('admin.include.layout')
@section('heading', 'Projects')
@section('title', 'Add Project')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(5deg);
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

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

        @keyframes pulseGlow {

            0%,
            100% {
                opacity: 0.6;
            }

            50% {
                opacity: 1;
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-slide-in {
            animation: slideIn 0.5s ease-out;
        }

        .animate-fade-up {
            animation: fadeInUp 0.6s ease-out;
        }

        .module-item {
            animation: slideIn 0.3s ease-out;
        }

        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.1);
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.1);
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #fb923c;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #f97316;
        }
    </style>

    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-100 to-orange-50/30 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">


            <div class="fixed inset-0 overflow-hidden pointer-events-none">
                <div
                    class="absolute top-20 left-10 w-72 h-72 bg-orange-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float">
                </div>
                <div class="absolute bottom-20 right-10 w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float"
                    style="animation-delay: 2s;"></div>
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-purple-200 rounded-full filter blur-3xl opacity-10 animate-float"
                    style="animation-delay: 4s;"></div>
            </div>


            <div class="relative mb-8 animate-fade-up">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden card-hover">
                    <div
                        class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-orange-500 to-orange-600 opacity-10 rounded-full transform translate-x-32 -translate-y-32">
                    </div>
                    <div class="relative px-6 py-6 md:px-8 md:py-8">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg transform rotate-3 hover:rotate-6 transition-all duration-300">
                                    <i class="fas fa-folder-open text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h1 class="text-3xl md:text-4xl font-black text-gray-800 tracking-tight">
                                        Create New Project
                                    </h1>
                                    <p class="text-gray-500 mt-1 flex items-center gap-2">
                                        <i class="fas fa-rocket text-orange-500"></i>
                                        Fill in the details to start a new project journey
                                    </p>
                                </div>
                            </div>
                            <div class="px-4 py-2 bg-orange-50 rounded-full">
                                <i class="fas fa-chart-line text-orange-500 mr-2"></i>
                                <span class="text-sm font-semibold text-orange-600">Active Projects:
                                    {{ \App\Models\Project::count() ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            @if ($errors->any())
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: `{!! implode('<br>', $errors->all()) !!}`,
                        confirmButtonColor: '#f97316',
                        background: '#fff',
                        customClass: {
                            popup: 'rounded-2xl'
                        }
                    });
                </script>
            @endif

            @if (session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Project Created!',
                        text: "{{ session('success') }}",
                        timer: 2500,
                        showConfirmButton: false,
                        background: '#fff',
                        customClass: {
                            popup: 'rounded-2xl'
                        }
                    });
                </script>
            @endif


            <form action="{{ route('mark.createProject') }}" method="POST" class="animate-fade-up"
                style="animation-delay: 0.1s" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="created_by" value="{{ Auth::guard('marketing_manager')->user()->id }}">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 card-hover">
                            <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-amber-50 border-b border-orange-100">
                                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-info-circle text-orange-500"></i>
                                    Basic Information
                                </h3>
                            </div>
                            <div class="p-6 space-y-5">
                                {{-- Project Title --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-tag text-orange-500 mr-2"></i>
                                        Project Title <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="text" name="project_name"
                                            placeholder="e.g., E-Commerce Platform, Mobile App Development"
                                            value="{{ old('project_name') }}"
                                            class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-400 transition-all duration-200">
                                        <i
                                            class="fas fa-folder-open absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    </div>
                                    @error('project_name')
                                        <p class="text-red-500 text-xs mt-1 flex items-center gap-1"><i
                                                class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Task Name --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-tasks text-orange-500 mr-2"></i>
                                        Task name <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="text" name="task_name"
                                            placeholder="e.g., E-Commerce Platform, Mobile App Development"
                                            value="{{ old('task_name') }}"
                                            class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-400 transition-all duration-200">
                                        <i
                                            class="fas fa-tasks absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    </div>
                                    @error('task_name')
                                        <p class="text-red-500 text-xs mt-1 flex items-center gap-1"><i
                                                class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- What Be Do (Description) --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-align-left text-orange-500 mr-2"></i>
                                        What Be Do <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="what_be_do" rows="5" placeholder="Describe the project scope, objectives, and key deliverables..."
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-400 transition-all duration-200 resize-none">{{ old('what_be_do') }}</textarea>
                                    @error('what_be_do')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-tasks text-orange-500 mr-2"></i>
                                        Documnet <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="file" name="attechment"
                                            placeholder="e.g., E-Commerce Platform, Mobile App Development"
                                            value="{{ old('attechment') }}"
                                            class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-400 transition-all duration-200">
                                        <i
                                            class="fas fa-tasks absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    </div>
                                    @error('attechment')
                                        <p class="text-red-500 text-xs mt-1 flex items-center gap-1"><i
                                                class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>


                        </div>


                        <div class="mt-8 bg-white rounded-2xl shadow-lg overflow-hidden card-hover">
                            <div class="px-6 py-5 flex flex-col sm:flex-row justify-between items-center gap-4">
                                <div class="flex items-center gap-2 text-sm text-gray-500">
                                    <i class="fas fa-shield-alt text-green-500"></i>
                                    <span>All project data is securely stored</span>
                                </div>
                                <div class="flex gap-3">
                                    <a href="{{ route('mark.listproject') }}"
                                        class="px-6 py-2.5 rounded-xl border-2 border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 flex items-center gap-2">
                                        <i class="fas fa-arrow-left"></i>
                                        Cancel
                                    </a>
                                    <button type="reset"
                                        class="px-6 py-2.5 rounded-xl border-2 border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 flex items-center gap-2">
                                        <i class="fas fa-undo-alt"></i>
                                        Reset
                                    </button>
                                    <button type="submit"
                                        class="px-8 py-2.5 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 transform hover:scale-[1.02] transition-all duration-200 text-white font-bold rounded-xl shadow-md hover:shadow-xl flex items-center gap-2">
                                        <i class="fas fa-save"></i>
                                        Create Project
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="lg:col-span-1 space-y-6">


                        <div
                            class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 card-hover sticky top-6">
                            <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-amber-50 border-b border-orange-100">
                                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-sliders-h text-orange-500"></i>
                                    Configuration
                                </h3>
                            </div>
                            <div class="p-6 space-y-5">
                                {{-- Status --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-chart-line text-orange-500 mr-2"></i>
                                        Status <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <select name="status"
                                            class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-400 appearance-none bg-white cursor-pointer transition-all duration-200">
                                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>🟡
                                                Pending</option>
                                            <option value="ongoing" {{ old('status') == 'ongoing' ? 'selected' : '' }}>🔵
                                                Ongoing</option>
                                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>
                                                🟢 Completed</option>
                                        </select>
                                        <i
                                            class="fas fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                        <i
                                            class="fas fa-chart-simple absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    </div>
                                    @error('status')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Priority --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-flag text-orange-500 mr-2"></i>
                                        Priority Level
                                    </label>
                                    <div class="grid grid-cols-3 gap-2">
                                        <label class="cursor-pointer">
                                            <input type="radio" name="priority" value="low" class="hidden peer"
                                                {{ old('priority') == 'low' ? 'checked' : '' }}>
                                            <div
                                                class="border-2 border-gray-200 rounded-xl p-3 text-center peer-checked:border-green-500 peer-checked:bg-green-50 transition-all duration-200">
                                                <i class="fas fa-arrow-down text-green-500 text-lg"></i>
                                                <p class="text-xs font-medium mt-1 text-gray-600">Low</p>
                                            </div>
                                        </label>
                                        <label class="cursor-pointer">
                                            <input type="radio" name="priority" value="medium" class="hidden peer"
                                                {{ old('priority') == 'medium' ? 'checked' : '' }}>
                                            <div
                                                class="border-2 border-gray-200 rounded-xl p-3 text-center peer-checked:border-orange-500 peer-checked:bg-orange-50 transition-all duration-200">
                                                <i class="fas fa-minus text-orange-500 text-lg"></i>
                                                <p class="text-xs font-medium mt-1 text-gray-600">Medium</p>
                                            </div>
                                        </label>
                                        <label class="cursor-pointer">
                                            <input type="radio" name="priority" value="high" class="hidden peer"
                                                {{ old('priority') == 'high' ? 'checked' : '' }}>
                                            <div
                                                class="border-2 border-gray-200 rounded-xl p-3 text-center peer-checked:border-red-500 peer-checked:bg-red-50 transition-all duration-200">
                                                <i class="fas fa-arrow-up text-red-500 text-lg"></i>
                                                <p class="text-xs font-medium mt-1 text-gray-600">High</p>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Timeline Card --}}
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 card-hover">
                            <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-amber-50 border-b border-orange-100">
                                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-calendar-alt text-orange-500"></i>
                                    Project Timeline
                                </h3>
                            </div>
                            <div class="p-6 space-y-5">
                                {{-- Start Date --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-play-circle text-orange-500 mr-2"></i>
                                        Start Date <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="datetime-local" name="start_date" value="{{ old('start_date') }}"
                                            class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-400 transition-all duration-200">
                                        <i
                                            class="fas fa-calendar-day absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    </div>
                                    @error('start_date')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- End Date --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-stop-circle text-orange-500 mr-2"></i>
                                        End Date
                                    </label>
                                    <div class="relative">
                                        <input type="datetime-local" name="end_date" value="{{ old('end_date') }}"
                                            class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-400 transition-all duration-200">
                                        <i
                                            class="fas fa-calendar-week absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    </div>
                                    @error('end_date')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mt-4 p-3 bg-blue-50 rounded-xl">
                                    <div class="flex items-center gap-2 text-xs text-blue-700">
                                        <i class="fas fa-clock"></i>
                                        <span>Set realistic deadlines for better project planning</span>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>



            </form>
        </div>
    </div>

    <script>
        // Add Module Functionality
        document.getElementById('add-module')?.addEventListener('click', function() {
            let wrapper = document.getElementById('module-wrapper');

            let html = `
            <div class="module-item flex gap-3 items-center bg-gray-50 rounded-xl p-3 border border-gray-200 hover:border-orange-300 transition-all duration-200 group animate-slide-in">
                <div class="flex-shrink-0">
                    <i class="fas fa-microchip text-orange-400"></i>
                </div>
                <input type="text" name="modules[]"
                    placeholder="e.g., User Authentication, Payment Gateway"
                    class="flex-1 bg-transparent border-0 focus:ring-0 focus:outline-none text-gray-700 placeholder-gray-400 font-medium">
                <button type="button"
                    class="remove-module w-8 h-8 bg-red-100 hover:bg-red-500 text-red-500 hover:text-white rounded-lg transition-all duration-200 flex items-center justify-center">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>
        `;

            wrapper.insertAdjacentHTML('beforeend', html);

            // Scroll to new module
            let newModule = wrapper.lastElementChild;
            newModule.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });

            // Focus the input
            let newInput = newModule.querySelector('input');
            if (newInput) newInput.focus();
        });

        // Remove Module (Event Delegation)
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-module')) {
                let moduleItem = e.target.closest('.module-item');
                if (moduleItem) {
                    // Add fade out effect
                    moduleItem.style.opacity = '0';
                    moduleItem.style.transform = 'translateX(-20px)';
                    setTimeout(() => {
                        moduleItem.remove();
                    }, 200);
                }
            }
        });

        // Form reset confirmation
        document.querySelector('button[type="reset"]')?.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to reset all form fields?')) {
                e.preventDefault();
            }
        });

        // Add input focus effects
        document.querySelectorAll('input, select, textarea').forEach(element => {
            element.addEventListener('focus', function() {
                this.parentElement?.classList.add('ring-2', 'ring-orange-200', 'rounded-xl');
            });
            element.addEventListener('blur', function() {
                this.parentElement?.classList.remove('ring-2', 'ring-orange-200');
            });
        });
    </script>
@endsection
