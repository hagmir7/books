<section class="books-listing">
    <style>
        .books-listing .book-grid .book .book-info {
            padding: 0px 35px 0px 2px!important;
        }
    </style>



    <div class="container-fluid">
        <div class="row">
            <div class="col-12" id="book-list">
                <div class="row book-grid">
                    @forelse ($books as $book)
                        <div class="col-lg-6 col-md-6 col-xl-4">
                            <div class="row book shadow-sm">
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24">
                            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
                                <path d="M3.25 13h3.68a2 2 0 0 1 1.664.89l.812 1.22a2 2 0 0 0 1.664.89h1.86a2 2 0 0 0 1.664-.89l.812-1.22A2 2 0 0 1 17.07 13h3.68" />
                                <path d="m5.45 4.11l-2.162 7.847A8 8 0 0 0 3 14.082V19a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-4.918a8 8 0 0 0-.288-2.125L18.55 4.11A2 2 0 0 0 16.76 3H7.24a2 2 0 0 0-1.79 1.11M10 8.5h4" />
                            </g>
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
