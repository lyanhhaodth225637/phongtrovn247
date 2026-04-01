<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostModeration;
use App\Models\Post;

class PostModerationController extends Controller
{
    public function reject(Request $request, $id)
    {
        $data = $request->validate([
            'reason_type' => 'required',
            'reason_detail' => 'nullable|string'
        ]);

        $post = Post::findOrFail($id);

        PostModeration::create([
            'post_id' => $post->id,
            'action' => 'rejected',
            'reason_type' => $data['reason_type'],
            'reason_detail' => $data['reason_detail'],
            'user_id' => auth()->id(),
        ]);

 
        $post->update([
            'status' => 'rejected'
        ]);

        return back()->with('success', 'Đã từ chối bài');
    }
}
