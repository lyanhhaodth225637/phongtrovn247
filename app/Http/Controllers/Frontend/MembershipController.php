<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Membership;

class MembershipController extends Controller
{
    public function index()
    {
        $membership = Membership::with('membershipPackages')
            ->orderByDesc('priority')  
            ->get();
        return view('frontend.membership.index', compact('membership'));
    }
    public function show($id)
    {
        $membership = Membership::with('membershipPackages')->findOrFail($id);

        return view('frontend.membership.show', compact('membership'));
    }
}
