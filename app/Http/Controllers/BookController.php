<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Models\Comment;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

class BookController extends Controller
{


    public function index(){
        return view("books.list");
    }

    public function books(){
         return view('home', [
            'books' => Book::with(['author', 'category'])
                ->whereHas('language', fn(Builder $query) => ($query->where('code', app()->getLocale())))
                ->latest()->paginate(30)
        ]);
    }


    public function show(Book $book){
        !$book->is_public && abort(403);
        return view("books.show", [
            "book" => $book,
            "title" => str_replace(":attr", $book->name, app('site')->site_options['book_title']),
            "description" => \Illuminate\Support\Str::limit($book->description, 160),
            "tags" => $book->tags,
            "author" => $book->author->full_name,
            "image" => $book->image,
            "rating" => Comment::where("book_id", $book->id)->avg('stars')
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'title' => 'nullable|string|max:150',
            'user_id' => 'required|exists:users,id',
            'author_id' => 'nullable|exists:authors,id',
            'book_category_id' => 'nullable|exists:book_categories,id',
            'language_id' => 'nullable|exists:languages,id',
            'pages' => 'nullable|integer',
            'size' => 'nullable|string|max:100',
            'type' => 'nullable|string|max:10',
            'image' => 'nullable|string',
            'description' => 'nullable|string',
            'body' => 'nullable|string',
            'tags' => 'nullable|string|max:500',
            'file' => 'nullable|string',
            'is_public' => 'boolean',
            'slug' => 'nullable|string|unique:books,slug',
        ]);

        $book = Book::create([
            'name' => $request->name,
            'title' => $request->title,
            'user_id' => $request->user_id,
            'author_id' => $request->author_id,
            'book_category_id' => $request->book_category_id,
            'language_id' => $request->language_id,
            'pages' => $request->pages,
            'size' => $request->size,
            'type' => $request->type,
            'image' => $request->image,
            'description' => $request->description,
            'body' => $request->body,
            'tags' => $request->tags,
            'file' => $request->file,
            'is_public' => $request->is_public,
            'slug' => $request->slug,
        ]);

        return response()->json($book, 201);
    }




    public function api_list(){
        return BookResource::collection(Book::where('is_public', true)->paginate(20));
    }

    public function api_show(Book $book)
    {
        return BookResource::make($book);
    }
}
