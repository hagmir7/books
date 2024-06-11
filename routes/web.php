<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookCategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PageController;
use App\Models\Book;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', [
        'books' => Book::with(['author', 'category'])->paginate(30)
    ]);
});

// Books


Route::prefix('books')->group(function () {
    Route::get('', [BookController::class, "index"])->name('books.index');
    Route::get("{book}", [BookController::class,"show"])->name("book.show");
});


// Categories
Route::prefix('category')->group(function () {
    Route::get("{category}", [BookCategoryController::class, "show"])->name("category.show");
});

Route::prefix('authors')->group(function () {
    Route::get('', [AuthorController::class, 'index'])->name('authors.indx');
    Route::get('{author}/books', [AuthorController::class, 'show'])->name('authors.show');
});







Route::view('/contact-us', 'contact')->name('contact');


Route::get('{page}', [PageController::class, 'show'])->name('page.show');
