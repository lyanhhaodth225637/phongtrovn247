<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Province;

class HomeController extends Controller
{
    public function index()
    {
        $provinces = Province::orderBy('name')->get();

        return view('frontend.home', compact('provinces'));
    }
}