<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $targetDate = Setting::get('countdown_target_date', '2026-08-30 00:00:00');
        return view('landing', compact('targetDate'));
    }
}
