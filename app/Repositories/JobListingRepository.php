<?php

namespace App\Repositories;

use App\Models\JobListing;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class JobListingRepository
{
    public function getAllActive(): Collection
    {
        return JobListing::active()->latest()->get();
    }

    public function getAllActivePaginated(): LengthAwarePaginator
    {
        return JobListing::active()->latest()->paginate(6);
    }

    public function getAll(): Collection
    {
        return JobListing::latest()->get();
    }

    public function getAllPaginated(): LengthAwarePaginator
    {
        return JobListing::latest()->paginate(6);
    }

    public function findBySlug(string $slug): ?JobListing
    {
        return JobListing::where('slug', $slug)->firstOrFail();
    }

    public function create(array $data): JobListing
    {
        return JobListing::create($data);
    }

    public function update(JobListing $job, array $data): bool
    {
        return $job->update($data);
    }

    public function delete(JobListing $job): bool
    {
        return $job->delete();
    }
}
