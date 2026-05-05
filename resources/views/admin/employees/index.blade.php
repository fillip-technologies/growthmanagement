@extends('admin.include.layout')
@section('heading', 'Employees')
@section('title', 'Employees List')

@section('content')
    <div class="max-w-7xl mx-auto mt-8">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Employees List </h1>
            <a href="{{ route('create') }}"
                class="inline-block bg-orange-600 hover:bg-orange-700
                  text-white px-5 py-2 rounded-lg font-semibold">
                + Add Employee
            </a>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @if ($errors->any())
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: `{!! implode('<br>', $errors->all()) !!}`
                });
            </script>
        @endif

        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    timer: 2500,
                    showConfirmButton: false
                });
            </script>
        @endif
        <!-- Table Card -->
        <div class="bg-white shadow-xl rounded-xl overflow-hidden">

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-orange-600 from-emerald-600 to-teal-600 text-white">
                        <tr>
                            <th class="px-6 py-4 font-semibold">#</th>
                            <th class="px-6 py-4 font-semibold">Name</th>
                            <th class="px-6 py-4 font-semibold">Email</th>
                            <th class="px-6 py-4 font-semibold">Phone</th>
                            <th class="px-6 py-4 font-semibold">Role</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                            <th class="px-6 py-4 font-semibold">Action</th>


                        </tr>
                    </thead>

                    <tbody class="divide-y">
                        @forelse ($employees as $data)
                            <tr class="hover:bg-gray-50 transition">

                                <!-- Index -->
                                <td class="px-6 py-4 font-semibold text-gray-700">
                                    {{ $loop->iteration }}
                                </td>

                                <!-- Name -->
                                <td class="px-6 py-4 font-semibold text-gray-800">
                                    {{ $data->name }}
                                </td>

                                <!-- Email -->
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $data->email }}
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $data->phone }}
                                </td>

                                <!-- Phone -->
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $data->role }}
                                </td>

                                <td class="px-6 py-4">
                                    <span
                                        class="px-3 py-1 text-xs font-semibold rounded
                                      {{ $data->status === 'active' ? 'bg-green-600 text-white' : 'bg-red-600 text-white' }}">
                                        {{ ucfirst($data->status) }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex gap-2">

                                        <!-- Edit -->
                                        <a href="{{ route('show', $data->id) }}"
                                            class="px-3 py-1 text-xs font-semibold text-white bg-blue-600 rounded hover:bg-blue-700">
                                            Edit
                                        </a>

                                        <!-- Delete -->
                                        <form action="{{ route('destroy', $data->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1 text-xs font-semibold text-white bg-red-600 rounded hover:bg-red-700">
                                                Delete
                                            </button>
                                        </form>


                                    </div>
                                </td>


                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-6 text-gray-500">
                                    No Employees found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t">
                {{ $employees->links() }}
            </div>
        </div>
    </div>

@endsection
