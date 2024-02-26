<?php

namespace App\Policies;

use App\Models\User;

class PagesPolicy
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
        return $user->hasPermission('pages.view');
    }

    public function create(User $user)
    {
        return $user->hasPermission('pages.create');
    }

    public function update(User $user)
    {
        return $user->hasPermission('pages.update');
    }

    public function delete(User $user)
    {
        return $user->hasPermission('pages.delete');
    }
}
