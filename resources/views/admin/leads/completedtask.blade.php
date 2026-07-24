@extends('admin.include.layout')
@section('heading', 'Task Assignment')
@section('title', 'Task Assign for Sales Department')

@section('content')
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Task Assigned!',
                text: "{{ session('success') }}",
                timer: 2500,
                showConfirmButton: false,
                background: '#fff',
                customClass: {
                    popup: 'rounded-2xl'
                }
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}",
                timer: 2500,
                showConfirmButton: false,
                background: '#fff',
                customClass: {
                    popup: 'rounded-2xl'
                }
            });
        </script>
    @endif

    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50/30 to-indigo-50/30 py-8 px-4">
        <div class="max-w-7xl mx-auto">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
                <span class="flex items-center gap-2">
                    <i class="fas fa-home text-blue-600"></i>
                    <a href="" class="hover:text-blue-600 transition-colors">Dashboard</a>
                </span>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <span class="text-gray-700 font-medium">Task Assignment</span>
            </nav>

            {{-- Page Header --}}
            <div class="mb-8">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                            <span class="bg-blue-600 text-white p-2.5 rounded-xl shadow-md shadow-blue-200">
                                <i class="fas fa-tasks text-xl"></i>
                            </span>
                            Task Assignment
                        </h1>
                        <p class="text-gray-500 mt-2 ml-1">Assign tasks to your sales team members</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-medium">
                            <i class="fas fa-user-check mr-2"></i>
                            {{ $leads->where('lead_status', 'converted')->count() }} Converted
                        </span>
                        <span class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                            <i class="fas fa-users mr-2"></i>
                            {{ $leads->count() }} Total Leads
                        </span>
                    </div>
                </div>
            </div>

            {{-- Main Card --}}
            <div class="bg-white rounded-2xl shadow-xl shadow-blue-100/50 overflow-hidden border border-blue-50">
                {{-- Card Header --}}
                <div class="relative px-8 py-5 bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700">
                    <div class="absolute inset-0 opacity-10 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmZmZmYiIGZpbGwtb3BhY2l0eT0iMC40Ij48cGF0aCBkPSJNMzYgMzR2LTRoNHY0aC00em0wIDB2LTRoLTR2NGg0eiIvPjwvZz48L2c+PC9zdmc+')]"></div>
                    <div class="relative flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-white flex items-center gap-3">
                                <i class="fas fa-user-plus text-blue-200"></i>
                                Assign Tasks to Sales Team
                            </h3>
                            <p class="text-blue-100 text-sm mt-1">Select projects and assign them to your sales representatives</p>
                        </div>
                        <span class="px-4 py-1.5 bg-white/20 backdrop-blur-sm text-white text-sm rounded-full border border-white/30">
                            <i class="fas fa-clock mr-1.5"></i> {{ now()->format('d M, Y') }}
                        </span>
                    </div>
                </div>

                {{-- Form Body --}}
                <div class="p-8">
                    <form action="{{ route('assingtaskforsales') }}" method="POST" id="taskForm">
                        @csrf
