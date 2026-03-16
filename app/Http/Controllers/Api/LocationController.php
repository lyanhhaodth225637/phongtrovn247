<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\Ward;
class LocationController extends Controller
{
    public function provinces()
    {
        return Province::all();
    }

    public function wards($province)
    {
        return Ward::where('province_id', $province)->get();
    }
}