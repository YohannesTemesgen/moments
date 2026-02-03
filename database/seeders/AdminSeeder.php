<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Moment;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
            ]
        );

        // Create countdown target date setting
        Setting::set('countdown_target_date', '2026-10-30 00:00:00');

        // Create sample moments
        $moments = [
            [
                'title' => 'Foundation Pouring',
                'description' => 'Updates on Sector B groundwork',
                'location' => 'Site B, North Sector',
                'latitude' => 9.0054,
                'longitude' => 38.7636,
                'category' => 'progress-update',
                'status' => 'in_progress',
                'moment_date' => now()->format('Y-m-d'),
                'moment_time' => '10:42:00',
            ],
            [
                'title' => 'Safety Inspection',
                'description' => 'Routine checkup - Q4',
                'location' => 'Main Lobby',
                'latitude' => 9.0104,
                'longitude' => 38.7516,
                'category' => 'safety',
                'status' => 'completed',
                'moment_date' => now()->format('Y-m-d'),
                'moment_time' => '09:15:00',
            ],
            [
                'title' => 'Material Delivery',
                'description' => 'Steel beams and concrete blocks arrived',
                'location' => 'Loading Dock 4',
                'latitude' => 9.0024,
                'longitude' => 38.7586,
                'category' => 'general',
                'status' => 'completed',
                'moment_date' => now()->subDay()->format('Y-m-d'),
                'moment_time' => '16:30:00',
            ],
        ];

        foreach ($moments as $momentData) {
            Moment::firstOrCreate(
                ['title' => $momentData['title'], 'user_id' => $admin->id],
                array_merge($momentData, ['user_id' => $admin->id])
            );
        }
    }
}
