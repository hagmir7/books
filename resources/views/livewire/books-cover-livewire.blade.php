<section class="home-book-carousel owl-carousel">
    {{-- @foreach ($books as $book)
        <div class="book {{ $colors[$loop->index] }}">
            <div class="row">
                <div class="book-cover col-lg-4 col-4">
                    <a href="{{ route("book.show", $book->slug) }}">
                        <img src="{{ Storage::url($book->image) }}" alt="{{ $book->name }}" class="img-fluid">
                    </a>
                </div>
                <div class="book-info col-lg-8 col-8">
                    <div class="book-title">
                        <a href="{{ route("book.show", $book->slug) }}">{{ $book->name }}</a>
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
                    <div class="book-short-description">{{ Str::limit($book->description, 90, '...') }}</div>
                </div>
            </div>
        </div>
    @endforeach --}}
</section>
