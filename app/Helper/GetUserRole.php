<?php 

namespace App\Helper;
use App\Models\Role;

class GetUserRole
{
    public static function user($role)
    {
        return Role::where('name', $role)->first();
    }
}