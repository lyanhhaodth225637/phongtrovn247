<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{

    use RegistersUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:10', 'unique:users'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'referred_by' => ['nullable', 'string', 'max:10', 'exists:users,phone'],
        ], [
            'referred_by.exists' => 'SĐT giới thiệu không tồn tại'
        ]);
    }

    protected function create(array $data)
    {
        $referrer = null;

        if (!empty($data['referred_by'])) {
            $referrer = User::where('phone', $data['referred_by'])->first();
        }

        $user = User::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'phone' => $data['phone'],
            'email' => $data['email'] ?? null,
            'password' => Hash::make($data['password']),
            'referred_by' => $referrer?->id // chuẩn
        ]);

        $user->assignRole('user');

        return $user;
    }
}
