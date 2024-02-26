<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Job;
use App\Models\Blog;
use App\Models\Page;
use App\Models\Role;
use App\Models\Company;
use App\Models\Training;
use App\Models\Education;
use App\Models\Reference;
use App\Policies\BlogPolicy;
use App\Policies\EducationsPolicy;
use App\Policies\JobsPolicy;
use App\Policies\PagesPolicy;
use App\Policies\PersonalDetailsPolicy;
use App\Policies\RolesPolicy;
use App\Policies\TrainingPolicy;
use App\Policies\UsersPolicy;
use App\Policies\ResumePolicy;
use App\Policies\CompanyPolicy;
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
        // Education::class => EducationsPolicy::class,
        // Training::class => TrainingPolicy::class,
        // Reference::class => ReferencePolicy::class,
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
