<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Province;
use App\Models\Amenity;
use App\Models\PostModeration;
use App\Models\Post;

class PostController extends Controller
{
   public function index()
   {
      $posts = Post::orderBy('created_at', 'asc')->get();
      return view('admin.post.index', compact('posts'));
   }

   public function create()
   {
      $categories = Category::orderBy('name', 'asc')->get();
      $provinces = Province::orderBy('name', 'asc')->get();
      $amenities = Amenity::orderBy('name', 'asc')->get();
      return view('admin.post.create', compact('categories', 'provinces', 'amenities'));
   }

   public function store(Request $request)
   {
      $data = $request->validate([
         'category' => 'required|exists:categories,id',
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

         'images' => 'required|array|max:20',
         'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:10240',

         'contact_name' => 'required|max:100',
         'contact_phone' => 'required|regex:/^[0-9]{9,11}$/'
      ]);


      DB::beginTransaction();

      try {

         // 1. Tạo post
         $post = Post::create([
            'user_id' => Auth::id(),
            'category_id' => $data['category'],
            'ward_id' => $data['ward_id'],

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
               'is_thumbnail' => $index === 0
            ]);
         }
         DB::commit();
         return redirect()->route('admin.post')
            ->with('success', 'Đăng bài thành công, chờ duyệt');

      } catch (\Exception $e) {
         DB::rollBack();
         return back()->with('error', $e->getMessage());
      }
   }

   public function show($id)
   {
      $post = Post::with([
         'images',
         'amenities',
         'ward',
         'category',
         'user',
         'postModerations' => function ($q) {
            $q->latest(); // orderBy created_at desc
         }
      ])->findOrFail($id);

      return view('admin.post.show', compact('post'));
   }


   //duyệt bài
   public function approved(string $id)
   {
      $post = Post::findOrFail($id);
      $post->update([
         'status' => 'approved'
      ]);

      return redirect()->route('admin.post')->with('success', 'Duyệt thành công');
   }
}
