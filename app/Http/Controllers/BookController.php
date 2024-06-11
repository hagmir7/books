<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Comment;



class BookController extends Controller
{


    public function index(){
        return view("books.list");
    }
    public function show(Book $book){
        ;
        return view("books.show", [
            "book" => $book,
            "title" => $book->title,
            "description" => \Illuminate\Support\Str::limit($book->description, 160),
            "tags" => $book->tags,
            "author" => $book->author->full_name,
            "image" => $book->image,
            "rating" => Comment::where("book_id", $book->id)->avg('stars')
        ]);
    }
}
