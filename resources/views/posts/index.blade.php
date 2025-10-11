@extends('layouts.base')

@section('content')
<section class="min-w-7xl py-8">
    <div class="mx-auto px-4">
        <div class="flex flex-wrap text-center justify-center">
            <div class="py-12 w-full md:w-1/2">
                <h1 class="text-2xl font-semibold mb-6">{{ $site->site_options['blog_title'] }}</h1>
                <form action="/blog" method="GET">
                    <div class="flex rounded-full border-2 border-gray-300 overflow-hidden bg-white shadow-sm">
                        <button class="bg-info text-white px-4 py-2 hover:bg-info/90 transition-colors flex-shrink-0"
                            type="submit" id="Search Button" title="Search Button" aria-label="Search">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5">
                                    <path d="M21 12a9 9 0 1 1-18 0a9 9 0 0 1 18 0"></path>
                                    <path
                                        d="M13.856 13.85a3.429 3.429 0 1 0-4.855-4.842a3.429 3.429 0 0 0 4.855 4.842m0 0L16 16">
                                    </path>
                                </g>
                            </svg>
                        </button>
                        <input type="search" name="q"
                            class="flex-1 px-4 py-3 rounded-r-full focus:outline-none focus:ring-2 focus:ring-primary rtl:rounded-r-none rtl:rounded-l-full"
                            value="{{ request()->query('q', '') }}"
                            placeholder="{{ app('site')?->site_options['search_label'] ?? __('Search') . '...' }}">
                    </div>
                </form>
            </div>
        </div>

        <div class="flex flex-wrap -mx-2">
            @forelse ($posts as $post)
            <div class="w-full md:w-1/2 lg:w-1/3 px-2 mb-6">
                <div class="post bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                    <div class="post-img overflow-hidden">
                        <a href="{{ route('blog.show', $post->slug) }}" class="block">
                            <img src="{{ asset('storage/'.$post->image) }}" alt="{{ $post->title }}"
                                class="w-full h-48 object-cover hover:scale-105 transition-transform duration-300">
                        </a>
                    </div>
                    <div class="post-info p-4">
                        <div class="post-meta text-sm text-gray-500 mb-2">
                            {{ $post->created_at->locale(app()->getLocale())->translatedFormat('M d, Y') }}
                        </div>
                        <a href="{{ route('blog.show', $post->slug) }}" class="post-title block">
                            <h2
                                class="text-xl font-semibold text-gray-900 hover:text-primary transition-colors line-clamp-2">
                                {{ $post->title }}
                            </h2>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="flex justify-center w-full py-12">
                <img src="{{ asset('imgs/empty.png') }}" alt="Empty image" class="max-w-xs">
            </div>
            @endforelse
        </div>

        <div class="mt-6 pb-8">
            {{ $posts->links() }}
        </div>
    </div>
</section>
@endsection
