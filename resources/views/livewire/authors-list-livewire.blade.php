{{-- Authors --}}
<div class="col-lg-3">
    <div class="row mini-list-authors">
        <div class="col-lg-12">
            <div class="section-title">
                <h2>{{ __("Popular Authors") }}</h2>
            </div>
        </div>
        @foreach ($authors as $author)
            <div class="col-lg-12 col-md-6 author">
                <div class="author-photo">
                    <a href="{{ route("authors.show", $author->slug) }}" class="text-center">
                        <img src="{{ Storage::url($author->image) }}" alt="{{ $author->full_name }} " class="rounded-circle">
                    </a>
                </div>
                <div class="author-info">
                    <div class="author-name">
                        <a href="{{ route("authors.show", $author->slug) }}"> {{ $author->full_name }}</a>
                    </div>
                    <div class="author-books">{{ $author->books_count }} books</div>
                </div>
            </div>
        @endforeach
    </div>
</div>
