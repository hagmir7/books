@extends('layouts.base')

@section('content')

{{-- @push('scripts')
<script type="application/ld+json">
    {
    "@context": "https://schema.org",
    "@type": "CollectionPage",
    "name": "{{ addslashes(__('Blog')) }} - {{ addslashes($site->name) }}",
    "url": "{{ request()->url() }}",
    "description": "{{ addslashes(Str::limit($site->description ?? '', 155)) }}",
    "inLanguage": "{{ app()->getLocale() }}",
    "breadcrumb": {
        "@type": "BreadcrumbList",
        "itemListElement": [
            {
                "@type": "ListItem",
                "position": 1,
                "name": "{{ __('Home') }}",
                "item": "{{ config('app.url') }}"
            },
            {
                "@type": "ListItem",
                "position": 2,
                "name": "{{ __('Blog') }}",
                "item": "{{ config('app.url') }}/blog"
            }
        ]
    },
    "mainEntity": {
        "@type": "ItemList",
        "itemListElement": [
            @foreach($posts as $i => $post)
            {
                "@type": "ListItem",
                "position": {{ $i + 1 }},
                "url": "{{ route('blog.show', $post->slug) }}",
                "name": "{{ addslashes($post->title) }}"
            }{{ !$loop->last ? ',' : '' }}
            @endforeach
        ]
    }
}
</script>
@endpush --}}

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mx-auto">

        @if(!request()->is('/'))
        {{-- ── Breadcrumb ──────────────────────────────────────── --}}
        <nav aria-label="{{ __('Breadcrumb') }}" class="mb-6 text-sm text-gray-500">
            <ol class="flex flex-wrap items-center gap-1.5" itemscope itemtype="https://schema.org/BreadcrumbList">

                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a href="{{ config('app.url') }}" itemprop="item" class="hover:text-green-600 transition-colors">
                        <span itemprop="name">{{ __('Home') }}</span>
                    </a>
                    <meta itemprop="position" content="1">
                </li>

                <li class="text-gray-300" aria-hidden="true">/</li>

                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <span itemprop="name" class="text-gray-700 font-medium">{{ __('Blog') }}</span>
                    <meta itemprop="position" content="2">
                </li>
            </ol>
        </nav>
        @endif

        {{-- ── Live Search (Livewire) ──────────────────────────── --}}
        @livewire('post-search')

        {{-- ── Posts Grid ──────────────────────────────────────── --}}
        <div class="mt-8">
            @if($posts->count())

            <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @foreach($posts as $i => $post)

                {{-- Determine loading strategy:
                First 4 cards are likely above fold → eager load.
                The rest → lazy load. --}}
                @php
                $isAboveFold = $i < 4; $loading=$isAboveFold ? 'eager' : 'lazy' ; $fetchprio=$isAboveFold ? 'high'
                    : 'low' ; @endphp <article class="post bg-white rounded-lg overflow-hidden shadow-sm
                           hover:shadow-md transition-shadow flex flex-col h-full" itemscope
                    itemtype="https://schema.org/BlogPosting">

                    {{-- Hidden schema meta --}}
                    <meta itemprop="datePublished" content="{{ $post->created_at->toIso8601String() }}">
                    <meta itemprop="dateModified" content="{{ $post->updated_at->toIso8601String() }}">
                    <meta itemprop="author" content="{{ $site->name }}">
                    <link itemprop="url" href="{{ route('blog.show', $post->slug) }}">

                    {{-- Card Image --}}
                    <a href="{{ route('blog.show', $post->slug) }}" class="block overflow-hidden" tabindex="-1"
                        aria-hidden="true">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" width="400"
                            height="225" loading="{{ $loading }}" fetchpriority="{{ $fetchprio }}" decoding="async"
                            itemprop="image" class="w-full object-cover transition-transform duration-300
                                    hover:scale-105 h-48 sm:h-56 md:h-44 lg:h-56">
                    </a>

                    {{-- Card Body --}}
                    <div class="post-info p-4 flex-1 flex flex-col gap-2">

                        {{-- Date --}}
                        <div class="flex items-center gap-1.5 text-xs text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" aria-hidden="true">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M12 12l3 -2" />
                                <path d="M12 7v5" />
                            </svg>
                            <time datetime="{{ $post->created_at->toIso8601String() }}" itemprop="datePublished">
                                {{ $post->created_at->locale(app()->getLocale())->translatedFormat('M d, Y') }}
                            </time>
                        </div>

                        {{-- Title --}}
                        <a href="{{ route('blog.show', $post->slug) }}" class="block mt-auto">
                            <h2 class="text-sm sm:text-base font-semibold text-gray-900
                                       hover:text-primary transition-colors line-clamp-2" itemprop="headline">
                                {{ $post->title }}
                            </h2>
                        </a>

                        {{-- Excerpt (improves AdSense quality signal + UX) --}}
                        @if($post->description ?? false)
                        <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed" itemprop="description">
                            {{ Str::limit(strip_tags($post->description), 100) }}
                        </p>
                        @endif

                        {{-- Read more link (improves crawlability) --}}
                        <a href="{{ route('blog.show', $post->slug) }}" class="mt-2 inline-flex items-center gap-1 text-xs font-medium
                                  text-green-600 hover:text-green-700 transition-colors"
                            aria-label="{{ __('Read') }}: {{ $post->title }}">
                            {{ __('Read more') }}
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round" aria-hidden="true">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                {{-- arrow direction flips with RTL automatically --}}
                                <path d="M9 6l6 6l-6 6" />
                            </svg>
                        </a>

                    </div>
                    </article>

                    @endforeach
            </div>

            @else

            {{-- ── Empty State ───────────────────────────────── --}}
            <div class="flex flex-col items-center justify-center py-20 gap-4 text-center">
                <img src="{{ asset('imgs/empty.png') }}" alt="{{ __('No posts found') }}" width="220" height="220"
                    loading="lazy" class="max-w-[180px] sm:max-w-[220px] opacity-75">
                <p class="text-gray-500 text-sm">{{ __('No posts found.') }}</p>
                <a href="{{ config('app.url') }}/blog" class="text-sm text-green-600 hover:underline">
                    {{ __('View all posts') }}
                </a>
            </div>

            @endif
        </div>

        {{-- ── Pagination ───────────────────────────────────────── --}}
        @if($posts->hasPages())
        <div class="mt-8 pb-8 flex justify-center">
            {{ $posts->links('pagination::tailwind') }}
        </div>
        @endif

    </div>
</section>

@endsection
