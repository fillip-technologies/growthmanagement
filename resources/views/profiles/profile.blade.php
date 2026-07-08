
@extends('admin.include.layout')
@section('heading', 'Profile')
@section('title', 'Profile')
@section('content')
@php
        $user = [];
        if (Auth::guard('super_admin')->check()) {
            $user = Auth::guard('super_admin')->user();
        } elseif (Auth::guard('project_manager')->check()) {
            $user = Auth::guard('project_manager')->user();
        } elseif (Auth::guard('team_leader')->check()) {
            $user = Auth::guard('team_leader')->user();
        } elseif (Auth::guard('employee')->check()) {
            $user = Auth::guard('employee')->user();
        }

    @endphp
<div class="p-4 sm:p-6 lg:p-8 max-w-5xl mx-auto">
    <!-- Profile Card -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <!-- Header Section with Gradient -->
        <div class="bg-gradient-to-r from-indigo-600 to-blue-600 px-6 py-8 sm:px-8 sm:py-10">
            <div class="flex flex-col sm:flex-row items-center gap-6">
                <!-- Avatar -->
                <div class="relative">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name ?? 'User') }}&size=120&background=ffffff&color=4F46E5&bold=true"
                         alt="Profile Avatar"
                         class="w-28 h-28 rounded-full border-4 border-white/30 shadow-lg">
                    <span class="absolute bottom-1 right-1 w-4 h-4 bg-green-400 border-2 border-white rounded-full"></span>
                </div>

                <!-- Name & Role -->
                <div class="text-center sm:text-left text-white flex-1">
                    <h2 class="text-2xl font-bold tracking-tight">{{ $user->name ?? 'N/A' }}</h2>
                    <p class="text-blue-100 font-medium flex items-center justify-center sm:justify-start gap-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-white/20 text-white">
                            {{ ucfirst(str_replace('_', ' ', $user->role ?? 'N/A')) }}
                        </span>
                        @if($user->designation)
                            <span>• {{ $user->designation }}</span>
                        @endif
                    </p>
                    <div class="mt-2 flex flex-wrap items-center justify-center sm:justify-start gap-4 text-sm text-blue-200">
                        @if($user->employeeID)
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/></svg>
                            ID: {{ $user->employeeID }}
                        </span>
                        @endif
                        @if($user->joinig_date)
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
                            Joined {{ \Carbon\Carbon::parse($user->joinig_date)->format('M d, Y') }}
                        </span>
                        @endif
                    </div>
                </div>

                <!-- Status Badge -->
                <div class="ml-auto hidden lg:block">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white/20 text-white backdrop-blur-sm">
                        @if($user->status)
                            <span class="w-2 h-2 bg-green-300 rounded-full mr-2"></span>
                            {{ ucfirst($user->status) }}
                        @else
                            <span class="w-2 h-2 bg-yellow-300 rounded-full mr-2"></span>
                            Active
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <!-- Body Section -->
        <div class="p-6 sm:p-8">
            <!-- Info Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Email -->
                <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100 hover:shadow-sm transition">
                    <div class="p-2.5 bg-blue-50 rounded-lg text-blue-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Email</p>
                        <p class="text-sm text-gray-800 font-medium truncate">{{ $user->email ?? 'N/A' }}</p>
                        @if($user->email_verified_at)
                            <span class="text-xs text-green-600 flex items-center gap-1 mt-0.5">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                Verified
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Phone -->
                <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100 hover:shadow-sm transition">
                    <div class="p-2.5 bg-green-50 rounded-lg text-green-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Phone</p>
                        <p class="text-sm text-gray-800 font-medium">{{ $user->phone ?: 'Not provided' }}</p>
                    </div>
                </div>

                <!-- Designation -->
                <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100 hover:shadow-sm transition">
                    <div class="p-2.5 bg-purple-50 rounded-lg text-purple-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"/><path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Designation</p>
                        <p class="text-sm text-gray-800 font-medium">{{ $user->designation ?: 'Not specified' }}</p>
                    </div>
                </div>

                <!-- Department -->
                <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100 hover:shadow-sm transition">
                    <div class="p-2.5 bg-orange-50 rounded-lg text-orange-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Department</p>
                        <p class="text-sm text-gray-800 font-medium">{{ $user->department ?: 'Not assigned' }}</p>
                    </div>
                </div>

                <!-- Role -->
                <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100 hover:shadow-sm transition">
                    <div class="p-2.5 bg-rose-50 rounded-lg text-rose-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Role</p>
                        <p class="text-sm text-gray-800 font-medium">{{ ucfirst(str_replace('_', ' ', $user->role ?? 'N/A')) }}</p>
                    </div>
                </div>

                <!-- Member Since -->
                <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100 hover:shadow-sm transition">
                    <div class="p-2.5 bg-teal-50 rounded-lg text-teal-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Member Since</p>
                        <p class="text-sm text-gray-800 font-medium">{{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('F d, Y') : 'N/A' }}</p>
                        @if($user->created_at)
                            <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</span>
                        @endif
                    </div>
                </div>

                <!-- Documents Section (Full Width) -->
                <div class="md:col-span-2">
                    <div class="bg-gray-50 rounded-xl border border-gray-100 p-5">
                        <div class="flex items-center gap-2 mb-3">
                            <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/></svg>
                            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Documents</p>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
                            @php
                                $documents = [
                                    'Aadhar Card' => $user->adhar_card,
                                    'PAN Card' => $user->pan_card,
                                    '10th Certificate' => $user->{'10th_certificate'},
                                    '12th Certificate' => $user->{'12th_certificate'},
                                    'Graduation' => $user->graduation
                                ];
                            @endphp
                            @foreach($documents as $label => $value)
                                <div class="flex items-center gap-2 bg-white rounded-lg px-3 py-2 border border-gray-200">
                                    <svg class="w-4 h-4 {{ $value ? 'text-green-500' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        @if($value)
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        @else
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        @endif
                                    </svg>
                                    <span class="text-xs font-medium {{ $value ? 'text-gray-700' : 'text-gray-400' }}">
                                        {{ $label }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <hr class="my-8 border-gray-200">

            <!-- Action Buttons -->
            {{-- <div class="flex flex-col sm:flex-row gap-4 justify-end">
                <a href=""
                   class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition duration-200 shadow-sm hover:shadow focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit Profile
                </a>
                <a href=""
                   class="inline-flex items-center justify-center gap-2 px-6 py-2.5 border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium rounded-xl transition duration-200 hover:shadow-sm focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Account Settings
                </a>
            </div> --}}
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-2 text-xs text-gray-400">
            <span>User ID: {{ $user->id ?? 'N/A' }}</span>
            <span>Last updated: {{ $user->updated_at ? \Carbon\Carbon::parse($user->updated_at)->format('M d, Y h:i A') : 'N/A' }}</span>
        </div>
    </div>
</div>

@endsection
