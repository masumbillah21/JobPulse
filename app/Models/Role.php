<?php

namespace App\Models;

use App\Trait\DateTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory, DateTrait;

    protected $fillable = [
        'name',
    ];

    protected $hidden = ['pivot'];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissons');
    }
}
