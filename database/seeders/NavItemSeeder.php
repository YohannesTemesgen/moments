<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NavItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $navItems = [
            [
                'name' => 'home',
                'label' => 'Home',
                'icon' => 'home',
                'route' => 'landing',
                'order' => 1,
                'is_visible' => true,
                'is_active' => true,
                'type' => 'link',
                'attributes' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'genna',
                'label' => 'Genna',
                'icon' => 'church',
                'route' => 'genacountdown',
                'order' => 2,
                'is_visible' => true,
                'is_active' => true,
                'type' => 'link',
                'attributes' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'settings',
                'label' => 'Settings',
                'icon' => 'settings',
                'route' => '',
                'order' => 3,
                'is_visible' => true,
                'is_active' => true,
                'type' => 'button',
                'attributes' => json_encode(['onclick' => 'toggleSettings()']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('nav_items')->insert($navItems);
    }
}
