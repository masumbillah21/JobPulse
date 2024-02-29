<?php

namespace App\Models;

use App\Trait\DateTrait;
use App\Trait\SlugTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobCategory extends Model
{
    use HasFactory, DateTrait, SlugTrait;

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
