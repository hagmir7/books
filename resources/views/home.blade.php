@extends('layouts.base')

@section('content')
{{-- Book Cover --}}
@livewire('books-cover-livewire')

<section class="home-book-list py-8">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap book-list">
            {{-- Authors --}}
            @livewire('authors-list-livewire')

            <div class="w-full lg:w-3/4">
                <div class="flex flex-wrap">
                    <div class="w-full p-0 m-2">
                        <div class="section-title">
                            <h1 class="text-3xl font-semibold mb-2">{{ $site->site_options['home_title'] }}</h1>
                        </div>
                    </div>

                    @forelse ($books as $book)
                    <div class="w-full md:w-1/2 lg:w-1/2 px-2 mb-4">
                        <div class="flex book">
                            <div class="book-cover w-1/4">
                                <a href="{{ route('book.show', $book->slug) }}">
                                    <img src="{{ Storage::url($book->image) }}" alt="{{ $book->name }}"
                                        class="w-full h-auto rounded shadow">
                                </a>
                            </div>
                            <div class="book-info w-3/4 pl-4 rtl:pl-0 rtl:pr-4">
                                <div class="book-title mb-2">
                                    <a href="{{ route('book.show', $book->slug) }}"
                                        class="text-lg font-semibold hover:text-primary transition-colors">
                                        {{ $book->name }}
                                    </a>
                                </div>
                                <div class="book-attr text-sm text-gray-600 mb-2">
                                    <span class="book-publishing-year">{{ $book->created_at->format("Y") }}, </span>
                                    <span class="book-author">{{ $book->author->full_name }}</span>
                                </div>
                                <div class="book-rating flex gap-1 mb-2">
                                    <x-stars />
                                    <x-stars />
                                    <x-stars />
                                    <x-stars />
                                    <x-stars />
                                </div>
                                <div class="book-short-description text-sm text-gray-700">
                                    {{ Str::limit($book->description, 100, '...') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="flex justify-center w-full py-12">
                        <img src="{{ asset('imgs/empty.png') }}" alt="Empty icon" class="max-w-xs">
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('footer')

@endsection
