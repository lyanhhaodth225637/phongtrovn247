<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
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

    public function create()
    {
        return view('admin.user.create');
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
}
