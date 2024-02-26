<?php

namespace App\Policies;

use App\Models\User;

class TrainingPolicy
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
        return $user->hasPermission('resume.view');
    }

    public function create(User $user)
    {
        return $user->hasPermission('resume.create');
    }

    public function update(User $user)
    {
        return $user->hasPermission('resume.update');
    }

    public function delete(User $user)
    {
        return $user->hasPermission('resume.delete');
    }
}
