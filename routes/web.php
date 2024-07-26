<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookCategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SitemapController;
use App\Models\Book;
use App\Models\Post;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::get('/sitemap', [SitemapController::class, 'index']);


Route::get('/livewire/update', function () {
    return redirect()->back();
});

Route::get('/ads.txt', function (Request $request) {
    $domain = $request->getHost();
    $site = Site::where('domain', $domain)->firstOrFail();
    return response($site->ads_txt, 200);
});


Route::get('/', function (Request $request) {
    $domain = str_replace('www.', '', $request->getHost());
    $site = Site::where('domain', $domain)->firstOrFail();
    $site_options = json_decode($site->site_options, true);
    if ($site_options['home_page'] == "books") {
        return view('home', [
            'books' => Book::with(['author', 'category'])->paginate(30)
        ]);
    }

    $posts = Post::where('site_id', $site->id)->paginate(15);
    return view('posts.index', [
        'posts' => $posts,
        'title' => json_decode($site->site_options, true)['blog_title']
    ]);
})->name('home');






Route::controller(PostController::class)->prefix('blog')->group(function(){
    Route::get('', 'index')->name("blog.index");
    Route::get('{post:slug}', 'show')->name("blog.show");
});


// Books
Route::controller(BookController::class)->prefix('books')->group(function () {
    Route::get('', 'index')->name('books.index');
    Route::get("{book:slug}", 'show')->name("book.show");
});


// Categories
Route::prefix('category')->group(function () {
    Route::get("{category:slug}", [BookCategoryController::class, "show"])->name("category.show");
});

Route::prefix('authors')->group(function () {
    Route::get('', [AuthorController::class, 'index'])->name('authors.indx');
    Route::get('{author:slug}/books', [AuthorController::class, 'show'])->name('authors.show');
});







Route::view('/contact-us', 'contact', ['title' => __("Contact us")])->name('contact');


Route::get('page/{page}', [PageController::class, 'show'])->name('page.show');


Route::middleware('api')->prefix('api/books')->group(function () {
    Route::get('', [BookController::class, 'api_list']);
    Route::get('{book:slug}', [BookController::class, 'api_show']);
});







