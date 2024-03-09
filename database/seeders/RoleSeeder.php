<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Enum\UserRoleEnum;
use App\Enum\UserTypeEnum;
use App\Models\Permission;
use App\Helper\GetUserRole;
use App\Helper\GetUserRoleID;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => UserRoleEnum::SUPER_ADMIN->value,
        ]);
        Role::create([
            'name' => UserRoleEnum::SYSTEM_ADMIN->value,
        ]);
        Role::create([
            'name' => UserRoleEnum::SYSTEM_EMP->value,
        ]);
        Role::create([
            'name' => UserRoleEnum::COMPNANY_ADMIN->value,
        ]);
        Role::create([
            'name' => UserRoleEnum::COMPNANY_EMP->value,
        ]);
        Role::create([
            'name' => UserRoleEnum::CANDIDATE->value,
        ]);

        //Super Admin
        $superAdmin = GetUserRole::user(UserRoleEnum::SUPER_ADMIN->value);
        $allPermissions = Permission::all();

        if ($superAdmin && $allPermissions) {
            $superAdmin->permissions()->attach($allPermissions);
        }

        //System Admin
        $systemAdmin = GetUserRole::user(UserRoleEnum::SYSTEM_ADMIN->value);

        $systemAdminPermissions = Permission::whereIn(
            'permission',
            [
                "dashboard.view", 
                "employee.view", 
                "employee.create", 
                "employee.update", 
                "employee.delete", 
                "company.view", 
                "company.create", 
                "company.update", 
                "company.delete", 
                "jobs.view.list", 
                "jobs.approved", 
                "jobs.list.view",
                "job.categories.view", 
                "job.categories.create", 
                "job.categories.update", 
                "job.categories.delete", 
                "pages.view", 
                "pages.create", 
                "pages.update", 
                "pages.delete", 
                "blogs.view", 
                "blogs.create", 
                "blogs.update", 
                "blogs.delete", 
                "categories.view", 
                "categories.create", 
                "categories.update", 
                "categories.delete", 
                "tags.view", 
                "tags.create", 
                "tags.update", 
                "tags.delete", 
                "settings.view", 
                "settings.create", 
                "settings.update", 
                "settings.delete",
                "plugin.view",
                "plugin.create",
                "plugin.update",
                "plugin.delete",
                "plugin.use",
                "users.list.view",
                "users.list.status",
            ]
        )->get();
        if ($systemAdmin && $systemAdminPermissions) {
            $systemAdmin->permissions()->attach($systemAdminPermissions);
        }

        //System Employee
        $systemEmp = GetUserRole::user(UserRoleEnum::SYSTEM_EMP->value);
        $sysEmpPermissions = Permission::whereIn(
            'permission',
            [ 
                "dashboard.view", 
                "company.view", 
                "company.delete", 
                "jobs.view.list", 
                "jobs.approved", 
                "jobs.list.view",
                "job.categories.view", 
                "job.categories.create", 
                "job.categories.update", 
                "pages.view", 
                "pages.create", 
                "pages.update", 
                "pages.delete", 
                "blogs.view", 
                "blogs.create", 
                "blogs.update", 
                "blogs.delete", 
                "categories.view", 
                "categories.create", 
                "categories.update", 
                "categories.delete", 
                "tags.view", 
                "tags.create", 
                "tags.update", 
                "tags.delete", 
                "settings.view", 
                "settings.create", 
                "settings.update", 
                "settings.delete",
                "plugin.view",
                "plugin.create",
                "plugin.update",
                "plugin.delete",
                "plugin.use",
                "users.list.view",
                "users.list.status",
            ])->get();

        if ($systemEmp && $sysEmpPermissions) {
            $systemEmp->permissions()->attach($sysEmpPermissions);
        }

        //Company Admin
        $companyAdmin = GetUserRole::user(UserRoleEnum::COMPNANY_ADMIN->value);
        $companyAdminPermissions = Permission::whereIn(
            'permission',
            [ 
                "dashboard.view", 
                "employee.view", 
                "employee.create", 
                "employee.update", 
                "employee.delete", 
                "company.create", 
                "company.update", 
                "company.delete", 
                "jobs.view", 
                "jobs.create", 
                "jobs.update", 
                "jobs.delete", 
                "blogs.view", 
                "blogs.create", 
                "blogs.update", 
                "blogs.delete",
                "candidate.view.list",
                "candidate.select",
                "candidate.view",
                "plugin.view",
                "plugin.use",
            ])->get();

        if ($companyAdmin && $companyAdminPermissions) {
            $companyAdmin->permissions()->attach($companyAdminPermissions);
        }

        //Company Employee
        $companyEmp = GetUserRole::user(UserRoleEnum::COMPNANY_EMP->value);
        $companyEmpPermissions = Permission::whereIn(
            'permission',
            [ 
                "dashboard.view", 
                "jobs.view", 
                "jobs.create", 
                "jobs.update", 
                "jobs.delete", 
                "blogs.view", 
                "blogs.create", 
                "blogs.update", 
                "blogs.delete",
                "candidate.view.list",
                "candidate.select",
                "candidate.view",
                "plugin.view",
                "plugin.use",
            ])->get();

        if ($companyEmp && $companyEmpPermissions) {
            $companyEmp->permissions()->attach($companyEmpPermissions);
        }

        //Candidate
        $candidate = GetUserRole::user(UserRoleEnum::CANDIDATE->value);
        $candidatePermissions = Permission::whereIn(
            'permission',
            [ 
                "dashboard.view", 
                "resume.view", 
                "resume.create", 
                "resume.update", 
                "resume.delete", 
                "jobs.apply",
                "application.view.list"
            ])->get();
        if ($candidate && $candidatePermissions) {
            $candidate->permissions()->attach($candidatePermissions);
        }
    }
}
