<section class="books-listing">
    <style>
        .books-listing .book-grid .book .book-info {
            padding: 0px 35px 0px 2px !important;
        }
    </style>

    <div class="container mx-auto px-4">
        <div class="flex flex-wrap">
            <div class="w-full" id="book-list">
                <div class="flex flex-wrap book-grid -mx-2">
                    @forelse ($books as $book)
                    <div class="w-full md:w-1/2 lg:w-1/2 xl:w-1/3 px-2 mb-4">
                        <div class="flex book shadow-sm bg-white rounded p-3">
                            <div class="book-cover w-1/4">
                                <a href="{{ route('book.show', $book->slug) }}">
                                    <img src="{{ Storage::url($book->image) }}" alt="{{ $book->name }}"
                                        class="w-full h-auto rounded">
                                </a>
                            </div>
                            <div class="book-info w-3/4 pl-4 rtl:pl-0 rtl:pr-4">
                                <div class="book-title mb-2">
                                    <a href="{{ route('book.show', $book->slug) }}"
                                        class="text-lg font-semibold hover:text-primary transition-colors">
                                        {{ $book->name }}
                                    </a>
                                </div>
                                <div class="book-attr text-sm text-gray-600 mb-2">
                                    <span class="book-publishing-year">{{ $book->created_at->format("Y") }}, </span>
                                    <span class="book-author">{{ $book->author->full_name }}</span>
                                </div>
                                <div class="book-rating flex gap-1 mb-2">
                                    <x-stars />
                                    <x-stars />
                                    <x-stars />
                                    <x-stars />
                                    <x-stars />
                                </div>
                                <div class="book-short-description text-sm text-gray-700">
                                    {{ Str::limit($book->description, 100, '...') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    @empty
                    <div class="flex justify-center w-full py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"
                            class="text-gray-400">
                            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="1.5">
                                <path
                                    d="M3.25 13h3.68a2 2 0 0 1 1.664.89l.812 1.22a2 2 0 0 0 1.664.89h1.86a2 2 0 0 0 1.664-.89l.812-1.22A2 2 0 0 1 17.07 13h3.68" />
                                <path
                                    d="m5.45 4.11l-2.162 7.847A8 8 0 0 0 3 14.082V19a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-4.918a8 8 0 0 0-.288-2.125L18.55 4.11A2 2 0 0 0 16.76 3H7.24a2 2 0 0 0-1.79 1.11M10 8.5h4" />
                            </g>
                        </svg>
                    </div>
                    @endforelse
                </div>

                @if ($total >= $amount)
                <div class="books-per-page flex">
                    <nav class="mx-auto">
                        <ul class="flex py-4">
                            <li>
                                <button wire:click='loadMore'
                                    class="px-8 py-2 bg-primary text-white rounded hover:bg-primary/90 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
                                    wire:loading.attr="disabled">
                                    <div class="loader animate-spin rounded-full h-4 w-4 border-b-2 border-white"
                                        wire:loading></div>
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
