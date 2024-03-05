<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCandidate extends Model
{
    use HasFactory;

    protected $table = 'job_candidate';
    public $timestamps = false;

    protected $fillable = [
        'job_id',
        'user_id',
        'expected_salary',
        'status',
    ];
    protected $hidden = ['pivot'];
    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
