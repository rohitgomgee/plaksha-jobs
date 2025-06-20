@extends('layouts.app')

@section('title', $job->title)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Jobs</a></li>
                    <li class="breadcrumb-item active">{{ $job->title }}</li>
                </ol>
            </nav>

            <h1 class="mb-3 title">{{ $job->title }}</h1>

            <div class="mb-4 text-center">
                <span class="badge bg-primary me-2">{{ $job->department }}</span>
                <span class="badge bg-secondary me-2">{{ $job->location }}</span>
                <span class="badge bg-info">{{ $job->employment_type }}</span>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Job Description</h5>
                    <p class="card-text">{!! nl2br(e($job->description)) !!}</p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Key Responsibilities</h5>
                    <p class="card-text">{!! nl2br(e($job->responsibilities)) !!}</p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Requirements</h5>
                    <p class="card-text">{!! nl2br(e($job->requirements)) !!}</p>
                </div>
            </div>

            <div class="text-center mb-5">
                <a href="mailto:careers@plaksha.edu.in?subject=Application for {{ urlencode($job->title) }}"
                    class="btn btn-primary btn-lg">
                    Apply Now
                </a>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">About Plaksha University</h5>
                    <p class="card-text">
                        Plaksha University is reimagining technology education and research for the 21st century.
                        Join us in our mission to create the next generation of fearless leaders.
                    </p>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-check-circle-fill text-success"></i> World-class faculty</li>
                        <li><i class="bi bi-check-circle-fill text-success"></i> State-of-the-art facilities</li>
                        <li><i class="bi bi-check-circle-fill text-success"></i> Innovation-driven culture</li>
                        <li><i class="bi bi-check-circle-fill text-success"></i> Global partnerships</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection