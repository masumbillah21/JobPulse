<?php

namespace App\Policies;

use App\Models\User;

class RolesPolicy
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
        return $user->hasPermission('role.view');
    }

    public function create(User $user)
    {
        return $user->hasPermission('role.create');
    }

    public function update(User $user)
    {
        return $user->hasPermission('role.update');
    }

    public function delete(User $user)
    {
        return $user->hasPermission('role.delete');
    }
}
