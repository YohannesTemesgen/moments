<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenant1 = \App\Models\Tenant::create(['id' => 'tenant1']);
        $tenant1->domains()->create(['domain' => 'tenant1.localhost']);

        $tenant2 = \App\Models\Tenant::create(['id' => 'tenant2']);
        $tenant2->domains()->create(['domain' => 'tenant2.localhost']);

        // Create a user for each tenant
        \App\Models\User::create([
            'tenant_id' => 'tenant1',
            'name' => 'Tenant 1 User',
            'email' => 'user1@tenant1.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);

        \App\Models\User::create([
            'tenant_id' => 'tenant2',
            'name' => 'Tenant 2 User',
            'email' => 'user2@tenant2.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);
    }
}
