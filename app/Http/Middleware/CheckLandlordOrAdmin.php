<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLandlordOrAdmin
{

    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->hasRole('landlord') || $user->hasRole('admin')) {
            return $next($request);
        }

        return redirect()->route('verify.auth_landlord')
            ->with('error', 'Bạn cần đăng ký chủ trọ để đăng tin');
    }
}
