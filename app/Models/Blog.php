<?php

namespace App\Models;

use App\Trait\DateTrait;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory, DateTrait;

    protected $fillable = [
        'user_id',
        'title',
        'body',
        'slug',
        'image',
        'status',
    ];

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getImageAttribute($value): string
    {
        return config('app.url') . Storage::url($value);
    }
    

    // public function getRouteKeyName()
    // {
    //     return 'slug';
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
