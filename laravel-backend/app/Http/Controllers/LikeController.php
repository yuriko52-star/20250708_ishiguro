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
        $user_id = auth()->id();
        $post_id = $request->post_id;
        $post = POst::find($post_id);
        $like = Like::where('post_id', $post_id)->where('user_id', $user_id)->first();
        if($post->user_id === $user_id) {
            return response()->json(['message'=> '自分の投稿にはいいねできません'], 403);
        }
        if ($like) {
            $like->delete();
            return response()->json(['liked' => false, 'message' => 'Unliked']);
        } else {
            Like::create([
                'post_id' => $post_id,
                'user_id' => $user_id,
            ]);
            return response()->json(['liked' => true, 'message' => 'Liked']);
        }
    }
}