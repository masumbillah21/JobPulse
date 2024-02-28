<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Job;
use App\Models\Blog;
use App\Models\Page;
use App\Models\Role;
use App\Models\Company;
use App\Policies\BlogPolicy;
use App\Policies\JobsPolicy;
use App\Policies\PagesPolicy;
use App\Policies\RolesPolicy;
use App\Policies\UsersPolicy;
use App\Policies\CompanyPolicy;
use App\Policies\PersonalDetailsPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Blog::class => BlogPolicy::class,
        User::class => UsersPolicy::class,
        Company::class => CompanyPolicy::class,
        Role::class => RolesPolicy::class,
        Permission::class => PermissionPolicy::class,
        PersonalDetail::class => PersonalDetailsPolicy::class,
        Job::class => JobsPolicy::class,
        Page::class => PagesPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
