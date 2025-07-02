<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::withCount('likes')
         ->with(['user', 'comments' => fn($q) => $q->latest()])
         ->latest()
         ->get();

         return response()->json(
            $posts->map(function ($post) {
                return [
                    'id' => $post->id,
                    'username' => $post->user->username,
                    'body' => $post->body,
                    'likes_count' => $post->likes_count,
                    
                    'comments' => $post->comments,
                ];
                
            }));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|max:20',
            'body' => 'required|max:120'
        ]);

        $post = Post::create([
            'user_id' => auth()->id(),
            'username' => $request->username,
            'body' => $request->body,
        ]);
        return response()->json($post, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::with(['comments' => fn($q) => $q->latest()->with('user')])
            ->with('user')
            ->withCount('likes')
            ->findOrFail($id);

          return response()->json([
            'id' => $post->id,
            'username' => $post->user->username,
            'body' => $post->body,
            'likes_count' => $post->likes_count,
            'comments' => $post->comments->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'comment' => $comment->comment,
                    'username' => $comment->user->username,
                ];
            }),
          ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        
        if($post->user_id !== auth()->id()) {
            return response()->json(['error' =>'Unauthorized'],403);
        }

        $post->delete();
        return response()->json(['message' => 'Deleted'], 200);
    }
}
