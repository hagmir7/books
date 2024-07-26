<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Site;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $domain = str_replace('www.', '', request()->getHost());
        $site = Site::where('domain', $domain)->firstOrFail();
        $posts = Post::where("site_id", $site->id)->paginate(15);
        return view('posts.index', [
            'posts' => $posts,
            'title' => __("Book News and Literary Delights")
        ]);
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
