


@extends('admin.include.layout')
@section('heading', 'My Task Details')
@section('title', 'My Task')
@section('content')

    <div class="container mx-auto px-4 py-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-3 sm:mb-0">My Tasks</h1>
            <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                    </path>
                </svg>
                {{ $tasks->count() }} Total Tasks
            </span>
        </div>

        <!-- Task Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @if ($tasks->count() > 0)
                @foreach ($tasks as $task)
                    <div
                        class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-100">
                        <!-- Card Header -->
                        <div
                            class="px-4 py-3 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200 flex justify-between items-center">
                            <h6 class="text-sm font-semibold text-blue-700">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                                Task #{{ $task->id }}
                            </h6>
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z">
                                        </path>
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false"
                                    class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 border border-gray-200"
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100">
                                    <a href="{{ route('view.sale.task', ['id' => $task->leaddata_id, 'user_id' => $task->user_id]) }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                        View Details
                                    </a>
                                    <a href="javascript:void(0)" onclick="openStatusModal({{ $task->leaddata_id }})"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                        Update Status
                                    </a>
                                    <hr class="my-1">
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                            </path>
                                        </svg>
                                        Add Comment
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="px-4 py-4">
                            <!-- Lead Information -->
                            @if ($task->leaddata)
                                <div class="mb-3">
                                    <h5 class="text-blue-600 font-semibold text-base">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                        {{ $task->leaddata->name ?? 'N/A' }}
                                    </h5>
                                    <p class="text-gray-500 text-xs mb-1">
                                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        {{ $task->leaddata->email ?? 'No email' }}
                                    </p>
                                    <p class="text-gray-500 text-xs mb-1">
                                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                            </path>
                                        </svg>
                                        {{ $task->leaddata->phone ?? 'No phone' }}
                                    </p>
                                    @if ($task->leaddata->company)
                                        <p class="text-gray-500 text-xs">
                                            <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                </path>
                                            </svg>
                                            {{ $task->leaddata->company }}
                                        </p>
                                    @endif
                                </div>
                            @else
                                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-2 mb-3">
                                    <p class="text-yellow-700 text-xs">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                            </path>
                                        </svg>
                                        No lead associated
                                    </p>
                                </div>
                            @endif

                            <!-- Assigned User -->
                            <div class="border-t border-gray-200 pt-2 mb-2">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <span class="text-gray-500 text-xs">Assigned To:</span>
                                        <p class="font-semibold text-sm">{{ $task->user->name ?? 'N/A' }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-gray-500 text-xs">Department:</span>
                                        <p class="font-semibold text-sm">{{ $task->user->department ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Status & Priority Badges -->
                            <div class="flex flex-wrap gap-2 mt-2">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'in_progress' => 'bg-blue-100 text-blue-800',
                                        'converted' => 'bg-green-100 text-green-800',
                                        'new' => 'bg-red-100 text-red-800',
                                        'lost' => 'bg-gray-100 text-gray-800',
                                    ];
                                    $status = strtolower($task->leaddata->lead_status ?? 'pending');
                                    $statusColor = $statusColors[$task->leaddata->lead_status] ?? 'bg-gray-100 text-gray-800';

                                    $priorityColors = [
                                        'high' => 'bg-red-100 text-red-800 border-red-300',
                                        'medium' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                                        'low' => 'bg-green-100 text-green-800 border-green-300',
                                    ];
                                    $priority = strtolower($task->priority ?? 'medium');
                                    $priorityColor = $priorityColors[$priority] ?? 'bg-gray-100 text-gray-800';
                                @endphp

                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current mr-1.5"></span>
                                    {{ ucwords(str_replace('_', ' ', $task->leaddata->lead_status ?? 'Pending')) }}
                                </span>

                                @if ($task->priority)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $priorityColor }}">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 01-1-1V6z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                @endif
                            </div>

                            <!-- Description -->
                            @if ($task->des)
                                <div class="mt-2">
                                    <p class="text-gray-600 text-xs leading-relaxed">
                                        <svg class="w-3 h-3 inline mr-1 text-gray-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 6h16M4 12h16M4 18h7"></path>
                                        </svg>
                                        {{ Str::limit($task->des, 80) }}
                                    </p>
                                </div>
                            @endif

                            <!-- Dates -->
                            <div class="mt-3 pt-2 border-t border-gray-200 flex justify-between text-gray-500 text-xs">
                                <div>
                                    <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    {{ $task->created_at ? $task->created_at->format('d M Y') : 'N/A' }}
                                </div>
                                <div>
                                    <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Due:
                                    {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d M Y') : 'N/A' }}
                                </div>
                            </div>
                        </div>



                    </div>
                @endforeach
            @else
                <!-- Empty State -->
                <div class="col-span-1 md:col-span-2 xl:col-span-3">
                    <div class="bg-white rounded-lg shadow-md p-12 text-center">
                        <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                        <h5 class="text-xl font-medium text-gray-500 mb-2">No tasks assigned yet</h5>
                        <p class="text-gray-400 text-sm">You don't have any tasks assigned at the moment.</p>
                    </div>
                </div>
            @endif
        </div>
        <!-- Update Status Modal -->
        <div id="statusModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">

            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 overflow-hidden">

                <!-- Header -->
                <div class="flex items-center justify-between px-6 py-4 border-b">
                    <h2 class="text-xl font-semibold text-gray-800">
                        Update Task Status
                    </h2>

                    <button onclick="closeStatusModal()" class="text-gray-500 hover:text-red-500 text-2xl">
                        &times;
                    </button>
                </div>

                <!-- Body -->
                <form action="{{ route('updateWorks') }}" method="POST" class="p-6 space-y-5">
                    @csrf
                    <input type="hidden" id="leaddata_id" name="leaddata_id">
                    <input type="hidden" name="user_id" value="{{ Auth::guard('employee')->check() ? Auth::guard('employee')->id() : "" }}">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">
                            Status
                        </label>

                        <select name="lead_status" id="lead_status"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="new" >New</option>
                            <option value="contacted">Contacted</option>
                            <option value="in_progress">In Progress</option>
                            <option value="converted">Converted</option>
                            <option value="lost">Lost</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">
                            Work Update
                        </label>

                        <textarea name="task_des" rows="5" placeholder="Write today's work update..."
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 resize-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    </div>

                    <div class="flex justify-end gap-3">

                        <button type="button" onclick="closeStatusModal()"
                            class="px-5 py-2 rounded-lg border border-gray-300 hover:bg-gray-100">
                            Cancel
                        </button>

                        <button type="submit" class="px-6 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
                            Update Status
                        </button>

                    </div>

                </form>

            </div>
        </div>
        <!-- Pagination -->
        @if ($tasks instanceof \Illuminate\Pagination\LengthAwarePaginator && $tasks->hasPages())
            <div class="mt-6">
                {{ $tasks->links() }}
            </div>
        @endif
    </div>

    <script>
        function openStatusModal(id) {
            const modal = document.getElementById('statusModal');
            modal.classList.remove('hidden');
            document.getElementById('leaddata_id').value = id;
            modal.classList.add('flex');
        }

        function closeStatusModal() {
            const modal = document.getElementById('statusModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }


        document.getElementById('statusModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeStatusModal();
            }
        });
    </script>

@endsection

















