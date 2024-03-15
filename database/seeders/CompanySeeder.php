<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::create([
            'name' => 'JobPulse',
            'description' => 'Company A description',
            'company_type' => 'Job Portal',
            'address' => 'Jhenaidah, Bangladesh',
            'phone' => '01910000000',
            'email' => 'admin@jobpulse.com',
            'website' => 'JobPulse.com',
            'logo' => '',
            'company_size' => '1-10',
            'slug' => 'jobpulse',
            'status' => true,
            'default' => true,
        ]);
    }
}
