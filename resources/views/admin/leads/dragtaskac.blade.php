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
    <div class="container mx-auto px-4 py-6">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700 border-b">
                    <h3 class="text-xl font-bold text-white">Assign Tasks to Sales Team</h3>
                </div>

                <div class="p-6">
                    <form action="{{ route('assingtaskforsales') }}" method="POST">
                        @csrf

                        <!-- Select Projects Section -->
                        <div class="mb-8">
                            <label class="block text-lg font-semibold text-gray-700 mb-4">
                                <i class="fas fa-project-diagram mr-2"></i> Select Projects
                            </label>
                            <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
                                <div class="mb-4 pb-3 border-b border-gray-200">
                                    <label
                                        class="inline-flex items-center cursor-pointer hover:text-blue-600 transition-colors">
                                        <input type="checkbox" checked disabled id="selectAllProjects" NAME
                                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        <span class="ml-2 font-semibold text-gray-700">Select All Projects</span>
                                    </label>
                                    <span id="selectedCount"
                                        class="ml-4 text-sm text-gray-500 bg-gray-200 px-3 py-1 rounded-full">No projects
                                        selected</span>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach ($leads as $item)
                                        <label
                                            class="relative block cursor-pointer @error('leaddata_id')
border-red-600
                                            @enderror rounded-xl border border-gray-200 bg-white p-5 shadow-sm transition-all hover:border-blue-500 hover:shadow-lg">

                                            <!-- Checkbox -->
                                            <input type="checkbox"
                                                name="{{ $item->lead_status == 'converted' ? '' : 'leaddata_id[]' }}"
                                                value="{{ $item->id }}"
                                                {{ $item->lead_status == 'converted' ? 'checked disabled' : '' }}
                                                class="absolute top-4 right-4 w-5 h-5 text-blue-600 rounded project-checkbox">


                                            <!-- Avatar -->
                                            <div class="flex items-center gap-3 mb-4">
                                                <div
                                                    class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-lg">
                                                    {{ strtoupper(substr($item->name, 0, 1)) }}
                                                </div>

                                                <div>
                                                    <h3 class="font-semibold text-gray-800">
                                                        {{ $item->name }}
                                                    </h3>
                                                    <p class="text-sm text-gray-500">
                                                        {{ $item->company_name }}
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Details -->
                                            <div class="space-y-2 text-sm text-gray-600">
                                                <div class="flex items-center">
                                                    <i class="fa-solid fa-phone w-5 text-blue-500"></i>
                                                    <span>{{ $item->phone }}</span>
                                                </div>

                                                <div class="flex items-center">
                                                    <i class="fa-solid fa-envelope w-5 text-red-500"></i>
                                                    <span>{{ $item->email }}</span>
                                                </div>

                                                <div class="flex items-center">
                                                    <i class="fa-solid fa-building w-5 text-green-500"></i>
                                                    <span>{{ $item->industry }}</span>
                                                </div>

                                                <div class="flex items-center">
                                                    <i class="fa-solid fa-location-dot w-5 text-orange-500"></i>
                                                    <span>{{ $item->city }}, {{ $item->state }}</span>
                                                </div>
                                            </div>

                                            <!-- Footer -->
                                            <div class="mt-4 flex items-center justify-between">
                                                <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700">
                                                    {{ ucfirst($item->lead_source) }}
                                                </span>

                                                <span
                                                    class="px-3 py-1 text-xs rounded-full
                                                 {{ $item->lead_status == 'new' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                                    {{ ucfirst($item->lead_status ?? 'Pending') }}
                                                </span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="mb-6">
                            <label class="block text-lg font-semibold text-gray-700 mb-2">
                                <i class="fas fa-user-check mr-2"></i> Assign To
                            </label>
                            <select name="assing_by"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-gray-700">

                                @foreach ($employees as $items)
                                    <option value="">Select Person</option>
                                    <option value="{{ $items->id }}">👨‍💼 {{ $items->name }} - {{ $items->email }}
                                    </option>
                                @endforeach
                            </select>
                            @error('assing_by')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Task Details -->
                        <div class="mb-6">
                            <label class="block text-lg font-semibold text-gray-700 mb-2">
                                <i class="fas fa-tasks mr-2"></i> Task Description
                            </label>
                            <textarea name="task_des"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-gray-700 resize-none"
                                rows="4" placeholder="Enter task details..."></textarea>
                            @error('task_des')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <label class="block text-lg font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-calendar-alt mr-2"></i> Due Date
                                </label>
                                <input type="date" name="due_date"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-gray-700">
                                @error('due_date')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-lg font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-flag mr-2"></i> Priority
                                </label>
                                <select name="priority"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-gray-700">
                                    <option value="low">🟢 Low</option>
                                    <option value="medium" selected>🟡 Medium</option>
                                    <option value="high">🟠 High</option>
                                    <option value="urgent">🔴 Urgent</option>
                                </select>
                                @error('priority')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-wrap gap-4 pt-4 border-t border-gray-200">
                            <button type="submit"
                                class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all transform hover:scale-105 flex items-center">
                                <i class="fas fa-tasks mr-2"></i> Assign Tasks
                            </button>
                            <button type="reset"
                                class="px-8 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all transform hover:scale-105 flex items-center">
                                <i class="fas fa-undo mr-2"></i> Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


  
