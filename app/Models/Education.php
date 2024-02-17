<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'degree',
        'institute',
        'board_university',
        'passing_year',
        'in_progress',
        'result_type',
        'result',
    ];
}
