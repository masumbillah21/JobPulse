<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
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
            'name' => 'Super Admin',
        ]);
        Role::create([
            'name' => 'Admin',
        ]);
        Role::create([
            'name' => 'Sys Employee',
        ]);
        Role::create([
            'name' => 'Admin Company',
        ]);
        Role::create([
            'name' => 'Company Employee',
        ]);

        $role = Role::find(1);
        $permissions = Permission::all();

        if ($role) {
            $role->permissions()->attach($permissions);
        }

    }
}
