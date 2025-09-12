<div>
    <section class="py-5 bg-light">
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
            <div class="row">
                <div class="col-12">
                    <div class="border-0 rounded-3 shadow-sm overflow-hidden ">
                        <div class="card-body p-0">
                            <!-- Main Search Bar -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-group input-group-lg">
                                        {{-- <span class="input-group-text bg-primary text-white border-0">
                                            <i class="fas fa-search"></i>
                                        </span> --}}
                                        <input type="text" class="form-control border-0"
                                            placeholder="{{ __("Start search by book, author...") }}"
                                            wire:model.live.debounce.300ms="search">
                                    </div>
                                </div>
                            </div>

                            <div wire:loading class="text-center py-5">
                                <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                {{-- <p class="text-muted lead">Searching books...</p> --}}
                            </div>

                            <div wire:loading.remove class="pt-2">
                                @if($search)
                                @forelse($books as $book)
                                @if($loop->first)
                                <div class="card  border-0 rounded-3 overflow-hidden mb-3">
                                    <div class="card-header bg-light border-0 py-3 mb-3">
                                        <h5 class="mb-0 text-secondary fw-bold">
                                            {{ __("Search Results") }}
                                        </h5>
                                    </div>
                                    @endif

                                    <div class="p-0 m-0">
                                        <div class="list-group-item border-0 py-0 px-4 bg-white hover-bg-light">
                                            <div class="d-flex flex-column">
                                                <h4 class="mb-2 text-dark fw-bold">
                                                    <a href="{{ route("book.show", $book?->slug) }}">
                                                        {{ $book->name }}
                                                    </a>
                                                </h4>
                                                @if($book->author)
                                                <a href="{{ route("authors.show", $book->author->slug) }}">
                                                    <p class="mb-2 text-secondary d-flex gap-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-user">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                                        </svg>
                                                        <span class="fw-semibold">{{ $book->author->full_name }}</span>
                                                    </p>
                                                </a>
                                                @endif


                                            </div>
                                        </div>
                                        <hr class="text-gray">
                                    </div>

                                    @if($loop->last)
                                </div>
                                @endif

                                @empty
                                <div class="card shadow-sm border-0 rounded-3">
                                    <div class="card-body text-center py-5">
                                        <h4 class="text-muted mb-3">{{ __("No books found") }}</h4>
                                        <p class="text-muted mb-4">{{ __("No books match your search criteria") }} "<strong>{{ $search }}</strong>"
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



        </div>
    </section>
</div>
