<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Services\JobListingService;
use Illuminate\Http\Request;

class JobListingController extends Controller
{
    protected $jobService;

    public function __construct(JobListingService $jobService)
    {
        $this->jobService = $jobService;
    }

    public function index()
    {
        $jobs = $this->jobService->getAllActiveJobs();
        return view('jobs.index', compact('jobs'));
    }

    public function show($slug)
    {
        $job = $this->jobService->getJobBySlug($slug);
        return view('jobs.show', compact('job'));
    }

    public function adminIndex()
    {
        $jobs = $this->jobService->getAllJobs();
        return view('admin.jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('admin.jobs.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'department' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'employment_type' => 'required|string|max:255',
            'requirements' => 'required|string',
            'responsibilities' => 'required|string',
        ]);

        $this->jobService->createJob($validated);

        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job listing created successfully.');
    }

    public function edit($slug)
    {
        $job = $this->jobService->getJobBySlug($slug);
        return view('admin.jobs.form', compact('job'));
    }

    public function update(Request $request, $slug)
    {
        $job = $this->jobService->getJobBySlug($slug);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'department' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'employment_type' => 'required|string|max:255',
            'requirements' => 'required|string',
            'responsibilities' => 'required|string',
        ]);

        $this->jobService->updateJob($job, $validated);

        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job listing updated successfully.');
    }

    public function toggleStatus($slug)
    {
        $job = $this->jobService->getJobBySlug($slug);
        $this->jobService->toggleJobStatus($job);

        return redirect()->back()
            ->with('success', 'Job status updated successfully.');
    }

    public function destroy($slug)
    {
        $job = $this->jobService->getJobBySlug($slug);
        $this->jobService->deleteJob($job);

        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job listing deleted successfully.');
    }
}
