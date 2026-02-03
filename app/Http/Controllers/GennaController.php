<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GennaController extends Controller
{
    public function index()
    {
        return view('genacountdown');
    }
}
