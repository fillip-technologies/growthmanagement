@extends('admin.include.layout')

@section('heading', 'Employees')
@section('title', 'Employees List')

@section('content')
<div class="max-w-7xl mx-auto mt-8">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Employees</h1>
            <p class="text-gray-500 text-sm">Manage your team members</p>
        </div>

        <a href="{{ route('create') }}"
            class="bg-orange-600 hover:bg-orange-700 text-white px-5 py-2 rounded-xl font-semibold shadow">
            + Add Employee
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white shadow-2xl rounded-2xl overflow-hidden border">

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">

                <!-- Head -->
                <thead class="bg-gradient-to-r from-orange-600 to-orange-500 text-white">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Profile</th>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Designation</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Phone</th>
                        <th class="px-4 py-3">Role</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-center">Action</th>
                    </tr>
                </thead>

                <!-- Body -->
                <tbody class="divide-y">
                    @forelse ($employees as $data)
                        <tr class="hover:bg-gray-50 transition">

                            <!-- Index -->
                            <td class="px-4 py-3">
                                {{ $loop->iteration }}
                            </td>

                            <!-- Profile Image -->
                            <td class="px-4 py-3">
                                @if ($data->profile)
                                    <img src="{{ asset($data->profile) }}"
                                        class="w-10 h-10 rounded-full object-cover border">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 font-bold">
                                        {{ strtoupper(substr($data->name, 0, 1)) }}
                                    </div>
                                @endif
                            </td>

                            <!-- Name -->
                            <td class="px-4 py-3 font-semibold text-gray-800">
                                {{ $data->name }}
                            </td>

                            <!-- Designation -->
                            <td class="px-4 py-3 text-gray-600">
                                {{ $data->designation }}
                            </td>

                            <!-- Email -->
                            <td class="px-4 py-3 text-gray-600">
                                {{ $data->email }}
                            </td>

                            <!-- Phone -->
                            <td class="px-4 py-3 text-gray-600">
                                {{ $data->phone }}
                            </td>

                            <!-- Role -->
                            <td class="px-4 py-3">
                                <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-600 font-semibold">
                                    {{ ucfirst($data->role->role) }}
                                </span>
                            </td>

                            <!-- Status -->
                            <td class="px-4 py-3">
                                <span class="px-3 py-1 text-xs rounded-full font-semibold
                                    {{ $data->status === 'active' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                    {{ ucfirst($data->status) }}
                                </span>
                            </td>

                            <!-- Action -->
                            <td class="px-4 py-3">
                                <div class="flex justify-center gap-2">

                                    <!-- Edit -->
                                    <a href="{{ route('show', $data->id) }}"
                                        class="p-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('destroy', $data->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-8 text-gray-400">
                                🚫 No Employees Found
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t bg-gray-50">
            {{ $employees->links() }}
        </div>

    </div>
</div>
@endsection
