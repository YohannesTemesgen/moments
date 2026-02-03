<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Moment;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    public function index()
    {
        $moments = Moment::with('images')
            ->orderBy('moment_date', 'desc')
            ->orderBy('moment_time', 'desc')
            ->get()
            ->groupBy(function ($moment) {
                return $moment->moment_date->format('Y-m-d');
            });

        return view('admin.timeline', compact('moments'));
    }
}
