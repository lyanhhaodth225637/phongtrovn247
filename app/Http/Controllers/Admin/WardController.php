<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ward;
use App\Models\Province;

class WardController extends Controller
{
    public function index()
    {
        $province = Province::where('code', 91)->firstOrFail();

        $wards = Ward::with('province')
            ->where('province_id', $province->id)
            ->orderBy('code')
            ->get();

        return view('admin.ward.index', compact('wards'));
    }
}
