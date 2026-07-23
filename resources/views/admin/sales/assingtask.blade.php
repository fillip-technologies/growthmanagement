@extends('admin.include.layout')
@section('heading', 'My Tasks')
@section('title', 'My Works')
@section('content')

<div class="max-w-6xl mx-auto">
    <div class="mb-8">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight flex items-center gap-3">
                    <span class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-2 rounded-xl">
                        <i class="fas fa-plus-circle"></i>
                    </span>
                    Create New Task
                </h2>
                <p class="mt-2 text-sm text-gray-500 ml-14">Fill in the details below to create a new task for your team</p>
            </div>
            <div class="flex items-center gap-2 bg-blue-50 px-4 py-2 rounded-xl border border-blue-100">
                <span class="inline-flex items-center gap-2 text-sm font-medium text-blue-700">
                    <i class="fas fa-clock"></i>
                    <span id="currentDate"></span>
                </span>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 flex items-center gap-3">
            <i class="fas fa-check-circle text-green-500 text-xl"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 flex items-center gap-3">
            <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
            <div class="flex items-start gap-3">
                <i class="fas fa-exclamation-triangle text-red-500 text-xl mt-0.5"></i>
                <div>
                    <h4 class="text-sm font-semibold text-red-800 mb-2">Please fix the following errors:</h4>
                    <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <form class="p-8" action="{{ route('sales.assingtaskforsales') }}" method="POST" id="taskForm">
            @csrf

            <!-- Progress Bar -->
            <div class="mb-8 flex items-center gap-4">
                <div class="flex-1">
                    <div class="flex justify-between text-xs font-medium text-gray-500 mb-1">
                        <span>Task Details</span>
                        <span>Assignment</span>
                        <span>Review</span>
                    </div>
                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full transition-all duration-500"
                             style="width: 40%"></div>
                    </div>
                </div>
                <span class="text-xs font-medium text-gray-500 bg-gray-100 px-3 py-1 rounded-full">Step 1/3</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Project Selection -->
                    <div class="group">
                        <label for="leaddata_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Select Project <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-project-diagram text-gray-400 group-focus-within:text-blue-500 transition-colors"></i>
                            </div>
                            <select id="leaddata_id" name="leaddata_id"
                                class="w-full pl-12 pr-10 py-3.5 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none transition-all duration-300 bg-gray-50 focus:bg-white appearance-none cursor-pointer @error('leaddata_id') border-red-500 @enderror">
                                <option value="">Select Project</option>
                                @foreach(mytasks() as $project)
                                    @if($project->leaddata)
                                        <option value="{{ $project->leaddata->id }}"
                                            {{ old('leaddata_id') == $project->leaddata->id ? 'selected' : '' }}>
                                            {{ $project->leaddata->lead_source ?? 'Project ' . $project->leaddata->id }}
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold
                                                @if($project->leaddata->lead_status == 'new') bg-blue-50 text-blue-700
                                                @elseif($project->leaddata->lead_status == 'contacted') bg-yellow-50 text-yellow-700
                                                @elseif($project->leaddata->lead_status == 'in_progress') bg-purple-50 text-purple-700
                                                @elseif($project->leaddata->lead_status == 'converted') bg-green-50 text-green-700
                                                @elseif($project->leaddata->lead_status == 'lost') bg-red-50 text-red-700
                                                @else bg-gray-50 text-gray-700 @endif">
                                                {{ ucfirst($project->leaddata->lead_status ?? 'Unknown') }}
                                            </span>
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                        <p class="mt-1.5 text-xs text-gray-400 flex items-center gap-1">
                            <i class="fas fa-info-circle"></i> Select the project this task belongs to
                        </p>
                    </div>

                    <!-- Task Description -->
                    <div class="group">
                        <label for="task_des" class="block text-sm font-semibold text-gray-700 mb-2">
                            Description <span class="text-gray-400 font-normal">(optional)</span>
                        </label>
                        <div class="relative">
                            <textarea id="task_des" name="task_des" rows="5"
                                placeholder="Provide detailed information about the task, including objectives, requirements, and expected outcomes"
                                class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl @error('task_des') border-red-500 @enderror focus:ring-4 focus:ring-blue-100 outline-none transition-all duration-300 bg-gray-50 focus:bg-white resize-none"
                                maxlength="500">{{ old('task_des') }}</textarea>
                            <div class="absolute bottom-3 right-3 bg-white px-2 py-0.5 rounded-md text-xs font-medium">
                                <span id="charCount">0</span> <span class="text-gray-400">/ 500</span>
                            </div>
                        </div>
                        <p class="mt-1.5 text-xs text-gray-400 flex items-center gap-1">
                            <i class="fas fa-info-circle"></i> Maximum 500 characters
                        </p>
                    </div>

                    <!-- Tags -->
                    <div class="group">
                        <label for="tags" class="block text-sm font-semibold text-gray-700 mb-2">
                            Tags <span class="text-gray-400 font-normal">(optional)</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-tags text-gray-400 group-focus-within:text-blue-500 transition-colors"></i>
                            </div>
                            <input type="text" id="tags" name="tags"
                                placeholder="e.g., frontend, bug, feature, design"
                                value="{{ old('tags') }}"
                                class="w-full pl-12 pr-4 py-3.5 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none transition-all duration-300 bg-gray-50 focus:bg-white">
                        </div>
                        <p class="mt-1.5 text-xs text-gray-400 flex items-center gap-1">
                            <i class="fas fa-info-circle"></i> Separate tags with commas
                        </p>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Priority -->
                    <div class="group">
                        <label for="priority" class="block text-sm font-semibold text-gray-700 mb-2">
                            Priority <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-flag text-gray-400 group-focus-within:text-blue-500 transition-colors"></i>
                            </div>
                            <select id="priority" name="priority"
                                class="w-full pl-12 pr-10 py-3.5 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none transition-all duration-300 bg-gray-50 focus:bg-white appearance-none cursor-pointer @error('priority') border-red-500 @enderror">
                                <option value="">Select priority</option>
                                <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>🟢 Low</option>
                                <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>🟡 Medium</option>
                                <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>🟠 High</option>
                                <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>🔴 Urgent</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Due Date -->
                    <div class="group">
                        <label for="due_date" class="block text-sm font-semibold text-gray-700 mb-2">
                            Due Date <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-calendar-alt text-gray-400 group-focus-within:text-blue-500 transition-colors"></i>
                            </div>
                            <input type="date" id="due_date" name="due_date"
                                value="{{ old('due_date', date('Y-m-d')) }}"
                                class="w-full pl-12 pr-4 py-3.5 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none transition-all duration-300 bg-gray-50 focus:bg-white @error('due_date') border-red-500 @enderror">
                        </div>
                        <p class="mt-1.5 text-xs text-gray-400 flex items-center gap-1">
                            <i class="fas fa-info-circle"></i> Set the deadline for this task
                        </p>
                    </div>

                    <!-- Lead Status -->
                    <div class="group">
                        <label for="lead_status" class="block text-sm font-semibold text-gray-700 mb-2">
                            Lead Status <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-chart-line text-gray-400 group-focus-within:text-blue-500 transition-colors"></i>
                            </div>
                            <select id="lead_status" name="lead_status"
                                class="w-full pl-12 pr-10 py-3.5 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none transition-all duration-300 bg-gray-50 focus:bg-white appearance-none cursor-pointer @error('lead_status') border-red-500 @enderror">
                                <option value="">Select status</option>
                                <option value="new" {{ old('lead_status') == 'new' ? 'selected' : '' }}>🆕 New</option>
                                <option value="contacted" {{ old('lead_status') == 'contacted' ? 'selected' : '' }}>📞 Contacted</option>
                                <option value="in_progress" {{ old('lead_status') == 'in_progress' ? 'selected' : '' }}>⚡ In Progress</option>
                                <option value="converted" {{ old('lead_status') == 'converted' ? 'selected' : '' }}>✅ Converted</option>
                                <option value="lost" {{ old('lead_status') == 'lost' ? 'selected' : '' }}>❌ Lost</option>
                                <option value="pending" {{ old('lead_status') == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Assignee -->
                    <div class="group">
                        <label for="user_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Assignee <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-user-circle text-gray-400 group-focus-within:text-blue-500 transition-colors"></i>
                            </div>
                            <select id="user_id" name="user_id"
                                class="w-full pl-12 pr-10 py-3.5 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none transition-all duration-300 bg-gray-50 focus:bg-white appearance-none cursor-pointer @error('user_id') border-red-500 @enderror">
                                <option value="">Select team member</option>
                                @foreach(saleEmployee() as $items)
                                    <option value="{{ $items->id }}"
                                        {{ old('user_id') == $items->id ? 'selected' : '' }}>
                                        {{ $items->name }} - {{ $items->email ?? "=" }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                        <p class="mt-1.5 text-xs text-gray-400 flex items-center gap-1">
                            <i class="fas fa-info-circle"></i> Assign the team member responsible for this task
                        </p>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="mt-8 pt-6 border-t-2 border-gray-100 flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <button type="submit"
                        class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-2 transform hover:scale-105">
                        <i class="fas fa-plus-circle"></i> Create Task
                    </button>

                    <button type="reset"
                        class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all duration-200 flex items-center gap-2">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                </div>

                <div class="flex items-center gap-3 text-sm text-gray-500">
                    <span class="flex items-center gap-1">
                        <i class="fas fa-asterisk text-red-500 text-xs"></i>
                        Required fields
                    </span>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set current date
    const dateElement = document.getElementById('currentDate');
    if (dateElement) {
        const now = new Date();
        const options = {
            weekday: 'short',
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        };
        dateElement.textContent = now.toLocaleDateString('en-US', options);
    }

    // Set default due date to tomorrow if not set
    const dateInput = document.getElementById('due_date');
    if (dateInput && !dateInput.value) {
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        dateInput.value = tomorrow.toISOString().split('T')[0];
    }

    // Character counter for description
    const description = document.getElementById('task_des');
    const charCount = document.getElementById('charCount');
    if (description && charCount) {
        // Initial count
        charCount.textContent = description.value.length;

        description.addEventListener('input', function() {
            const count = this.value.length;
            charCount.textContent = count;

            if (count > 500) {
                charCount.style.color = '#ef4444';
                // Truncate if exceeds max
                if (count > 500) {
                    this.value = this.value.substring(0, 500);
                    charCount.textContent = 500;
                }
            } else {
                charCount.style.color = '#6b7280';
            }
        });
    }

    // Form validation before submit
    const form = document.getElementById('taskForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const leadData = document.getElementById('leaddata_id').value;
            const priority = document.getElementById('priority').value;
            const dueDate = document.getElementById('due_date').value;
            const assignee = document.getElementById('user_id').value;
            const status = document.getElementById('lead_status').value;

            let errors = [];

            if (!leadData) errors.push('Please select a project');
            if (!priority) errors.push('Please select a priority');
            if (!dueDate) errors.push('Please select a due date');
            if (!assignee) errors.push('Please select an assignee');
            if (!status) errors.push('Please select a lead status');

            if (errors.length > 0) {
                e.preventDefault();

                // Create error alert
                const alertDiv = document.createElement('div');
                alertDiv.className = 'fixed top-4 right-4 z-50 p-4 bg-red-50 border border-red-200 rounded-xl shadow-lg max-w-md';
                alertDiv.innerHTML = `
                    <div class="flex items-start gap-3">
                        <i class="fas fa-exclamation-circle text-red-500 text-xl mt-0.5"></i>
                        <div>
                            <h4 class="text-sm font-semibold text-red-800">Validation Errors</h4>
                            <ul class="mt-1 text-sm text-red-600 list-disc list-inside">
                                ${errors.map(err => `<li>${err}</li>`).join('')}
                            </ul>
                        </div>
                    </div>
                `;
                document.body.appendChild(alertDiv);

                // Auto remove after 5 seconds
                setTimeout(() => {
                    alertDiv.remove();
                }, 5000);

                return false;
            }

            // Show loading state on submit
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating...';
                submitBtn.disabled = true;
            }
        });
    }

    // Auto-dismiss flash messages
    const flashMessages = document.querySelectorAll('.bg-green-50, .bg-red-50');
    flashMessages.forEach(msg => {
        if (msg.classList.contains('bg-green-50') || msg.classList.contains('bg-red-50')) {
            setTimeout(() => {
                msg.style.transition = 'opacity 0.5s';
                msg.style.opacity = '0';
                setTimeout(() => {
                    msg.style.display = 'none';
                }, 500);
            }, 5000);
        }
    });
});
</script>

<style>
/* Custom styles for better UI */
.group:focus-within .text-gray-400 {
    color: #3b82f6;
}

select option {
    padding: 8px;
}

/* Smooth transitions */
.group {
    transition: all 0.3s ease;
}

/* Responsive adjustments */
@media (max-width: 1024px) {
    .grid {
        gap: 2rem;
    }
}

@media (max-width: 640px) {
    .p-8 {
        padding: 1.5rem;
    }

    .flex-wrap {
        gap: 0.75rem;
    }

    .text-3xl {
        font-size: 1.5rem;
    }
}
</style>

@endsection
