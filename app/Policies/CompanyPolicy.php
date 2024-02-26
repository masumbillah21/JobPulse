<?php

namespace App\Policies;

use App\Models\User;

class CompanyPolicy
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
        return $user->hasPermission('company.view');
    }

    public function create(User $user)
    {
        return $user->hasPermission('company.create');
    }

    public function update(User $user)
    {
        return $user->hasPermission('company.update');
    }

    public function delete(User $user)
    {
        return $user->hasPermission('company.delete');
    }
}
