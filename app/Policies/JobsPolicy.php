<?php

namespace App\Policies;

use App\Models\User;

class JobsPolicy
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
        return $user->hasPermission('jobs.view');
    }

    public function create(User $user)
    {
        return $user->hasPermission('jobs.create');
    }

    public function update(User $user)
    {
        return $user->hasPermission('jobs.update');
    }

    public function delete(User $user)
    {
        return $user->hasPermission('jobs.delete');
    }

    public function apply(User $user)
    {
        return $user->hasPermission('jobs.delete');
    }
}
