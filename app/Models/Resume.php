<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'alt_email',
        'phone',
        'father_name',
        'mother_name',
        'dob',
        'gender',
        'marital_status',
        'nationality',
        'religion',
        'present_address',
        'permanent_address',
        'image'
    ];
}
