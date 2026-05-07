<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserMembership;


class UserMembershipController extends Controller
{
    public function index()
    {
        $userMemberships = UserMembership::with('user', 'membershipPackage')->get();
        return view('admin.user_membership.index', compact('userMemberships'));
    }

    
}
