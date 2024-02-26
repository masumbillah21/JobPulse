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
    $menus = [ ];

    $this->createMenu($menus);
  }

  private function createMenu($datas)
  {
    foreach ($datas as $menu) {
      $permission = new Permission([
        'name' => $menu['label'],
      ]);
      $permission->save();
    }
  }
}
