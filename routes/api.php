<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookCategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Models\Book;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('/books', [BookController::class, 'store']);
