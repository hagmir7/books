<?php

namespace App\Http\Controllers;

use App\Models\BookCategory;
use Illuminate\Http\Request;

class BookCategoryController extends Controller
{


    // public function
    public function show(BookCategory $category)
    {
        $title = $category->title ? $category->title : $category->name;
        $description = $category->description;
        return view("categories.show", compact("category", 'title', 'description'));
    }
}
