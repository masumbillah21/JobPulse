<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enum\UserRoleEnum;
use App\Enum\UserTypeEnum;
use App\Helper\GetUserRole;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OwerUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = User::create([
            'company_id' => 1,
            'name' => 'Super Admin',
            'email' => 'mbillah21@yahoo.com',
            'password' => '12345678',
            'user_type' => UserTypeEnum::SYSTEM,
        ]);
        $suerAdminRole = GetUserRole::user(UserRoleEnum::SUPER_ADMIN->value);
        if ($superAdmin && $suerAdminRole) {
            $superAdmin->roles()->attach($suerAdminRole);
        }

        $systemAdmin = User::create([
            'company_id' => 1,
            'name' => 'System Admin',
            'email' => 'mbillah21@gmail.com',
            'password' => '12345678',
            'user_type' => UserTypeEnum::SYSTEM,
        ]);

        $systemUserRole = GetUserRole::user(UserRoleEnum::SYSTEM_ADMIN->value);
        if ($systemAdmin && $systemUserRole) {
            $systemAdmin->roles()->attach($systemUserRole);
        }
    }
}
