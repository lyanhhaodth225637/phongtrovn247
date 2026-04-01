<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\Amenity;
use App\Models\Category;
use App\Models\Post;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::query();
        if ($request->sort == 'new') {
            $query->latest();
            $posts = $query->get();

            return view('frontend.new_post', compact('posts'));
        }

        $posts = $this->getPost();
        return view('frontend.home', $posts);
    }
    public function getPost()
    {
        return [
            'postVip5' => Post::with(['images', 'ward', 'category', 'membership', 'user'])
                ->whereHas('membership', fn($q) => $q->where('slug', 'vip-5'))
                ->where('status', 'approved')
                ->where('is_visible_admin', true)
                ->where('is_visible_owner', true)
                ->orderByRaw('COALESCE(pushed_at, created_at) DESC')
                ->limit(8)
                ->get(),

            'postVip4' => Post::whereHas('membership', fn($q) => $q->where('slug', 'vip-4'))
                ->where('status', 'approved')
                ->orderByDesc('pushed_at')
                ->limit(1)
                ->get(),

            'postVip3' => Post::whereHas('membership', fn($q) => $q->where('slug', 'vip-3'))
                ->where('status', 'approved')
                ->orderByDesc('pushed_at')
                ->limit(8)
                ->get(),

            'postVip2' => Post::whereHas('membership', fn($q) => $q->where('slug', 'vip-2'))
                ->where('status', 'approved')
                ->orderByDesc('pushed_at')
                ->limit(8)
                ->get(),

            'postVip1' => Post::whereHas('membership', fn($q) => $q->where('slug', 'vip-1'))
                ->where('status', 'approved')
                ->orderByDesc('pushed_at')
                ->limit(8)
                ->get(),

            'postFree' => Post::whereDoesntHave('membership')
                ->where('status', 'approved')
                ->latest()
                ->limit(8)
                ->get(),
        ];
    }




    public function new_post()
    {
        return view('frontend.new_post');
    }


    public function category_show(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)
            ->where('status', 'show')
            ->firstOrFail();

        $query = $category->posts();

        if ($request->sort == 'new') {
            $query->latest();
        }

        $posts = $query->get();

        return view('frontend.category.index', compact('category', 'posts'));
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

      return view('frontend.show', compact('post'));
   }
}