<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
        ]);
        $userId = auth()->id();
        $postId = $request->post_id;

        $alreadyLiked = Like::where('post_id', $postId)->where('user_id', $userId)->exists();
        if($alreadyLiked) {
            return response()->json(['message' => 'Already liked'], 200);
        }
        Like::create([
            'post_id' => $postId,
            'user_id' => $userId,
        ]);
        return response()->json(['message' => 'Liked'], 201);
    }
    public function destroy(Request $request)
    {
        $request->validate([
            'post_id' => 'request|exists:posts,id'
        ]);

        $userId = auth()->id();
        $postId = $request->post_id;

        $like = Like::where('post_id', $postId)->where('user_id', $userId)->first();

        if($like) {
            $like->delete();
            return response()->json(['message' => 'unliked'], 200);
        }
        return response()->json(['message'=> 'Like not found'], 404);
    }
}
