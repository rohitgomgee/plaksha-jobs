@extends('layouts.app')

@section('title', 'Page Not Found')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="error-page my-5">
                <h1 class="display-1">404</h1>
                <h2 class="mb-4">Page Not Found</h2>
                <p class="lead mb-4">
                    The page you are looking for might have been removed, had its name changed, 
                    or is temporarily unavailable.
                </p>
                <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-house-door"></i> Back to Homepage
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 