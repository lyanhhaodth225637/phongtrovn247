<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Province;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('status', 'show')
            ->orderBy('created_at', 'asc')
            ->get();

        $baseQuery = $this->basePostQuery($request);

        // thống kê
        $totalPosts = Post::where('status', 'approved')
            ->where('is_visible_admin', true)
            ->where('is_visible_owner', true)
            ->count();

        $totalProvinces = Province::count();

        $newPostsToday = Post::where('status', 'approved')
            ->where('is_visible_admin', true)
            ->where('is_visible_owner', true)
            ->whereDate('created_at', today())
            ->count();

        $totalViewsPerDay = Post::where('status', 'approved')
            ->where('is_visible_admin', true)
            ->where('is_visible_owner', true)
            ->sum('view_count');

        // TAB MỚI NHẤT
        if ($request->sort === 'new') {
            $newPosts = (clone $baseQuery)
                ->orderByDesc('created_at')
                ->paginate(20)
                ->withQueryString();

            return view('frontend.home', compact(
                'categories',
                'newPosts',
                'totalPosts',
                'totalProvinces',
                'newPostsToday',
                'totalViewsPerDay'
            ));
        }

        // TAB ĐỀ XUẤT
        $posts = $this->getPost($request, $baseQuery);

        return view('frontend.home', array_merge(
            compact(
                'categories',
                'totalPosts',
                'totalProvinces',
                'newPostsToday',
                'totalViewsPerDay'
            ),
            $posts
        ));
    }

    public function getPost(Request $request, $baseQuery = null)
    {
        $baseQuery = $baseQuery ?? $this->basePostQuery($request);

        return [
            'postVip5' => $this->buildPostQuery('de-xuat', $baseQuery)->limit(8)->get(),
            'postVip4' => $this->buildPostQuery('noi-bat', $baseQuery)->limit(8)->get(),
            'postVip1' => $this->buildPostQuery('thuong', $baseQuery)->limit(8)->get(),

        ];
    }

    //lấy bài tất cả viết theo vip

    private function basePostQuery(Request $request)
    {
        $query = Post::with(['images', 'ward.province', 'category', 'membership', 'user', 'amenities'])
            ->where('status', 'approved')
            ->where('is_visible_admin', true)
            ->where('is_visible_owner', true)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });

        // 1. Danh mục theo slug
        if ($request->filled('category')) {
            $categorySlug = $request->category;

            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // 2. Tỉnh/Thành
        if ($request->filled('province')) {
            $provinceId = $request->province;

            $query->whereHas('ward', function ($q) use ($provinceId) {
                $q->where('province_id', $provinceId);
            });
        }

        // 3. Phường/Xã
        if ($request->filled('ward')) {
            $query->where('ward_id', $request->ward);
        }

        // 4. Khoảng giá
        if ($request->filled('price') && $request->price !== 'all') {
            switch ($request->price) {
                case 'Dưới 1 triệu':
                    $query->where('price', '<', 1000000);
                    break;

                case '1 - 2 triệu':
                    $query->whereBetween('price', [1000000, 2000000]);
                    break;

                case '2 - 3 triệu':
                    $query->whereBetween('price', [2000000, 3000000]);
                    break;

                case '3 - 5 triệu':
                    $query->whereBetween('price', [3000000, 5000000]);
                    break;

                case '5 - 7 triệu':
                    $query->whereBetween('price', [5000000, 7000000]);
                    break;

                case '7 - 10 triệu':
                    $query->whereBetween('price', [7000000, 10000000]);
                    break;

                case 'Trên 10 triệu':
                    $query->where('price', '>', 10000000);
                    break;
            }
        }

        // 5. Diện tích
        if ($request->filled('area') && $request->area !== 'all') {
            switch ($request->area) {
                case 'Dưới 20m²':
                    $query->where('area', '<', 20);
                    break;

                case '20 - 30m²':
                    $query->whereBetween('area', [20, 30]);
                    break;

                case '30 - 50m²':
                    $query->whereBetween('area', [30, 50]);
                    break;

                case '50 - 70m²':
                    $query->whereBetween('area', [50, 70]);
                    break;

                case 'Trên 70m²':
                    $query->where('area', '>', 70);
                    break;
            }
        }

        // 6. Tiện ích
        if ($request->filled('amenities')) {
            $amenitySlugs = array_filter(explode(',', $request->amenities));

            foreach ($amenitySlugs as $slug) {
                $query->whereHas('amenities', function ($q) use ($slug) {
                    $q->where('slug', $slug);
                });
            }
        }

        return $query;
    }

    private function buildPostQuery($vipSlug, $baseQuery)
    {
        return (clone $baseQuery)
            ->whereHas('membership', fn($q) => $q->where('slug', $vipSlug))
            ->orderByRaw('COALESCE(pushed_at, created_at) DESC');
    }

    private function buildFreePostQuery($baseQuery)
    {
        return (clone $baseQuery)
            ->whereDoesntHave('membership')
            ->orderByRaw('COALESCE(pushed_at, created_at) DESC');
    }

    public function show($id, $slug = null)
    {
        $post = Post::with([
            'images',
            'amenities',
            'ward.province',
            'category',
            'user',
            'membership',
            'postModerations' => function ($q) {
                $q->latest();
            }
        ])
            ->where('status', 'approved')
            ->where('is_visible_admin', true)
            ->where('is_visible_owner', true)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->findOrFail($id);

        $post->increment('view_count');
        $post->refresh();

        $relatedPosts = Post::with(['images', 'ward', 'membership'])
            ->where('id', '!=', $post->id)
            ->where('status', 'approved')
            ->where('is_visible_admin', true)
            ->where('is_visible_owner', true)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->whereHas('ward', function ($q) use ($post) {
                $q->where('province_id', $post->ward->province_id);
            })
            ->orderByRaw('COALESCE(pushed_at, created_at) DESC')
            ->limit(6)
            ->get();

        return view('frontend.show', compact('post', 'relatedPosts'));
    }

    public function allPost(Request $request)
    {
        $type = $request->route('type')
            ?? $request->route()->defaults['type']
            ?? 'normal';

        $posts = $this->basePostQuery($request);

        // Bài viết đề xuất
        if ($type === 'suggest') {
            $posts = $posts
                ->whereHas('membership', function ($q) {
                    $q->where('priority', '=', 50); // VIP 4, VIP 5
                })
                ->orderByRaw('COALESCE(pushed_at, created_at) DESC');
        }

        // Bài viết nổi bật
        elseif ($type === 'featured') {
            $posts = $posts
                ->whereHas('membership', function ($q) {
                    $q->where('priority', '=', 40); // VIP 4, VIP 5
                })
                ->orderByRaw('COALESCE(pushed_at, created_at) DESC');
        }

        // Bài viết thường
        else {
            $posts = $posts
                ->whereNull('membership_id')
                ->orderByDesc('created_at');
        }

        $posts = $posts->paginate(20)->withQueryString();

        return view('frontend.all-post', [
            'posts' => $posts,
            'type' => $type,
            'title' => match ($type) {
                'suggest' => 'Bài viết đề xuất',
                'featured' => 'Bài viết nổi bật',
                default => 'Bài viết thường',
            }
        ]);
    }
}
