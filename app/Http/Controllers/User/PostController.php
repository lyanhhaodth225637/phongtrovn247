<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Amenity;
use App\Models\Province;
use App\Models\Post;
use App\Models\UserMembership;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Notifications\NewPostPendingApprovalNotification;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PostApprovedNotification;
use App\Models\Ward;
use Illuminate\Support\Facades\Storage;
use App\Models\WalletTransaction;


class PostController extends Controller
{
   public function index(Request $request)
   {
      $activeStatus = $request->input('status', 'all');
      $keyword = trim($request->input('q', ''));
      $currentUserMembership = UserMembership::with('membershipPackage.membership')
         ->where('user_id', auth()->id())
         ->where('status', 'active')
         ->where('end_date', '>', now())
         ->latest('end_date')
         ->first();

      $query = Post::with(['category', 'ward.province', 'membership', 'images'])
         ->where('user_id', auth()->id())
         ->latest();

      // Filter theo tab
      if ($activeStatus === 'hidden') {
         $query->where('is_visible_owner', 0);
      } elseif ($activeStatus !== 'all') {
         $query->where('status', $activeStatus)
            ->where('is_visible_owner', 1);
      }

      // Filter theo keyword
      if ($keyword !== '') {
         $query->where(function ($q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
               ->orWhere('address', 'like', "%{$keyword}%")
               ->orWhere('id', $keyword);
         });
      }

      $posts = $query->paginate(10)->withQueryString();

      // Stats tính trên toàn bộ post của user, không bị ảnh hưởng bởi filter
      $allPosts = Post::where('user_id', auth()->id())->get();

      $stats = [
         'all' => $allPosts->count(),
         'approved' => $allPosts->where('status', 'approved')->where('is_visible_owner', 1)->count(),
         'pending' => $allPosts->where('status', 'pending')->count(),
         'rejected' => $allPosts->where('status', 'rejected')->count(),
         'hidden' => $allPosts->where('is_visible_owner', 0)->count(),
      ];

      return view('user.post.index', compact('posts', 'stats', 'activeStatus', 'keyword', 'currentUserMembership'));
   }

   public function create()
   {
      $categories = Category::orderBy('name', 'asc')->get();
      $provinces = Province::orderBy('name', 'asc')->get();
      $amenities = Amenity::orderBy('name', 'asc')->get();
      return view('user.post.create', compact('categories', 'provinces', 'amenities'));
   }

