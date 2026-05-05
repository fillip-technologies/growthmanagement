@extends('admin.include.layout')

@section('heading', 'My Performance')
@section('title', 'Performance Dashboard')

@section('content')

<style>
    .perf-card {
        border-radius: 16px;
        transition: all 0.3s ease;
    }
    .perf-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
    .gradient-header {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: #fff;
        border-radius: 16px 16px 0 0;
    }
    .rating-star {
        color: #fbbf24;
        font-size: 16px;
    }
</style>

<div class="container-fluid">

    {{-- ================= HEADER ================= --}}
    <div class="card mb-4 shadow-sm ">
        <div class="card-body gradient-header d-flex justify-content-between align-items-center px-3">
            <div>
                <h4 class="mb-1">Performance Overview</h4>
                <p class="mb-0 opacity-75">Track your work performance & feedback</p>
            </div>
            <i class="fas fa-chart-line fa-2x opacity-50"></i>
        </div>
    </div>

    {{-- ================= PERFORMANCE CARDS ================= --}}
    <div class="row">

        @forelse($perfermans as $item)
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card perf-card shadow-sm h-100 p-3">

                    {{-- Card Header --}}
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <strong>{{ $item->task->title ?? 'Task Name' }}</strong>

                        <span class="badge">
                            {{ ucfirst($item->score ?? 'N/A') }}
                        </span>
                    </div>

                    {{-- Card Body --}}
                    <div class="card-body">

                        {{-- Employee --}}
                        <p class="mb-1">
                            <i class="fas fa-user text-primary me-1"></i>
                            <strong>{{ $item->employee->name ?? 'Employee' }}</strong>
                        </p>

                        {{-- Feedback --}}
                        <p class="text-muted mb-2">
                            {!! $item->feedback ?? 'No feedback available.' !!}
                        </p>

                        {{-- Rating --}}
                        <div class="mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star rating-star
                                    {{ $i <= ($item->rating ?? 0) ? '' : 'opacity-25' }}">
                                </i>
                            @endfor
                            <small class="text-muted ms-2">
                                {{ $item->rating ?? 0 }}/5
                            </small>
                        </div>

                    </div>

                    {{-- Footer --}}
                    <div class="card-footer bg-white text-muted d-flex justify-content-between">
                        <small>
                            <i class="fas fa-calendar-alt me-1"></i>
                            {{ $item->created_at?->format('d M Y') }}
                        </small>

                        <small>
                            <i class="fas fa-tasks me-1"></i>
                            Task Review
                        </small>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-1"></i>
                    No performance data available
                </div>
            </div>
        @endforelse

    </div>
</div>

@endsection
