<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\User;

class BlogPolicy
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
        return $user->hasPermission('blogs.view');
    }

    public function create(User $user)
    {
        return $user->hasPermission('blogs.create');
    }

    public function update(User $user, Blog $blog)
    {
        return $user->hasPermission('blogs.update') || $user->id === $blog->user_id;
        //return $user->id === $blog->user_id; // For example, only the owner can update the blog
    }

    public function delete(User $user, Blog $blog)
    {
        return $user->hasPermission('blogs.delete');
        //return $user->isAdmin() || $user->id === $blog->user_id; // For example, admins or owner can delete
    }
}
