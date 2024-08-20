<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        return view("authors.index", [
            "authors" => Author::withCount('books')->orderBy('books_count', 'desc')->paginate(20),
            "title" => __("Popular Authors")
        ]);
    }

    public function show(Author $author){
        $books = $author->books()->paginate(18);
        $title = str_replace(":attr", $author->full_name, app('site')->site_options['author_title']);
        return view('authors.show', compact('author', 'books', 'title'));
    }
}
