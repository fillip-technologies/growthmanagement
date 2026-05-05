@extends('admin.include.layout')

@section('content')

<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">

    <h2 class="text-xl font-bold mb-4">Edit Daily Work</h2>

    <form action="{{ route('daily.work.update', $log->id) }}" method="POST">
        @csrf

        <select name="project_id" class="border p-2 w-full mb-3">
            @foreach($projects as $project)
                <option value="{{ $project->id }}"
                    {{ $log->project_id == $project->id ? 'selected' : '' }}>
                    {{ $project->name }}
                </option>
            @endforeach
        </select>

        <input type="date" name="work_date"
               value="{{ $log->work_date }}"
               class="border p-2 w-full mb-3">

        <textarea name="work_done"
                  class="border p-2 w-full mb-3">{{ $log->work_done }}</textarea>

        <input type="number" name="progress"
               value="{{ $log->progress }}"
               class="border p-2 w-full mb-3">

        <button class="bg-orange-600 text-white px-4 py-2 rounded">
            Update
        </button>
    </form>

</div>

@endsection