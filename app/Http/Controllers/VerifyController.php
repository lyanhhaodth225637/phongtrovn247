<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use App\Mail\SendOtpMail;
use App\Models\User;
use App\Notifications\LandlordVerificationRequestedNotification;


class VerifyController extends Controller
{
    public function create()
    {
        return view('user.register.create');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $email = strtolower(trim($request->email));
        $ip = $request->ip();

        // ====================== RATE LIMIT ======================

        $emailKey = 'otp:email:' . $email;
        $ipKey = 'otp:ip:' . $ip;

        // ❌ Check email spam
        if (RateLimiter::tooManyAttempts($emailKey, 4)) {
            $seconds = RateLimiter::availableIn($emailKey);

            return response()->json([
                'message' => "Bạn đã gửi OTP quá nhiều lần. Thử lại sau {$seconds}s"
            ], 429);
        }

        // ❌ Check IP spam
        if (RateLimiter::tooManyAttempts($ipKey, 12)) {
            $seconds = RateLimiter::availableIn($ipKey);

            return response()->json([
                'message' => "Quá nhiều yêu cầu từ IP. Thử lại sau {$seconds}s"
            ], 429);
        }

        // 🔥 HIT NGAY (QUAN TRỌNG)
        RateLimiter::hit($emailKey, 300); // 5 phút
        RateLimiter::hit($ipKey, 600);    // 10 phút

        // ====================== GỬI OTP ======================
        try {
            $otp = rand(100000, 999999);

            session([
                'otp' => $otp,
                'otp_expired_at' => now()->addSeconds(300), // 5 phút
                'otp_email' => $email,
            ]);

            Mail::to($email)->send(new SendOtpMail($otp));

            return response()->json([
                'message' => 'OTP đã được gửi'
            ]);

        } catch (\Exception $e) {
            \Log::error('Send OTP Error: ' . $e->getMessage());

            return response()->json([
                'message' => 'Có lỗi khi gửi OTP, vui lòng thử lại!'
            ], 500);
        }
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        if (
            $request->email !== session('otp_email') ||
            $request->otp != session('otp') ||
            now()->greaterThan(session('otp_expired_at', now()->subSecond()))
        ) {
            return back()->with('error', 'Mã OTP không đúng hoặc đã hết hạn.');
        }

        $user = auth()->user();

        // $wasVerifiedBefore = !is_null($user->email_verified_at);

        $user->email = $request->email;
        $user->email_verified_at = now();
        $user->save();

        session()->forget(['otp', 'otp_expired_at', 'otp_email']);

        $admins = User::role('admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new LandlordVerificationRequestedNotification($user));
        }


        return redirect()->route('verify.auth_landlord')
            ->with('success', 'Email đã được xác thực thành công!');
    }


    //test
    // public function verify(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'otp' => 'required|digits:6',
    //     ]);

    //     if (
    //         $request->email !== session('otp_email') ||
    //         $request->otp != session('otp') ||
    //         now()->greaterThan(session('otp_expired_at', now()->subSecond()))
    //     ) {
    //         return back()->with('error', 'Mã OTP không đúng hoặc đã hết hạn.');
    //     }

    //     $user = auth()->user();

    //     $user->email = $request->email;
    //     $user->email_verified_at = now();
    //     $user->save();

    //     session()->forget(['otp', 'otp_expired_at', 'otp_email']);

    //     $admin = User::find(1);

    //     $admin->notify(new LandlordVerificationRequestedNotification($user));

    //     dd($admin->notifications()->latest()->first());

    //     return redirect()->route('verify.auth_landlord')
    //         ->with('success', 'Email đã được xác thực thành công!');
    // }
}