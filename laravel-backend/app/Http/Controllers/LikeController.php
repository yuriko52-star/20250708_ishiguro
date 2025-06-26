<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
        ]);
        $userId = auth()->id();
        $postId = $request->post_id;
        $post = POst::find($postId);
        $like = Like::where('post_id', $postId)->where('user_id', $userId)->first();
        if($post->user_id === $userId) {
            return response()->json(['message'=> '自分の投稿にはいいねできません'], 403);
        }
        if ($like) {
            $like->delete();
            return response()->json(['liked' => false, 'message' => 'Unliked']);
        } else {
            Like::create([
                'post_id' => $postId,
                'user_id' => $userId,
            ]);
            return response()->json(['liked' => true, 'message' => 'Liked']);
        }
    }
}