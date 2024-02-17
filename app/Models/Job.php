<?php

namespace App\Models;

use App\Trait\DateTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory, DateTrait;

    protected $fillable = [
        'user_id',
        'company_id',
        'title',
        'location',
        'job_type',
        'description',
        'requirements',
        'responsibilities',
        'salary',
        'facilities',
        'closing_date',
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
}
