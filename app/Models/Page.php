<?php

namespace App\Models;

use App\Trait\DateTrait;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory, DateTrait;

    protected $fillable = [
        'user_id',
        'title',
        'contents',
        'featured_image',
        'page_type',
        'for_nav',
        'email_to',
        'page_order',
        'status',
        'slug'
    ];

    protected $casts = [
        'contents' => 'array',
    ];

    public function getFeaturedImageAttribute($value): string
    {
        return config('app.url') . Storage::url($value);
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
