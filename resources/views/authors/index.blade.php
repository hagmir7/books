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
                        <ul class="inline-flex items-center -space-x-px">
                            {{-- Page numbers --}}
                            @foreach ($authors->links()->elements[0] as $page => $url)
                            @if ($page == $authors->currentPage())
                            <li>
                                <span class="px-3 py-1.5 mx-0.5 rounded-md bg-indigo-600 text-white text-sm font-medium"
                                    aria-current="page">{{ $page }}</span>
                            </li>
                            @else
                            <li>
                                <a href="{{ $url }}"
                                    class="ajax-page px-3 py-1.5 mx-0.5 rounded-md bg-white border border-gray-200 text-sm text-gray-700 hover:bg-gray-50">
                                    {{ $page }}
                                </a>
                            </li>
                            @endif
                            @endforeach

                            {{-- Next / Last --}}
                            @if ($authors->hasMorePages())
                            <li>
                                <a href="{{ $authors->nextPageUrl() }}"
                                    class="ajax-page ml-2 inline-flex items-center px-3 py-1.5 rounded-md bg-white border border-gray-200 text-sm text-gray-700 hover:bg-gray-50"
                                    aria-label="Next page">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 24 24"
                                        fill="currentColor" aria-hidden="true">
                                        <path
                                            d="M7 6l-.112 .006a1 1 0 0 0-.669 1.619l3.501 4.375-3.5 4.375a1 1 0 0 0 .78 1.625h6a1 1 0 0 0 .78-.375l4-5a1 1 0 0 0 0-1.25l-4-5a1 1 0 0 0-.78-.375h-6z" />
                                    </svg>
                                    {{ __("Next") }}
                                </a>
                            </li>
                            <li>
                                <a href="?page={{ $authors->lastPage() }}"
                                    class="ajax-page ml-2 inline-flex items-center px-3 py-1.5 rounded-md bg-white border border-gray-200 text-sm text-gray-700 hover:bg-gray-50">
                                    {{ __("Last Page") }}
                                </a>
                            </li>
                            @else
                            <li>
                                <span
                                    class="ml-2 inline-flex items-center px-3 py-1.5 rounded-md bg-gray-100 border border-gray-200 text-sm text-gray-400"
                                    aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 24 24"
                                        fill="currentColor">
                                        <path
                                            d="M17 6h-6a1 1 0 0 0-.78.375l-4 5a1 1 0 0 0 0 1.25l4 5a1 1 0 0 0 .78.375h6l.112-.006a1 1 0 0 0 .669-1.619l-3.501-4.375 3.5-4.375a1 1 0 0 0-.78-1.625z" />
                                    </svg>
                                    {{ __("Last Page") }}
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
