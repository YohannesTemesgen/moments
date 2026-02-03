<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Moment;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        $moments = Moment::with('images')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->orderBy('moment_date', 'desc')
            ->get();

        return view('admin.map', compact('moments'));
    }
}
