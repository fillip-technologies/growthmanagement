@extends('admin.include.layout')
@section('heading', 'Employees')
@section('title', 'Add Employees')

@section('content')
    {{-- Font Awesome 6 (free) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <div class="min-h-screen bg-gradient-to-br from-slate-100 to-gray-200 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">

            {{-- Header Card with Wave Decoration --}}
            <div
                class="relative bg-white rounded-2xl shadow-2xl overflow-hidden mb-8 transform transition duration-500 hover:scale-[1.01]">
                <div class="absolute top-0 right-0 w-40 h-40 bg-orange-100 rounded-full -mr-16 -mt-16 opacity-70"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-blue-100 rounded-full -ml-12 -mb-12 opacity-60"></div>
                <div class="relative p-6 md:p-8">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div>
                            <div class="flex items-center gap-3">
                                <div class="p-3 bg-orange-100 rounded-xl">
                                    <i class="fas fa-user-plus text-2xl text-orange-600"></i>
                                </div>
                                <div>
                                    <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">Add New Employee</h1>
                                    <p class="text-gray-500 mt-1">Fill in the details to create a new team member</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <div class="bg-gray-100 rounded-full px-4 py-2 text-sm text-gray-600">
                                <i class="fas fa-users mr-2"></i> Total Employees: {{ \App\Models\User::count() ?? '--' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SweetAlert & Message Handling --}}
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            @if ($errors->any())
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops... Validation Error',
                        html: `{!! implode('<br>', $errors->all()) !!}`,
                        confirmButtonColor: '#ea580c',
                        background: '#fff',
                        backdrop: true,
                    });
                </script>
            @endif

            @if (session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Employee Added!',
                        text: "{{ session('success') }}",
                        timer: 2800,
                        showConfirmButton: false,
                        background: '#fff',
                        toast: false,
                        position: 'center',
                        didOpen: () => {
                            Swal.showLoading();
                            setTimeout(() => Swal.close(), 2700);
                        }
                    });
                </script>
            @endif

            {{-- Main Form Card --}}
            <div
                class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-white/30 transition duration-300">
                <form action="{{ route('add.employees') }}" method="POST" enctype="multipart/form-data" id="employeeForm">
                    @csrf
                    <div class="p-6 md:p-8 space-y-8">

                        {{-- Row 1: Name & Email --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Name Field with Icon --}}
                            <div class="relative group">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    <i class="fas fa-user mr-2 text-orange-500"></i>Full Name
                                </label>
                                <div class="relative">
                                    <input type="text" name="name" value="{{ old('name') }}"
                                        class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 shadow-sm"
                                        placeholder="John Doe">
                                    <i
                                        class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-orange-500 transition"></i>
                                </div>
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1"><i
                                            class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email Field with Icon --}}
                            <div class="relative group">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    <i class="fas fa-envelope mr-2 text-orange-500"></i>Email Address
                                </label>
                                <div class="relative">
                                    <input type="email" name="email" value="{{ old('email') }}"
                                        class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 shadow-sm"
                                        placeholder="john@example.com">
                                    <i
                                        class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-orange-500 transition"></i>
                                </div>
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Row 2: Designation & Password --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Designation --}}
                            <div class="relative group">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    <i class="fas fa-briefcase mr-2 text-orange-500"></i>Designation
                                </label>
                                <div class="relative">
                                    <input type="text" name="designation" value="{{ old('designation') }}"
                                        class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 shadow-sm"
                                        placeholder="Software Engineer">
                                    <i
                                        class="fas fa-briefcase absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-orange-500 transition"></i>
                                </div>
                                @error('designation')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Password with Strength indicator (fake for UI) --}}
                            <div class="relative group">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    <i class="fas fa-lock mr-2 text-orange-500"></i>Password
                                </label>
                                <div class="relative">
                                    <input type="password" name="password" id="password" value="{{ old('password') }}"
                                        class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 shadow-sm"
                                        placeholder="••••••••">
                                    <i
                                        class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-orange-500 transition"></i>
                                    <i class="fas fa-eye-slash absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 cursor-pointer hover:text-orange-500 transition"
                                        id="togglePassword"></i>
                                </div>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                <div class="text-xs text-gray-400 mt-1 hidden" id="passwordStrength">Use 8+ characters for
                                    strong password</div>
                            </div>
                        </div>

                        {{-- Row 3: Profile Image & Role --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Profile Image with preview --}}
                            <div class="relative group">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    <i class="fas fa-image mr-2 text-orange-500"></i>Profile Image
                                </label>
                                <div class="flex items-center gap-4">
                                    <div class="relative w-full">
                                        <input type="file" name="profile" id="profileInput" accept="image/*"
                                            class="w-full py-2 px-3 border border-gray-300 rounded-xl shadow-sm text-sm file:mr-4 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 transition">
                                    </div>
                                    <div class="w-12 h-12 rounded-full bg-gray-100 overflow-hidden shadow-md flex-shrink-0"
                                        id="imagePreviewContainer">
                                        <img id="imagePreview"
                                            src="https://ui-avatars.com/api/?background=ea580c&color=fff&rounded=true&bold=true&size=48&name=User"
                                            class="w-full h-full object-cover" alt="Preview">
                                    </div>
                                </div>
                                @error('profile')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Role Dropdown with Icon --}}
                            <div class="relative group">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    <i class="fas fa-user-tag mr-2 text-orange-500"></i>Role
                                </label>
                                <div class="relative">
                                    <select name="role_id"
                                        class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 appearance-none bg-white shadow-sm">
                                        <option value="">-- Select Role --</option>
                                        @foreach (role() as $role)
                                            <option value="{{ $role->id }}"
                                                {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                                {{ ucfirst($role->role ?? '') }}</option>
                                        @endforeach
                                    </select>
                                    <i
                                        class="fas fa-user-tag absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                    <i
                                        class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                </div>
                                @error('role_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Row 4: Phone & Status --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Phone with Flag Icon (ui only) --}}
                            <div class="relative group">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    <i class="fas fa-phone-alt mr-2 text-orange-500"></i>Phone Number
                                </label>
                                <div class="relative">
                                    <input type="text" name="phone" value="{{ old('phone') }}"
                                        class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 shadow-sm"
                                        placeholder="+1 234 567 8900" maxlength="12"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,12)">
                                    <i
                                        class="fas fa-phone-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-orange-500 transition"></i>
                                </div>
                                @error('phone')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Status with Toggle style --}}
                            <div class="relative group">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    <i class="fas fa-toggle-on mr-2 text-orange-500"></i>Status
                                </label>
                                <select name="status"
                                    class="w-full py-3 px-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-white shadow-sm">
                                    <option value="">-- Select Status --</option>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>🟢 Active
                                    </option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>🔴
                                        Inactive</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 mt-4 mb-4 gap-4">
                            <div class="relative group">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    <i class="fas fa-id-badge mr-2 text-orange-500"></i>Employee ID
                                </label>
                                <div class="relative">
                                    <input type="text" name="employeeID" value="{{ old('employeeID') }}"
                                        class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 shadow-sm">
                                    <i
                                        class="fas fa-id-card absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-orange-500 transition"></i>
                                </div>
                                @error('employeeID')
                                    <p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}</p>
                                @enderror
                            </div>

                            <div class="relative group">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    <i class="fas fa-calendar-alt mr-2 text-orange-500"></i>Joining Date
                                </label>
                                <div class="relative">
                                    <input type="date" name="joinig_date" value="{{ old('joinig_date') }}"
                                        class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 shadow-sm">
                                    <i
                                        class="fas fa-calendar-day absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-orange-500 transition"></i>
                                </div>
                                @error('joinig_date')
                                    <p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}</p>
                                @enderror
                            </div>

                            <div class="relative group">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    <i class="fas fa-building mr-2 text-orange-500"></i>Department
                                </label>
                                <select name="department"
                                    class="w-full py-3 px-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-white shadow-sm">
                                    <option value="">-- Select Department --</option>
                                    @foreach (department() ?? [] as $dept)
                                        <option value="{{ $dept }}"
                                            {{ old('department') == $dept ? 'selected' : '' }}>
                                            {{ $dept }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department')
                                    <p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        {{-- Extra note or hint --}}
                        <div class="bg-orange-50/50 rounded-xl p-4 border border-orange-100">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-info-circle text-orange-500 mt-0.5"></i>
                                <div class="text-sm text-gray-600">
                                    <span class="font-semibold">Heads up!</span> All fields with <span
                                        class="text-red-500">*</span> are required. Employee will receive a welcome email
                                    after creation.
                                </div>
                            </div>
                        </div>

                    </div> {{-- end padding --}}

                    {{-- Form Actions --}}
                    <div
                        class="bg-gray-50/80 px-6 md:px-8 py-5 flex flex-col sm:flex-row justify-end gap-3 border-t border-gray-200">
                        <button type="reset"
                            class="px-6 py-2.5 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-100 transition duration-200 flex items-center justify-center gap-2">
                            <i class="fas fa-eraser"></i> Reset
                        </button>
                        <button type="submit"
                            class="px-8 py-2.5 bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-700 hover:to-orange-600 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i> Save Employee
                        </button>
                    </div>
                </form>
            </div>

            {{-- Footer Suggestion --}}
            <div class="text-center text-gray-400 text-sm mt-8">
                <i class="fas fa-shield-alt mr-1"></i> Data protected & encrypted
            </div>
        </div>
    </div>

    {{-- JavaScript for Image Preview & Password Toggle --}}
    <script>
        // Image preview
        const profileInput = document.getElementById('profileInput');
        const imagePreview = document.getElementById('imagePreview');

        profileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            } else {
                imagePreview.src =
                    "https://ui-avatars.com/api/?background=ea580c&color=fff&rounded=true&bold=true&size=48&name=User";
            }
        });

        // Password show/hide
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
            this.classList.toggle('fa-eye');
        });

        // Optional: add a subtle animation on form fields
        const formInputs = document.querySelectorAll('input, select');
        formInputs.forEach(input => {
            input.addEventListener('focus', () => {
                input.parentElement?.classList.add('ring-1', 'ring-orange-200', 'rounded-xl');
            });
            input.addEventListener('blur', () => {
                input.parentElement?.classList.remove('ring-1', 'ring-orange-200');
            });
        });
    </script>

    <style>
        /* Custom smooth transitions */
        input,
        select,
        button {
            transition: all 0.2s ease;
        }

        .group:hover i {
            transition: color 0.2s;
        }

        /* Custom file input button style */
        input[type="file"]::file-selector-button {
            transition: background 0.2s;
        }
    </style>
@endsection
