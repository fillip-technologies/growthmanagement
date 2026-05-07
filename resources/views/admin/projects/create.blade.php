@extends('admin.include.layout')

@section('content')
    <div class="p-6">

        <!-- Page Title -->
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Add Project</h2>

        <!-- Card -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="border-b pb-4">
                <h2 class="text-2xl font-bold text-gray-800">Create Project</h2>
                <p class="text-sm text-gray-500">Fill all required project details</p>
            </div>

            <form action="{{ route('project.store') }}" method="POST" class="bg-white shadow-xl rounded-2xl p-6 space-y-6">
                @csrf

                <!-- Heading -->


                <!-- Title + Status -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <!-- Title -->
                    <div>
                        <label class="block mb-2 font-semibold text-gray-700">
                            Project Title <span class="text-red-500">*</span>
                        </label>

                        <input type="text" name="name" placeholder="Enter project title" value="{{ old('name') }}"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400">

                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block mb-2 font-semibold text-gray-700">
                            Status <span class="text-red-500">*</span>
                        </label>

                        <select name="status"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400">

                            <option value="pending">Pending</option>
                            <option value="ongoing">Ongoing</option>
                            <option value="completed">Completed</option>

                        </select>

                        @error('status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <!-- Description -->
                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Description <span class="text-red-500">*</span>
                    </label>

                    <textarea name="description" rows="5" placeholder="Enter project description"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400">{{ old('description') }}</textarea>

                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Modules -->
                <div>


                    <div id="module-wrapper" class="space-y-3">
                        <label class="font-semibold text-gray-700">
                            Modules <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-3 module-item">

                            <input type="text" name="modules[]" placeholder="Enter module name"
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-400">

                            <button type="button"
                                class="remove-module bg-red-500 hover:bg-red-600 text-white px-4 rounded-xl transition">
                                ✕
                            </button>

                        </div>

                    </div>
                    <div class="flex justify-between items-center mb-3 mt-3">


                        <button type="button" id="add-module"
                            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                            + Add Module
                        </button>
                    </div>

                    @error('modules')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Priority -->
                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Priority
                    </label>

                    <select name="priority"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400">
                        <option value="">--Select Priority--</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>

                    </select>
                </div>

                <!-- Dates -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <!-- Start Date -->
                    <div>
                        <label class="block mb-2 font-semibold text-gray-700">
                            Start Date <span class="text-red-500">*</span>
                        </label>

                        <input type="date" name="start_date"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400">

                        @error('start_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- End Date -->
                    <div>
                        <label class="block mb-2 font-semibold text-gray-700">
                            End Date
                        </label>

                        <input type="date" name="end_date"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400">

                        @error('end_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <!-- Buttons -->
                <div class="flex justify-between items-center pt-4 border-t">

                    <a href="{{ route('project.list') }}"
                        class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 rounded-xl font-medium transition">
                        ← Back
                    </a>

                    <button type="submit"
                        class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-xl font-semibold shadow-md transition">
                        Save Project
                    </button>

                </div>

            </form>
        </div>

    </div>
    <script>
        document.getElementById('add-module').addEventListener('click', function() {
            let wrapper = document.getElementById('module-wrapper');

            let html = `
            <div class="flex gap-2 mb-2 module-item">
                <input type="text" name="modules[]"
                       placeholder="Enter module name"
                       class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-orange-400">

                <button type="button"
                        class="remove-module bg-red-500 text-white px-3 rounded-lg">
                    ✕
                </button>
            </div>
        `;

            wrapper.insertAdjacentHTML('beforeend', html);
        });

        // Remove module
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-module')) {
                e.target.closest('.module-item').remove();
            }
        });
    </script>
@endsection
