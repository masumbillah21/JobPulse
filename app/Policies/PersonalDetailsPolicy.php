<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PersonalDetail;

class PersonalDetailsPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function view(User $user, PersonalDetail $personalDetail)
    {
        return true;
    }

    public function create(User $user, PersonalDetail $personalDetail)
    {
        return $user->hasPermission('personal_details.create');
    }

    public function update(User $user, PersonalDetail $personalDetail)
    {
        return $user->hasPermission('resume.update');
    }

    public function delete(User $user, PersonalDetail $personalDetail)
    {
        return $user->hasPermission('resume.delete');
    }
}
