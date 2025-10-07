<div>
    <style>
        .search-container {
            position: relative;
        }

        .scroll-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            z-index: 50;
            max-height: 350px;
            overflow-y: auto;
            margin-top: 0.5rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            background: white;
            border-radius: 0.75rem;
        }

        .results-container {
            max-height: 280px;
            overflow-y: auto;
        }

        .scroll-results::-webkit-scrollbar,
        .results-container::-webkit-scrollbar {
            width: 6px;
        }

        .scroll-results::-webkit-scrollbar-thumb,
        .results-container::-webkit-scrollbar-thumb {
            background-color: #bbb;
            border-radius: 3px;
        }

        .scroll-results::-webkit-scrollbar-track,
        .results-container::-webkit-scrollbar-track {
            background: transparent;
        }

        .hover-bg-light:hover {
            background-color: #f8f9fa !important;
        }
    </style>

    <section class="py-12">
        <div class="container mx-auto px-4">
            <!-- Search Header -->
            <div class="flex flex-wrap mb-8">
                <div class="w-full">
                    <div class="flex justify-center">
                        <div class="logo">
                            <a href="/"><img src="{{ Storage::url($site->logo) }}" alt="{{ $site->name }}"></a>
                        </div>
                    </div>
                   <div class="flex items-center w-full justify-center">
                    <h1 class="text-center text-xl font-semibold mt-3">{{ $site->name }}</h1>
                   </div>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="flex justify-center">
                <div class="w-full sm:w-11/12 md:w-10/12 lg:w-8/12 xl:w-8/12">
                    <div class="search-container">
                        <!-- Search Input Card -->
                        <div class="bg-white border-0 rounded-xl shadow-sm overflow-hidden">
                            <div class="p-0">
                                <div class="flex flex-wrap">
                                    <div class="w-full">
                                        <div class="relative">
                                            <input type="text"
                                                class="w-full py-3 pl-12 pr-4 rtl:pr-12 rtl:pl-4 border-0 text-base focus:outline-none focus:ring-2 focus:ring-primary rounded-xl"
                                                placeholder="{{ __('Start search by book, author...') }}"
                                                wire:model.live.debounce.500ms="search">

                                            <!-- Search Icon (hidden when loading) -->
                                            <svg wire:loading.remove xmlns="http://www.w3.org/2000/svg" width="20"
                                                height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="absolute top-1/2 left-3 rtl:left-auto rtl:right-3 -translate-y-1/2 text-gray-400">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                                <path d="M21 21l-6 -6" />
                                            </svg>

                                            <!-- Spinner (shown when loading) -->
                                            <div wire:loading
                                                class="absolute top-1/2 left-3 rtl:left-auto rtl:right-3 -translate-y-1/2"
                                                style="width: 20px; height: 20px;">
                                                <div
                                                    class="animate-spin rounded-full h-5 w-5 border-b-2 border-gray-400">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Search Results -->
                        <div wire:loading.remove>
                            @if($search)
                            @forelse($books as $book)
                            @if($loop->first)
                            <div class="scroll-results">
                                <div class="bg-white border-0 rounded-xl overflow-hidden">
                                    <div class="bg-gray-50 border-0 py-2 md:py-3 px-4 mb-0">
                                        <h5 class="mb-0 text-gray-600 font-bold text-base md:text-lg">
                                            {{ __('Search Results') }}
                                        </h5>
                                    </div>
                                    <div class="results-container">
                                        @endif

                                        <div class="p-0 m-0">
                                            <div
                                                class="border-0 py-2 px-3 bg-white hover-bg-light transition-colors cursor-pointer">
                                                <div class="flex flex-col">
                                                    <h4 class="mb-2 text-gray-900 font-bold text-base">
                                                        <a href="{{ route('book.show', $book?->slug) }}"
                                                            class="no-underline text-gray-900 hover:text-primary transition-colors">
                                                            {{ $book->name }}
                                                        </a>
                                                    </h4>
                                                    @if($book->author)
                                                    <a href="{{ route('authors.show', $book->author->slug) }}"
                                                        class="no-underline">
                                                        <p class="mb-2 text-gray-600 flex items-center gap-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                                height="18" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="flex-shrink-0">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                                            </svg>
                                                            <span class="font-semibold text-sm">{{
                                                                $book->author->full_name }}</span>
                                                        </p>
                                                    </a>
                                                    @endif
                                                </div>
                                            </div>
                                            @if(!$loop->last)
                                            <hr class="border-gray-300 mx-3 my-2">
                                            @endif
                                        </div>

                                        @if($loop->last)
                                    </div> <!-- Close results-container -->
                                </div> <!-- Close card -->
                            </div> <!-- Close scroll-results -->
                            @endif

                            @empty
                            <div class="scroll-results">
                                <div class="bg-white border-0 rounded-xl shadow-sm">
                                    <div class="text-center py-8 md:py-12 px-3">
                                        <h4 class="text-gray-500 mb-3 text-lg md:text-xl">{{ __('No books found') }}
                                        </h4>
                                        <p class="text-gray-500 mb-4 text-sm">
                                            {{ __('No books match your search criteria') }} "<strong>{{ $search
                                                }}</strong>"
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endforelse
                            @endif
                        </div>
                    </div> <!-- Close search-container -->
                </div>
            </div>
        </div>
    </section>
</div>
