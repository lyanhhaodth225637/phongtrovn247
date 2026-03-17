<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Province;
use App\Models\Amenity;
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
      DB::beginTransaction();
      try {
         $request->validate([
            
         ]);

      } catch (\Throwable $e) {
         DB::rollBack();
         return back()->with('error', 'Có lỗi xảy ra, đăng tin thất bại');
      }
   }
}
