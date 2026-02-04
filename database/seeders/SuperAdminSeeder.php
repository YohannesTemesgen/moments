<?php

namespace Database\Seeders;

use App\Models\SuperAdmin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SuperAdmin::firstOrCreate(
            ['email' => 'superadmin@moments.app'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('password'),
                'phone' => '+1 (555) 000-0000',
            ]
        );
    }
}
