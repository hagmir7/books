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

        $sitemap_name = explode(".", str_replace('www.', '', request()->host()))[0];

        $site = Site::where('domain', $sitemap_name)->firstOrFail();

        $site_options = $site->site_options



        $sitemap = Sitemap::create()
            ->add(Url::create('/'))
            ->add(Url::create('/contact-us'))
            ->add(Url::create('/blog'))
            ->add(Url::create('/books'))
            ->add(Url::create('/authors'));


        Book::all()->each(function (Book $book) use ($sitemap) {
            $sitemap->add(Url::create("/books/{$book->slug}"));
        });

        Author::all()->each(function (Author $author) use ($sitemap) {
            $sitemap->add(Url::create("/authors/{$author->slug}/books"));
        });

        BookCategory::all()->each(function (BookCategory $cateogry) use ($sitemap) {
            $sitemap->add(Url::create("/category/{$cateogry->slug}"));
        });



        // if ($site_options['home_page'] == "books") {

        //     $sitemap = Sitemap::create()
        //         ->add(Url::create('/'))
        //         ->add(Url::create('/books'))
        //         ->add(Url::create('/authors'));

        //     Book::all()->each(function (Book $book) use ($sitemap) {
        //         $sitemap->add(Url::create("/books/{$book->slug}"));
        //     });

        //     Author::all()->each(function (Author $author) use ($sitemap) {
        //         $sitemap->add(Url::create("/authors/{$author->slug}/books"));
        //     });

        //     BookCategory::all()->each(function (BookCategory $cateogry) use ($sitemap) {
        //         $sitemap->add(Url::create("/category/{$cateogry->slug}"));
        //     });
        // }



        Post::where('site_id', $site->id)->each(function (Post $post) use ($sitemap) {
            $sitemap->add(Url::create("/blog/{$post->slug}"));
        });
        $sitemap->writeTofile(public_path($sitemap_name.'.xml'));

        return "Sitemap generated successfully!";
    }

}
