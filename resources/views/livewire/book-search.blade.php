<div>
    <style>
        .search-container {
            position: relative;
            /* Added to make absolute positioning work properly */
        }

        .scroll-results {
            position: absolute;
            top: 100%;
            /* directly under search bar */
            left: 0;
            right: 0;
            z-index: 1050;
            /* above other elements */
            max-height: 350px;
            /* limit height */
            overflow-y: auto;
            /* enable scroll */
            margin-top: .5rem;
            /* little space under input */
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15);
            /* Bootstrap shadow */
            background: white;
            /* Ensure background is white */
            border-radius: 0.75rem;
            /* Match Bootstrap rounded-3 */
        }

        /* Make the results container scrollable */
        .results-container {
            max-height: 280px;
            /* Leave space for header */
            overflow-y: auto;
        }

        /* Optional: nicer scrollbar */
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

        /* Hover effect for search results */
        .hover-bg-light:hover {
            background-color: #f8f9fa !important;
        }
    </style>

    <section class="py-5">
        <div class="container">
            <!-- Search Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        <div class="logo">
                            <a href="/"><img src="{{ Storage::url($site->logo) }}" alt="{{ $site->name }}"></a>
                        </div>
                    </div>
                    <h1 class="text-center h2 mt-3">{{ $site->name }}</h1>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="row justify-content-center">
                <div class="col-12 col-sm-11 col-md-10 col-lg-8 col-xl-8">
                    <div class="search-container">
                        <!-- Fixed: Added search-container wrapper -->
                        <div class="card border-0 rounded-3 shadow-sm overflow-hidden">
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="position-relative">
                                            <!-- Fixed: corrected typo -->
                                            <input type="text" class="form-control form-control-lg ps-5 border-0 fs-6"
                                                placeholder="{{ __('Start search by book, author...') }}"
                                                wire:model.live.debounce.500ms="search">

                                            <!-- Search Icon (hidden when loading) -->
                                            <svg wire:loading.remove xmlns="http://www.w3.org/2000/svg" width="20"
                                                height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="position-absolute top-50 start-0 translate-middle-y ms-3 text-muted">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                                <path d="M21 21l-6 -6" />
                                            </svg>

                                            <!-- Spinner (shown when loading) -->
                                            <div wire:loading
                                                class="position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"
                                                style="width: 20px; height: 20px;">
                                                <div class="spinner-border text-muted" role="status"
                                                    style="width: 20px; height: 20px;">
                                                    <span class="visually-hidden">Loading...</span>
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
                                <!-- Fixed: moved outside the loop -->
                                <div class="card border-0 rounded-3 overflow-hidden">
                                    <div class="card-header bg-light border-0 py-2 py-md-3 mb-0">
                                        <h5 class="mb-0 text-secondary fw-bold fs-6 fs-md-5">
                                            {{ __('Search Results') }}
                                        </h5>
                                    </div>
                                    <div class="results-container">
                                        <!-- Fixed: Added scrollable container -->
                                        @endif

                                        <div class="p-0 m-0">
                                            <div class="list-group-item border-0 py-2 px-3 bg-white hover-bg-light">
                                                <div class="d-flex flex-column">
                                                    <h4 class="mb-2 text-dark fw-bold fs-6">
                                                        <a href="{{ route('book.show', $book?->slug) }}"
                                                            class="text-decoration-none text-dark">
                                                            {{ $book->name }}
                                                        </a>
                                                    </h4>
                                                    @if($book->author)
                                                    <a href="{{ route('authors.show', $book->author->slug) }}"
                                                        class="text-decoration-none">
                                                        <p class="mb-2 text-secondary d-flex align-items-center gap-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                                height="18" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-user flex-shrink-0">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                                            </svg>
                                                            <span class="fw-semibold small">{{
                                                                $book->author->full_name}}</span>
                                                        </p>
                                                    </a>
                                                    @endif
                                                </div>
                                            </div>
                                            @if(!$loop->last)
                                            <hr class="text-secondary mx-3 my-2">
                                            @endif
                                        </div>

                                        @if($loop->last)
                                    </div> <!-- Close results-container -->
                                </div> <!-- Close card -->
                            </div> <!-- Close scroll-results -->
                            @endif

                            @empty
                            <div class="scroll-results">
                                <div class="card border-0 rounded-3 shadow-sm">
                                    <div class="card-body text-center py-4 py-md-5 px-3">
                                        <h4 class="text-muted mb-3 fs-5 fs-md-4">{{ __('No books found') }}</h4>
                                        <p class="text-muted mb-4 small">
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
