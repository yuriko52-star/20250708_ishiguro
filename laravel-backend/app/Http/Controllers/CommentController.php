<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class CommentController extends Controller
{
    public function show($postId)
    {
        $post = Post::with(['comments.user' => fn($q) => $q->latest()])->findOrFail($postId);

        return response()->json($post->comments);
    }
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
           
            'comment' => 'required|max:120'
        ]);
        $comment = Comment::create([
            'post_id' => $request->post_id,
            'user_id' => auth()->id(),
           
            'comment' => $request->comment
        ]);
        return response()->json($comment->load('user'), 201);
    }
}
