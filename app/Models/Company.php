<?php

namespace App\Models;

use App\Trait\DateTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Storage;

class Company extends Model
{
    use HasFactory, DateTrait;
    protected $fillable = [
        'name',
        'description',
        'company_type',
        'address',
        'phone',
        'email',
        'website',
        'logo',
        'company_size',
        'slug',
        'status',
        'default'
    ];

    protected $hidden = [
        'pivot'
    ];

    public function getLogoAttribute($value): string
    {
        return config('app.url') . Storage::url($value);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }

    public function features(): BelongsToMany
    {
        return $this->belongsToMany(Feature::class, 'company_feature');
    }
    

}
