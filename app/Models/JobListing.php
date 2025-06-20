<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class JobListing extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'department',
        'location',
        'employment_type',
        'requirements',
        'responsibilities',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($job) {
            if (!$job->slug) {
                $job->slug = Str::slug($job->title);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
