<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class CommentController extends Controller
{
    public function show($post_id)
    {
        $post = Post::with([
            'post.comments' => fn($q) => $q->latest(),
            'comments.user',
            ])
            ->withCount('likes')
            ->findOrFail($post_id);

        return response()->json([
            'id' => $post->id,
            'username' => $post->user->username,
            'body' => $post->body,
            'likes_count' => $post->likes_count,
            'comments' => $post->comments->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'comment' => $comment->comment,
                    'user' => [
                        'id' => $comment->user->id,
                        'username' => $comment->user->username,
                    ],
                    'create_at' => $comment->created_at,
                ];
            }),
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
           'comment' => 'required|max:120'
        ]);
        $post = Post::findOrFail($request->post_id);
       
        $comment = Comment::create([
            'post_id' => $request->post_id,
            'user_id' => auth()->id(),
           
            'comment' => $request->comment
        ]);
        return response()->json([
            'id' => $comment->id,
            'comment' => $comment->comment,
            'user' => [
                'id' => $comment->user->id,
                'username' => $comment->user->username,
            ],
            'created_at' => $comment->created_at,
        ],201);
    }
}
