<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\User;
class LoginController extends Controller
{

    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function username()
    {
        return 'phone';
    }

    // chỉ cho tài khoản active đăng nhập
    protected function credentials(Request $request)
    {
        return [
            'phone' => $request->phone,
            'password' => $request->password,
            'status' => 'active'
        ];
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $user = User::where('phone', $request->phone)->first();

        if ($user && $user->status == 'locked') {
            throw ValidationException::withMessages([
                'phone' => ['Tài khoản của bạn đang bị khóa. Vui lòng liên hệ QTV để giải quyết'],
            ]);
        }

        if ($user && $user->status == 'banned') {
            throw ValidationException::withMessages([
                'phone' => ['Tài khoản của bạn đã bị cấm.'],
            ]);
        }

        throw ValidationException::withMessages([
            'phone' => ['Sai số điện thoại hoặc mật khẩu.'],
        ]);
    }
}
