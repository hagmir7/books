<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookCategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SitemapController;
use App\Models\Book;
use App\Models\Post;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::get('/sitemap', [SitemapController::class, 'index']);


Route::get('/livewire/update', function () {
    return redirect()->back();
});

Route::get('/ads.txt', function () {
    return response(app('site')->ads_txt, 200);
});


Route::get('/', function () {
    $site_options = app('site')->site_options;

    if ($site_options['home_page'] == "books") {
        return view('home', [
            'books' => Book::with(['author', 'category'])
                ->whereHas('language', fn($query) => ($query->where('code', app()->getLocale())))
                ->where('verified', true)
                ->latest()
                ->paginate(30)
        ]);
    }

    $posts = Post::where('site_id', app('site')->id)->paginate(15);
    return view('posts.index', [
        'posts' => $posts,
        'title' => app('site')->site_options['blog_title']
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



Route::prefix('copyright')->group(function(){
    Route::get('/list', function(){
        $books = Book::where("is_public", 0)->where('language_id', app("site")->language_id)->get();
        return view('copyright.list', ['books' => $books]);
    });
});


Route::get('delete-files', [FileController::class, 'cleanUpFiles']);
Route::get('delete-images', [FileController::class, 'cleanUpImages']);



Route::post('delete-books', function(Request $request){
    $request->validate([
        'slugs' => 'required|string',
    ]);

    $slugs = array_filter(array_map('trim', explode("\n", $request->input('slugs'))));
    $deletedBooks = Book::whereIn('slug', $slugs)->update(['is_public' => false]);;
    return redirect()->back()->with('status', "$deletedBooks books were deleted.");

})->name("books.remove");

Route::view('book_form', 'book_form');




Route::post('/upload-books', [BookController::class, 'uploadBooks'])->name('book.upload');
Route::get('/book-upload', function(){
    return view('books.upload');
});


Route::get('ai-generater', [BookController::class, 'updateAndPublishBooksWithSdk'])->name("ai.generater");


Route::get('/convert-book-sizes', function () {

    $books = Book::all();

    foreach ($books as $book) {
        // Remove " B" from the size string
        $sizeInBytes = str_replace(' MB', '', $book->size);

        // Make sure it's numeric
        if (is_numeric($sizeInBytes) && intval($sizeInBytes) > 200) {
            // Convert from bytes to MB
            $sizeInMB = round($sizeInBytes / (1024 * 1024), 2);

            // Save the corrected size
            $book->size = $sizeInMB . ' MB';
            $book->save();
        }
    }

    return "All book sizes have been correctly converted from Bytes to MB!";
});
