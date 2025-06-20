@extends('layouts.app')

@section('title', 'Open Positions')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 container-fluid">
            <h1 class="mb-4 title">Open Positions at Plaksha University</h1>

            @if($jobs->isEmpty())
            <div class="alert alert-info">
                No open positions available at the moment. Please check back later.
            </div>
            @else
            <div class="row home-page">
                @foreach($jobs as $job)
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $job->title }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $job->department }}</h6>
                            <p class="card-text">
                                <small class="text-muted">
                                    <i class="bi bi-geo-alt"></i> {{ $job->location }} |
                                    <i class="bi bi-clock"></i> {{ $job->employment_type }}
                                </small>
                            </p>
                            <p class="card-text">{{ Str::limit($job->description, 150) }}</p>
                            <a href="{{ route('jobs.show', $job->slug) }}" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $jobs->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection