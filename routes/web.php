<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});



Route::view('/authors', 'authors.list')->name('authors.list');
Route::view('/books', 'books.list')->name('books.list');
Route::view('/contact-us', 'contact')->name('contact');


Route::get('{page}', [PageController::class, 'show'])->name('page.show');
