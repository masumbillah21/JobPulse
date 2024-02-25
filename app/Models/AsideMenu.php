<?php

namespace App\Models;

use App\Trait\DateTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsideMenu extends Model
{
    use HasFactory, DateTrait;
    protected $fillable = ['label', 'route', 'icon', 'parent_id', 'status'];

    public function children()
    {
        return $this->hasMany(AsideMenu::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(AsideMenu::class, 'parent_id', 'id');
    }
}
