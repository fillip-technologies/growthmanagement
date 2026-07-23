@extends('admin.include.layout')
@section('heading', 'Leads Management')
@section('title', 'Create New Lead')
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

@section('content')
    <div class="p-6 space-y-6">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Create New Lead</h2>
                <p class="text-gray-500 mt-1">Add a new lead to the system</p>
            </div>
            <a href="{{ route('admin.clientLeads') }}"
                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Leads
            </a>
        </div>

        <!-- Form -->
        <form action="{{ route('createLeadsdata') }}" method="POST"
            class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            @csrf
            <input type="hidden" name="created_by"
                value="{{ Auth::guard('account_manager')->check() ? Auth::guard('account_manager')->id() : '' }}">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <div class="space-y-6">

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Personal Information
                        </h3>

                        <div class="space-y-4">
                            <div class="grid md:grid-cols-2 lg:grid-cols-2 gap-4">

                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                        Full Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                                        placeholder="Enter full name">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                        Select Clients <span class="text-red-500">*</span>
                                    </label>
                                    <select name="client_id" id=""
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('client_id') border-red-500 @enderror">
                                        <option value="">Select Clients</option>
                                        @foreach (fillipLeads() as $items)
                                            <option value="{{ $items['id'] }}">{{ $items['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('client_id')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>


                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                                    placeholder="Enter email address">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>


                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @enderror"
                                    placeholder="Enter phone number">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-3 p-3">
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                                        City<span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel" name="city" id="phone" value="{{ old('city') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @enderror"
                                        placeholder="Enter your city">
                                    @error('city')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                                        State <span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel" name="state" id="phone" value="{{ old('state') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @enderror"
                                        placeholder="Enter your state">
                                    @error('state')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                                        Country<span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel" name="country" id="phone" value="{{ old('country') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @enderror"
                                        placeholder="Enter your country">
                                    @error('country')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                                        Pin Code <span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel" name="pin_code" id="pin_code" value="{{ old('pin_code') }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @enderror"
                                        placeholder="Enter your pin_code">
                                    @error('pin_code')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>


                    </div>

                    <!-- Company Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Company Information
                        </h3>

                        <div class="space-y-4">
                            <!-- Company -->
                            <div>
                                <label for="company" class="block text-sm font-medium text-gray-700 mb-1">
                                    Company Name
                                </label>
                                <input type="text" name="company_name" id="company"
                                    value="{{ old('company_name') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('company') border-red-500 @enderror"
                                    placeholder="Enter company name">
                                @error('company_name')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Industry -->
                            <div>
                                <label for="industry" class="block text-sm font-medium text-gray-700 mb-1">
                                    Industry <span class="text-red-500">*</span>
                                </label>
                                <select name="industry" id="industry"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('industry') border-red-500 @enderror">
                                    <option value="">Select Industry</option>
                                    <option value="Technology" {{ old('industry') == 'Technology' ? 'selected' : '' }}>
                                        Technology</option>
                                    <option value="Healthcare" {{ old('industry') == 'Healthcare' ? 'selected' : '' }}>
                                        Healthcare</option>
                                    <option value="Finance" {{ old('industry') == 'Finance' ? 'selected' : '' }}>Finance
                                    </option>
                                    <option value="Education" {{ old('industry') == 'Education' ? 'selected' : '' }}>
                                        Education</option>
                                    <option value="Retail" {{ old('industry') == 'Retail' ? 'selected' : '' }}>Retail
                                    </option>
                                    <option value="Manufacturing"
                                        {{ old('industry') == 'Manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                                    <option value="Real Estate" {{ old('industry') == 'Real Estate' ? 'selected' : '' }}>
                                        Real Estate</option>
                                    <option value="Hospitality" {{ old('industry') == 'Hospitality' ? 'selected' : '' }}>
                                        Hospitality</option>
                                    <option value="Consulting" {{ old('industry') == 'Consulting' ? 'selected' : '' }}>
                                        Consulting</option>
                                    <option value="Other" {{ old('industry') == 'Other' ? 'selected' : '' }}>Other
                                    </option>
                                </select>
                                @error('industry')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Services Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Services & Budget
                        </h3>

                        <div>
                            <label for="services" class="block text-sm font-medium text-gray-700 mb-1">
                                Services <span class="text-red-500">*</span>
                            </label>

                            <select name="services" id="services"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('services') border-red-500 @enderror">

                                <option value="">-- Select Service --</option>

                                <option value="Website Development — Basic Package"
                                    {{ old('services') == 'Website Development — Basic Package' ? 'selected' : '' }}>
                                    Website Development — Basic Package
                                </option>

                                <option value="Website Development — Standard Package"
                                    {{ old('services') == 'Website Development — Standard Package' ? 'selected' : '' }}>
                                    Website Development — Standard Package
                                </option>

                                <option value="Website Development — Premium Package"
                                    {{ old('services') == 'Website Development — Premium Package' ? 'selected' : '' }}>
                                    Website Development — Premium Package
                                </option>

                                <option value="Website Development — Multilingual Support"
                                    {{ old('services') == 'Website Development — Multilingual Support' ? 'selected' : '' }}>
                                    Website Development — Multilingual Support
                                </option>

                                <option value="Website Development — E-commerce Integration"
                                    {{ old('services') == 'Website Development — E-commerce Integration' ? 'selected' : '' }}>
                                    Website Development — E-commerce Integration
                                </option>

                                <option value="Website Development — Custom CMS"
                                    {{ old('services') == 'Website Development — Custom CMS' ? 'selected' : '' }}>
                                    Website Development — Custom CMS
                                </option>

                                <option value="Website Development — SEO Optimization"
                                    {{ old('services') == 'Website Development — SEO Optimization' ? 'selected' : '' }}>
                                    Website Development — SEO Optimization
                                </option>

                                <option value="Website Development — Responsive Design"
                                    {{ old('services') == 'Website Development — Responsive Design' ? 'selected' : '' }}>
                                    Website Development — Responsive Design
                                </option>

                                <option value="Website Development — API Integration"
                                    {{ old('services') == 'Website Development — API Integration' ? 'selected' : '' }}>
                                    Website Development — API Integration
                                </option>

                                <option value="Website Development — Payment Gateway"
                                    {{ old('services') == 'Website Development — Payment Gateway' ? 'selected' : '' }}>
                                    Website Development — Payment Gateway
                                </option>
                            </select>

                            @error('services')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>


                    </div>

                    <!-- Lead Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Lead Information
                        </h3>

                        <div class="space-y-4">
                            <div>
                                <label for="source" class="block text-sm font-medium text-gray-700 mb-1">
                                    Lead Source <span class="text-red-500">*</span>
                                </label>
                                <select name="lead_source" id="source"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('lead_source') border-red-500 @enderror">
                                    <option value="">Select Source</option>
                                    <option value="get-a-quote-calculator"
                                        {{ old('lead_source') == 'get-a-quote-calculator' ? 'selected' : '' }}>Get-a-Quote
                                        Calculator</option>
                                    <option value="website" {{ old('lead_source') == 'website' ? 'selected' : '' }}>
                                        Website</option>
                                    <option value="referral" {{ old('lead_source') == 'referral' ? 'selected' : '' }}>
                                        Referral</option>
                                    <option value="social_media"
                                        {{ old('lead_source') == 'social_media' ? 'selected' : '' }}>Social Media</option>
                                    <option value="email" {{ old('lead_source') == 'email' ? 'selected' : '' }}>Email
                                        Campaign</option>
                                    <option value="phone" {{ old('lead_source') == 'phone' ? 'selected' : '' }}>Phone
                                        Call</option>
                                    <option value="event" {{ old('lead_source') == 'event' ? 'selected' : '' }}>
                                        Event/Conference</option>
                                    <option value="partner" {{ old('lead_source') == 'partner' ? 'selected' : '' }}>
                                        Partner Channel</option>
                                    <option value="other" {{ old('lead_source') == 'other' ? 'selected' : '' }}>Other
                                    </option>
                                </select>
                                @error('lead_source')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="lead_status" class="block text-sm font-medium text-gray-700 mb-1">
                                    Lead Status <span class="text-red-500">*</span>
                                </label>
                                <select name="lead_status" id="status"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('lead_status') border-red-500 @enderror">
                                    <option value="new" {{ old('lead_status') == 'new' ? 'selected' : '' }}>New
                                    </option>
                                    <option value="contacted" {{ old('lead_status') == 'contacted' ? 'selected' : '' }}>
                                        Contacted</option>
                                    <option value="in_progress"
                                        {{ old('lead_status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="converted" {{ old('lead_status') == 'converted' ? 'selected' : '' }}>
                                        Converted</option>
                                    <option value="lost" {{ old('lead_status') == 'lost' ? 'selected' : '' }}>Lost
                                    </option>
                                    <option value="pending" {{ old('lead_status') == 'pending' ? 'selected' : '' }}>
                                        Pending</option>
                                </select>
                                @error('lead_status')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="space-y-6">
                                <label for="budget" class="block text-sm font-medium text-gray-700 mb-1">
                                    Budget <span class="text-red-500">*</span>
                                </label>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <input type="number" name="budget" id="budget_amount"
                                            value="{{ old('budget_amount') }}"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('budget_amount') border-red-500 @enderror"
                                            placeholder="Amount">
                                    </div>
                                    <div>
                                        <select name="budget_type" id="budget_type"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('budget_type') border-red-500 @enderror">
                                            <option value="one_time"
                                                {{ old('budget_type') == 'one_time' ? 'selected' : '' }}>
                                                One-time</option>
                                            <option value="monthly"
                                                {{ old('budget_type') == 'monthly' ? 'selected' : '' }}>
                                                Monthly</option>
                                            <option value="project_based"
                                                {{ old('budget_type') == 'project_based' ? 'selected' : '' }}>Project Based
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                @error('budget_amount')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                                @error('budget_type')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <!-- Message/Notes -->
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">
                                    Message / Notes
                                </label>
                                <textarea name="message" id="message" rows="4"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('message') border-red-500 @enderror"
                                    placeholder="Enter any additional notes or message">{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200 flex items-center justify-end gap-4">
                <a href=""
                    class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                    class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Create Lead
                </button>
            </div>
        </form>
    </div>

    <style>
        select[multiple] {
            background-image: none;
        }

        select[multiple] option {
            padding: 8px 12px;
            border-bottom: 1px solid #f3f4f6;
        }

        select[multiple] option:checked {
            background: #3b82f6 linear-gradient(0deg, #3b82f6 0%, #3b82f6 100%);
            color: white;
        }

        select[multiple] option:hover {
            background: #eff6ff;
        }
    </style>
@endsection
