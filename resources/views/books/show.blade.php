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

        <div class="lg:grid grid-cols-1 lg:grid-cols-6 gap-6">
            <div class="col-span-2 xl:col-span-1 w-full">
                <div class="lg:sticky lg:top-4">
                    <div class="mb-4 flex justify-center">
                        <img src="{{ asset('storage/'.$book->image) }}" alt="{{ formatBookTitle($book->name) }}"
                            class="h-auto rounded-md object-cover w-1/2 md:w-1/3 lg:w-full" itemprop="image" />
                    </div>
                    <x-download-book :book="$book" />
                </div>
            </div>

            <div class="col-span-4 xl:col-span-3 w-full px-0 lg:px-4">
                {!! app("site")->ads !!}
                <h1 itemprop="name" class="text-xl md:text-2xl font-bold mb-4" dir="auto">
                    {{ formatBookTitle($book->name) }}
                </h1>


                <div class="book-rating general mb-3" itemprop="aggregateRating" itemscope
                    itemtype="http://schema.org/AggregateRating">
                    <div class="flex items-center gap-2 flex-wrap">
                        <div id="rating-container" aria-hidden="true"></div>
                        <div class="whole-rating text-[17px] md:text-md text-gray-600">
                            <span class="average">{{ $rating ? $rating : 5 }} {{ __("Avg rating") }}</span>
                            <span class="separator"> — </span>
                            <span>{{ $book->comments->count() ? $book->comments->count() : 2 }}</span> {{ __("Votes") }}
                        </div>
                    </div>
                    <meta itemprop="ratingValue" content="{{ $rating ? $rating : 5 }}" />
                    <meta itemprop="ratingCount"
                        content="{{ $book->comments->count() ? $book->comments->count() : 2  }}" />
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
            <aside class="mt-5 md:mt-0 md:col-span-6 xl:col-span-2 gap-2 w-full md:grid  md:grid-cols-2  xl:grid-cols-1 xl:inline-table">
               @forelse (
                    $book->category?->books()
                    ->with(['author', 'language'])
                    ->where('verified', true)
                    ->whereHas('language', fn($query) => $query->where('code', app()->getLocale()))
                    ->where('is_public', 1)
                    ->orderBy('updated_at', 'desc')
                    ->take(10)
                    ->get() ?? [] as $relatedBook
                    )
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden h-full mb-3">
                    <div class="flex p-4 sm:p-5 gap-3 sm:gap-4">
                        <!-- Book Cover -->
                        <div class="flex-shrink-0 relative">
                            <a href="{{ route('book.show', $relatedBook->slug) }}" class="block">
                                <div class="relative transform transition-transform duration-300 group-hover:scale-105">
                                    <img src="{{ asset('storage/'.$relatedBook->image) }}" alt="{{ $relatedBook->name }}"
                                        class="w-20 h-28 sm:w-24 sm:h-32 md:w-28 md:h-40 rounded-md object-cover shadow-lg">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent rounded-md">
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Book Info -->
                        <div class="flex-1 flex flex-col min-w-0">
                            <!-- Title -->
                            <h3 class="mb-1.5 sm:mb-2 whitespace-nowrap text-ellipsis overflow-hidden">
                                <a href="{{ route('book.show', $relatedBook->slug) }}"
                                    class="text-sm sm:text-base md:text-lg font-semibold text-gray-900 hover:text-primary transition-colors duration-200 line-clamp-2 leading-snug">
                                    {{ $relatedBook->name }}
                                </a>
                            </h3>

                            <!-- Author & Year -->
                            <div class="text-xs sm:text-sm text-gray-600 mb-2 sm:mb-3 truncate">
                                <span class="inline-flex items-center gap-1">
                                    <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 opacity-70" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span class="font-medium">{{ $relatedBook->author->full_name }}</span>
                                </span>
                                <span class="mx-1.5 text-gray-400">•</span>
                                <span class="text-gray-500">{{ $relatedBook->created_at->format("Y") }}</span>
                            </div>

                            <!-- Rating -->
                            <div class="flex items-center gap-1 mb-2 sm:mb-3">
                                <div class="flex gap-0.5">
                                    @for($i = 0; $i < 5; $i++) <svg class="w-3 h-3 sm:w-4 sm:h-4 text-yellow-400 fill-current"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                        @endfor
                                </div>
                                <span class="text-xs text-gray-500 ml-1">(4.5)</span>
                            </div>

                            <!-- Description -->
                            <p class="text-xs sm:text-sm text-gray-600 line-clamp-2 sm:line-clamp-3 leading-relaxed mt-auto">
                                {{ Str::limit($relatedBook->description, 120, '...') }}
                            </p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="flex justify-center w-full py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"
                        class="text-gray-400">
                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="1.5">
                            <path
                                d="M3.25 13h3.68a2 2 0 0 1 1.664.89l.812 1.22a2 2 0 0 0 1.664.89h1.86a2 2 0 0 0 1.664-.89l.812-1.22A2 2 0 0 1 17.07 13h3.68" />
                            <path
                                d="m5.45 4.11l-2.162 7.847A8 8 0 0 0 3 14.082V19a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-4.918a8 8 0 0 0-.288-2.125L18.55 4.11A2 2 0 0 0 16.76 3H7.24a2 2 0 0 0-1.79 1.11M10 8.5h4" />
                        </g>
                    </svg>
                </div>
                @endforelse
            </aside>
        </div>
    </div>
</section>
@endsection
