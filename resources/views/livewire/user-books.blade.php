<section class="books-listing">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap">
            <div class="w-full" id="book-list">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-6">
                    @forelse ($books as $book)
                    <div class="group">
                        <div
                            class="bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden h-full">
                            <div class="flex p-4 sm:p-5 gap-3 sm:gap-4">
                                <!-- Book Cover -->
                                <div class="flex-shrink-0 relative">
                                    <a href="{{ route('book.show', $book->slug) }}" class="block">
                                        <div
                                            class="relative transform transition-transform duration-300 group-hover:scale-105">
                                            <img src="{{ asset('storage/'.$book->image) }}" alt="{{ $book->name }}"
                                                class="w-20 h-28 sm:w-24 sm:h-32 md:w-28 md:h-40 rounded-md object-cover shadow-lg">
                                            <div
                                                class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent rounded-md">
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <!-- Book Info -->
                                <div class="flex-1 flex flex-col min-w-0">
                                    <!-- Title -->
                                    <h3 class="mb-1.5 sm:mb-2 whitespace-nowrap text-ellipsis overflow-hidden">
                                        <a href="{{ route('book.show', $book->slug) }}"
                                            class="text-sm sm:text-base md:text-lg font-semibold text-gray-900 hover:text-primary transition-colors duration-200 line-clamp-2 leading-snug">
                                            {{ $book->name }}
                                        </a>
                                    </h3>

                                    <!-- Author & Year -->
                                    <div class="text-xs sm:text-sm text-gray-600 mb-2 sm:mb-3 truncate">
                                        <span class="inline-flex items-center gap-1">
                                            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 opacity-70" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            <span class="font-medium">{{ $book->author->full_name }}</span>
                                        </span>
                                        <span class="mx-1.5 text-gray-400">•</span>
                                        <span class="text-gray-500">{{ $book->created_at->format("Y") }}</span>
                                    </div>

                                    <!-- Rating -->
                                    <div class="flex items-center gap-1 mb-2 sm:mb-3">
                                        <div class="flex gap-0.5">
                                            @for($i = 0; $i < 5; $i++) <svg
                                                class="w-3 h-3 sm:w-4 sm:h-4 text-yellow-400 fill-current"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                                </svg>
                                                @endfor
                                        </div>
                                        <span class="text-xs text-gray-500 ml-1">(4.5)</span>
                                    </div>

                                    <!-- Description -->
                                    <p
                                        class="text-xs sm:text-sm text-gray-600 line-clamp-2 sm:line-clamp-3 leading-relaxed mt-auto">
                                        {{ Str::limit($book->description, 120, '...') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-16 px-4">
                        <div class="bg-gray-50 rounded-full p-6 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24"
                                class="text-gray-300">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5">
                                    <path
                                        d="M3.25 13h3.68a2 2 0 0 1 1.664.89l.812 1.22a2 2 0 0 0 1.664.89h1.86a2 2 0 0 0 1.664-.89l.812-1.22A2 2 0 0 1 17.07 13h3.68" />
                                    <path
                                        d="m5.45 4.11l-2.162 7.847A8 8 0 0 0 3 14.082V19a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-4.918a8 8 0 0 0-.288-2.125L18.55 4.11A2 2 0 0 0 16.76 3H7.24a2 2 0 0 0-1.79 1.11M10 8.5h4" />
                                </g>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">{{ __("No books found") }}</h3>
                        <p class="text-sm text-gray-500 text-center max-w-sm">
                            {{ __("We couldn't find any books.") }}
                        </p>
                    </div>
                    @endforelse
                </div>

                @if ($total >= $amount)
                <div class="books-per-page flex justify-center py-6">
                    <button wire:click="loadMore" wire:loading.attr="disabled"
                        class="inline-flex items-center gap-2 px-6 py-2.5 bg-primary text-gray-500 font-medium rounded-lg shadow-sm hover:bg-primary/90 hover:shadow-md active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary/50">
                        <svg wire:loading class="w-5 h-5 animate-spin text-gray-500" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        <span wire:loading.remove>{{ __('Load More') }}</span>
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
