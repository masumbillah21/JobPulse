<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enum\UserTypeEnum;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OwerUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'System Admin',
            'email' => 'mbillah21@yahoo.com',
            'password' => '12345678',
            'user_type' => UserTypeEnum::SYSTEM,
        ]);

        $user = User::find(1);

        if ($user) {
            $user->roles()->attach(1);
        }
    }
}
