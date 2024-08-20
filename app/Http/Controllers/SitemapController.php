<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\Post;
use App\Models\Site;
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
            Book::all()->each(function (Book $book) use ($sitemap) {
                $sitemap->add(Url::create("/books/{$book->slug}"));
            });
        }


        if (app("site")->site_options['author_sitemap']) {
            $sitemap->add(Url::create('/authors'));
            Author::all()->each(function (Author $author) use ($sitemap) {
                $sitemap->add(Url::create("/authors/{$author->slug}/books"));
            });
        }


        if (app("site")->site_options['category_sitemap']) {
            $sitemap->add(Url::create('/category'));
            BookCategory::all()->each(function (BookCategory $cateogry) use ($sitemap) {
                $sitemap->add(Url::create("/category/{$cateogry->slug}"));
            });
        }

        if (app("site")->site_options['post_sitemap']) {
            $sitemap->add(Url::create('/blog'));
            Post::all()->each(function (Post $post) use ($sitemap) {
                $sitemap->add(Url::create("/blog/{$post->slug}"));
            });
        }
        $sitemap->writeTofile(public_path(app("site")->domain . '.xml'));
        return "Sitemap generated successfully!";
    }
}
