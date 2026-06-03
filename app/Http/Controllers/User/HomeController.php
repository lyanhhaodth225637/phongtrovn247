<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\UserMembership;
use App\Models\WalletTransaction;

class HomeController extends Controller
{

   //Hiển thị trang hồ sơ

   public function index()
   {
      return view('user.profile.index');
   }


   //Cập nhật thông tin cá nhân + avatar

   public function updateProfile(Request $request)
   {
      DB::beginTransaction();

      try {
         $user = Auth::user();

         $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
               'nullable',
               'email',
               'max:255',
               Rule::unique('users', 'email')->ignore($user->id),
            ],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
         ], [
            'name.required' => 'Vui lòng nhập họ và tên.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã tồn tại.',
            'avatar.image' => 'File tải lên phải là hình ảnh.',
            'avatar.mimes' => 'Ảnh chỉ chấp nhận jpg, jpeg, png, webp.',
            'avatar.max' => 'Ảnh không được vượt quá 2MB.',
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

         // nếu email thay đổi thì bỏ xác thực email cũ
         if (($user->email ?? null) !== ($request->email ?? null)) {
            $user->email_verified_at = null;
         }

         $user->name = Str::ucwords($request->name);
         $user->slug = $slugNew;
         $user->email = $request->email;
         $user->save();

         DB::commit();

         return back()->with('success', 'Cập nhật thông tin cá nhân thành công.');
      } catch (\Throwable $e) {
         DB::rollBack();
         return back()->with('error', 'Có lỗi xảy ra khi cập nhật hồ sơ.');
      }
   }


   // Đổi mật khẩu

   public function updatePassword(Request $request)
   {
      $user = Auth::user();

      $request->validate([
         'current_password' => ['required'],
         'password' => ['required', 'string', 'min:8', 'confirmed'],
      ], [
         'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
         'password.required' => 'Vui lòng nhập mật khẩu mới.',
         'password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự.',
         'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
      ]);

      if (!Hash::check($request->current_password, $user->password)) {
         return back()
            ->withErrors([
               'current_password' => 'Mật khẩu hiện tại không chính xác.'
            ])
            ->withInput();
      }

      if (Hash::check($request->password, $user->password)) {
         return back()
            ->withErrors([
               'password' => 'Mật khẩu mới không được trùng với mật khẩu hiện tại.'
            ])
            ->withInput();
      }

      try {
         $user->update([
            'password' => Hash::make($request->password)
         ]);

         return back()->with('success', 'Đổi mật khẩu thành công.');
      } catch (\Throwable $e) {
         return back()->with('error', 'Có lỗi xảy ra khi đổi mật khẩu.');
      }
   }


   // Xóa tài khoản

   public function destroy(Request $request)
   {
      $user = Auth::user();

      DB::beginTransaction();

      try {
         // Xóa avatar nếu có
         if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
         }

         Auth::logout();

         // Nếu có quan hệ ràng buộc nhiều bảng, cần xử lý thêm ở đây
         $user->delete();

         $request->session()->invalidate();
         $request->session()->regenerateToken();

         DB::commit();

         return redirect()->route('user.profile.index')->with('success', 'Tài khoản đã được xóa thành công.');
      } catch (\Throwable $e) {
         DB::rollBack();

         return back()->with('error', 'Không thể xóa tài khoản lúc này.');
      }
   }


   // public function referredBy()
   // {
   //    $user = Auth::user();

   //    // Danh sách user được giới thiệu bởi tài khoản hiện tại
   //    $referrals = User::where('referred_by', $user->id)
   //       ->latest()
   //       ->get()
   //       ->map(function ($item) {

   //          $reward = WalletTransaction::where('user_id', auth()->id())
   //             ->where('type', 'promotion')
   //             ->where('status', 'success')
   //             ->where('description', 'like', '%' . $item->phone . '%')
   //             ->latest()
   //             ->first();

   //          $item->reward_amount = $reward?->amount ?? 0;
   //          $item->reward_status = $reward->status ?? 'cc';

   //          return $item;
   //       });

   //    // Danh sách người đã nạp lần đầu
   //    $paidReferrals = $referrals->filter(function ($item) {
   //       return (bool) $item->has_deposited;
   //    });

   //    // Thưởng ước tính:
   //    // ví dụ tạm tính theo rule hiện tại: mỗi người nạp đầu thì người giới thiệu nhận 10%
   //    // vì schema wallet_transactions hiện chưa có type referral_bonus riêng
   //    // nên ở đây mình chỉ demo giao diện trước
   //    $estimatedReward = 0;

   //    // Nếu Hào đã có logic cộng thưởng vào wallet_transactions bằng admin_adjust
   //    // thì có thể cộng thực tế ở đây, còn không để 0 cho an toàn
   //    $paidReward = WalletTransaction::where('user_id', $user->id)
   //       ->where('type', 'admin_adjust')
   //       ->where('status', 'success')
   //       ->sum('amount');

   //    return view('user.referred.index', [
   //       'user' => $user,
   //       'referrals' => $referrals,
   //       'paidReferrals' => $paidReferrals,
   //       'totalReferred' => $referrals->count(),
   //       'estimatedReward' => $estimatedReward,
   //       'paidReward' => $paidReward,
   //    ]);
   // }


   public function referredBy()
   {
      $user = Auth::user();

      // Danh sách user được giới thiệu bởi tài khoản hiện tại
      $referrals = User::where('referred_by', $user->id)
         ->latest()
         ->get();

      $transactions = WalletTransaction::where('user_id', Auth::id())
         ->whereIn('type', ['promotion'])
         ->latest()
         ->get()
         ->keyBy('transactionable_id');


      $totalTransactions = WalletTransaction::where('user_id', Auth::id())
         ->whereIn('type', ['promotion'])
         ->latest()
         ->get();

      $totalReward = $totalTransactions->sum('amount');

      return view('user.referred.index', compact('referrals', 'transactions', 'totalReward'));
   }


   public function rank()
   {
      $user = Auth::user();

      $userMemberships = UserMembership::with(['membershipPackage.membership'])
         ->where('user_id', $user->id)
         ->orderByDesc('created_at')
         ->get();

      $currentMembership = UserMembership::with(['membershipPackage.membership'])
         ->where('user_id', $user->id)
         ->where('status', 'active')
         ->where('start_date', '<=', now())
         ->where('end_date', '>=', now())
         ->latest('end_date')
         ->first();

      return view('user.rank.index', compact('userMemberships', 'currentMembership'));
   }
}