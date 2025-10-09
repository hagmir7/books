<div>
    <section class="py-12">
        <div class="container mx-auto px-4">
            <!-- Header -->
            <div class="flex flex-col items-center mb-8">
                <a href="/" class="block">
                    <img src="{{ Storage::url($site->logo) }}" alt="{{ $site->name }}" class="h-16 object-contain" />
                </a>
                <h1 class="mt-3 text-center text-xl font-semibold">{{ $site->name }}</h1>
            </div>

            <!-- Search -->
            <div class="flex justify-center">
                <div class="w-full sm:w-10/12 md:w-8/12 lg:w-7/12">
                    <div class="relative">
                        <!-- Card -->
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                            <div class="p-0">
                                <div class="p-3">
                                    <div class="relative">
                                        <!-- Input -->
                                        <input type="text" aria-label="{{ __('Search books, authors...') }}"
                                            placeholder="{{ __('Start search by book, author...') }}"
                                            wire:model.live.debounce.500ms="search"
                                            class="w-full pl-10 pr-4 py-2 text-base rounded-lg border-0 focus:outline-none focus:ring-2 focus:ring-primary" />

                                        <!-- Search Icon (hidden while loading) -->
                                        <svg wire:loading.remove xmlns="http://www.w3.org/2000/svg"
                                            class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21 21l-4.35-4.35" />
                                            <circle cx="11" cy="11" r="6" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>

                                        <!-- Spinner (shown while loading) -->
                                        <svg wire:loading
                                            class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 animate-spin text-gray-500"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Results dropdown -->
                        <div wire:loading.remove>
                            @if($search)
                            @forelse($books as $book)
                            @if($loop->first)
                            <div class="absolute z-50 mt-2 w-full max-h-80 overflow-auto bg-white rounded-xl shadow-lg ring-1 ring-black/5"
                                role="listbox" aria-label="{{ __('Search results') }}">
                                <div class="px-4 py-3 bg-gray-50 rounded-t-xl">
                                    <h5 class="text-base font-semibold text-gray-600 mb-0">{{ __('Search Results') }}
                                    </h5>
                                </div>
                                <div class="divide-y divide-gray-100">
                                    @endif

                                    <div class="px-3 py-3 hover:bg-gray-50 transition-colors cursor-pointer"
                                        role="option" tabindex="0">
                                        <div class="flex flex-col">
                                            <h4 class="text-base font-bold text-gray-900 mb-1">
                                                <a href="{{ route('book.show', $book?->slug) }}"
                                                    class="no-underline hover:text-primary">
                                                    {{ $book->name }}
                                                </a>
                                            </h4>

                                            @if($book->author)
                                            <a href="{{ route('authors.show', $book->author->slug) }}"
                                                class="no-underline">
                                                <p class="text-sm text-gray-600 flex items-center gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M8 7a4 4 0 118 0 4 4 0 01-8 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6 21v-2a4 4 0 014-4h4a4 4 0 014 4v2" />
                                                    </svg>
                                                    <span class="font-semibold">{{ $book->author->full_name }}</span>
                                                </p>
                                            </a>
                                            @endif
                                        </div>
                                    </div>

                                    @if($loop->last)
                                </div> <!-- .divide wrapper -->
                            </div> <!-- dropdown -->
                            @endif

                            @empty
                            <div
                                class="absolute z-50 mt-2 w-full max-h-80 overflow-auto bg-white rounded-xl shadow-lg ring-1 ring-black/5">
                                <div class="text-center py-8 px-4">
                                    <h4 class="text-gray-500 mb-3 text-lg">{{ __('No books found') }}</h4>
                                    <p class="text-gray-500 text-sm">
                                        {{ __('No books match your search criteria') }} "<strong>{{ $search }}</strong>"
                                    </p>
                                </div>
                            </div>
                            @endforelse
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
