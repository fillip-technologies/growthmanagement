@extends('admin.include.layout')
@section('content')
    <div class="p-6">
        <!-- Page Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Leave Management</h1>
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Apply Leave
            </button>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow p-4">
                <div class="text-sm text-gray-500">Total Leaves</div>
                <div class="text-2xl font-bold text-gray-800">{{ $datas->count() }}</div>
                <div class="text-xs text-green-600 mt-1">↑ 12% from last month</div>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <div class="text-sm text-gray-500">Approved</div>
                <div class="text-2xl font-bold text-green-600">{{ $datas->where('status','approved')->count() }}</div>
                <div class="text-xs text-gray-500 mt-1">Leaves</div>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <div class="text-sm text-gray-500">Pending</div>
                <div class="text-2xl font-bold text-yellow-600">{{ $datas->where('status','pending')->count() }}</div>
                <div class="text-xs text-gray-500 mt-1">Awaiting approval</div>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <div class="text-sm text-gray-500">Rejected</div>
                <div class="text-2xl font-bold text-red-600">{{ $datas->where('status','reject')->count() }}</div>
                <div class="text-xs text-gray-500 mt-1">This month</div>
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="p-4 border-b border-gray-200">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <input type="text" placeholder="Search employee..."
                                class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <select
                            class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>All Status</option>
                            <option>Pending</option>
                            <option>Approved</option>
                            <option>Rejected</option>
                        </select>
                        <select
                            class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>All Types</option>
                            <option>Casual Leave</option>
                            <option>Sick Leave</option>
                            <option>Annual Leave</option>
                            <option>Maternity Leave</option>
                        </select>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-500">Show:</span>
                        <select
                            class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>10</option>
                            <option>25</option>
                            <option>50</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Leave Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Employee</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Leave
                                Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">From
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">To
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Days
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Row 1 -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0">
                                        <img class="h-10 w-10 rounded-full"
                                            src="https://ui-avatars.com/api/?name=John+Doe&background=0D8ABC&color=fff"
                                            alt="">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">John Doe</div>
                                        <div class="text-sm text-gray-500">Software Developer</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    Casual Leave
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2024-01-15</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2024-01-16</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Approved
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button class="text-blue-600 hover:text-blue-900 mr-3">View</button>
                                <button class="text-red-600 hover:text-red-900">Cancel</button>
                            </td>
                        </tr>

                        <!-- Row 2 -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0">
                                        <img class="h-10 w-10 rounded-full"
                                            src="https://ui-avatars.com/api/?name=Sarah+Smith&background=F59E0B&color=fff"
                                            alt="">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">Sarah Smith</div>
                                        <div class="text-sm text-gray-500">Marketing Manager</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Sick Leave
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2024-01-20</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2024-01-22</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">3</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Pending
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button class="text-blue-600 hover:text-blue-900 mr-3">Approve</button>
                                <button class="text-red-600 hover:text-red-900">Reject</button>
                            </td>
                        </tr>

                        <!-- Row 3 -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0">
                                        <img class="h-10 w-10 rounded-full"
                                            src="https://ui-avatars.com/api/?name=Mike+Johnson&background=10B981&color=fff"
                                            alt="">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">Mike Johnson</div>
                                        <div class="text-sm text-gray-500">HR Specialist</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                    Annual Leave
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2024-02-01</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2024-02-05</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">5</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Rejected
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button class="text-blue-600 hover:text-blue-900 mr-3">View</button>
                                <button class="text-gray-600 hover:text-gray-900">Resubmit</button>
                            </td>
                        </tr>

                        <!-- Row 4 -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0">
                                        <img class="h-10 w-10 rounded-full"
                                            src="https://ui-avatars.com/api/?name=Emily+Brown&background=EF4444&color=fff"
                                            alt="">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">Emily Brown</div>
                                        <div class="text-sm text-gray-500">Graphic Designer</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-pink-100 text-pink-800">
                                    Maternity Leave
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2024-01-25</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2024-02-25</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">30</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Approved
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button class="text-blue-600 hover:text-blue-900 mr-3">View</button>
                                <button class="text-red-600 hover:text-red-900">Cancel</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-500">
                        Showing 1 to 4 of 24 entries
                    </div>
                    <div class="flex items-center gap-2">
                        <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50 disabled:opacity-50"
                            disabled>Previous</button>
                        <button class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">1</button>
                        <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50">2</button>
                        <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50">3</button>
                        <span class="px-2 text-gray-500">...</span>
                        <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50">6</button>
                        <button class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50">Next</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
