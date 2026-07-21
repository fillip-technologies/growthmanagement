@extends('admin.include.layout')
@section('heading', 'Reports')
@section('title', 'Sales Works Reports')
@section('content')

    <div class="p-6 bg-gray-50 min-h-screen">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Sales Works Report</h2>
                <p class="text-sm text-gray-500 mt-1">Overview of user performance and project statistics</p>
            </div>
            <div class="flex space-x-3">
                <button
                    class="bg-white hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg border border-gray-300 text-sm font-medium transition flex items-center shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Export
                </button>

            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6 border border-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-700 uppercase tracking-wider mb-1">From Date</label>
                    <input type="date" value="2026-01-01"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 uppercase tracking-wider mb-1">To Date</label>
                    <input type="date" value="2026-07-20"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 uppercase tracking-wider mb-1">Project</label>
                    <select
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        <option value="">All Projects</option>
                        <option value="1">E-commerce Platform</option>
                        <option value="2" selected>CRM System</option>
                        <option value="3">Mobile App</option>
                        <option value="4">Website Redesign</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 uppercase tracking-wider mb-1">User</label>
                    <select
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        <option value="">All Users</option>
                        <option value="1">John Doe</option>
                        <option value="2" selected>Jane Smith</option>
                        <option value="3">Mike Johnson</option>
                        <option value="4">Sarah Williams</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition flex items-center justify-center text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Apply Filters
                    </button>
                </div>
            </div>
        </div>



        <!-- User & Project Details Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex justify-between items-center">
                    <h3 class="text-sm font-semibold text-gray-800">User & Project Details</h3>
                    <div class="flex items-center space-x-2">
                        <span class="text-xs text-gray-500">Showing 10 records</span>
                        <button class="text-xs text-blue-600 hover:text-blue-700 font-medium">View All</button>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Projects</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Revenue</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Budget Type</th>

                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($reports as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-sm font-semibold text-blue-600">
                                           {{ strtoupper(substr($item->user?->name ?? '-', 0, 2)) }}</div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ $item->user->name ?? '-' }}</p>
                                            <p class="text-xs text-gray-500">{{ $item->user->email ?? "-" }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $item->leaddata->lead_source ?? '-' }}</p>
                                        <p class="text-xs text-gray-500">{{ $item->leaddata->services ?? '_' }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                       {{ ucfirst($item->leaddata?->lead_status ?? '-') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="text-sm font-medium text-gray-900">₹{{ $item->leaddata->budget ?? '-' }}</p>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ ucfirst($item->leaddata->budget_type) ?? '-' }}</p>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <a href="{{ route('viewtaskdetails',$item->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium mr-3">View</button>

                                </td>
                            </tr>

                        @empty
                        @endforelse

                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="px-6 py-3 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                <p class="text-xs text-gray-500">
                    Showing {{ $reports->firstItem() }} to {{ $reports->lastItem() }} of {{ $reports->total() }} entries
                </p>

                <div>
                    {{ $reports->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
