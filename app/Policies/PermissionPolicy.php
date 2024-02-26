<?php

namespace App\Policies;

use App\Models\User;

class PermissionPolicy
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
        return $user->hasPermission('permissions.view');
    }

    public function create(User $user)
    {
        return $user->hasPermission('permissions.create');
    }

    public function update(User $user)
    {
        return $user->hasPermission('permissions.update');
    }

    public function delete(User $user)
    {
        return $user->hasPermission('permissions.delete');
    }
}
