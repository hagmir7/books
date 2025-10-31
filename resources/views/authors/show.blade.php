@extends('layouts.base')

@section('content')
<section class="single-author bg-gradient-to-b from-gray-50 to-white py-12">
    <div class="container mx-auto px-4 max-w-7xl">
        <!-- Author Header Section -->
        <div class="flex flex-wrap author mb-12">
            <div class="w-full">
                <div class="author-photo mx-auto mb-8">
                    <img src="{{ asset("storage/" . $author->image) }}" alt="{{ $author->full_name }}"
                    class="rounded-full w-30 h-30 object-cover mx-auto shadow-sm ring-4 ring-white">
                </div>
            </div>
            <div class="w-full">
                <div class="author-info max-w-4xl mx-auto">
                    <h1 class="text-xl md:text-2xl font-bold text-gray-900 text-center mb-6">
                        {{ str_replace(":attr", $author->full_name, $site->site_options['author_title']) }}
                    </h1>
                    <div
                        class="prose max-w-4xl mx-auto prose-headings:text-gray-900 prose-p:text-gray-700 prose-li:text-gray-700 prose-a:text-blue-600 prose-a:underline prose-strong:text-gray-900 leading-relaxed prose-hr:p-1 prose-hr:m-1 prose-p:mt-0 prose-p:mb-0 ">
                        {!! $author->description !!}
                    </div>

                    @if (auth()?->user()?->email_verified_at)
                    <div class="mt-8">
                        @livewire('author-actions', ['author' => $author, key($author->slug)])
                    </div>
                    @endif
                </div>


            </div>

        </div>

        <!-- Navigation Buttons -->
        <nav aria-label="Author navigation" class="w-full mb-2">
            <ul class="flex justify-between items-center px-4">

                {{-- Previous author --}}
                @if($author->previous())
                <li>
                    <a href="{{ route('authors.show', $author->previous()->slug) }}" aria-label="Previous author"
                        class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-md hover:shadow-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 ease-in-out hover:-translate-y-0.5">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                </li>
                @else
                {{-- Invisible placeholder to keep spacing --}}
                <li><span class="block w-12 h-12"></span></li>
                @endif

                {{-- Next author --}}
                @if($author->next())
                <li>
                    <a href="{{ route('authors.show', $author->next()->slug) }}" aria-label="Next author"
                        class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-md hover:shadow-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 ease-in-out hover:-translate-y-0.5">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </li>
                @endif
            </ul>
        </nav>

        <!-- Books Section -->
        <div class="flex flex-wrap">
            <div class="w-full books-listing">
                <div class="books-list">
                    <!-- Filter Header -->
                    <div class="top-filter bg-white rounded-lg shadow-sm border border-gray-200 px-6 py-4 mb-8">
                        <div class="flex items-center gap-2 text-gray-700">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            {{ __("Found") }}
                            <span class="font-bold text-blue-600">{{ $author->books->where('verified', true)->count() }}
                                {{ __("books") }}</span>
                            {{ __("in total") }}
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-6">
                        @forelse ($books as $book)
                        <div class="group">
                            <div
                                class="bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden h-full">
                                <div class="flex p-4 sm:p-5 gap-3 sm:gap-4">
                                    <!-- Book Cover -->
                                    <div class="flex-shrink-0 relative">
                                        <a href="{{ route('book.show', $book->slug) }}" class="block">
                                            <div
                                                class="relative transform transition-transform duration-300 group-hover:scale-105">
                                                <img src="{{ asset('storage/'.$book->image) }}" alt="{{ $book->name }}"
                                                    class="w-20 h-28 sm:w-24 sm:h-32 md:w-28 md:h-40 rounded-md object-cover shadow-lg">
                                                <div
                                                    class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent rounded-md">
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <!-- Book Info -->
                                    <div class="flex-1 flex flex-col min-w-0">
                                        <!-- Title -->
                                        <h3 class="mb-1.5 sm:mb-2 whitespace-nowrap text-ellipsis overflow-hidden">
                                            <a href="{{ route('book.show', $book->slug) }}"
                                                class="text-sm sm:text-base md:text-lg font-semibold text-gray-900 hover:text-primary transition-colors duration-200 line-clamp-2 leading-snug">
                                                {{ $book->name }}
                                            </a>
                                        </h3>

                                        <!-- Author & Year -->
                                        <div class="text-xs sm:text-sm text-gray-600 mb-2 sm:mb-3 truncate">
                                            <span class="inline-flex items-center gap-1">
                                                <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 opacity-70" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                <span class="font-medium">{{ $book->author->full_name }}</span>
                                            </span>
                                            <span class="mx-1.5 text-gray-400">•</span>
                                            <span class="text-gray-500">{{ $book->created_at->format("Y") }}</span>
                                        </div>

                                        <!-- Rating -->
                                        <div class="flex items-center gap-1 mb-2 sm:mb-3">
                                            <div class="flex gap-0.5">
                                                @for($i = 0; $i < 5; $i++) <svg
                                                    class="w-3 h-3 sm:w-4 sm:h-4 text-yellow-400 fill-current"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                                    </svg>
                                                    @endfor
                                            </div>
                                            <span class="text-xs text-gray-500 ml-1">(4.5)</span>
                                        </div>

                                        <!-- Description -->
                                        <p
                                            class="text-xs sm:text-sm text-gray-600 line-clamp-2 sm:line-clamp-3 leading-relaxed mt-auto">
                                            {{ Str::limit($book->description, 120, '...') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-full flex flex-col items-center justify-center py-16 px-4">
                            <div class="bg-gray-50 rounded-full p-6 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24"
                                    class="text-gray-300">
                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="1.5">
                                        <path
                                            d="M3.25 13h3.68a2 2 0 0 1 1.664.89l.812 1.22a2 2 0 0 0 1.664.89h1.86a2 2 0 0 0 1.664-.89l.812-1.22A2 2 0 0 1 17.07 13h3.68" />
                                        <path
                                            d="m5.45 4.11l-2.162 7.847A8 8 0 0 0 3 14.082V19a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-4.918a8 8 0 0 0-.288-2.125L18.55 4.11A2 2 0 0 0 16.76 3H7.24a2 2 0 0 0-1.79 1.11M10 8.5h4" />
                                    </g>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-700 mb-2">{{ __("No books found") }}</h3>
                            <p class="text-sm text-gray-500 text-center max-w-sm">
                                {{ __("We couldn't find any books.") }}
                            </p>
                        </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if ($books->hasPages()) {{-- only show when there are multiple pages --}}
                    <div class="books-per-page flex justify-center">
                        <nav class="bg-white rounded-lg shadow-sm border border-gray-200 px-2 py-2">
                            <ul class="flex items-center gap-1">

                                {{-- MOBILE: compact view --}}
                                <li class="sm:hidden flex items-center gap-2">
                                    {{-- Prev --}}
                                    @if ($books->onFirstPage())
                                    <span
                                        class="inline-flex items-center justify-center w-10 h-10 text-gray-300 cursor-not-allowed"
                                        aria-hidden="true">
                                        «
                                    </span>
                                    @else
                                    <a href="{{ $books->previousPageUrl() }}"
                                        class="inline-flex items-center justify-center w-10 h-10 hover:bg-gray-100 rounded-lg ajax-page"
                                        aria-label="Previous page">
                                        «
                                    </a>
                                    @endif

                                    {{-- Page X of Y --}}
                                    <span
                                        class="inline-flex items-center px-3 h-10 rounded-lg bg-gray-50 border border-gray-200 text-sm">
                                        {{ __("Page") }} {{ $books->currentPage() }} {{ __("of") }} {{
                                        $books->lastPage() }}
                                    </span>

                                    {{-- Next --}}
                                    @if ($books->hasMorePages())
                                    <a href="{{ $books->nextPageUrl() }}"
                                        class="inline-flex items-center justify-center w-10 h-10 hover:bg-gray-100 rounded-lg ajax-page"
                                        aria-label="Next page">
                                        »
                                    </a>
                                    @else
                                    <span
                                        class="inline-flex items-center justify-center w-10 h-10 text-gray-300 cursor-not-allowed"
                                        aria-hidden="true">
                                        »
                                    </span>
                                    @endif
                                </li>

                                {{-- DESKTOP: full pagination (hidden on small screens) --}}
                                <li class="hidden sm:flex items-center gap-1">
                                    {{-- Numeric page items (use existing elements structure) --}}
                                    @foreach ($books->links()->elements[0] as $page => $url)
                                    @if ($page == $books->currentPage())
                                    <span
                                        class="inline-flex items-center justify-center w-10 h-10 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg font-medium shadow-md">
                                        {{ $page }}
                                    </span>
                                    @else
                                    <a href="{{ $url }}"
                                        class="inline-flex items-center justify-center w-10 h-10 text-gray-700 hover:bg-gray-100 rounded-lg font-medium transition-colors duration-200 ajax-page">
                                        {{ $page }}
                                    </a>
                                    @endif
                                    @endforeach

                                    {{-- Next arrow --}}
                                    @if ($books->hasMorePages())
                                    <a href="{{ $books->nextPageUrl() }}"
                                        class="inline-flex items-center justify-center w-10 h-10 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200 ajax-page ml-2"
                                        aria-label="Next page">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="currentColor" class="text-gray-600">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M7 6l-.112 .006a1 1 0 0 0 -.669 1.619l3.501 4.375l-3.5 4.375a1 1 0 0 0 .78 1.625h6a1 1 0 0 0 .78 -.375l4 -5a1 1 0 0 0 0 -1.25l-4 -5a1 1 0 0 0 -.78 -.375h-6z" />
                                        </svg>
                                    </a>

                                    {{-- Last page link --}}
                                    <a href="{{ $books->url($books->lastPage()) }}"
                                        class="inline-flex items-center px-4 h-10 text-gray-700 hover:bg-gray-100 rounded-lg font-medium transition-colors duration-200 ajax-page ml-1">
                                        {{ __("Last Page") }}
                                    </a>
                                    @else
                                    <span
                                        class="inline-flex items-center justify-center w-10 h-10 text-gray-300 cursor-not-allowed ml-2"
                                        aria-hidden="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="currentColor">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M17 6h-6a1 1 0 0 0 -.78 .375l-4 5a1 1 0 0 0 0 1.25l4 5a1 1 0 0 0 .78 .375h6l.112 -.006a1 1 0 0 0 .669 -1.619l-3.501 -4.375l3.5 -4.375a1 1 0 0 0 -.78 -1.625z" />
                                        </svg>
                                    </span>
                                    @endif
                                </li>
                            </ul>
                        </nav>
                    </div>
                    @endif
                    <!-- End pagination -->
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
