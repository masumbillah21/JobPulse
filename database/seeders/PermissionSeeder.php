<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $menus = [
      [
        "name" => "View Dashbaord",
        "permission" => "dashboard.view"
      ],
      [
        "name" => "View Employees",
        "permission" => "employee.view"
      ],
      [
        "name" => "Create Employee",
        "permission" => "employee.create"
      ],
      [
        "name" => "Update Employee",
        "permission" => "employee.update"
      ],
      [
        "name" => "Delete Employee",
        "permission" => "employee.delete"
      ],
      [
        "name" => "View Company",
        "permission" => "company.view"
      ],
      [
        "name" => "Create Company",
        "permission" => "company.create"
      ],
      [
        "name" => "Update Company",
        "permission" => "company.update"
      ],
      [
        "name" => "Delete Company",
        "permission" => "company.delete"
      ],
      [
        "name" => "View Roles",
        "permission" => "role.view"
      ],
      [
        "name" => "Create Role",
        "permission" => "role.create"
      ],
      [
        "name" => "Update Role",
        "permission" => "role.update"
      ],
      [
        "name" => "Delete Role",
        "permission" => "role.delete"
      ],
      [
        "name" => "View Permissions",
        "permission" => "permissions.view"
      ],
      [
        "name" => "Create Permission",
        "permission" => "permissions.create"
      ],
      [
        "name" => "Update Permission",
        "permission" => "permissions.update"
      ],
      [
        "name" => "Delete Permission",
        "permission" => "permissions.delete"
      ],
      [
        "name" => "View Resume",
        "permission" => "resume.view"
      ],
      [
        "name" => "Create Resume",
        "permission" => "resume.create"
      ],
      [
        "name" => "Update Resume",
        "permission" => "resume.update"
      ],
      [
        "name" => "Delete Resume",
        "permission" => "resume.delete"
      ],
      [
        "name" => "View Jobs",
        "permission" => "jobs.view"
      ],
      [
        "name" => "Create Job",
        "permission" => "jobs.create"
      ],
      [
        "name" => "Update Job",
        "permission" => "jobs.update"
      ],
      [
        "name" => "Delete Job",
        "permission" => "jobs.delete"
      ],
      [
        "name" => "Job List View",
        "permission" => "jobs.view.list"
      ],
      [
        "name" => "Job List Approved",
        "permission" => "jobs.approved"
      ],
      [
        "name" => "Job Show From List",
        "permission" => "jobs.list.view"
      ],
      [
        "name" => "View Job Categories",
        "permission" => "job.categories.view"
      ],
      [
        "name" => "Create Job Category",
        "permission" => "job.categories.create"
      ],
      [
        "name" => "Update Job Category",
        "permission" => "job.categories.update"
      ],
      [
        "name" => "Delete Job Category",
        "permission" => "job.categories.delete"
      ],
      [
        "name" => "Apply Job",
        "permission" => "jobs.apply"
      ],
      [
        "name" => "View Candidate List",
        "permission" => "candidate.view.list"
      ],
      [
        "name" => "View Candidate",
        "permission" => "candidate.view"
      ],
      [
        "name" => "Select Candidate",
        "permission" => "candidate.select"
      ],
      [
        "name" => "View Application List",
        "permission" => "application.view.list"
      ],
      [
        "name" => "View Pages",
        "permission" => "pages.view"
      ],
      [
        "name" => "Create Pages",
        "permission" => "pages.create"
      ],
      [
        "name" => "Update Page",
        "permission" => "pages.update"
      ],
      [
        "name" => "Delete Page",
        "permission" => "pages.delete"
      ],
      [
        "name" => "View Blogs",
        "permission" => "blogs.view"
      ],
      [
        "name" => "Create Blog",
        "permission" => "blogs.create"
      ],
      [
        "name" => "Update Blog",
        "permission" => "blogs.update"
      ],
      [
        "name" => "Delete Blog",
        "permission" => "blogs.delete"
      ],
      [
        "name" => "View Categories",
        "permission" => "categories.view"
      ],
      [
        "name" => "Create Category",
        "permission" => "categories.create"
      ],
      [
        "name" => "Update Category",
        "permission" => "categories.update"
      ],
      [
        "name" => "Delete Category",
        "permission" => "categories.delete"
      ],
      [
        "name" => "View Tags",
        "permission" => "tags.view"
      ],
      [
        "name" => "Create Tag",
        "permission" => "tags.create"
      ],
      [
        "name" => "Update Tag",
        "permission" => "tags.update"
      ],
      [
        "name" => "Delete Tag",
        "permission" => "tags.delete"
      ],
      [
        "name" => "View Settings",
        "permission" => "settings.view"
      ],
      [
        "name" => "Create Settings",
        "permission" => "settings.create"
      ],
      [
        "name" => "Update Settings",
        "permission" => "settings.update"
      ],
      [
        "name" => "Delete Settings",
        "permission" => "settings.delete"
      ],
      [
        "name" => "View Plugins",
        "permission" => "plugin.view"
      ],
      [
        "name" => "Create Plugins",
        "permission" => "plugin.create"
      ],
      [
        "name" => "Update Plugins",
        "permission" => "plugin.update"
      ],
      [
        "name" => "Delete Plugins",
        "permission" => "plugin.delete"
      ],
      [
        "name" => "Use Plugins",
        "permission" => "plugin.use"
      ],
      [
        "name" => "View User List",
        "permission" => "users.list.view"
      ],
      [
        "name" => "User Status Change",
        "permission" => "users.list.status"
      ],
    ];  

    $this->createMenu($menus);
  }

  private function createMenu($datas)
  {
    foreach ($datas as $menu) {
      $permission = new Permission([
        'name' => $menu['name'],
        'permission' => $menu['permission'],
      ]);
      $permission->save();
    }
  }
}
