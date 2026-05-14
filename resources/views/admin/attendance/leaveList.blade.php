@extends('admin.include.layout')
@section('content')
    <div class="p-6">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow p-4">
                <div class="text-sm text-gray-500">Total Leaves</div>
                <div class="text-2xl font-bold text-gray-800">{{ $datas->count() }}</div>
                <div class="text-xs text-green-600 mt-1">↑ 12% from last month</div>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <div class="text-sm text-gray-500">Approved</div>
                <div class="text-2xl font-bold text-green-600">{{ $datas->where('status', 'approved')->count() }}</div>
                <div class="text-xs text-gray-500 mt-1">Leaves</div>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <div class="text-sm text-gray-500">Pending</div>
                <div class="text-2xl font-bold text-yellow-600">{{ $datas->where('status', 'pending')->count() }}</div>
                <div class="text-xs text-gray-500 mt-1">Awaiting approval</div>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <div class="text-sm text-gray-500">Rejected</div>
                <div class="text-2xl font-bold text-red-600">{{ $datas->where('status', 'reject')->count() }}</div>
                <div class="text-xs text-gray-500 mt-1">This month</div>
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="p-4 border-b border-gray-200">
                <form method="GET" action=""
                    class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <input type="text" name="search" placeholder="Search employee..."
                                value="{{ request('search') }}"
                                class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <select name="status"
                            class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved
                            </option>
                            <option value="reject" {{ request('status') == 'reject' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        <button type="submit"
                            class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition duration-200">
                            Filter
                        </button>
                        @if (request('search') || request('status'))
                            <a href="" class="text-red-600 hover:text-red-800">Clear</a>
                        @endif
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-500">Show:</span>
                        <select name="per_page" onchange="this.form.submit()"
                            class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        </select>
                    </div>
                </form>
            </div>

            <!-- Leave Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Employee</th>
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
                        @forelse ($datas as $data)
                            <tr class="hover:bg-gray-50 transition duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div
                                                class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                <span class="text-gray-600 font-medium">
                                                    {{ substr($data->employee->name ?? 'N/A', 0, 2) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $data->employee->name ?? 'N/A' }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $data->employee->email ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($data->from_date)->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($data->to_date)->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $data->days ?? \Carbon\Carbon::parse($data->from_date)->diffInDays(\Carbon\Carbon::parse($data->to_date)) + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if ($data->status == 'approved') bg-green-100 text-green-800
                                    @elseif($data->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($data->status == 'reject') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($data->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <button type="button" onclick="viewDetails({{ $data->id }})"
                                            class="text-blue-600 hover:text-blue-900" title="View">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </button>

                                        @if ($data->status == 'pending')
                                            <button type="button" onclick="statusapprove({{ $data->id }})"
                                                class="text-green-600 hover:text-green-900" title="Approve"
                                                onclick="return confirm('Are you sure you want to approve this leave request?')">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </button>


                                            <button type="button" onclick="statusreject({{ $data->id }})"
                                                class="text-red-600 hover:text-red-900" title="Reject"
                                                onclick="return confirm('Are you sure you want to reject this leave request?')">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        @endif


                                        <button type="submit" onclick="deletedata({{ $data->id }})"
                                            class="text-red-600 hover:text-red-900" title="Delete"
                                            onclick="return confirm('Are you sure you want to delete this leave record?')">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="text-gray-500">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                        <p class="mt-2 text-sm">No leave requests found</p>
                                        <p class="mt-1 text-xs">Try adjusting your search or filter criteria</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if (method_exists($datas, 'links'))
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $datas->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
    <div id="leaveModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    </div>

    <script>
        function showNotification(message, type = 'success') {
            const colors = {
                success: 'bg-green-500',
                error: 'bg-red-500',
                info: 'bg-blue-500'
            };

            const notification = $(`
                <div class="fixed top-4 right-4 z-50 animate-slide-in-right">
                    <div class="${colors[type]} text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            ${type === 'success' ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>' :
                              type === 'error' ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>' :
                              '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'}
                        </svg>
                        <span>${message}</span>
                    </div>
                </div>
            `);

            $('body').append(notification);
            setTimeout(() => {
                notification.fadeOut(300, function() {
                    $(this).remove();
                });
            }, 3000);
        }

        function statusapprove(id) {
            $.ajax({
                type: "POST",
                url: "{{ route('status.approved') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },


                success: function(res) {
                    showNotification(res.message);
                    setTimeout(() => {
                        location.reload()
                    }, 1500);
                },
                error: function(error) {
                    console.log(error);

                }
            });
        }

        function statusreject(id) {
            $.ajax({
                type: "POST",
                url: "{{ route('status.reject') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success: function(res) {
                    showNotification(res.message);
                    setTimeout(() => {
                        location.reload()
                    }, 1500);

                },
                error: function(error) {
                    console.log(error);

                }
            });

        }

        function deletedata(id) {
            $.ajax({
                type: "DELETE",
                url: "{{ route('status.delete') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success: function(res) {
                    showNotification(res.message);
                    setTimeout(() => {
                        location.reload()
                    }, 1500);

                },
                error: function(error) {
                    console.log(error);
                }
            });

        }

        function viewDetails(id) {

            var leaveModal = $("#leaveModal");

            $.ajax({
                type: "GET",
                url: "{{ route('viwe.leave') }}",
                data: {
                    id: id
                },
                success: function(res) {

                    if (res.success == true) {

                        let html = `
                  <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                  <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-lg bg-white animate-fadeIn">

            <!-- Header -->
            <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                <div class="flex items-center space-x-2">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-900">Leave Details</h3>
                </div>
                <button onclick="closeLeaveModal()"
                    class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Content -->
            <div id="modalContent" class="mt-6 space-y-4">

                <!-- Employee Name -->
                <div class="flex flex-col sm:flex-row sm:items-center py-2 px-3 bg-gray-50 rounded-lg">
                    <span class="font-semibold text-gray-700 sm:w-32">Employee Name :</span>
                    <span class="text-gray-900 mt-1 sm:mt-0">${res.data.employee?.name ?? 'N/A'}</span>
                </div>

                <!-- From Date -->
                <div class="flex flex-col sm:flex-row sm:items-center py-2 px-3 hover:bg-gray-50 rounded-lg transition-colors">
                    <span class="font-semibold text-gray-700 sm:w-32">From Date :</span>
                    <span class="text-gray-900 mt-1 sm:mt-0">${res.data.from_date ?? 'N/A'}</span>
                </div>

                <!-- To Date -->
                <div class="flex flex-col sm:flex-row sm:items-center py-2 px-3 hover:bg-gray-50 rounded-lg transition-colors">
                    <span class="font-semibold text-gray-700 sm:w-32">To Date :</span>
                    <span class="text-gray-900 mt-1 sm:mt-0">${res.data.to_date ?? 'N/A'}</span>
                </div>

                <!-- Duration -->
                <div class="flex flex-col sm:flex-row sm:items-center py-2 px-3 hover:bg-gray-50 rounded-lg transition-colors">
                    <span class="font-semibold text-gray-700 sm:w-32">Duration :</span>
                    <span class="text-gray-900 mt-1 sm:mt-0">
                        ${calculateDuration(res.data.from_date, res.data.to_date)}
                    </span>
                </div>

                <!-- Reason -->
                <div class="flex flex-col sm:flex-row py-2 px-3 hover:bg-gray-50 rounded-lg transition-colors">
                    <span class="font-semibold text-gray-700 sm:w-32">Reason :</span>
                    <span class="text-gray-900 mt-1 sm:mt-0 flex-1">${res.data.reason ?? 'N/A'}</span>
                </div>

                <!-- Status -->
                <div class="flex flex-col sm:flex-row sm:items-center py-2 px-3 bg-gray-50 rounded-lg">
                    <span class="font-semibold text-gray-700 sm:w-32">Status :</span>
                    <span class="mt-1 sm:mt-0">
                        ${getStatusBadge(res.data.status ?? 'Pending')}
                    </span>
                </div>

            </div>

            <!-- Footer -->
            <div class="mt-8 flex justify-end space-x-3 pt-4 border-t border-gray-200">
                <button onclick="closeLeaveModal()"
                    class="px-5 py-2.5 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-400">
                    Close
                </button>
            </div>

        </div>
    </div>
`;

                        leaveModal.html(html);
                        leaveModal.removeClass('hidden');
                    }

                },

                error: function(error) {
                    console.log(error);
                }
            });
        }

        function closeLeaveModal() {
            $("#leaveModal").addClass('hidden').html('');
        }


        $(document).on('click', '#leaveModal', function(e) {
            if (e.target.id == 'leaveModal') {
                closeLeaveModal();
            }
        });

        function calculateDuration(fromDate, toDate) {
            if (!fromDate || !toDate) return 'N/A';

            const start = new Date(fromDate);
            const end = new Date(toDate);
            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            return `${diffDays} day${diffDays !== 1 ? 's' : ''}`;
        }

        // Helper function to get status badge with appropriate color
        function getStatusBadge(status) {
            const statusColors = {
                'Approved': 'bg-green-100 text-green-800 border border-green-200',
                'Pending': 'bg-yellow-100 text-yellow-800 border border-yellow-200',
                'Rejected': 'bg-red-100 text-red-800 border border-red-200',
                'Cancelled': 'bg-gray-100 text-gray-800 border border-gray-200'
            };

            const colorClass = statusColors[status] || statusColors['Pending'];

            return `<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold ${colorClass}">
        <span class="w-2 h-2 rounded-full mr-2 ${status === 'Approved' ? 'bg-green-500' : status === 'Pending' ? 'bg-yellow-500' : status === 'Rejected' ? 'bg-red-500' : 'bg-gray-500'}"></span>
        ${status}
    </span>`;
        }

        const style = document.createElement('style');
        style.textContent = `
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fadeIn {
        animation: fadeIn 0.3s ease-out;
    }
`;
        document.head.appendChild(style);
    </script>
@endsection
