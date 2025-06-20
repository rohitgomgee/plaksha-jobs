@extends('layouts.app')

@section('title', 'Manage Jobs')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manage Job Listings</h1>
        <a href="{{ route('admin.jobs.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add New Job
        </a>
    </div>

    @if($jobs->isEmpty())
    <div class="alert alert-info">
        No job listings found. Create your first job listing.
    </div>
    @else
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="job_list_table" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Department</th>
                            <th>Location</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jobs as $job)
                        <tr>
                            <td>
                                <a href="{{ route('jobs.show', $job->slug) }}" target="_blank">
                                    {{ $job->title }}
                                </a>
                            </td>
                            <td>{{ $job->department }}</td>
                            <td>{{ $job->location }}</td>
                            <td>{{ $job->employment_type }}</td>
                            <td>
                                <form action="{{ route('admin.jobs.toggle', $job->slug) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm {{ $job->is_active ? 'btn-success' : 'btn-secondary' }}">
                                        {{ $job->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                </form>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.jobs.edit', $job->slug) }}"
                                        class="btn btn-sm btn-info">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.jobs.destroy', $job->slug) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this job listing?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $jobs->links() }}
            </div>
        </div>
    </div>
    @endif
</div>
@endsection