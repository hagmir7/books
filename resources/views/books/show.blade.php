@extends('layouts.base')
@section('content')
<section class="mt-6" data-book="{{ $book->slug }}" itemscope itemtype="http://schema.org/Book">
    <meta itemprop="url" content="/book/{{ $book->slug }}" />
    <meta itemprop="author" content="{{ $book->author->full_name }}" />
    <meta itemprop="publisher" content="{{ $book->author->full_name }}" />

    <div class="container mx-auto px-4">
        {!! app("site")->ads !!}

        @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('success') }}
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-6 gap-6">
            <div class="lg:col-span-1 w-full">
                <div class="lg:sticky lg:top-4">
                    <div class="mb-4 flex justify-center">
                        <img src="{{ Storage::url($book->image) }}" alt="{{ formatBookTitle($book->name) }}" class="h-auto rounded-md object-cover w-1/2 md:w-1/3 lg:w-full" itemprop="image" />
                    </div>
                   <x-download-book :book="$book" />
                </div>
            </div>

            <div class="lg:col-span-3 w-full px-0 lg:px-4">
                {!! app("site")->ads !!}
                <h1 itemprop="name" class="text-xl md:text-2xl font-bold mb-4" dir="auto">
                    {{ formatBookTitle($book->name) }}
                </h1>


                <div class="book-rating general mb-3" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
                    <div class="flex items-center gap-2 flex-wrap">
                        <div id="rating-container" aria-hidden="true"></div>
                        <div class="whole-rating text-[17px] md:text-md text-gray-600">
                            <span class="average">{{ $rating ? $rating : 5 }} {{ __("Avg rating") }}</span>
                            <span class="separator"> — </span>
                            <span>{{ $book->comments->count() ? $book->comments->count() : 2 }}</span> {{ __("Votes") }}
                        </div>
                    </div>
                    <meta itemprop="ratingValue" content="{{ $rating ? $rating : 5 }}" />
                    <meta itemprop="ratingCount" content="{{ $book->comments->count() ? $book->comments->count() : 2  }}" />
                </div>

                <x-about-book :book="$book" />

                {!! app("site")->ads !!}

                {{-- Description --}}
            <div class="prose prose-lg prose-headings:mt-0 prose-headings:font-black prose-h2:text-[23px] prose-h3:text-[19px] prose-h4:text-[17px] max-w-none mt-6 leading-relaxed text-black prose-p:text-[16px] prose-p:text-gray-700 dark:text-gray-200 prose-headings:text-black dark:prose-headings:text-white prose-a:text-green-600 hover:prose-a:text-green-700 dark:prose-a:text-green-400 dark:hover:prose-a:text-green-300 prose-img:rounded-2xl prose-img:shadow-sm"
                itemprop="description">
                {!! $book->body !!}
            </div>
                {!! app("site")->ads !!}

                {{-- Book Actions (Livewire) --}}
                @if (auth()?->user()?->email_verified_at)
                @livewire('book-actions', ['book' => $book, key($book->slug)])
                @endif



                {{-- Navigation --}}
                <div class="mt-5 flex justify-center">
                    <nav aria-label="Next and Previous navigation" class="w-full">
                        <ul class="flex justify-between gap-4">
                            <li>
                                @if($book->previous())
                                <a class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
                                    href="{{ route('book.show', $book->previous()->slug) }}"
                                    aria-label="{{ __('Previous book') }}">
                                    <span aria-hidden="true">&laquo; {{ __("Previous") }}</span>
                                </a>
                                @endif
                            </li>
                            <li>
                                @if($book->next())
                                <a class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
                                    href="{{ route('book.show', $book->next()->slug) }}"
                                    aria-label="{{ __('Next book') }}">
                                    <span aria-hidden="true">{{ __("Next") }} &raquo;</span>
                                </a>
                                @endif
                            </li>
                        </ul>
                    </nav>
                </div>

                {{-- Reviews --}}
                <div class="flex flex-wrap mt-5 mb-3">
                    <div class="w-full lg:w-1/2">
                        <h2 class="text-2xl font-bold">{{ __("Book reviews") }}</h2>
                    </div>
                </div>

                @livewire('review-form-livewire', ['book' => $book], key($book->slug))
            </div>

           <x-about-book :book="$book" />
        </div>
    </div>
</section>
@endsection
