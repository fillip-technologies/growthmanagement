@extends('admin.include.layout')
@section('heading', 'Details')
@section('title', 'Sales Works Reports Details')
@section('content')

    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Sales Report Details</h2>
                <p class="text-gray-500 text-sm mt-1">View complete information about the sales report</p>
            </div>
            
        </div>
    </div>

    {{-- User/Employee Information Section --}}
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-8 mb-6 border border-blue-100">
        <div class="flex items-start justify-between">
            <div class="flex items-start space-x-6">
                <!-- Large Avatar -->
                <div
                    class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center text-white font-bold text-2xl shadow-lg shadow-blue-200">
                    {{ $data && $data->user ? strtoupper(substr($data->user->name, 0, 2)) : 'N/A' }}
                </div>

                <div>
                    <div class="flex items-center space-x-3 mb-1">
                        <h3 class="text-xl font-bold text-gray-800">{{ $data->user->name ?? 'N/A' }}</h3>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                            {{ $data->user->role ?? 'Employee' }}
                        </span>
                        <span class="text-xs text-gray-400">ID: #{{ $data->user->id ?? 'N/A' }}</span>
                    </div>
                    <p class="text-gray-600 text-sm">{{ $data->user->department ?? 'N/A' }}</p>

                    <div class="flex flex-wrap gap-6 mt-4">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span class="text-sm text-gray-600">{{ $data->user->email ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                            <span class="text-sm text-gray-600">{{ $data->user->phone ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span class="text-sm text-gray-600">
                                Joined:
                                {{ optional($data->user)->joinig_date
                                    ? \Carbon\Carbon::parse(optional($data->user)->joinig_date)->format('d F Y')
                                    : 'N/A' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Lead/Task Information Section --}}
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-2xl p-8 mb-6 border border-green-100">
            <div class="flex flex-col">
                <!-- Project Header -->
                <div class="flex items-start justify-between mb-6 pb-6 border-b border-green-200/50">
                    <div class="flex items-start space-x-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg shadow-green-200">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center space-x-3">
                                <h3 class="text-xl font-bold text-gray-800">{{ $data->leaddata->lead_source ?? 'N/A' }}</h3>
                                <span class="text-xs text-gray-400">Lead #{{ $data->leaddata->id ?? 'N/A' }}</span>
                            </div>
                            <div class="flex items-center space-x-4 mt-1">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                            {{ $data->leaddata->lead_status == 'contacted'
                                ? 'bg-green-100 text-green-800 border border-green-200'
                                : ($data->leaddata->lead_status == 'in_progress'
                                    ? 'bg-yellow-100 text-yellow-800 border border-yellow-200'
                                    : ($data->leaddata->lead_status == 'closed' || $data->leaddata->lead_status == 'converted'
                                        ? 'bg-blue-100 text-blue-800 border border-blue-200'
                                        : ($data->leaddata->lead_status == 'lost'
                                            ? 'bg-red-100 text-red-800 border border-red-200'
                                            : 'bg-gray-100 text-gray-800 border border-gray-200'))) }}">
                                    <span
                                        class="w-1.5 h-1.5 rounded-full mr-1.5
                                {{ $data->leaddata->lead_status == 'contacted'
                                    ? 'bg-green-500'
                                    : ($data->leaddata->lead_status == 'in_progress'
                                        ? 'bg-yellow-500 animate-pulse'
                                        : ($data->leaddata->lead_status == 'closed' || $data->leaddata->lead_status == 'converted'
                                            ? 'bg-blue-500'
                                            : ($data->leaddata->lead_status == 'lost'
                                                ? 'bg-red-500'
                                                : 'bg-gray-500'))) }}"></span>
                                    {{ ucfirst(str_replace('_', ' ', $data->leaddata->lead_status ?? 'N/A')) }}
                                </span>
                                @if ($data->leaddata->budget)
                                    <span class="text-sm text-gray-600">Budget: <strong
                                            class="text-green-600">${{ number_format((float) $data->leaddata->budget, 2) }}</strong></span>
                                @endif
                                @if ($data->leaddata->budget_type)
                                    <span class="text-sm text-gray-600">Type: <strong
                                            class="text-gray-700">{{ ucfirst($data->leaddata->budget_type) }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Client Information Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    @if ($data->leaddata->name)
                        <div class="bg-white/60 backdrop-blur-sm rounded-xl p-4 border border-green-200/50">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium">Contact Name</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $data->leaddata->name }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($data->leaddata->email)
                        <div class="bg-white/60 backdrop-blur-sm rounded-xl p-4 border border-green-200/50">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium">Email</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $data->leaddata->email }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($data->leaddata->phone)
                        <div class="bg-white/60 backdrop-blur-sm rounded-xl p-4 border border-green-200/50">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium">Phone</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $data->leaddata->phone }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Company and Services Section --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    @if ($data->leaddata->company_name)
                        <div class="bg-white/60 backdrop-blur-sm rounded-xl p-4 border border-green-200/50">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium">Company</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $data->leaddata->company_name }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($data->leaddata->industry)
                        <div class="bg-white/60 backdrop-blur-sm rounded-xl p-4 border border-green-200/50">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium">Industry</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $data->leaddata->industry }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Location Information --}}
                @if ($data->leaddata->country || $data->leaddata->city || $data->leaddata->state || $data->leaddata->pin_code)
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                        @if ($data->leaddata->country)
                            <div class="bg-white/60 backdrop-blur-sm rounded-xl p-4 border border-green-200/50">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 font-medium">Country</p>
                                        <p class="text-sm font-semibold text-gray-800">{{ $data->leaddata->country }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($data->leaddata->state)
                            <div class="bg-white/60 backdrop-blur-sm rounded-xl p-4 border border-green-200/50">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 font-medium">State</p>
                                        <p class="text-sm font-semibold text-gray-800">{{ $data->leaddata->state }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($data->leaddata->city)
                            <div class="bg-white/60 backdrop-blur-sm rounded-xl p-4 border border-green-200/50">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-cyan-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 font-medium">City</p>
                                        <p class="text-sm font-semibold text-gray-800">{{ $data->leaddata->city }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($data->leaddata->pin_code)
                            <div class="bg-white/60 backdrop-blur-sm rounded-xl p-4 border border-green-200/50">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 font-medium">PIN Code</p>
                                        <p class="text-sm font-semibold text-gray-800">{{ $data->leaddata->pin_code }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Services and Message Section --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if ($data->leaddata->services)
                        <div class="bg-white/60 backdrop-blur-sm rounded-xl p-4 border border-green-200/50">
                            <div class="flex items-start space-x-3">
                                <div
                                    class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium">Services Required</p>
                                    <p class="text-sm text-gray-700 mt-0.5">{{ $data->leaddata->services }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($data->leaddata->message)
                        <div class="bg-white/60 backdrop-blur-sm rounded-xl p-4 border border-green-200/50">
                            <div class="flex items-start space-x-3">
                                <div
                                    class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium">Message / Notes</p>
                                    <p class="text-sm text-gray-700 mt-0.5">{{ $data->leaddata->message }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Task Dates and Metadata --}}
                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white/60 backdrop-blur-sm rounded-xl p-4 border border-green-200/50">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">Created Date</p>
                                <p class="text-sm font-semibold text-gray-800">
                                    {{ $data->created_at ? $data->created_at->format('d F Y h:i A') : 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white/60 backdrop-blur-sm rounded-xl p-4 border border-green-200/50">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">Last Updated</p>
                                <p class="text-sm font-semibold text-gray-800">
                                    {{ $data->updated_at ? $data->updated_at->format('d F Y h:i A') : 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white/60 backdrop-blur-sm rounded-xl p-4 border border-green-200/50">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">Lead Source</p>
                                <p class="text-sm font-semibold text-gray-800">
                                    {{ ucfirst($data->leaddata->lead_source ?? 'N/A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($data->leaddata->created_by)
                    <div class="mt-6">
                        <div class="bg-white/60 backdrop-blur-sm rounded-xl p-4 border border-green-200/50">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium">Created By (User ID)</p>
                                    <p class="text-sm font-semibold text-gray-800">#{{ $data->leaddata->created_by }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    @endsection
