@extends('admin.include.layout')
@section('heading', 'Edit Profile')
@section('title', 'Edit Profile')
@section('content')

<div class="p-4 sm:p-6 lg:p-8 max-w-5xl mx-auto">
    <!-- Edit Profile Card -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-blue-600 px-6 py-6 sm:px-8">
            <div class="flex items-center gap-4">
                <div class="p-2 bg-white/20 rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-white">Edit Profile</h2>
                    <p class="text-blue-100 text-sm">Update your personal information and documents</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form action="" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8">
            @csrf
            @method('PUT')

            <div class="space-y-8">
                <!-- Personal Information Section -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                        Personal Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Full Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $user->name) }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('name') border-red-500 @enderror"
                                   placeholder="Enter full name"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Designation -->
                        <div>
                            <label for="designation" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Designation
                            </label>
                            <input type="text"
                                   id="designation"
                                   name="designation"
                                   value="{{ old('designation', $user->designation) }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('designation') border-red-500 @enderror"
                                   placeholder="e.g. CEO, Manager">
                            @error('designation')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   value="{{ old('email', $user->email) }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('email') border-red-500 @enderror"
                                   placeholder="Enter email address"
                                   required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Phone Number
                            </label>
                            <input type="tel"
                                   id="phone"
                                   name="phone"
                                   value="{{ old('phone', $user->phone) }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('phone') border-red-500 @enderror"
                                   placeholder="+1 (555) 123-4567">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Department -->
                        <div>
                            <label for="department" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Department
                            </label>
                            <input type="text"
                                   id="department"
                                   name="department"
                                   value="{{ old('department', $user->department) }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('department') border-red-500 @enderror"
                                   placeholder="Enter department name">
                            @error('department')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Employee ID -->
                        <div>
                            <label for="employeeID" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Employee ID
                            </label>
                            <input type="text"
                                   id="employeeID"
                                   name="employeeID"
                                   value="{{ old('employeeID', $user->employeeID) }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('employeeID') border-red-500 @enderror"
                                   placeholder="EMP-001">
                            @error('employeeID')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Joining Date -->
                        <div>
                            <label for="joinig_date" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Joining Date
                            </label>
                            <input type="date"
                                   id="joinig_date"
                                   name="joinig_date"
                                   value="{{ old('joinig_date', $user->joinig_date) }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('joinig_date') border-red-500 @enderror">
                            @error('joinig_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Status
                            </label>
                            <select id="status"
                                    name="status"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('status') border-red-500 @enderror">
                                <option value="">Select Status</option>
                                <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="on_leave" {{ old('status', $user->status) == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                                <option value="terminated" {{ old('status', $user->status) == 'terminated' ? 'selected' : '' }}>Terminated</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Role Section -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        Role & Access
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Role <span class="text-red-500">*</span>
                            </label>
                            <select id="role"
                                    name="role"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('role') border-red-500 @enderror"
                                    required>
                                <option value="">Select Role</option>
                                <option value="super_admin" {{ old('role', $user->role) == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="manager" {{ old('role', $user->role) == 'manager' ? 'selected' : '' }}>Manager</option>
                                <option value="employee" {{ old('role', $user->role) == 'employee' ? 'selected' : '' }}>Employee</option>
                            </select>
                            @error('role')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="role_id" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Role ID (Optional)
                            </label>
                            <input type="number"
                                   id="role_id"
                                   name="role_id"
                                   value="{{ old('role_id', $user->role_id) }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('role_id') border-red-500 @enderror"
                                   placeholder="Enter role ID">
                            @error('role_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Documents Section -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                        </svg>
                        Documents
                    </h3>
                    <p class="text-sm text-gray-500 mb-4">Upload your documents (PDF, JPG, PNG - Max 5MB each)</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @php
                            $documents = [
                                'adhar_card' => ['label' => 'Aadhar Card', 'icon' => '🪪'],
                                'pan_card' => ['label' => 'PAN Card', 'icon' => '📇'],
                                '10th_certificate' => ['label' => '10th Certificate', 'icon' => '📄'],
                                '12th_certificate' => ['label' => '12th Certificate', 'icon' => '📄'],
                                'graduation' => ['label' => 'Graduation', 'icon' => '🎓']
                            ];
                        @endphp
                        @foreach($documents as $field => $doc)
                            <div class="border border-gray-200 rounded-xl p-4 bg-gray-50 hover:bg-gray-100 transition">
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                    {{ $doc['icon'] }} {{ $doc['label'] }}
                                </label>
                                <div class="flex items-center gap-3">
                                    <input type="file"
                                           id="{{ $field }}"
                                           name="{{ $field }}"
                                           accept=".pdf,.jpg,.jpeg,.png"
                                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition">
                                </div>
                                @if($user->$field)
                                    <div class="mt-2 flex items-center gap-2 text-xs text-green-600">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span>Current file uploaded</span>
                                    </div>
                                @endif
                                @error($field)
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Profile Image (Optional) -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                        Profile Picture
                    </h3>
                    <div class="flex items-center gap-6">
                        <div class="flex-shrink-0">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name ?? 'User') }}&size=80&background=4F46E5&color=fff&bold=true"
                                 alt="Profile Avatar"
                                 class="w-20 h-20 rounded-full border-2 border-gray-200">
                        </div>
                        <div class="flex-1">
                            <input type="file"
                                   id="profile"
                                   name="profile"
                                   accept=".jpg,.jpeg,.png,.gif"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition">
                            <p class="mt-1 text-xs text-gray-400">Recommended: Square image, max 2MB</p>
                            @error('profile')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="border-t border-gray-200 pt-6 flex flex-col sm:flex-row gap-4 justify-end">
                    <a href=""
                       class="inline-flex items-center justify-center gap-2 px-6 py-2.5 border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium rounded-xl transition duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Cancel
                    </a>
                    <button type="submit"
                            class="inline-flex items-center justify-center gap-2 px-8 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition duration-200 shadow-sm hover:shadow focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Save Changes
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
