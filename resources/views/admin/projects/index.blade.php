@extends('admin.include.layout')

@section('content')
    <div class="max-w-7xl mx-auto mt-8">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

            <div>
                <h1 class="text-2xl font-semibold text-gray-800">Project Management</h1>
                <p class="text-sm text-gray-500">Track and manage all projects</p>
            </div>

            <a href="{{ route('project.create') }}"
                class="inline-flex items-center gap-2 bg-gray-900 hover:bg-gray-800 text-white px-5 py-2 rounded-lg text-sm font-medium shadow-sm transition">
                + Add Project
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
                            <th class="px-4 py-3 text-left">Project</th>
                            <th class="px-4 py-3 text-left">Description</th>
                            <th class="px-4 py-3 text-left">Start Date</th>
                            <th class="px-4 py-3 text-left">Deadline</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-center">Modules</th>
                            <th class="px-4 py-3 text-center">Action</th>
                        </tr>
                    </thead>

                    {{-- BODY --}}
                    <tbody class="divide-y divide-gray-100">

                        @forelse($projects as $key => $p)
                            <tr class="hover:bg-gray-50 transition">

                                {{-- INDEX --}}
                                <td class="px-4 py-3 text-gray-500">
                                    {{ $key + 1 }}
                                </td>

                                {{-- PROJECT NAME --}}
                                <td class="px-4 py-3 font-medium text-gray-800">
                                    {{ $p->name }}
                                </td>

                                {{-- DESCRIPTION --}}
                                <td class="px-4 py-3 text-gray-600 max-w-xs truncate">
                                    {{ $p->description }}
                                </td>

                                {{-- START DATE --}}
                                <td class="px-4 py-3 text-gray-600">
                                    {{ $p->start_date }}
                                </td>

                                {{-- DEADLINE --}}
                                <td class="px-4 py-3 text-gray-600">
                                    {{ $p->end_date ?? '-' }}
                                </td>

                                {{-- STATUS --}}
                                <td class="px-4 py-3">

                                    <span
                                        class="px-2 py-1 text-xs rounded-full font-medium
                                    {{ $p->status == 'completed' ? 'bg-green-50 text-green-600' : '' }}
                                    {{ $p->status == 'ongoing' ? 'bg-blue-50 text-blue-600' : '' }}
                                    {{ $p->status == 'pending' ? 'bg-yellow-50 text-yellow-600' : '' }}">

                                        {{ ucfirst($p->status) }}

                                    </span>

                                </td>
                                <td class="px-4 py-3">
                                    <select
                                        class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-orange-400">
                                        <option value="">Modules</option>
                                        @foreach ($p->modules as $module)
                                            <option value="{{ $module }}">{{ $module }}</option>
                                        @endforeach
                                    </select>
                                </td>

                                {{-- ACTION --}}
                                <td class="px-4 py-3">

                                    <div class="flex justify-center items-center gap-2">

                                        {{-- EDIT --}}
                                        <a href="{{ route('project.edit', $p->id) }}"
                                            class="p-2 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-900 hover:text-white transition"
                                            title="Edit">

                                            <i class="fa-solid fa-pen"></i>
                                        </a>

                                        {{-- DELETE --}}
                                        <form action="{{ route('project.delete', $p->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this project?')">

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
                                    No projects found
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>
@endsection
