@extends('layouts.base')


@section('content')
    <section class="single-author">
        <div class="container">
            <div class="row author">
                <div class="col-lg-12">
                    <div class="author-photo m-auto">
                        <img src="{{ Storage::url($author->image) }}" alt="{{ $author->full_name }}" class="img-fluid">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="author-info">
                        <h1>{{ str_replace(":attribute", $author->full_name, $site->site_options['author_title']) }}</h1>
                        <div class="description-author more">
                            <div class="text-center">
                                {!! $author->description !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 books-listing">
                    <div class="books-list">
                        <div class="top-filter row">
                            <div class="col-lg-8 text">
                                Found <span>{{ $author->books->count() }} books</span> in total
                            </div>
                        </div>
                        <div class="row book-grid">
                            @foreach ($books as $book)
                                <div class="col-sm-12 col-md-6 col-lg-4 book-3-row">
                                    <div class="row book" itemscope itemtype="http://schema.org/Book">
                                        <meta itemprop="isbn" content="9780670858699" />
                                        <meta itemprop="name" content="{{ $book->name }}" />
                                        <meta itemprop="datePublished" content="{{ $book->created_at->format("Y") }}" />
                                        <div class="book-cover col-lg-3 col-3">
                                            <a href="{{ route("book.show", $book->slug) }}">
                                                <img src="{{ Storage::url($book->image) }}" alt="{{ $book->name }}" class="img-fluid">
                                            </a>
                                        </div>
                                        <div class="book-info col-lg-9 col-9">
                                            <div class="book-title">
                                                <a href="{{ route("book.show", $book->slug) }}">{{ $book->name }}</a>
                                            </div>
                                            <div class="book-attr">
                                                <span class="book-publishing-year">{{ $book->created_at->format("Y") }}</span>
                                            </div>
                                            <div class="book-rating">
                                                <x-stars />
                                                <x-stars />
                                                <x-stars />
                                                <x-stars />
                                                <x-stars />
                                            </div>
                                            <div class="book-short-description">{{ Str::limit($book->description, 90, "...")}}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="books-per-page d-flex">
                            <nav class="m-auto">
                                <ul class="pagination py-4">
                                    <!-- Pagination Elements -->
                                    @foreach ($books->links()->elements[0] as $page => $url)
                                        @if ($page == $books->currentPage())
                                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                        @else
                                            <li class="page-item">
                                                <a href="{{ $url }}" class="page-link ajax-page">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach

                                    <!-- Next Page Link -->
                                    @if ($books->hasMorePages())
                                        <li class="page-item">
                                            <a href="{{ $books->nextPageUrl() }}" class="page-link ajax-page">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="currentColor"
                                                    class="icon icon-tabler icons-tabler-filled icon-tabler-arrow-badge-right">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path
                                                        d="M7 6l-.112 .006a1 1 0 0 0 -.669 1.619l3.501 4.375l-3.5 4.375a1 1 0 0 0 .78 1.625h6a1 1 0 0 0 .78 -.375l4 -5a1 1 0 0 0 0 -1.25l-4 -5a1 1 0 0 0 -.78 -.375h-6z" />
                                                </svg>
                                            </a>
                                        </li>
                                        <li class="page-item">
                                            <a href="?page={{ $books->lastPage() }}" class="page-link ajax-page">Last Page</a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                               <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="currentColor"
                                                class="icon icon-tabler icons-tabler-filled icon-tabler-arrow-badge-left">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M17 6h-6a1 1 0 0 0 -.78 .375l-4 5a1 1 0 0 0 0 1.25l4 5a1 1 0 0 0 .78 .375h6l.112 -.006a1 1 0 0 0 .669 -1.619l-3.501 -4.375l3.5 -4.375a1 1 0 0 0 -.78 -1.625z" />
                                            </svg>
                                            </span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
