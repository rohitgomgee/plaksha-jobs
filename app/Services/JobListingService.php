<?php

namespace App\Services;

use App\Models\JobListing;
use App\Repositories\JobListingRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class JobListingService
{
    protected $repository;

    public function __construct(JobListingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllActiveJobs(): LengthAwarePaginator
    {
        return $this->repository->getAllActivePaginated();
    }

    public function getAllJobs(): LengthAwarePaginator
    {
        return $this->repository->getAllPaginated();
    }

    public function getJobBySlug(string $slug): ?JobListing
    {
        return $this->repository->findBySlug($slug);
    }

    public function createJob(array $data): JobListing
    {
        if (!isset($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        return $this->repository->create($data);
    }

    public function updateJob(JobListing $job, array $data): bool
    {
        if (isset($data['title']) && !isset($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        return $this->repository->update($job, $data);
    }

    public function deleteJob(JobListing $job): bool
    {
        return $this->repository->delete($job);
    }

    public function toggleJobStatus(JobListing $job): bool
    {
        return $this->repository->update($job, ['is_active' => !$job->is_active]);
    }
}
