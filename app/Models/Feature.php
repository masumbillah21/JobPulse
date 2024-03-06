<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'permissions',
        'status'
    ];

    protected $casts = [
        'permissions' => 'array'
    ];

    protected $hidden = [
        'pivot'
    ];

    public function company()
    {
        return $this->belongsToMany(Company::class, 'company_feature');
    }
}
