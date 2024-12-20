{{-- Authors --}}
<div class="col-lg-3">
    <div class="row">
        <div class="col-12">
            <div class="mb-4">
                <h2 class="h4 mb-3">{{ __("Popular Authors") }}</h2>
            </div>
        </div>
        @foreach ($authors as $author)
            <div class="col-12 col-md-6 col-lg-12 mb-3">
                <div class="d-flex gap-3 bg-light p-2 rounded">
                     <div>
                        <a href="{{ route("authors.show", $author->slug) }}" class="text-center">
                            <img src="{{ $author->image ? Storage::url($author->image) : '/storage/default/author.png' }}"
                                 alt="{{ $author->full_name }}"
                                 class="rounded-circle"
                                 style="width: 43px; height: 43px; object-fit: cover;">
                        </a>
                    </div>
                    <div>
                        <h3 class="h6 mb-1">
                            <a href="{{ route("authors.show", $author->slug) }}" class="text-decoration-none">
                                {{ $author->full_name }}
                            </a>
                        </h3>
                        <small class="text-muted">{{ $author->books_count }} {{ __("books") }}</small>
                    </div>

                </div>
            </div>
        @endforeach
    </div>
</div>
