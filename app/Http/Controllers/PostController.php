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

        $search_query = request()->query('q');
        if($search_query){
            $posts = Post::where("site_id", $site->id)
                ->where('language_id', app('site')->language_id)
                ->where('title', $search_query)
                ->orWhere('title', 'like', '%' . $search_query . '%')
                ->orWhere('tags', 'like', '%' . $search_query . '%')
                ->orderByRaw("
                    CASE
                        WHEN title LIKE ? THEN 1
                        WHEN description LIKE ? THEN 2
                        ELSE 3
                    END
                ", ['%' . $search_query . '%', '%' . $search_query . '%'])
                ->paginate(20);
        }else{
            $posts = Post::where("site_id", $site->id)
                ->where('language_id', app('site')->language_id)
                ->paginate(20);
        }


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
