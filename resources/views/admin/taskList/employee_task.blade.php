@extends('admin.include.layout')

@section('content')
    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonColor: '#ef4444'
            });
        </script>
    @endif

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                timer: 2500,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        </script>
    @endif

    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Task Management</h1>
                    <p class="text-gray-600 mt-1">Manage and track employee tasks across projects</p>
                </div>
                <div class="flex gap-3">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-xl shadow-lg">
                        <div class="text-2xl font-bold">{{ $tasks->count() }}</div>
                        <div class="text-xs opacity-90">Total Tasks</div>
                    </div>
                    <div class="bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-3 rounded-xl shadow-lg">
                        <div class="text-2xl font-bold">{{ App\Models\Project::where('status', 'completed')->count() }}
                        </div>
                        <div class="text-xs opacity-90">Completed</div>
                    </div>
                    <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white px-6 py-3 rounded-xl shadow-lg">
                        <div class="text-2xl font-bold">
                            {{ App\Models\Project::where('status', 'ongoing')->count() }}</div>
                        <div class="text-xs opacity-90">In Progress</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filter Bar -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" id="searchInput" placeholder="Search by employee name, project, or module..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div class="flex gap-3">
                    <select id="statusFilter"
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">All Status</option>
                        <option value="ongoing">Ongoing</option>
                        <option value="completed">Completed</option>
                        <option value="pending">Pending</option>
                    </select>
                    <select id="progressFilter"
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">All Progress</option>
                        <option value="0-30">0-30%</option>
                        <option value="31-70">31-70%</option>
                        <option value="71-99">71-99%</option>
                        <option value="100">100%</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Tasks Grid View -->
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6" id="tasksContainer">
            @forelse ($tasks as $key => $task)
                @php
                    $project = $task->addtask->project ?? null;
                    $modules = $project->modules ?? [];
                    $progress = $task->addtask->progress ?? 0;

                    $progressColor = $progress < 30 ? 'red' : ($progress < 70 ? 'yellow' : 'green');
                    $progressText = $progress < 30 ? 'Critical' : ($progress < 70 ? 'In Progress' : 'On Track');
                @endphp

                <div
                    class="task-card bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 group">

                    <!-- Card Header -->
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-5 border-b border-gray-200">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <div
                                        class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                        {{ strtoupper(substr($task->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div
                                        class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full bg-green-500 border-2 border-white">
                                    </div>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 text-lg">{{ $task->user->name ?? 'N/A' }}</h3>
                                    <p class="text-xs text-gray-500">{{ $task->user->email ?? 'No Email' }}</p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <span
                                    class="px-2 py-1 text-xs rounded-full {{ $progressColor === 'green' ? 'bg-green-100 text-green-700' : ($progressColor === 'yellow' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                    {{ $progressText }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-5 space-y-4">
                        <!-- Project Info -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-semibold text-blue-600 text-lg">{{ $project->name ?? 'N/A' }}</h4>
                                <button type="button" onclick="empopenChat({{ $project->id }},{{ $task->user->id }})"
                                    id="chatToggle" data-empID="{{ $task->user->id }}"
                                    data-project_id="{{ $project->id }}"
                                    class="relative group/btn w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-all duration-200 shadow-sm">
                                    <i class="fa-solid fa-bell text-sm"></i>
                                    <span
                                        class="absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover/btn:opacity-100 transition pointer-events-none whitespace-nowrap">
                                        Send Message
                                    </span>
                                </button>
                            </div>

                            <p class="text-sm text-gray-600 line-clamp-2">
                                {{ $project->description ?? 'No description available' }}</p>
                        </div>

                        <!-- Project Details Grid -->
                        <div class="grid grid-cols-2 gap-3">
                            <div class="bg-gray-50 rounded-lg p-2">
                                <div class="text-xs text-gray-500">Start Date</div>

                                <div class="text-sm font-medium text-gray-700">
                                    {{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('d/m/Y') : 'N/A' }}
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-2">
                                <div class="text-xs text-gray-500">End Date</div>

                                <div class="text-sm font-medium text-gray-700">
                                    {{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('d/m/Y') : 'N/A' }}
                                </div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-2">
                                <div class="text-xs text-gray-500">Priority</div>
                                <div class="text-sm font-medium">
                                    <span
                                        class="px-2 py-0.5 rounded-full text-xs {{ ($project->priority ?? '') == 'high' ? 'bg-red-100 text-red-700' : (($project->priority ?? '') == 'medium' ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700') }}">
                                        {{ ucfirst($project->priority ?? 'N/A') }}
                                    </span>
                                </div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-2">
                                <div class="text-xs text-gray-500">Status</div>
                                <div class="text-sm font-medium">
                                    <span
                                        class="px-2 py-0.5 rounded-full text-xs {{ ($project->status ?? '') == 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                        {{ ucfirst($project->status ?? 'N/A') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Modules -->
                        @if (!empty(json_decode($project->modules)) && count(json_decode($project->modules)) > 0)
                            <div>
                                <div class="text-xs text-gray-500 mb-2">Modules</div>
                                <div class="flex flex-wrap gap-2">
                                    @foreach (json_decode($project->modules) ?? [] as $module)
                                        <span class="px-2 py-1 rounded-full bg-blue-50 text-blue-600 text-xs font-medium">
                                            {{ $module }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Progress Bar -->
                        <div>
                            <div class="flex justify-between text-xs font-medium mb-1">
                                <span class="text-gray-600">Working Persentage %</span>
                                <span
                                    class="{{ $progressColor === 'green' ? 'text-green-600' : ($progressColor === 'yellow' ? 'text-yellow-600' : 'text-red-600') }} font-bold">
                                    {{ $progress }}%
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                <div class="h-2 rounded-full transition-all duration-500 {{ $progressColor === 'green' ? 'bg-green-500' : ($progressColor === 'yellow' ? 'bg-yellow-500' : 'bg-red-500') }}"
                                    style="width: {{ $progress }}%">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer -->
                    <div class="p-5 bg-gray-50 border-t border-gray-100">

                        <form action="{{ route('employee.status') }}" method="POST"
                            class="grid grid-cols-1 md:grid-cols-4 gap-3 items-center">

                            @csrf
                            <input type="hidden" name="employee_id" value="{{ EmpLogin()->id ?? '' }}">
                            <input type="hidden" name="project_id" value="{{ $project->id }}">

                            <!-- Progress -->
                            <input type="number" name="progress" min="0" max="100"
                                value="{{ $task->progress ?? '' }}" placeholder="Progress %"
                                class="max-w-full px-3 py-2 border border-gray-300 rounded-lg
                               focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">

                            <!-- Status -->
                            <select name="status"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg
                                    focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">

                                <option value="">Update Status</option>

                                <option value="ongoing" @selected(($project->status ?? '') === 'ongoing')>
                                    🟡 Ongoing
                                </option>

                                <option value="completed" @selected(($project->status ?? '') === 'completed')>
                                    ✅ Completed
                                </option>

                                <option value="pending" @selected(($project->status ?? '') === 'pending')>
                                    ⏰ Pending
                                </option>
                            </select>

                            <!-- Submit Button -->
                            <button type="submit"
                                class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                                Update
                            </button>



                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="text-center py-16 bg-white rounded-2xl shadow-sm">
                        <i class="fas fa-tasks text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">No Tasks Found</h3>
                        <p class="text-gray-500">There are no tasks assigned at the moment.</p>
                    </div>
                </div>
            @endforelse
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
        .task-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .task-card:hover {
            transform: translateY(-4px);
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Filter animation */
        .task-card {
            animation: fadeInUp 0.5s ease-out;
            animation-fill-mode: backwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <script>
        function filterTasks() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value;
            const progressFilter = document.getElementById('progressFilter').value;

            const tasks = document.querySelectorAll('.task-card');

            tasks.forEach(task => {
                let show = true;


                const employeeName = task.querySelector('h3')?.textContent.toLowerCase() || '';
                const projectName = task.querySelector('h4')?.textContent.toLowerCase() || '';
                const modules = task.querySelectorAll('.bg-blue-50');
                let moduleText = '';
                modules.forEach(module => {
                    moduleText += module.textContent.toLowerCase();
                });

                if (searchTerm && !employeeName.includes(searchTerm) && !projectName.includes(searchTerm) && !
                    moduleText.includes(searchTerm)) {
                    show = false;
                }

                if (show && statusFilter) {
                    const statusSpan = task.querySelector('.bg-yellow-100, .bg-green-100');
                    const statusText = statusSpan?.textContent.toLowerCase() || '';
                    if (!statusText.includes(statusFilter)) {
                        show = false;
                    }
                }

                if (show && progressFilter) {
                    const progressText = task.querySelector('.text-green-600, .text-yellow-600, .text-red-600')
                        ?.textContent || '';
                    const progress = parseInt(progressText);

                    if (progressFilter === '0-30' && (progress < 0 || progress > 30)) show = false;
                    else if (progressFilter === '31-70' && (progress < 31 || progress > 70)) show = false;
                    else if (progressFilter === '71-99' && (progress < 71 || progress > 99)) show = false;
                    else if (progressFilter === '100' && progress !== 100) show = false;
                }

                task.style.display = show ? 'block' : 'none';
            });
        }

        function viewTaskDetails(taskId) {
            Swal.fire({
                title: 'Task Details',
                text: 'Viewing task #' + taskId,
                icon: 'info',
                confirmButtonColor: '#3b82f6'
            });
        }

        document.getElementById('searchInput')?.addEventListener('keyup', filterTasks);
        document.getElementById('statusFilter')?.addEventListener('change', filterTasks);
        document.getElementById('progressFilter')?.addEventListener('change', filterTasks);


        setTimeout(() => {
            const alerts = document.querySelectorAll('.swal2-popup');
            if (alerts.length) {
                Swal.close();
            }
        }, 3000);

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

        function empopenChat(project_id, employee_id) {

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
                url: "{{ route('get.employee.chat') }}",
                data: {
                    project_id: project_id
                },

                success: function(response) {

                    let html = "";

                    if (!response.data.length) {

                        html = `
                        <div class="text-center text-gray-400">
                            No messages yet
                        </div>
                    `;

                    } else {

                        response.data.forEach(chat => {

                            let isMine = chat.chatCount == 2;

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
                    url: "{{ route('employee.chat.sms') }}",
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
