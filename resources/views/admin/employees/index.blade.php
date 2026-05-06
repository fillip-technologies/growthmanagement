@extends('admin.include.layout')

@section('heading', 'Employees')
@section('title', 'Employees List')

@section('content')

<div class="max-w-7xl mx-auto mt-8">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Employees</h1>
            <p class="text-sm text-gray-500">Manage and monitor your team members</p>
        </div>

        <a href="{{ route('create') }}"
           class="inline-flex items-center gap-2 bg-gray-900 hover:bg-gray-800 text-white px-5 py-2 rounded-lg text-sm font-medium shadow-sm transition">

            + Add Employee
        </a>

    </div>

    {{-- TABLE CARD --}}
    <div class="bg-white border rounded-xl shadow-sm overflow-hidden">

        <div class="overflow-x-auto">

            <table class="min-w-full text-sm">

                {{-- HEADER --}}
                <thead class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3 text-left">#</th>
                        <th class="px-4 py-3 text-left">Employee</th>
                        <th class="px-4 py-3 text-left">Designation</th>
                        <th class="px-4 py-3 text-left">Contact</th>
                        <th class="px-4 py-3 text-left">Role</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-center">Action</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody class="divide-y divide-gray-100">

                    @forelse ($employees as $data)

                        <tr class="hover:bg-gray-50 transition">

                            {{-- INDEX --}}
                            <td class="px-4 py-3 text-gray-500">
                                {{ $loop->iteration }}
                            </td>

                            {{-- EMPLOYEE --}}
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">

                                    {{-- PROFILE --}}
                                    @if ($data->profile)
                                        <img src="{{ asset($data->profile) }}"
                                             class="w-9 h-9 rounded-full object-cover border">
                                    @else
                                        <div class="w-9 h-9 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-semibold text-sm">
                                            {{ strtoupper(substr($data->name, 0, 1)) }}
                                        </div>
                                    @endif

                                    <div>
                                        <div class="font-medium text-gray-800">
                                            {{ $data->name }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            ID: {{ $data->id }}
                                        </div>
                                    </div>

                                </div>
                            </td>

                            {{-- DESIGNATION --}}
                            <td class="px-4 py-3 text-gray-600">
                                {{ $data->designation }}
                            </td>

                            {{-- CONTACT --}}
                            <td class="px-4 py-3 text-gray-600">
                                <div>{{ $data->email }}</div>
                                <div class="text-xs text-gray-400">{{ $data->phone }}</div>
                            </td>

                            {{-- ROLE --}}
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-50 text-blue-600 font-medium">
                                    {{ ucfirst($data->role->role ?? 'N/A') }}
                                </span>
                            </td>

                            {{-- STATUS --}}
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs rounded-full font-medium
                                    {{ $data->status === 'active'
                                        ? 'bg-green-50 text-green-600'
                                        : 'bg-red-50 text-red-600' }}">
                                    {{ ucfirst($data->status) }}
                                </span>
                            </td>

                            {{-- ACTION --}}
                            <td class="px-4 py-3">

                                <div class="flex justify-center items-center gap-2">

                                    {{-- VIEW / EDIT --}}
                                    <a href="{{ route('show', $data->id) }}"
                                       class="p-2 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-900 hover:text-white transition"
                                       title="View / Edit">

                                        <i class="fa-solid fa-eye"></i>
                                    </a>

                                    {{-- DELETE --}}
                                    <form action="{{ route('destroy', $data->id) }}" method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this employee?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="p-2 rounded-lg bg-gray-100 text-red-500 hover:bg-red-500 hover:text-white transition"
                                                title="Delete">

                                            <i class="fa-solid fa-trash"></i>
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="text-center py-10 text-gray-400">
                                No employees found
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}
        <div class="p-4 border-t bg-gray-50">
            {{ $employees->links() }}
        </div>

    </div>

</div>

@endsection
