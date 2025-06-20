@extends('layouts.app')

@section('title', isset($job) ? 'Edit Job' : 'Create Job')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1 class="title">{{ isset($job) ? 'Edit Job Listing' : 'Create New Job Listing' }}</h1>
            <div class="card">
                <div class="card-body">
                    <form action="{{ isset($job) ? route('admin.jobs.update', $job->slug) : route('admin.jobs.store') }}"
                        method="POST">
                        @csrf
                        @if(isset($job))
                        @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="title" class="form-label">Job Title</label>
                            <input type="text"
                                class="form-control @error('title') is-invalid @enderror"
                                id="title"
                                name="title"
                                value="{{ old('title', $job->title ?? '') }}"
                                required>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="department" class="form-label">Department</label>
                                    <input type="text"
                                        class="form-control @error('department') is-invalid @enderror"
                                        id="department"
                                        name="department"
                                        value="{{ old('department', $job->department ?? '') }}"
                                        required>
                                    @error('department')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="location" class="form-label">Location</label>
                                    <input type="text"
                                        class="form-control @error('location') is-invalid @enderror"
                                        id="location"
                                        name="location"
                                        value="{{ old('location', $job->location ?? '') }}"
                                        required>
                                    @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="employment_type" class="form-label">Employment Type</label>
                                    <select class="form-select @error('employment_type') is-invalid @enderror"
                                        id="employment_type"
                                        name="employment_type"
                                        required>
                                        <option value="">Select Type</option>
                                        <option value="Full-time" {{ old('employment_type', $job->employment_type ?? '') == 'Full-time' ? 'selected' : '' }}>
                                            Full-time
                                        </option>
                                        <option value="Part-time" {{ old('employment_type', $job->employment_type ?? '') == 'Part-time' ? 'selected' : '' }}>
                                            Part-time
                                        </option>
                                        <option value="Contract" {{ old('employment_type', $job->employment_type ?? '') == 'Contract' ? 'selected' : '' }}>
                                            Contract
                                        </option>
                                    </select>
                                    @error('employment_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Job Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                id="description"
                                name="description"
                                rows="5"
                                required>{{ old('description', $job->description ?? '') }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="responsibilities" class="form-label">Key Responsibilities</label>
                            <textarea class="form-control @error('responsibilities') is-invalid @enderror"
                                id="responsibilities"
                                name="responsibilities"
                                rows="5"
                                required>{{ old('responsibilities', $job->responsibilities ?? '') }}</textarea>
                            @error('responsibilities')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="requirements" class="form-label">Requirements</label>
                            <textarea class="form-control @error('requirements') is-invalid @enderror"
                                id="requirements"
                                name="requirements"
                                rows="5"
                                required>{{ old('requirements', $job->requirements ?? '') }}</textarea>
                            @error('requirements')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.jobs.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                {{ isset($job) ? 'Update Job' : 'Create Job' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection