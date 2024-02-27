<?php

namespace App\Models;

use App\Trait\DateTrait;
use App\Trait\SlugTrait;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory, DateTrait, SlugTrait;

    protected $fillable = [
        'user_id',
        'title',
        'body',
        'slug',
        'image',
        'status',
    ];

    protected $hidden = [
        'pivot'
    ];

    public function getImageAttribute($value): string
    {
        return config('app.url') . Storage::url($value);
    }
 

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'blog_categories');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'blog_tags');
    }
}
