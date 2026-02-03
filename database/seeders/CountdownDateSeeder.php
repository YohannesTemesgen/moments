<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class CountdownDateSeeder extends Seeder
{
    public function run()
    {
        // Set the countdown target date to October 30, 2026
        $targetDate = '2026-10-30 23:59:59';
        
        Setting::set('countdown_target_date', $targetDate);
        
        $this->command->info('Countdown target date set to: ' . $targetDate);
    }
}
