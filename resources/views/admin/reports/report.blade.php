@extends('admin.include.layout')

@section('heading', 'Reports')
@section('title', 'Report Lists')

@section('content')
    <style>
        @media (max-width: 767px) {
            #reportsTable thead {
                display: none;
            }

            #reportsTable,
            #reportsTable tbody,
            #reportsTable tr,
            #reportsTable td {
                display: block;
                width: 100%;
            }

            #reportsTable tr {
                margin-bottom: 1rem;
                overflow: hidden;
                border: 1px solid #dbeafe;
                border-radius: 1rem;
                background: #ffffff;
                box-shadow: 0 16px 34px rgba(15, 36, 87, 0.08);
            }

            #reportsTable td {
                border: 0;
                padding: 0.9rem 1rem;
                white-space: normal !important;
            }

            #reportsTable td::before {
                content: attr(data-label);
                display: block;
                margin-bottom: 0.45rem;
                color: #64748b;
                font-size: 0.72rem;
                font-weight: 800;
                letter-spacing: 0.08em;
                text-transform: uppercase;
            }

            #reportsTable td:last-child {
                border-top: 1px solid #eef2ff;
            }

            .report-actions {
                justify-content: flex-start !important;
            }
        }
    </style>

    <div class="max-w-[1500px] mx-auto mt-4 px-0 sm:px-2 lg:px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-8 mb-10">
            <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-blue-500 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wide">Active Tasks</p>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ $reports->where('project.status', 'progress')->count() }}
                        </p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fa-solid fa-play text-cyan-500"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-emerald-500 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wide">Completed</p>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ $reports->where('project.status', 'completed')->count() }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center">
                        <i class="fa-solid fa-check-double text-emerald-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-cyan-500 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wide">Pending</p>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ $reports->where('project.status', 'pending')->count() }}
                        </p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-cyan-100 flex items-center justify-center">
                        <i class="fa-regular fa-hourglass-half text-cyan-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-blue-500 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wide">Total Employees</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $reports->unique('user_id')->count() }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fa-solid fa-users text-blue-600"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <div class="h-8 w-1 bg-gradient-to-b from-blue-400 to-cyan-500 rounded-full"></div>
                    <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Reports</h1>
                </div>
                <p class="text-sm text-gray-500 ml-3">
                    Comprehensive overview of all tasks, projects, and employee performance metrics
                </p>
            </div>
            <div class="flex items-center gap-3">
                <div
                    class="hidden sm:flex items-center gap-2 bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-100">
                    <i class="fa-regular fa-calendar-alt text-blue-500 text-sm"></i>
                    <span class="text-xs text-gray-600 font-medium">{{ now()->format('d M, Y') }}</span>
                </div>
                <div
                    class="bg-gradient-to-r from-blue-500 to-cyan-500 text-white px-5 py-2.5 rounded-xl shadow-md shadow-blue-200">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-chart-simple text-sm"></i>
                        <span class="text-sm font-semibold">Total Tasks : {{ $reports->count() ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden transition-all duration-200 hover:shadow-xl">
            <div class="overflow-x-auto scrollbar-thin scrollbar-thumb-gray-300">
                <table id="reportsTable" class="min-w-full text-sm md:min-w-[1100px]">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-gray-100 border-b-2 border-gray-200">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">#
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                <i class="fa-regular fa-diagram-project mr-2 text-blue-400"></i>Project Details
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                <i class="fa-regular fa-user mr-2 text-blue-400"></i>Employee Details
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                <i class="fa-regular fa-flag mr-2 text-blue-400"></i>Status
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                <i class="fa-regular fa-chart-line mr-2 text-blue-400"></i>Progress
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                <i class="fa-regular fa-gear mr-2 text-blue-400"></i>Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($reports as $key => $task)
                            <tr class="hover:bg-blue-50/40 transition-all duration-150 group">

                                <td data-label="#" class="px-6 py-5 whitespace-nowrap align-top">
                                    <div
                                        class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 text-cyan-600 flex items-center justify-center text-xs font-bold shadow-sm group-hover:scale-105 transition">
                                        {{ $key + 1 }}
                                    </div>
                                </td>
                                <td data-label="Project Details" class="px-6 py-5 align-top">
                                    <div class="space-y-3">
                                        <h3
                                            class="font-semibold text-gray-800 text-base group-hover:text-cyan-500 transition">
                                            {{ $task->project->name ?? 'N/A' }}
                                        </h3>

                                        <div class="grid grid-cols-1 gap-2">
                                            <div
                                                class="bg-gray-50 rounded-xl p-3 border border-gray-100 shadow-sm hover:shadow-md transition">
                                                <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                                                    <i class="fa-regular fa-calendar-check text-blue-500 text-xs"></i>
                                                    <span>Start Date</span>
                                                </div>
                                                <div class="font-medium text-gray-700 text-sm">
                                                    {{ isset($task->project->start_date) ? \Carbon\Carbon::parse($task->project->start_date)->format('d M Y') : 'N/A' }}
                                                </div>
                                            </div>

                                            <div
                                                class="bg-gray-50 rounded-xl p-3 border border-gray-100 shadow-sm hover:shadow-md transition">
                                                <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                                                    <i class="fa-regular fa-calendar-xmark text-red-400 text-xs"></i>
                                                    <span>End Date</span>
                                                </div>
                                                <div class="font-medium text-gray-700 text-sm">
                                                    {{ isset($task->project->end_date) ? \Carbon\Carbon::parse($task->project->end_date)->format('d M Y') : 'N/A' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="Employee Details" class="px-6 py-5 align-top">
                                    <div class="flex items-start gap-4">
                                        <div class="relative">
                                            <div
                                                class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-cyan-500 flex items-center justify-center text-white font-bold text-lg shadow-md">
                                                {{ strtoupper(substr($task->user->name ?? 'E', 0, 1)) }}
                                            </div>
                                            <div
                                                class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white">
                                            </div>
                                        </div>

                                        <div class="flex-1">
                                            <h3 class="font-semibold text-gray-800 group-hover:text-cyan-500 transition">
                                                {{ $task->user->name ?? 'N/A' }}
                                            </h3>
                                            <p class="text-xs text-gray-500 mt-0.5 flex items-center gap-1">
                                                <i class="fa-regular fa-envelope text-gray-400 text-xs"></i>
                                                {{ $task->user->email ?? 'No Email' }}
                                            </p>
                                            <div class="mt-2 space-y-1.5">
                                                <div class="flex items-center gap-2 text-xs text-gray-600">
                                                    <i class="fa-solid fa-briefcase w-3 text-blue-500"></i>
                                                    <span>{{ $task->user->designation ?? 'Employee' }}</span>
                                                </div>
                                                <div class="flex items-center gap-2 text-xs text-gray-600">
                                                    <i class="fa-solid fa-phone w-3 text-green-500"></i>
                                                    <span>{{ $task->user->phone ?? 'N/A' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="Status" class="px-6 py-5 align-top whitespace-nowrap">
                                    @php
                                        $status = strtolower($task->project->status ?? 'pending');
                                    @endphp

                                    @if ($status == 'completed')
                                        <span
                                            class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 px-3 py-1.5 rounded-full text-xs font-semibold shadow-sm">
                                            <i class="fa-solid fa-circle-check text-emerald-500 text-xs"></i>
                                            Completed
                                        </span>
                                    @elseif($status == 'progress')
                                        <span
                                            class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-700 px-3 py-1.5 rounded-full text-xs font-semibold shadow-sm">
                                            <i class="fa-solid fa-spinner fa-pulse text-blue-500 text-xs"></i>
                                            In Progress
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 bg-cyan-50 text-cyan-700 px-3 py-1.5 rounded-full text-xs font-semibold shadow-sm">
                                            <i class="fa-solid fa-clock text-cyan-500 text-xs"></i>
                                            Pending
                                        </span>
                                    @endif
                                </td>
                                <td data-label="Progress" class="px-6 py-5 align-top min-w-[200px]">
                                    @php
                                        $progress = $task->progress ?? 0;
                                        $progressColor =
                                            $progress >= 75
                                                ? 'from-emerald-500 to-emerald-600'
                                                : ($progress >= 40
                                                    ? 'from-blue-400 to-blue-500'
                                                    : 'from-rose-400 to-rose-500');
                                    @endphp

                                    <div class="space-y-2">
                                        <div class="flex justify-between text-xs">
                                            <span class="text-gray-500 font-medium">Completion</span>
                                            <span
                                                class="font-bold {{ $progress >= 75 ? 'text-emerald-600' : ($progress >= 40 ? 'text-cyan-500' : 'text-rose-600') }}">
                                                {{ $progress }}%
                                            </span>
                                        </div>

                                        <div
                                            class="relative w-full bg-gray-100 rounded-full h-2.5 overflow-hidden shadow-inner">
                                            <div class="absolute inset-y-0 left-0 bg-gradient-to-r {{ $progressColor }} rounded-full transition-all duration-700 ease-out"
                                                style="width: {{ $progress }}%">
                                            </div>
                                        </div>

                                        @if ($progress == 100)
                                            <div
                                                class="text-[10px] text-emerald-600 font-medium mt-1 flex items-center gap-1">
                                                <i class="fa-regular fa-trophy"></i> Milestone Achieved
                                            </div>
                                        @elseif($progress > 0)
                                            <div class="text-[10px] text-gray-400 mt-1">
                                                {{ $progress < 100 ? $progress : 'Complete' }}% done</div>
                                        @endif
                                    </div>
                                </td>
                                <td data-label="Actions" class="px-6 py-5 align-top whitespace-nowrap">
                                    <div class="report-actions flex items-center justify-center gap-2">
                                        <button type="button"
                                            onclick="openChat({{ $task->project->id ?? 0 }}, {{ $task->user->id ?? 0 }})"
                                            id="chatToggle" data-empID="{{ $task->user->id ?? 0 }}"
                                            data-project_id="{{ $task->project->id }}"
                                            class="relative group/btn w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-all duration-200 shadow-sm">
                                            <i class="fa-solid fa-bell text-sm"></i>
                                            <span
                                                class="absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover/btn:opacity-100 transition pointer-events-none whitespace-nowrap">
                                                Send Alert Message
                                            </span>
                                        </button>

                                        <a href="#"
                                            onclick="return confirm('⚠️ Are you absolutely sure? This action cannot be undone.')"
                                            class="relative group/btn w-9 h-9 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center hover:bg-rose-600 hover:text-white transition-all duration-200 shadow-sm">
                                            <i class="fa-solid fa-trash text-sm"></i>
                                            <span
                                                class="absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover/btn:opacity-100 transition pointer-events-none whitespace-nowrap">Delete</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center mb-5 shadow-inner">
                                            <i class="fa-regular fa-folder-open text-4xl text-blue-500"></i>
                                        </div>
                                        <h3 class="text-xl font-semibold text-gray-800 mb-1">No Tasks Found</h3>
                                        <p class="text-sm text-gray-500 max-w-sm">It appears there are no tasks available.
                                            Start by creating a new task or project.</p>
                                        <button
                                            class="mt-6 inline-flex items-center gap-2 px-5 py-2 bg-blue-500 text-white rounded-xl hover:bg-cyan-500 transition shadow-md shadow-blue-200">
                                            <i class="fa-solid fa-plus"></i> Create New Task
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($reports->count() > 0)
                <div
                    class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-t border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="text-sm text-gray-600">
                        Showing
                        <span class="font-semibold text-gray-800">{{ $reports->firstItem() ?? 0 }}</span>
                        to
                        <span class="font-semibold text-gray-800">{{ $reports->lastItem() ?? 0 }}</span>
                        of
                        <span class="font-semibold text-gray-800">{{ $reports->total() ?? 0 }}</span>
                        tasks
                    </div>
                    <div class="flex justify-center">
                        @if (method_exists($reports, 'links'))
                            {{ $reports->links() }}
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div id="chatBox"
        class="fixed bottom-24 right-5 w-80 bg-white rounded-2xl shadow-2xl border border-gray-200 hidden flex-col overflow-hidden z-50">

        <!-- Header -->
        <div class="bg-blue-600 text-white px-4 py-3 flex items-center justify-between">
            <h2 class="font-semibold text-lg">Live Chat</h2>

            <button id="closeChat" class="text-white hover:text-gray-200 text-xl">
                ×
            </button>
        </div>


        <div id="chatBody" class="h-80 overflow-y-auto p-4 space-y-3 bg-gray-50"></div>

        <input type="hidden" id="employee_id">
        <input type="hidden" id="project_id">

        <!-- INPUT -->
        <div class="p-3 border-t bg-white flex items-center gap-2">
            <input type="text" id="text_filed" placeholder="Type message..."
                class="flex-1 border rounded-full px-4 py-2 outline-none focus:ring-2 focus:ring-blue-400">

            <button id="sent_message" type="button"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-full transition">
                Send
            </button>
        </div>
    </div>
    <style>
        .scrollbar-thin::-webkit-scrollbar {
            height: 6px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #93c5fd;
            border-radius: 10px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: #06b6d4;
        }
    </style>

    <script>
        const chatToggle = document.getElementById('chatToggle');
        const chatBox = document.getElementById('chatBox');
        const closeChat = document.getElementById('closeChat');


        chatToggle.addEventListener('click', () => {
            chatBox.classList.toggle('hidden');
        });


        closeChat.addEventListener('click', () => {
            chatBox.classList.add('hidden');
        });

        document.addEventListener("DOMContentLoaded", function() {

            document.querySelectorAll("#chatToggle").forEach(btn => {
                btn.addEventListener("click", function() {

                    let empID = this.getAttribute("data-empID");
                    let projectID = this.getAttribute("data-project_id");

                    document.getElementById("employee_id").value = empID;
                    document.getElementById("project_id").value = projectID;

                    document.getElementById("chatBox").classList.remove("hidden");
                });
            });
            document.getElementById("closeChat").addEventListener("click", function() {
                document.getElementById("chatBox").classList.add("hidden");
            });

        });
    </script>

    <script>
        let currentProjectId = null;
        let currentEmployeeId = null;

        function openChat(project_id, employee_id) {

            currentProjectId = project_id;
            currentEmployeeId = employee_id;

            $("#chatBox").removeClass("hidden");
            $("#project_id").val(project_id);
            $("#employee_id").val(employee_id);
            getSms(project_id, employee_id);
        }

        function getSms(project_id, employee_id) {

            $.ajax({
                type: "GET",
                url: "{{ route('get.admin.chat') }}",
                data: {
                    project_id: project_id
                },
                success: function(response) {
                    let html = "";
                    if (!response.data.length) {
                        html = `<div class="text-center text-gray-400">No messages yet</div>`;
                    } else {

                        response.data.forEach(chat => {

                            let isMine = chat.chatCount == 1;

                            if (isMine) {
                                html += `
                            <div class="flex justify-end mb-2">
                                <div class="bg-blue-600 text-white px-4 py-2 rounded-2xl max-w-[75%]">
                                    ${chat.textSMS}
                                </div>
                            </div>
                        `;
                            } else {
                                html += `
                            <div class="flex mb-2">
                                <div class="bg-gray-200 text-gray-800 px-4 py-2 rounded-2xl max-w-[75%]">
                                    ${chat.textSMS}
                                </div>
                            </div>
                        `;
                            }
                        });
                    }

                    $("#chatBody").html(html);
                    $("#chatBody").scrollTop($("#chatBody")[0].scrollHeight);
                }
            });
        }

        $(document).ready(function() {

            $("#sent_message").on('click', function(e) {
                e.preventDefault();

                var empID = $("#employee_id").val();
                var projectID = $("#project_id").val();
                var sms = $("#text_filed").val();

                if (!sms || !sms.trim()) return;

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.chat.sms') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        project_id: projectID,
                        textsms: sms,
                        employee_id: empID,
                    },

                    success: function(response) {
                        $("#text_filed").val("");
                        getSms(projectID, empID);
                    },

                    error: function(error) {
                        console.log(error);
                    }
                });
            });

            $("#closeChat").on("click", function() {
                $("#chatBox").addClass("hidden");
            });

            setInterval(() => {
                if (currentProjectId && currentEmployeeId) {

                    getSms(currentProjectId, currentEmployeeId);
                }

            }, 2000);

        });
    </script>
@endsection
