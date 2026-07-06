@extends('admin.include.layout')
@section('heading', 'Employees')
@section('title', 'Edit Employees')

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
                                    <i class="fas fa-user-edit text-2xl text-orange-600"></i>
                                </div>
                                <div>
                                    <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">Edit Employee</h1>
                                    <p class="text-gray-500 mt-1">Update information for <span
                                            class="font-semibold text-orange-600">{{ $user->name }}</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <a href=""
                                class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2 rounded-full transition duration-200 shadow-sm">
                                <i class="fas fa-arrow-left text-sm"></i>
                                <span>Back to List</span>
                            </a>
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
                        title: 'Validation Error',
                        html: `{!! implode('<br>', $errors->all()) !!}`,
                        confirmButtonColor: '#ea580c',
                        background: '#fff',
                    });
                </script>
            @endif

            @if (session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: "{{ session('success') }}",
                        timer: 2500,
                        showConfirmButton: false,
                        background: '#fff',
                    });
                </script>
            @endif

            {{-- Main Form Card --}}
            <div
                class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-white/30 transition duration-300">
                <form action="{{ route('update.employees', $user->id) }}" method="POST" enctype="multipart/form-data"
                    id="employeeForm">
                    @csrf
                    <div class="p-6 md:p-8 space-y-8">

                        {{-- Row 1: Name & Email --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Name Field --}}
                            <div class="relative group">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    <i class="fas fa-user mr-2 text-orange-500"></i>Full Name
                                </label>
                                <div class="relative">
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
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

                            {{-- Email Field --}}
                            <div class="relative group">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    <i class="fas fa-envelope mr-2 text-orange-500"></i>Email Address
                                </label>
                                <div class="relative">
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
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

                        {{-- Row 2: Designation & Password (Optional) --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Designation --}}
                            <div class="relative group">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    <i class="fas fa-briefcase mr-2 text-orange-500"></i>Designation
                                </label>
                                <div class="relative">
                                    <input type="text" name="designation"
                                        value="{{ old('designation', $user->designation) }}"
                                        class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 shadow-sm"
                                        placeholder="Software Engineer">
                                    <i
                                        class="fas fa-briefcase absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-orange-500 transition"></i>
                                </div>
                                @error('designation')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Password (Optional with toggle) --}}
                            <div class="relative group">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    <i class="fas fa-key mr-2 text-orange-500"></i>Password <span
                                        class="text-xs text-gray-400 font-normal">(Leave blank to keep current)</span>
                                </label>
                                <div class="relative">
                                    <input type="password" name="password" id="password"
                                        class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 shadow-sm"
                                        placeholder="New password (optional)">
                                    <i
                                        class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-orange-500 transition"></i>
                                    <i class="fas fa-eye-slash absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 cursor-pointer hover:text-orange-500 transition"
                                        id="togglePassword"></i>
                                </div>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-400 mt-1"><i class="fas fa-info-circle"></i> Only fill this if
                                    you want to change the password</p>
                            </div>
                        </div>

                        {{-- Row 3: Profile Image & Role --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Profile Image with preview --}}
                            <div class="relative group">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    <i class="fas fa-image mr-2 text-orange-500"></i>Profile Image
                                </label>
                                <div class="flex items-center gap-4 flex-wrap">
                                    <div class="relative flex-1 min-w-[180px]">
                                        <input type="file" name="profile" id="profileInput" accept="image/*"
                                            class="w-full py-2 px-3 border border-gray-300 rounded-xl shadow-sm text-sm file:mr-4 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 transition">
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-14 h-14 rounded-full bg-gray-100 overflow-hidden shadow-md flex-shrink-0 border-2 border-orange-200">
                                            <img id="imagePreview" src="{{ asset($user->profile) }}"
                                                class="w-full h-full object-cover" alt="Current Profile">
                                        </div>
                                        <span class="text-xs text-gray-400">Current</span>
                                    </div>
                                </div>
                                @error('profile')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Role Dropdown --}}
                            <div class="relative group">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    <i class="fas fa-user-tag mr-2 text-orange-500"></i>Role
                                </label>
                                <div class="relative">
                                    <select name="role"
                                        class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 appearance-none bg-white shadow-sm">
                                        <option value="">-- Select Role --</option>
                                        @foreach (role() as $key => $role)
                                            <option value="{{ $key }}" @selected($user->role == $key)>
                                                {{ ucfirst($role ?? '') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <i
                                        class="fas fa-user-tag absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                    <i
                                        class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                </div>
                                @error('role')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Row 4: Phone & Status --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Phone --}}
                            <div class="relative group">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    <i class="fas fa-phone-alt mr-2 text-orange-500"></i>Phone Number
                                </label>
                                <div class="relative">
                                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                        class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 shadow-sm"
                                        placeholder="1234567890" maxlength="12"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,12)">
                                    <i
                                        class="fas fa-phone-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-orange-500 transition"></i>
                                </div>
                                @error('phone')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Status with badge preview --}}
                            <div class="relative group">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    <i class="fas fa-toggle-on mr-2 text-orange-500"></i>Status
                                </label>
                                <select name="status"
                                    class="w-full py-3 px-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-white shadow-sm">
                                    <option value="">-- Select Status --</option>
                                    <option value="active" @selected(old('status', $user->status) === 'active')>🟢 Active</option>
                                    <option value="inactive" @selected(old('status', $user->status) === 'inactive')>🔴 Inactive</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                <div class="mt-2">
                                    @if ($user->status === 'active')
                                        <span
                                            class="inline-flex items-center gap-1 text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full"><i
                                                class="fas fa-circle text-[8px]"></i> Current: Active</span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 text-xs bg-red-100 text-red-700 px-2 py-0.5 rounded-full"><i
                                                class="fas fa-circle text-[8px]"></i> Current: Inactive</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Row 5: Employee ID & Joining Date & Department --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="relative group">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">
                                    <i class="fas fa-id-badge mr-2 text-orange-500"></i>Employee ID
                                </label>
                                <div class="relative">
                                    <input type="text" name="employeeID"
                                        value="{{ old('employeeID', $user->employeeID ?? '') }}"
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
                                    <input type="date" name="joinig_date"
                                        value="{{ old('joinig_date', $user->joinig_date ?? '') }}"
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
                                        <option value="{{ $dept }}" @selected(old('department', $user->department) == $dept)>
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

                        {{-- NEW SECTION: Document Uploads (Aadhar, Pan, Certificates) with existing file preview --}}
                        <div class="border-t border-gray-200 pt-6 mt-2">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <i class="fas fa-folder-open text-orange-500"></i> Document Uploads
                                <span class="text-xs font-normal text-gray-400 ml-2">(Optional, leave empty to keep current)</span>
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Aadhar Card --}}
                                <div class="relative group">
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                                        <i class="fas fa-id-card mr-2 text-orange-500"></i>Aadhar Card
                                    </label>
                                    <input type="file" name="adhar_card" accept="image/*,application/pdf"
                                        class="w-full py-2 px-3 border border-gray-300 rounded-xl shadow-sm text-sm file:mr-4 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 transition">
                                    @if($user->adhar_card)
                                        <div class="mt-2 flex items-center gap-2">
                                            <i class="fas fa-check-circle text-green-500 text-xs"></i>
                                            <a href="{{ asset($user->adhar_card) }}" target="_blank" class="text-xs text-orange-600 hover:underline">View Current Aadhar</a>
                                            <span class="text-xs text-gray-400">| Leave empty to keep</span>
                                        </div>
                                    @endif
                                    @error('adhar_card')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Pan Card --}}
                                <div class="relative group">
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                                        <i class="fas fa-credit-card mr-2 text-orange-500"></i>Pan Card
                                    </label>
                                    <input type="file" name="pan_card" accept="image/*,application/pdf"
                                        class="w-full py-2 px-3 border border-gray-300 rounded-xl shadow-sm text-sm file:mr-4 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 transition">
                                    @if($user->pan_card)
                                        <div class="mt-2 flex items-center gap-2">
                                            <i class="fas fa-check-circle text-green-500 text-xs"></i>
                                            <a href="{{ asset($user->pan_card) }}" target="_blank" class="text-xs text-orange-600 hover:underline">View Current Pan Card</a>
                                            <span class="text-xs text-gray-400">| Leave empty to keep</span>
                                        </div>
                                    @endif
                                    @error('pan_card')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- 10th Certificate --}}
                                <div class="relative group">
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                                        <i class="fas fa-graduation-cap mr-2 text-orange-500"></i>10th Certificate
                                    </label>
                                    <input type="file" name="10th_certificate" accept="image/*,application/pdf"
                                        class="w-full py-2 px-3 border border-gray-300 rounded-xl shadow-sm text-sm file:mr-4 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 transition">
                                    @if($user->{'10th_certificate'})
                                        <div class="mt-2 flex items-center gap-2">
                                            <i class="fas fa-check-circle text-green-500 text-xs"></i>
                                            <a href="{{ asset($user->{'10th_certificate'}) }}" target="_blank" class="text-xs text-orange-600 hover:underline">View Current 10th Certificate</a>
                                            <span class="text-xs text-gray-400">| Leave empty to keep</span>
                                        </div>
                                    @endif
                                    @error('10th_certificate')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- 12th Certificate --}}
                                <div class="relative group">
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                                        <i class="fas fa-diploma mr-2 text-orange-500"></i>12th Certificate
                                    </label>
                                    <input type="file" name="12th_certificate" accept="image/*,application/pdf"
                                        class="w-full py-2 px-3 border border-gray-300 rounded-xl shadow-sm text-sm file:mr-4 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 transition">
                                    @if($user->{'12th_certificate'})
                                        <div class="mt-2 flex items-center gap-2">
                                            <i class="fas fa-check-circle text-green-500 text-xs"></i>
                                            <a href="{{ asset($user->{'12th_certificate'}) }}" target="_blank" class="text-xs text-orange-600 hover:underline">View Current 12th Certificate</a>
                                            <span class="text-xs text-gray-400">| Leave empty to keep</span>
                                        </div>
                                    @endif
                                    @error('12th_certificate')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Graduation Certificate (Full width optionally) --}}
                                <div class="relative group md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                                        <i class="fas fa-university mr-2 text-orange-500"></i>Graduation Certificate
                                    </label>
                                    <input type="file" name="graduation" accept="image/*,application/pdf"
                                        class="w-full py-2 px-3 border border-gray-300 rounded-xl shadow-sm text-sm file:mr-4 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 transition">
                                    @if($user->graduation)
                                        <div class="mt-2 flex items-center gap-2">
                                            <i class="fas fa-check-circle text-green-500 text-xs"></i>
                                            <a href="{{ asset($user->graduation) }}" target="_blank" class="text-xs text-orange-600 hover:underline">View Current Graduation Certificate</a>
                                            <span class="text-xs text-gray-400 ml-2">| Leave empty to keep</span>
                                        </div>
                                    @endif
                                    <p class="text-xs text-gray-400 mt-1">Supported formats: JPG, PNG, PDF (Max 5MB each)</p>
                                    @error('graduation')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Info Note --}}
                        <div class="bg-orange-50/50 rounded-xl p-4 border border-orange-100">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-info-circle text-orange-500 mt-0.5"></i>
                                <div class="text-sm text-gray-600">
                                    <span class="font-semibold">Note:</span> Leave password blank to keep the current
                                    password. Upload a new image to replace the existing one. For documents, upload new files only if you want to update them.
                                </div>
                            </div>
                        </div>

                    </div> {{-- end padding --}}

                    {{-- Form Actions --}}
                    <div
                        class="bg-gray-50/80 px-6 md:px-8 py-5 flex flex-col sm:flex-row justify-end gap-3 border-t border-gray-200">
                        <a href=""
                            class="px-6 py-2.5 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-100 transition duration-200 flex items-center justify-center gap-2 text-center">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <button type="submit"
                            class="px-8 py-2.5 bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-700 hover:to-orange-600 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i> Update Employee
                        </button>
                    </div>
                </form>
            </div>

            {{-- Footer --}}
            <div class="text-center text-gray-400 text-sm mt-8">
                <i class="fas fa-shield-alt mr-1"></i> Changes are logged for security
            </div>
        </div>
    </div>

    {{-- JavaScript for Image Preview & Password Toggle --}}
    <script>
        // Image preview on file select
        const profileInput = document.getElementById('profileInput');
        const imagePreview = document.getElementById('imagePreview');

        if (profileInput) {
            profileInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                } else {
                    // Revert to original if no file selected
                    imagePreview.src = "{{ asset($user->profile) }}";
                }
            });
        }

        // Password show/hide toggle
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');

        if (togglePassword && passwordField) {
            togglePassword.addEventListener('click', function() {
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                this.classList.toggle('fa-eye-slash');
                this.classList.toggle('fa-eye');
            });
        }

        // Add focus effects to all inputs
        const formInputs = document.querySelectorAll('input, select');
        formInputs.forEach(input => {
            input.addEventListener('focus', () => {
                input.classList.add('ring-2', 'ring-orange-200');
            });
            input.addEventListener('blur', () => {
                input.classList.remove('ring-2', 'ring-orange-200');
            });
        });
    </script>

    <style>
        /* Custom transitions */
        input,
        select,
        button {
            transition: all 0.2s ease;
        }

        input[type="file"]::file-selector-button {
            transition: background 0.2s;
            cursor: pointer;
        }

        .group:hover i {
            transition: color 0.2s;
        }
    </style>
@endsection
