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
                        <img src="{{ 'https://norkitab.com' . Storage::url($book->image) }}" alt="{{ formatBookTitle($book->name) }}"
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
            <aside class="mt-5 md:mt-0 md:col-span-6 xl:col-span-2 gap-2 w-full md:grid  md:grid-cols-2  xl:grid-cols-1 xl:block">
                @forelse (
                $book->category->books()
                ->with(['author', 'language']) {{-- ✅ Eager load relations --}}
                ->where('verified', true)
                ->whereHas('language', fn($query) => $query->where('code', app()->getLocale()))
                ->where('is_public', 1)
                ->orderBy('updated_at', 'desc')
                ->take(10)
                ->get() as $relatedBook
                )
                <div class="flex book shadow-sm bg-white rounded p-3 mb-2 hover:shadow-md transition-shadow">
                    <div class="book-cover w-1/4">
                        <a href="{{ route('book.show', $relatedBook->slug) }}">
                            <img src="{{ 'https://norkitab.com' . Storage::url($relatedBook->image) }}" alt="{{ $relatedBook->name }}" class="w-full h-auto rounded">
                        </a>
                    </div>

                    <div class="book-info w-3/4 pl-4 rtl:pl-0 rtl:pr-4">
                        <div class="book-title mb-2 whitespace-nowrap text-ellipsis overflow-hidden">
                            <a href="{{ route('book.show', $relatedBook->slug) }}"
                                class="text-lg font-semibold hover:text-primary transition-colors">
                                {{ $relatedBook->name }}
                            </a>
                        </div>

                        <div class="book-attr text-sm text-gray-600 mb-2">
                            <span class="book-publishing-year">{{ $relatedBook->created_at->format('Y') }}, </span>
                            <span class="book-author">{{ $relatedBook->author->full_name }}</span>
                        </div>

                        <div class="book-rating flex gap-1 mb-2">
                            @for ($i = 0; $i
                            < 5; $i++) <x-stars />
                            @endfor
                        </div>

                        <div class="book-short-description text-sm text-gray-700">
                            {{ Str::limit($relatedBook->description, 100, '...') }}
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
