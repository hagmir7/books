@extends('layouts.base')

@section('content')
<section class="py-8">
    <div class="max-w-7xl mx-auto px-4">
        <div class="w-full">
            <div class="authors-list">
                <h1 class="text-2xl font-semibold py-3 text-gray-900">
                    {{ __("Most popular book authors") }}
                </h1>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach ($authors as $author)
                    <div class="rounded-lg overflow-hidden bg-white shadow-sm">
                        <div class="author p-3 flex flex-col items-center">
                            <a href="{{ route('authors.show', $author->slug) }}"
                                class="block w-full text-center rounded-md overflow-hidden">
                                <img class="w-full h-40 object-cover rounded-lg"
                                    src="{{ $author->image ? asset('storage/' . $author->image) : asset('storage/default/author.png') }}"
                                    alt="{{ $author->full_name }}">
                            </a>

                            <div class="author-info w-full mt-3 text-center">
                                <h2 class="author-name text-base font-semibold leading-tight">
                                    <a href="{{ route('authors.show', $author->slug) }}"
                                        class="block hover:underline no-underline text-gray-800">
                                        {{ $author->full_name }}
                                    </a>
                                </h2>
                                <span class="author-books text-sm text-gray-500">
                                    {{ $author->books_count }} {{ __("books") }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6 flex justify-center">
                    <nav aria-label="Authors pagination">
                        <ul class="inline-flex items-center -space-x-px gap-2">

                            {{-- Prev --}}
                            @if ($authors->onFirstPage())
                            <li>
                                <span
                                    class="inline-flex items-center px-3 py-1.5 rounded-md bg-gray-100 border border-gray-200 text-sm text-gray-400"
                                    aria-hidden="true">
                                    « {{ __("Prev") }}
                                </span>
                            </li>
                            @else
                            <li>
                                <a href="{{ $authors->previousPageUrl() }}"
                                    class="ajax-page inline-flex items-center px-3 py-1.5 rounded-md bg-white border border-gray-200 text-sm text-gray-700 hover:bg-gray-50"
                                    aria-label="Previous page">« {{ __("Prev") }}</a>
                            </li>
                            @endif

                            {{-- Build window around current page --}}
                            @php
                            $last = $authors->lastPage();
                            $current = $authors->currentPage();
                            $window = 2; // pages on either side of current to show
                            $start = max(1, $current - $window);
                            $end = min($last, $current + $window);
                            @endphp

                            {{-- First page --}}
                            @if ($start > 1)
                            <li>
                                <a href="{{ $authors->url(1) }}"
                                    class="ajax-page px-3 py-1.5 mx-0.5 rounded-md bg-white border border-gray-200 text-sm text-gray-700 hover:bg-gray-50">
                                    1
                                </a>
                            </li>

                            {{-- Ellipsis if gap --}}
                            @if ($start > 2)
                            <li>
                                <span class="px-3 py-1.5 mx-0.5 text-sm text-gray-500">…</span>
                            </li>
                            @endif
                            @endif

                            {{-- Page numbers window --}}
                            @for ($page = $start; $page <= $end; $page++) @if ($page==$current) <li>
                                <span class="px-3 py-1.5 mx-0.5 rounded-md bg-indigo-600 text-white text-sm font-medium"
                                    aria-current="page">
                                    {{ $page }}
                                </span>
                                </li>
                                @else
                                <li>
                                    <a href="{{ $authors->url($page) }}"
                                        class="ajax-page px-3 py-1.5 mx-0.5 rounded-md bg-white border border-gray-200 text-sm text-gray-700 hover:bg-gray-50">
                                        {{ $page }}
                                    </a>
                                </li>
                                @endif
                                @endfor

                                {{-- Ellipsis before last if needed --}}
                                @if ($end < $last) @if ($end < $last - 1) <li>
                                    <span class="px-3 py-1.5 mx-0.5 text-sm text-gray-500">…</span>
                                    </li>
                                    @endif

                                    {{-- Last page --}}
                                    <li>
                                        <a href="{{ $authors->url($last) }}"
                                            class="ajax-page px-3 py-1.5 mx-0.5 rounded-md bg-white border border-gray-200 text-sm text-gray-700 hover:bg-gray-50">
                                            {{ $last }}
                                        </a>
                                    </li>
                                    @endif

                                    {{-- Next --}}
                                    @if ($authors->hasMorePages())
                                    <li>
                                        <a href="{{ $authors->nextPageUrl() }}"
                                            class="ajax-page ml-2 inline-flex items-center px-3 py-1.5 rounded-md bg-white border border-gray-200 text-sm text-gray-700 hover:bg-gray-50"
                                            aria-label="Next page">{{ __("Next") }} »</a>
                                    </li>
                                    @else
                                    <li>
                                        <span
                                            class="ml-2 inline-flex items-center px-3 py-1.5 rounded-md bg-gray-100 border border-gray-200 text-sm text-gray-400"
                                            aria-hidden="true">
                                            {{ __("Next") }} »
                                        </span>
                                    </li>
                                    @endif

                        </ul>
                    </nav>
                </div>
                <!-- End pagination -->

            </div>
        </div>
    </div>
</section>
@endsection
