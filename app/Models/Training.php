<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'organization',
        'location',
        'start_date',
        'end_date',
        'description',
        'current',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
