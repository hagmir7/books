@extends('layouts.base')

@section('content')
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mx-auto">
        <!-- Search / title -->
        <div class="flex flex-col items-center justify-center text-center gap-6">
            <div class="w-full md:w-3/5 lg:w-1/2">
                <div class="flex justify-center">
                    <h1 class="text-xl sm:text-2xl font-semibold mb-4">{{ $site->site_options['blog_title'] }}</h1>
                </div>

                <form action="/blog" method="GET" class="w-full">
                    <div class="flex flex-col sm:flex-row items-center gap-3">
                        <input type="search" name="q" value="{{ request()->query('q', '') }}"
                            placeholder="{{ app('site')?->site_options['search_label'] ?? __('Search') . '...' }}"
                            class="w-full rounded-full px-4 py-3 focus:outline-none border-2 border-gray-200 bg-white shadow-sm text-sm"
                            aria-label="Search posts" />
                    </div>
                </form>
            </div>
        </div>

        <!-- Posts grid -->
        <div class="mt-8">
            <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @forelse ($posts as $post)
                <article
                    class="post bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow flex flex-col h-full">
                    <a href="{{ route('blog.show', $post->slug) }}" class="block overflow-hidden">
                        <img src="{{ asset('storage/'.$post->image) }}" alt="{{ $post->title }}" loading="lazy" class="w-full object-cover transition-transform duration-300 transform hover:scale-105
                                       h-48 sm:h-56 md:h-44 lg:h-56">
                    </a>

                    <div class="post-info p-4 flex-1 flex flex-col">
                        <div class="post-meta text-sm text-gray-500 mb-2">
                            {{ $post->created_at->locale(app()->getLocale())->translatedFormat('M d, Y') }}
                        </div>

                        <a href="{{ route('blog.show', $post->slug) }}" class="post-title block mt-auto">
                            <h2 class="text-md sm:text-lg font-semibold text-gray-900 hover:text-primary transition-colors line-clamp-2">
                                {{ $post->title }}
                            </h2>
                        </a>
                    </div>
                </article>
                @empty
                <div class="flex justify-center w-full py-12">
                    <img src="{{ asset('imgs/empty.png') }}" alt="No posts" class="max-w-[220px] sm:max-w-xs">
                </div>
                @endforelse
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6 pb-8 flex justify-center">
            {{ $posts->links('pagination::tailwind') }}
        </div>
    </div>
</section>
@endsection
