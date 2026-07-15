@extends('admin.include.layout')
@section('heading', 'Leads Management')
@section('title', 'Leads List')

@section('content')
    <div class="p-6 space-y-6">
        <!-- Header Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <div class="flex items-center gap-4">
                    <div class="bg-blue-50 rounded-lg p-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Leads</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $paginatedLeads->total() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <div class="flex items-center gap-4">
                    <div class="bg-green-50 rounded-lg p-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">New Leads</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $paginatedLeads->where('status', 'new')->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <div class="flex items-center gap-4">
                    <div class="bg-purple-50 rounded-lg p-3">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Converted</p>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ $paginatedLeads->where('status', 'converted')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <div class="flex items-center gap-4">
                    <div class="bg-yellow-50 rounded-lg p-3">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Pending</p>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ $paginatedLeads->where('status', 'pending')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
@php
    $search = null;
    if(Auth::guard('super_admin')->check()){
        $search = route('admin.clientLeads');
    }else {
        $search = route('marketing.clientLeads');
    }
@endphp
        <!-- Search & Filters -->
        <form method="GET" action="{{ $search }}">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <div class="flex flex-col md:flex-row gap-4">

                    <!-- Search -->
                    <div class="flex-1 relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>

                        <input type="text" name="search" value="{{ request('search') }}"
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg"
                            placeholder="Search by name, email or phone">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                        Search
                    </button>

                </div>
            </div>
        </form>


        <!-- Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Industry</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Services</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>

                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($paginatedLeads as $lead)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $loop->iteration + ($paginatedLeads->currentPage() - 1) * $paginatedLeads->perPage() }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-medium text-sm">
                                            {{ strtoupper(substr($lead['name'] ?? 'U', 0, 1)) }}
                                        </div>
                                        <span class="font-medium text-gray-900">{{ $lead['name'] ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $lead['email'] ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $lead['phone'] ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $lead['industry'] ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <div class="flex flex-wrap gap-1">
                                        @if (!empty($lead['services']))
                                            <span class="text-xs text-gray-400">+{{ $lead['services'] }}</span>
                                        @else
                                            -
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = [
                                            'new' => 'bg-blue-100 text-blue-800',
                                            'contacted' => 'bg-yellow-100 text-yellow-800',
                                            'in_progress' => 'bg-purple-100 text-purple-800',
                                            'converted' => 'bg-green-100 text-green-800',
                                            'lost' => 'bg-red-100 text-red-800',
                                            'pending' => 'bg-orange-100 text-orange-800',
                                        ];
                                        $status = strtolower($lead['status'] ?? 'pending');
                                        $colorClass = $statusColors[$status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-3 py-1 text-xs font-medium rounded-full {{ $colorClass }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                        <span class="text-gray-500 text-lg">No Leads Found</span>
                                        <p class="text-gray-400 text-sm">Try adjusting your search or filter criteria</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-sm text-gray-600">
                        Showing <span class="font-medium">{{ $paginatedLeads->firstItem() ?? 0 }}</span>
                        to <span class="font-medium">{{ $paginatedLeads->lastItem() ?? 0 }}</span>
                        of <span class="font-medium">{{ $paginatedLeads->total() }}</span> results
                    </p>
                    <div class="flex items-center gap-2">
                        {{ $paginatedLeads->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Pagination Styling -->
    <style>
        .pagination {
            display: flex;
            gap: 0.25rem;
            align-items: center;
        }

        .pagination .page-item {
            display: inline-flex;
        }

        .pagination .page-link {
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
            color: #4B5563;
            font-size: 0.875rem;
            transition: all 0.15s;
            border: 1px solid transparent;
        }

        .pagination .page-link:hover {
            background-color: #F3F4F6;
            color: #1F2937;
        }

        .pagination .active .page-link {
            background-color: #2563EB;
            color: white;
            border-color: #2563EB;
        }

        .pagination .disabled .page-link {
            color: #9CA3AF;
            pointer-events: none;
        }
    </style>
@endsection
