@extends('admin.include.layout')

@section('content')
    <div class="p-6">

        <!-- Page Title -->
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Add Project</h2>

        <!-- Card -->
        <div class="bg-white rounded-xl shadow-lg p-6">

            <h3 class="text-lg font-semibold text-orange-500 mb-4">
                Project Details
            </h3>

            <form action="{{ route('project.store') }}" method="POST">
                @csrf

                <!-- Title + Status -->
                <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="block mb-1 font-medium">Title *</label>
                        <input type="text" name="name" placeholder="Enter project title"
                            class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-orange-400">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>




                    <div>
                        <label class="block mb-1 font-medium">Status *</label>
                        <select name="status"
                            class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-orange-400">
                            <option value="pending">Pending</option>
                            <option value="ongoing">Ongoing</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    @error('status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                </div>



                <!-- Description -->
                <div class="mb-4">
                    <label class="block mb-1 font-medium">Description *</label>
                    <textarea name="description" rows="4" placeholder="Enter project description"
                        class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-orange-400"></textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                </div>
                <!-- Modules Section -->
                <div class="mb-4">
                    <label class="block mb-2 font-medium">Modules *</label>

                    <div id="module-wrapper">
                        <div class="flex gap-2 mb-2 module-item">
                            <input type="text" name="modules[]" placeholder="Enter module name"
                                class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-orange-400">

                            <button type="button" class="remove-module bg-red-500 text-white px-3 rounded-lg">
                                ✕
                            </button>
                        </div>
                    </div>

                    <button type="button" id="add-module" class="mt-2 bg-green-500 text-white px-4 py-1 rounded-lg">
                        + Add Module
                    </button>

                    @error('modules')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dates -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Start Date *</label>
                        <input type="date" name="start_date"
                            class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-orange-400">
                        @error('start_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                    </div>

                    <div>
                        <label class="block mb-1 font-medium">End Date</label>
                        <input type="date" name="end_date"
                            class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-orange-400">
                        @error('end_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                </div>

                <!-- Buttons -->
                <div class="flex justify-between items-center">

                    <a href="{{ route('project.list') }}" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">
                        ← Back
                    </a>

                    <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600">
                        Save Project
                    </button>

                </div>

            </form>
        </div>

    </div>
    <script>
    document.getElementById('add-module').addEventListener('click', function () {
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
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-module')) {
            e.target.closest('.module-item').remove();
        }
    });
</script>
@endsection
