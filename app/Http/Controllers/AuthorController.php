<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Parsedown;

class AuthorController extends Controller
{


    public function generate($author)
    {
        $response = Http::get('https://api.facepy.com/en/ai?author=' . $author->full_name);
        if ($response->successful()) {
            $parsedown = new Parsedown();
            $description = $parsedown->text($response->json()['message']);

            $author->description = $description;
            $author->save();
        } else {
            abort($response->status(), 'Error fetching JSON file.');
        }
    }


    public function index()
    {
        return view("authors.index", [
            "authors" => Author::withCount('books')->where('verified', true)->orderBy('books_count', 'desc')->paginate(24),
            "title" => __("Popular Authors")
        ]);
    }

    public function show(Author $author)
    {
        !$author->verified && abort(404);

        if (!$author->description) {
            $this->generate($author);
        }

        $books = $author->books()
            ->with(['category', 'author'])
            ->where('verified', true)
            ->whereNull('copyright_date')
            ->where('is_public')
            ->paginate(18);

        $title = str_replace(":attr", $author->full_name, app('site')->site_options['author_title']);

        return view('authors.show', compact('author', 'books', 'title'));
    }
}
