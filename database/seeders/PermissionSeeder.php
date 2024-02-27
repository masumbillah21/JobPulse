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
        "name" => "Apply Job",
        "permission" => "jobs.apply"
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
      ]
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
