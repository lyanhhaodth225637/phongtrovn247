<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;


class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::with('category')
            ->orderBy('name')
            ->get();

        return view('admin.location.index', compact('locations'));
    }
}
