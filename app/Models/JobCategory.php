<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'slug',
    ];

    public function getLogoAttribute($value): string
    {
        return config('app.url') . Storage::url($value);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}
