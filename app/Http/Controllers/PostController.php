<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::paginate(12);
        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        return view('posts.show', [
            "post" => $post,
            "title" => $post->title,
            "description" => \Illuminate\Support\Str::limit($post->description, 160),
            "tags" => $post->tags,
            "image" => $post->image,
        ]);
    }
}
