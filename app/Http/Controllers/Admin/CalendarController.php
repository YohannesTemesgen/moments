<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Moment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $currentDate = $request->has('date') ? Carbon::parse($request->date) : Carbon::now();
        $selectedDate = $request->has('selected') ? Carbon::parse($request->selected) : Carbon::now();
        
        $startOfMonth = $currentDate->copy()->startOfMonth();
        $endOfMonth = $currentDate->copy()->endOfMonth();
        
        $moments = Moment::with('images')
            ->whereBetween('moment_date', [$startOfMonth, $endOfMonth])
            ->get()
            ->groupBy(function ($moment) {
                return $moment->moment_date->format('Y-m-d');
            });

        $selectedMoments = Moment::with('images')
            ->whereDate('moment_date', $selectedDate)
            ->orderBy('moment_time', 'desc')
            ->get();

        return view('admin.calendar', compact('currentDate', 'selectedDate', 'moments', 'selectedMoments'));
    }
}
