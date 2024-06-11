@extends('layouts.base')


@section('content')
{{-- Book Cover --}}
@livewire('books-cover-livewire')

<section class="home-book-list">
    <div class="container">
        <div class="row book-list">
            {{-- Boooks --}}
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-12 p-0">
                        <div class="section-title">
                            <h1 class="h3">{{ __("Popular, Free PDF Books") }}</h1>
                        </div>
                    </div>
                    @forelse ($books as $book)
                        <div class="col-lg-6 col-md-6">
                            <div class="row book">
                                <div class="book-cover col-lg-3 col-3">
                                    <a href="{{ route('book.show', $book->slug) }}">
                                        <img src="{{ Storage::url($book->image) }}" alt="{{ $book->name }} {{ $book->type }}" class="img-fluid">
                                    </a>
                                </div>
                                <div class="book-info col-lg-9 col-9">
                                    <div class="book-title">
                                        <a href="{{ route('book.show', $book->slug) }}">{{ $book->name }} {{ $book->type }}</a>
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
                                    </div>
                                    <div class="book-short-description">{{ Str::limit($book->description, 100, '...') }}</div>
                                </div>
                            </div>
                        </div>

                    @empty
                    <div class="d-flex justify-content-center w-100 py-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M18 6l-12 12" />
                            <path d="M6 6l12 12" />
                        </svg>
                    </div>
                    @endforelse
                </div>
            </div>
            @livewire('authors-list-livewire')
        </div>
    </div>
</section>
@endsection
