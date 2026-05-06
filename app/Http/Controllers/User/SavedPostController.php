<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedPostController extends Controller
{

    public function index()
    {
        $savedPosts = auth()->user()
            ->savedPosts()
            ->with([
                'images',
                'ward.province',
                'category',
                'membership',
                'user'
            ])
            ->where('status', 'approved')
            ->where('is_visible_admin', true)
            ->where('is_visible_owner', true)
            ->latest('saved_posts.created_at')
            ->paginate(12);

        return view('frontend.saved-post', compact('savedPosts'));
    }
    public function store($id)
    {
        // dd("vào đây");
        $user = Auth::user();

        $post = Post::where('id', $id)
            ->where('status', 'approved')
            ->where('is_visible_admin', true)
            ->where('is_visible_owner', true)
            ->firstOrFail();

        $alreadySaved = $user->savedPosts()->where('post_id', $post->id)->exists();

        if ($alreadySaved) {
            $user->savedPosts()->detach($post->id);

            return back()->with('success', 'Đã bỏ lưu bài viết "' . $post->title . '" thành công');
        }

        $user->savedPosts()->attach($post->id);

        return back()->with('success', 'Đã lưu bài viết "' . $post->title . '" thành công.');
    }
}