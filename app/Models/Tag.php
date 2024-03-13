<?php

namespace App\Models;

use App\Trait\DateTrait;
use App\Trait\SlugTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory, DateTrait, SlugTrait;

    protected $fillable = [
        'name',
        'slug',
    ];

    protected $hidden = ['pivot'];

    public function blog()
    {
        return $this->belongsToMany(Blog::class, 'blog_tags');
    }
}
