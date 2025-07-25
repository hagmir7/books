<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\Post;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = Sitemap::create()
            ->add(Url::create('/'))
            ->add(Url::create('/contact-us'));

        if (app("site")->site_options['book_sitemap']) {
            $sitemap->add(Url::create('/books'));
            Book::where('is_public', true)
                ->where('verified', true)
                ->whereNull('copyright_date')
                ->whereHas('language', fn($query) => $query->where('code', app()->getLocale()))
                ->each(function (Book $book) use ($sitemap) {
                    $sitemap->add(Url::create("/books/{$book->slug}"));
                });
        }

        if (app("site")->site_options['author_sitemap']) {
            $sitemap->add(Url::create('/authors'));
            Author::whereHas('books', function ($book) {
                $book->where('verified', true)
                    ->whereNull('copyright_date')
                    ->whereHas('language', fn($query) => $query->where('code', app()->getLocale()));
            })
                ->each(function (Author $author) use ($sitemap) {
                    $sitemap->add(Url::create("/authors/{$author->slug}/books"));
                });
        }

        if (app("site")->site_options['category_sitemap']) {
            $sitemap->add(Url::create('/category'));
            BookCategory::whereHas('books', function ($book) {
                $book->where('verified', true)
                    ->whereNull('copyright_date')
                    ->whereHas('language', fn($query) => $query->where('code', app()->getLocale()));
            })->each(function (BookCategory $category) use ($sitemap) {
                $sitemap->add(Url::create("/category/{$category->slug}"));
            });
        }


        if (app("site")->site_options['post_sitemap']) {
            $sitemap->add(Url::create('/blog'));
            Post::where('site_id', app('site')->id)->each(function (Post $post) use ($sitemap) {
                $sitemap->add(Url::create("/blog/{$post->slug}"));
            });
        }
        $sitemap->writeTofile(public_path(app("site")->domain . '.xml'));
        return "Sitemap generated successfully!";
    }
}
