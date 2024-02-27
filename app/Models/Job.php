<?php

namespace App\Models;

use App\Trait\DateTrait;
use App\Trait\SlugTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory, DateTrait, SlugTrait;

    protected $fillable = [
        'user_id',
        'company_id',
        'job_category_id',
        'title',
        'location',
        'job_type',
        'job_level',
        'work_type',
        'description',
        'requirements',
        'responsibilities',
        'salary',
        'facilities',
        'skills',
        'closing_date',
        'slug',
        'status',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id');
    }
}
