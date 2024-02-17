<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PersonalDetail extends Model
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImageAttribute($value): string
    {
        return config('app.url') . Storage::url($value);
    }
}
