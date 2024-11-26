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
                            <h1 class="h3">{{ $site->site_options['home_title'] }}</h1>
                        </div>
                    </div>
                    @forelse ($books as $book)
                        <div class="col-lg-6 col-md-6">
                            <div class="row book">
                                <div class="book-cover col-lg-3 col-3">
                                    <a href="{{ route('book.show', $book->slug) }}">
                                        <img src="{{ Storage::url($book->image) }}" alt="{{ $book->name }}" class="img-fluid">
                                    </a>
                                </div>
                                <div class="book-info col-lg-9 col-9">
                                    <div class="book-title">
                                        <a href="{{ route('book.show', $book->slug) }}">{{ $book->name }}</a>
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
                                    <div class="book-short-description">{{ Str::limit($book->description, 100, '...') }}</div>
                                </div>
                            </div>
                        </div>
                    @empty
                    <div class="d-flex justify-content-center w-100 py-5">
                        <img src="{{ asset("imgs/empty.png") }}" alt="Empty icon">
                    </div>
                    @endforelse
                </div>
            </div>
            @livewire('authors-list-livewire')
        </div>
    </div>
</section>
@endsection


@section('footer')

@endsection
