<?php

namespace App\Policies;

use App\Models\User;

class UsersPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function view(User $user)
    {
        //return $user->hasPermission('employee.view');
        return true;
    }

    public function create(User $user)
    {
        return $user->hasPermission('employee.create');
    }

    public function update(User $user)
    {
        return $user->hasPermission('employee.update');
    }

    public function delete(User $user)
    {
        return $user->hasPermission('employee.delete');
    }
}
