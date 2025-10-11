@extends('layouts.base')

@section('content')
<section class="authors-listing">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="authors-list">
                    <h1 class="h2 py-3">{{ __("Most popular book authors") }}</h1>
                    <div class="row">
                        @foreach ($authors as $author)
                            <div class="col-sm-4 col-md-3 col-lg-2 col-6 rounded overflow-hidden">
                                <div class="author overflow-hidden" style="border-radius: 17px">
                                    <div class="author-photo">
                                        <a href="{{ route("authors.show", $author->slug) }}" class="text-center rounded">
                                            <img class="cover" src="{{ asset("storage/". $author->image) }}" alt="{{ $author->full_name }}">
                                        </a>
                                    </div>
                                    <div class="author-info">
                                        <h2 class="author-name h4 mt-2 mx-1">
                                            <a href="{{ route("authors.show", $author->slug) }}">{{ $author->full_name }}</a>
                                        </h2>
                                        <span class="author-books">{{ $author->books_count }} {{ __("books") }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="books-per-page d-flex">
                        <nav class="m-auto">
                            <ul class="pagination py-4">
                                <!-- Pagination Elements -->
                                @foreach ($authors->links()->elements[0] as $page => $url)
                                @if ($page == $authors->currentPage())
                                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                @else
                                <li class="page-item">
                                    <a href="{{ $url }}" class="page-link ajax-page">{{ $page }}</a>
                                </li>
                                @endif
                                @endforeach

                                <!-- Next Page Link -->
                                @if ($authors->hasMorePages())
                                <li class="page-item">
                                    <a href="{{ $authors->nextPageUrl() }}" class="page-link ajax-page">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="currentColor"
                                            class="icon icon-tabler icons-tabler-filled icon-tabler-arrow-badge-right">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M7 6l-.112 .006a1 1 0 0 0 -.669 1.619l3.501 4.375l-3.5 4.375a1 1 0 0 0 .78 1.625h6a1 1 0 0 0 .78 -.375l4 -5a1 1 0 0 0 0 -1.25l-4 -5a1 1 0 0 0 -.78 -.375h-6z" />
                                        </svg>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a href="?page={{ $authors->lastPage() }}" class="page-link ajax-page">{{ __("Last Page") }}</a>
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