   public function store(Request $request)
   {
      $data = $request->validate([
         'category_id' => 'required|exists:categories,id',
         'ward_id' => 'required|exists:wards,id',
         'title' => 'required|min:30|max:100',
         'description' => 'required|min:50',
         'price' => 'required|numeric|min:0',
         'price_unit' => 'required|in:month,day',
         'area' => 'required|integer|min:1',
         'address' => 'required|string',
         'latitude' => 'nullable|numeric',
         'longitude' => 'nullable|numeric',
         'amenities' => 'nullable|array',
         'amenities.*' => 'exists:amenities,id',
         'images' => 'required|array|max:10',
         'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:10240',
         'contact_name' => 'required|max:100',
         'contact_phone' => 'required|regex:/^[0-9]{9,11}$/'
      ]);

      DB::beginTransaction();

      try {
         $user = Auth::user();

         // Lấy gói active hiện tại của user
         $activeUserMembership = UserMembership::with('membershipPackage.membership')
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->where('end_date', '>', now())
            ->latest('end_date')
            ->first();


         // membership_id của bài đăng sẽ lấy từ membership của gói active
         $membershipId = $activeUserMembership?->membershipPackage?->membership_id;

         // Có thể cho bài đăng hết hạn theo thời gian hết hạn gói user đang dùng
         $expiresAt = $activeUserMembership?->end_date;

         // 1. Tạo post
         $post = Post::create([
            'user_id' => $user->id,
            'category_id' => $data['category_id'],
            'ward_id' => $data['ward_id'],
            'membership_id' => $membershipId,

            'title' => $data['title'],
            'slug' => Str::slug($data['title']) . '-' . time(),

            'description' => $data['description'],

            'price' => $data['price'],
            'price_unit' => $data['price_unit'],
            'area' => $data['area'],

            'address' => Str::ucwords($data['address']),
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],

            'status' => 'pending',
            'view_count' => 0,

            'is_visible_admin' => true,
            'is_visible_owner' => true,

            'expires_at' => $expiresAt,
         ]);

         // 2. Lưu tiện ích
         if (!empty($data['amenities'])) {
            $post->amenities()->sync($data['amenities']);
         }

         // 3. Upload ảnh
         foreach ($request->file('images') as $index => $file) {
            $path = $file->store('posts', 'public');

            $post->images()->create([
               'image' => $path,
               'sort_order' => $index,
               'is_thumbnail' => $index === 0,
            ]);
         }
         $post->load('user');

         DB::commit();

         // gửi thông báo cho admin
         $admins = User::role('admin')->get();
         Notification::send($admins, new NewPostPendingApprovalNotification($post));
         return redirect()
            ->route('user.post.index')
            ->with('success', 'Đăng bài thành công, chờ duyệt');


      } catch (\Throwable $e) {
         DB::rollBack();

         return back()
            ->withInput()
            ->with('error', $e->getMessage());
      }
   }


   //sửa
   public function edit($id)
   {
      $post = Post::with(['images', 'amenities', 'ward.province'])
         ->where('user_id', auth()->id())
         ->findOrFail($id);

      $categories = Category::orderBy('name', 'asc')->get();
      $provinces = Province::orderBy('name', 'asc')->get();
      $amenities = Amenity::orderBy('name', 'asc')->get();

      $wards = collect();

      if ($post->ward && $post->ward->province_id) {
         $wards = Ward::where('province_id', $post->ward->province_id)
            ->orderBy('name', 'asc')
            ->get();
      }

      $postAmenities = $post->amenities->pluck('id')->toArray();

      return view('user.post.edit', compact(
         'post',
         'amenities',
         'categories',
         'provinces',
         'wards',
         'postAmenities'
      ));
   }

   public function update(Request $request, $id, $slug)
   {
      $post = Post::with(['images', 'amenities'])
         ->where('user_id', auth()->id())
         ->findOrFail($id);

      $data = $request->validate([
         'category_id' => 'required|exists:categories,id',
         'ward_id' => 'required|exists:wards,id',

         'title' => 'required|string|min:30|max:100',
         'description' => 'required|string|min:50',

         'price' => 'required|numeric|min:0',
         'price_unit' => 'required|in:month,day',
         'area' => 'required|numeric|min:1',

         'address' => 'required|string',

         'latitude' => 'nullable|numeric',
         'longitude' => 'nullable|numeric',

         'amenities' => 'nullable|array',
         'amenities.*' => 'exists:amenities,id',

         'images' => 'nullable|array|max:10',
         'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:10240',

         'delete_images' => 'nullable|array',
         'delete_images.*' => 'integer',

         'old_thumbnail_id' => 'nullable|integer',

         'contact_name' => 'nullable|max:100',
         'contact_phone' => 'nullable|regex:/^[0-9]{9,11}$/',
      ]);

      DB::beginTransaction();

      try {
         $newSlug = $post->slug;

         if ($post->title !== $data['title']) {
            $baseSlug = Str::slug($data['title']);
            $newSlug = $baseSlug;

            $exists = Post::where('slug', $newSlug)
               ->where('id', '!=', $post->id)
               ->exists();

            if ($exists) {
               $newSlug = $baseSlug . '-' . time();
            }
         }

         $post->update([
            'category_id' => $data['category_id'],
            'ward_id' => $data['ward_id'],

            'title' => $data['title'],
            'slug' => $newSlug,

            'description' => $data['description'],

            'price' => $data['price'],
            'price_unit' => $data['price_unit'],
            'area' => $data['area'],

            'address' => Str::ucwords($data['address']),
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,

            // sửa xong phải duyệt lại
            'status' => 'pending',
            'approved_by' => null,
            'approved_at' => null,
            'admin_note' => null,

            // cho hiện lại ở cả admin và chủ bài
            'is_visible_admin' => true,
            'is_visible_owner' => true,
         ]);

         // cập nhật tiện ích
         $post->amenities()->sync($data['amenities'] ?? []);

         // xóa ảnh được tick xóa
         if (!empty($data['delete_images'])) {
            $imagesToDelete = $post->images()
               ->whereIn('id', $data['delete_images'])
               ->get();

            foreach ($imagesToDelete as $image) {
               if ($image->image && Storage::disk('public')->exists($image->image)) {
                  Storage::disk('public')->delete($image->image);
               }
               $image->delete();
            }
         }

         // thêm ảnh mới
         if ($request->hasFile('images')) {
            $currentMaxSort = (int) ($post->images()->max('sort_order') ?? 0);

            foreach ($request->file('images') as $index => $file) {
               $path = $file->store('posts', 'public');

               $post->images()->create([
                  'image' => $path,
                  'sort_order' => $currentMaxSort + $index + 1,
                  'is_thumbnail' => false,
               ]);
            }
         }

         // cập nhật lại thumbnail
         $post->load('images');

         if ($post->images->count() > 0) {
            $post->images()->update(['is_thumbnail' => false]);

            if (!empty($data['old_thumbnail_id'])) {
               $thumbnail = $post->images()->where('id', $data['old_thumbnail_id'])->first();

               if ($thumbnail) {
                  $thumbnail->update(['is_thumbnail' => true]);
               } else {
                  $post->images()->orderBy('sort_order')->first()?->update(['is_thumbnail' => true]);
               }
            } else {
               $post->images()->orderBy('sort_order')->first()?->update(['is_thumbnail' => true]);
            }
         }

         $post->load('user');

         DB::commit();

         // gửi thông báo cho admin
         $admins = User::role('admin')->get();
         Notification::send($admins, new NewPostPendingApprovalNotification($post));

         return redirect()
            ->route('user.post.index')
            ->with('success', 'Cập nhật bài đăng thành công, bài viết đã được gửi duyệt lại.');

      } catch (\Throwable $e) {
         DB::rollBack();

         return back()
            ->withInput()
            ->with('error', $e->getMessage());
      }
   }

   public function pushPost($id)
   {
      $post = Post::with('membership')
         ->where('id', $id)
         ->where('user_id', Auth::id())
         ->firstOrFail();

      // Chỉ gói đề xuất mới được đẩy
      if (!$post->membership || $post->membership->slug !== 'de-xuat') {
         return back()->with('error', 'Chỉ bài đăng gói đề xuất mới được phép đẩy tin.');
      }

      // Chỉ cho đẩy 1 lần / 24 giờ
      if ($post->pushed_at && $post->pushed_at->copy()->addDay()->isFuture()) {
         return back()->with(
            'error',
            'Bạn chỉ có thể đẩy lại tin sau: ' .
            $post->pushed_at->copy()->addDay()->format('d/m/Y H:i')
         );
      }

      $pushPrice = 10000;
      $user = Auth::user();

      // Kiểm tra số dư ví
      if ($user->balance < $pushPrice) {
         return back()->with('error', 'Số dư ví không đủ để đẩy tin. Bạn cần tối thiểu 10.000đ.');
      }

      try {
         DB::transaction(function () use ($user, $post, $pushPrice) {
            $before = $user->balance;
            $after = $before - $pushPrice;

            // Trừ tiền
            $user->update([
               'balance' => $after,
            ]);

            // Cập nhật bài viết
            $post->update([
               'pushed_at' => now(),
               'push_count' => $post->push_count + 1,
            ]);

            // Ghi lịch sử giao dịch
            WalletTransaction::create([
               'user_id' => $user->id,
               'transaction_code' => 'PUSH' . now()->format('YmdHis') . rand(100, 999),
               'type' => 'push_post',
               'amount' => $pushPrice,
               'balance_before' => $before,
               'balance_after' => $after,
               'status' => 'success',
               'description' => 'Đẩy tin: ' . $post->title,
               'transactionable_type' => Post::class,
               'transactionable_id' => $post->id,
               'processed_at' => now(),
            ]);
         });

         return back()->with('success', 'Đẩy tin thành công. Hệ thống đã trừ 10.000đ từ ví của bạn.');
      } catch (\Throwable $e) {
         return back()->with('error', 'Có lỗi xảy ra khi đẩy tin.');
      }
   }

   public function repost($id)
   {
      $post = Post::with([
         'images',
         'amenities',
         'ward.province',
         'membership',
      ])
         ->where('user_id', auth()->id())
         ->findOrFail($id);



      // lấy gói hiện tại của user
      $currentMembership = UserMembership::with('membershipPackage.membership')
         ->where('user_id', auth()->id())
         ->where('status', 'active')
         ->where('end_date', '>', now())
         ->latest('end_date')
         ->first();

      if (!$currentMembership) {
         return redirect()
            ->route('user.post.index')
            ->with('error', 'Bạn chưa có gói dịch vụ đang hoạt động để đăng lại bài.');
      }

      $categories = Category::orderBy('name')->get();
      $provinces = Province::orderBy('name')->get();
      $amenities = Amenity::orderBy('name')->get();

      $wards = collect();

      if ($post->ward?->province_id) {
         $wards = Ward::where('province_id', $post->ward->province_id)
            ->orderBy('name')
            ->get();
      }

      $postAmenities = $post->amenities->pluck('id')->toArray();

      return view('user.post.repost', compact(
         'post',
         'categories',
         'provinces',
         'amenities',
         'wards',
         'postAmenities',
         'currentMembership'
      ));
   }
   public function repostStore(Request $request, $id, $slug)
   {
      $post = Post::with(['images', 'amenities', 'user'])
         ->where('user_id', auth()->id())
         ->findOrFail($id);

      $data = $request->validate([
         'category_id' => 'required|exists:categories,id',
         'ward_id' => 'required|exists:wards,id',

         'title' => 'required|string|min:30|max:100',
         'description' => 'required|string|min:50',

         'price' => 'required|numeric|min:0',
         'price_unit' => 'required|in:month,day',
         'area' => 'required|numeric|min:1',

         'address' => 'required|string',
         'latitude' => 'nullable|numeric',
         'longitude' => 'nullable|numeric',

         'amenities' => 'nullable|array',
         'amenities.*' => 'exists:amenities,id',

         'images' => 'nullable|array|max:10',
         'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:10240',

         'delete_images' => 'nullable|array',
         'delete_images.*' => 'integer',

         'old_thumbnail_id' => 'nullable|integer',
      ]);

      DB::beginTransaction();

      try {

         // lấy gói hiện tại của user
         $currentMembership = UserMembership::with('membershipPackage.membership')
            ->where('user_id', auth()->id())
            ->where('status', 'active')
            ->where('end_date', '>', now())
            ->latest('end_date')
            ->first();

         if (!$currentMembership) {
            return back()
               ->withInput()
               ->with('error', 'Bạn không có gói dịch vụ đang hoạt động để đăng lại bài.');
         }

         $membership = $currentMembership->membershipPackage->membership;

         // tạo slug mới nếu đổi tiêu đề
         $newSlug = $post->slug;

         if ($post->title !== $data['title']) {
            $baseSlug = Str::slug($data['title']);
            $newSlug = $baseSlug;

            if (
               Post::where('slug', $newSlug)
                  ->where('id', '!=', $post->id)
                  ->exists()
            ) {
               $newSlug .= '-' . time();
            }
         }

         // cập nhật bài đăng
         $post->update([
            'membership_id' => $membership->id,

            'category_id' => $data['category_id'],
            'ward_id' => $data['ward_id'],

            'title' => $data['title'],
            'slug' => $newSlug,
            'description' => $data['description'],

            'price' => $data['price'],
            'price_unit' => $data['price_unit'],
            'area' => $data['area'],

            'address' => Str::ucwords($data['address']),
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,

            // đăng lại bài
            'status' => 'pending',
            'expires_at' => $currentMembership->end_date,
            'pushed_at' => now(),
            'push_count' => 0,

            // reset trạng thái duyệt
            'approved_by' => null,
            'approved_at' => null,
            'admin_note' => null,

            // bật lại hiển thị
            'is_visible_admin' => true,
            'is_visible_owner' => true,
         ]);

         // cập nhật tiện ích
         $post->amenities()->sync($data['amenities'] ?? []);

         // xóa ảnh
         if (!empty($data['delete_images'])) {
            $imagesToDelete = $post->images()
               ->whereIn('id', $data['delete_images'])
               ->get();

            foreach ($imagesToDelete as $image) {
               if ($image->image && Storage::disk('public')->exists($image->image)) {
                  Storage::disk('public')->delete($image->image);
               }

               $image->delete();
            }
         }

         // thêm ảnh mới
         if ($request->hasFile('images')) {
            $currentMaxSort = (int) ($post->images()->max('sort_order') ?? 0);

            foreach ($request->file('images') as $index => $file) {
               $path = $file->store('posts', 'public');

               $post->images()->create([
                  'image' => $path,
                  'sort_order' => $currentMaxSort + $index + 1,
                  'is_thumbnail' => false,
               ]);
            }
         }

         // cập nhật thumbnail
         $post->load('images');

         if ($post->images->count()) {
            $post->images()->update(['is_thumbnail' => false]);

            $thumbnail = null;

            if (!empty($data['old_thumbnail_id'])) {
               $thumbnail = $post->images()
                  ->where('id', $data['old_thumbnail_id'])
                  ->first();
            }

            if (!$thumbnail) {
               $thumbnail = $post->images()
                  ->orderBy('sort_order')
                  ->first();
            }

            $thumbnail?->update([
               'is_thumbnail' => true
            ]);
         }

         DB::commit();

         // gửi thông báo cho admin duyệt lại
         $admins = User::role('admin')->get();

         Notification::send(
            $admins,
            new NewPostPendingApprovalNotification($post)
         );

         return redirect()
            ->route('user.post.index')
            ->with(
               'success',
               'Đăng lại bài thành công. Bài viết đã được gắn lại gói "' .
               $membership->name .
               '" và gửi duyệt lại.'
            );

      } catch (\Throwable $e) {
         DB::rollBack();

         return back()
            ->withInput()
            ->with('error', $e->getMessage());
      }
   }


   public function hidePost($id)
   {
      $post = Post::where('user_id', auth()->id())
         ->findOrFail($id);

      // Không cho ẩn nếu bài đã ẩn rồi
      if (!$post->is_visible_owner) {
         return back()->with('error', 'Bài viết này đã được ẩn trước đó.');
      }

      $post->update([
         'is_visible_owner' => false,
      ]);

      return back()->with('success', 'Đã ẩn bài viết thành công.');
   }

   public function showPost($id)
   {
      $post = Post::where('user_id', auth()->id())
         ->findOrFail($id);

      // Không cho hiện nếu bài đang hiện
      if ($post->is_visible_owner) {
         return back()->with('error', 'Bài viết này đang được hiển thị.');
      }

      // Nếu bài hết hạn thì không cho hiện lại
      if ($post->status === 'expired') {
         return back()->with('error', 'Bài viết đã hết hạn, vui lòng đăng lại bài.');
      }

      $post->update([
         'is_visible_owner' => true,
      ]);

      return back()->with('success', 'Đã hiển thị lại bài viết.');
   }


}
