<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SystemWallet;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at')->get();
        return view('admin.user.index', compact('users'));
    }
    public function indexLock()
    {
        $users = User::whereIn('status', ['locked', 'banned'])
            ->latest()
            ->get();

        return view('admin.user.locked', compact('users'));
    }


    public function create()
    {
        return view('admin.user.create');
    }
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|digits_between:10,11|unique:users,phone',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed|min:6',
                'status' => 'required|in:active,locked,banned',
                'role' => 'required',
                'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            $slug = Str::slug($request->name);

            $user = User::create([
                'name' => Str::ucwords($request->name),
                'slug' => $slug,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => $request->status,
            ]);

            // upload avatar
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $ext = $file->getClientOriginalExtension();

                $filename = $slug . '-' . $user->id . '.' . $ext;
                $path = 'avatars/' . $filename;

                Storage::disk('public')->putFileAs('avatars', $file, $filename);

                $user->update([
                    'avatar' => $path
                ]);
            }

            // gán role
            $user->assignRole($request->role);

            DB::commit();

            return redirect()->route('admin.user')
                ->with('success', 'Thêm người dùng thành công!');

        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra, thêm người dùng thất bại!');
        }
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|digits_between:10,11|unique:users,phone,' . $id,
                'email' => 'required|email|unique:users,email,' . $id,
                'status' => 'required|in:active,locked,banned',
                'role' => 'required'
            ]);
            $slugNew = Str::slug($request->name);
            // upload avatar
            if ($request->hasFile('avatar')) {

                $file = $request->file('avatar');
                $ext = $file->getClientOriginalExtension();

                $filename = $slugNew . '-' . $user->id . '.' . $ext;
                $path = 'avatars/' . $filename;

                // xóa avatar cũ
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }

                Storage::disk('public')->putFileAs('avatars', $file, $filename);

                $user->avatar = $path;
            }
            // update password
            if ($request->filled('password')) {

                $request->validate([
                    'password' => 'confirmed|min:6'
                ]);
                $user->password = Hash::make($request->password);
            }
            // update thông tin
            $user->update([
                'name' => Str::ucwords($request->name),
                'slug' => $slugNew,
                'phone' => $request->phone,
                'email' => $request->email,
                'status' => $request->status,
            ]);
            // dd($request->role, $user->getRoleNames());
            // update role
            $user->syncRoles($request->role);
            DB::commit();
            return redirect()->route('admin.user')
                ->with('success', 'Cập nhật người dùng thành công!');

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra, cập nhật thất bại!');
        }
    }

    public function show($id)
    {
        $user = User::with([
            'posts.category',
            'posts.ward',
            'posts.membership',
            'userMemberships.membershipPackage.membership'
        ])->findOrFail($id);

        return view('admin.user.show', compact('user'));
    }

    //ví hệ thống
    public function systemWallet()
    {
        $wallet = SystemWallet::where('is_active', true)->first();

        return view('admin.wallet.index', compact('wallet'));
    }

}
