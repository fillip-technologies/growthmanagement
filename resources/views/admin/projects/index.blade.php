@extends('admin.include.layout')

@section('content')

<div class="p-6">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Project List</h2>

        <a href="{{ route('project.create') }}"
           class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600">
            + Add Project
        </a>
    </div>

    <!-- Card -->
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">

        <table class="w-full text-left">
            <thead class="bg-orange-500 text-white">
                <tr>
                    <th class="p-3">#</th>
                    <th class="p-3">Title</th>
                    <th class="p-3">Description</th>
                    <th class="p-3">Start Date</th>
                    <th class="p-3">Deadline</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($projects as $key => $p)
                <tr class="border-b hover:bg-gray-100">

                    <td class="p-3">{{ $key + 1 }}</td>

                    <td class="p-3 font-semibold">
                        {{ $p->name }}
                    </td>



                    <td class="p-3">
                        {{ $p->description }}
                    </td>

                    <td class="p-3">
                        {{ $p->start_date }}
                    </td>

                    <td class="p-3">
                        {{ $p->end_date ?? '-' }}
                    </td>

                    <td class="p-3">
                        @if($p->status == 'completed')
                            <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm">
                                Completed
                            </span>
                        @elseif($p->status == 'ongoing')
                            <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-sm">
                                Ongoing
                            </span>
                        @else
                            <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm">
                                Pending
                            </span>
                        @endif
                    </td>

                    <td class="p-3 flex gap-2">

                        <a href="{{ route('project.edit',$p->id) }}"
                           class="bg-blue-500 text-white px-3 py-1 rounded">
                            Edit
                        </a>

                        <form action="{{ route('project.delete',$p->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button class="bg-red-500 text-white px-3 py-1 rounded" onclick="return confirm('Are you sure delete this data')">
                                Delete
                            </button>
                        </form>

                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection
