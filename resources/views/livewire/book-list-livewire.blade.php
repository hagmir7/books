<section class="books-listing">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12" id="book-list">
                <div class="top-filter row">
                    <div class="col-lg-7">
                        <h1 class="h4">{{ $category->name ? $category->name : "Books" }}</h1>
                    </div>
                    <div class="col-lg-5 text p-0 text-end">
                        Found <span>{{ $total }} books</span> in total
                    </div>
                </div>
                <div class="row book-grid">
                    @forelse ($books as $book)
                        <div class="col-lg-6 col-md-6 col-xl-4">
                            <div class="row book">
                                <div class="book-cover col-lg-3 col-3">
                                    <a href="{{ route('book.show', $book->slug) }}">
                                        <img src="{{ Storage::url($book->image) }}" alt="{{ $book->name }}" class="img-fluid">
                                    </a>
                                </div>
                                <div class="book-info col-lg-9 col-9">
                                    <div class="book-title">
                                        <a href="{{ route('book.show', $book->slug) }}">{{ $book->name }}</a>
                                    </div>
                                    <div class="book-attr">
                                        <span class="book-publishing-year">{{ $book->created_at->format("Y") }}, </span>
                                        <span class="book-author">{{ $book->author->full_name }} </span>
                                    </div>
                                    <div class="book-rating">
                                        <x-stars />
                                        <x-stars />
                                        <x-stars />
                                        <x-stars />
                                        <x-stars />
                                    </div>
                                    <div class="book-short-description">{{ Str::limit($book->description, 100, '...') }}</div>
                                </div>
                            </div>
                        </div>

                    @empty
                    <div class="d-flex justify-content-center w-100 py-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M18 6l-12 12" />
                            <path d="M6 6l12 12" />
                        </svg>
                    </div>
                    @endforelse
                </div>
                @if ($total >= $amount)
                    <div class="books-per-page d-flex">
                        <nav class="m-auto">
                            <ul class="pagination py-4">
                                <li class="page-item">

                                    <button wire:click='loadMore' class="page-link px-5" wire:loading.attr="disabled">
                                        <div class="loader" wire:loading></div>
                                        <div>{{ __("Load More") }}</div>
                                    </button>
                                </li>

                            </ul>
                        </nav>
                    </div>
                @endif

            </div>
        </div>
    </div>
</section>