<input type="hidden" name="created_by" value="{{ Auth::guard('account_manager')->check() ? Auth::guard('account_manager')->id() : ""  }}">
                        {{-- Select Projects Section --}}
                        <div class="mb-8">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-1 h-8 bg-blue-600 rounded-full"></div>
                                <label class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-project-diagram text-blue-600"></i>
                                    Select Projects
                                </label>
                                <span class="text-sm text-gray-400 font-normal ml-2">— Choose leads to assign</span>
                            </div>

                            <div class="bg-gradient-to-br from-gray-50 to-gray-100/70 rounded-2xl border border-gray-200 p-6">
                                {{-- Toolbar --}}
                                <div class="flex flex-wrap items-center justify-between gap-3 mb-5 pb-4 border-b border-gray-200">
                                    <div class="flex items-center gap-4">
                                        <label class="inline-flex items-center cursor-pointer group">
                                            <input type="checkbox"
                                                   checked
                                                   disabled
                                                   id="selectAllProjects"
                                                   class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition-all">
                                            <span class="ml-2.5 font-semibold text-gray-700 group-hover:text-blue-600 transition-colors">
                                                <i class="fas fa-check-double mr-1.5 text-blue-600"></i>Select All
                                            </span>
                                        </label>
                                        <span id="selectedCount"
                                              class="text-sm text-gray-600 bg-white px-4 py-1.5 rounded-full border border-gray-200 shadow-sm">
                                            <span id="selectedNumber">0</span> projects selected
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-2 text-sm text-gray-500">
                                        <i class="fas fa-info-circle text-blue-500"></i>
                                        <span>Converted leads are pre-selected</span>
                                    </div>
                                </div>

                                {{-- Project Cards Grid --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5" id="projectGrid">
                                    @foreach ($leads as $item)
                                        <label
                                            class="project-card relative block cursor-pointer rounded-xl border-2 border-gray-200 bg-white p-5 shadow-sm transition-all duration-300 hover:border-blue-400 hover:shadow-lg hover:-translate-y-0.5
                                                @if($item->lead_status == 'converted') bg-blue-50/50 border-blue-300 ring-2 ring-blue-200/50 @endif
                                                @error('leaddata_id') border-red-400 ring-2 ring-red-200 @enderror">

                                            <input type="checkbox"
                                                   name="leaddata_id[]"
                                                   value="{{ $item->id }}"
                                                   class="project-checkbox absolute top-4 right-4 w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition-all">

                                            {{-- Status Badge (Converted) --}}
                                            @if($item->lead_status == 'converted')
                                                <span class="absolute top-4 left-4 px-2.5 py-0.5 bg-green-500 text-white text-[10px] font-semibold rounded-full shadow-sm shadow-green-200">
                                                    <i class="fas fa-check-circle mr-1"></i> Converted
                                                </span>
                                            @endif

                                            {{-- Avatar & Name --}}
                                            <div class="flex items-center gap-4 mb-4 {{ $item->lead_status == 'converted' ? 'mt-4' : '' }}">
                                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center text-blue-700 font-bold text-xl shadow-inner">
                                                    {{ strtoupper(substr($item->name, 0, 1)) }}
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <h3 class="font-semibold text-gray-800 truncate">{{ $item->name }}</h3>
                                                    <p class="text-sm text-gray-500 truncate flex items-center gap-1.5">
                                                        <i class="fas fa-building text-gray-400 text-xs"></i>
                                                        {{ $item->company_name ?? 'N/A' }}
                                                    </p>
                                                </div>
                                            </div>

                                            {{-- Details Grid --}}
                                            <div class="grid grid-cols-2 gap-1.5 text-sm text-gray-600">
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-phone w-4 text-blue-500 text-xs"></i>
                                                    <span class="truncate">{{ $item->phone }}</span>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-envelope w-4 text-red-400 text-xs"></i>
                                                    <span class="truncate">{{ $item->email }}</span>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-industry w-4 text-green-500 text-xs"></i>
                                                    <span class="truncate">{{ $item->industry ?? 'N/A' }}</span>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-location-dot w-4 text-orange-400 text-xs"></i>
                                                    <span class="truncate">{{ $item->city }}, {{ $item->state }}</span>
                                                </div>
                                            </div>

                                            {{-- Footer Tags --}}
                                            <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between">
                                                <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-50 text-blue-700 border border-blue-100">
                                                    <i class="fas fa-tag mr-1 text-blue-400"></i>
                                                    {{ ucfirst($item->lead_source) }}
                                                </span>
                                                <span class="px-3 py-1 text-xs font-medium rounded-full
                                                    {{ $item->lead_status == 'new' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-gray-50 text-gray-600 border border-gray-200' }}">
                                                    <i class="fas fa-circle {{ $item->lead_status == 'new' ? 'text-emerald-400' : 'text-gray-400' }} text-[8px] mr-1.5"></i>
                                                    {{ ucfirst($item->lead_status ?? 'Pending') }}
                                                </span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            @error('leaddata_id')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1.5">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Assign To --}}
                        <div class="mb-6">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-1 h-8 bg-blue-600 rounded-full"></div>
                                <label class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-user-check text-blue-600"></i>
                                    Assign To
                                </label>
                                <span class="text-sm text-gray-400 font-normal ml-2">— Select team member</span>
                            </div>
                            <div class="relative">
                                <select name="user_id"
                                    class="w-full px-5 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all text-gray-700 appearance-none cursor-pointer">
                                    <option value="">👤 Select Sales Person</option>
                                    @foreach ($employees as $items)
                                         <option value="{{ $items->id }}">👨‍💼 {{ $items->name }} — {{ $items->email }} - {{ $items->role }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-400">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                            @error('user_id')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1.5">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>


                        <div class="mb-6">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-1 h-8 bg-blue-600 rounded-full"></div>
                                <label class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                    <i class="fas fa-tasks text-blue-600"></i>
                                    Task Description
                                </label>
                                <span class="text-sm text-gray-400 font-normal ml-2">— What needs to be done?</span>
                            </div>
                            <textarea name="description"
                                class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all text-gray-700 resize-none"
                                rows="4" placeholder="Enter detailed task description..."></textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1.5">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Due Date & Priority --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                    <i class="fas fa-calendar-alt text-blue-600"></i>
                                    Due Date
                                </label>
                                <input type="date" name="due_date"
                                    class="w-full px-5 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all text-gray-700">
                                @error('due_date')
                                    <p class="mt-2 text-sm text-red-600 flex items-center gap-1.5">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                    <i class="fas fa-flag text-blue-600"></i>
                                    Priority
                                </label>
                                <select name="priority"
                                    class="w-full px-5 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all text-gray-700 appearance-none cursor-pointer">
                                    <option value="low">🟢 Low</option>
                                    <option value="medium" selected>🟡 Medium</option>
                                    <option value="high">🟠 High</option>
                                    <option value="urgent">🔴 Urgent</option>
                                </select>
                                @error('priority')
                                    <p class="mt-2 text-sm text-red-600 flex items-center gap-1.5">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex flex-wrap items-center gap-4 pt-6 border-t-2 border-gray-100">
                            <button type="submit"
                                class="group px-8 py-3.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl shadow-lg shadow-blue-200 hover:shadow-xl transition-all duration-300 transform hover:scale-105 flex items-center gap-3">
                                <i class="fas fa-paper-plane group-hover:translate-x-1 transition-transform"></i>
                                Assign Tasks
                            </button>
                            <button type="reset"
                                class="px-8 py-3.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl shadow-sm hover:shadow transition-all duration-300 flex items-center gap-3">
                                <i class="fas fa-undo"></i>
                                Reset
                            </button>
                            <span class="ml-auto text-sm text-gray-400 flex items-center gap-2">
                                <i class="fas fa-shield-alt text-blue-400"></i>
                                All fields are required
                            </span>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Footer Info --}}
            <div class="mt-6 text-center text-sm text-gray-400 flex items-center justify-center gap-6">
                <span><i class="fas fa-check-circle text-green-400 mr-1.5"></i> Converted leads are auto-assigned</span>
                <span><i class="fas fa-info-circle text-blue-400 mr-1.5"></i> Select multiple projects</span>
                <span><i class="fas fa-clock text-gray-400 mr-1.5"></i> Tasks will be tracked in dashboard</span>
            </div>
        </div>
    </div>

    {{-- JavaScript for Selection Count --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.project-checkbox');
            const selectedCount = document.getElementById('selectedNumber');

            function updateCount() {
                const checked = document.querySelectorAll('.project-checkbox:checked');
                selectedCount.textContent = checked.length;
            }

            checkboxes.forEach(cb => {
                cb.addEventListener('change', updateCount);
            });

            updateCount();
        });
    </script>
@endsection
