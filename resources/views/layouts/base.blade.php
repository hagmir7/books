<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    @php
    $options = $site->site_options ?? [];
    $isAr = app()->getLocale() === 'ar';
    $locale = $isAr ? 'ar_MA' : 'en_US';

    // Resolve per-page values (set via @section or view()->share())
    $metaTitle = isset($title) ? Str::limit(strip_tags($title), 60) : Str::limit($site->name, 60);
    $metaDescription = isset($description) ? Str::limit(strip_tags($description), 155) : Str::limit($site->description
    ?? '', 155);
    $metaKeywords = isset($tags) ? $tags : ($site->keywords ?? '');
    $metaImage = isset($image) ? asset('storage/' . $image) : asset('storage/' . $site->image);
    $metaUrl = request()->url(); // canonical without query string
    @endphp

    {{-- ══════════════════════════════════════════════
    CHARSET & VIEWPORT — must be first
    ══════════════════════════════════════════════ --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- ══════════════════════════════════════════════
    TITLE — 50-60 chars ideal
    ══════════════════════════════════════════════ --}}
    <title>{{ $metaTitle }}</title>

    {{-- ══════════════════════════════════════════════
    CORE META
    ══════════════════════════════════════════════ --}}
    <meta name="description" content="{{ $metaDescription }}">
    @if($metaKeywords)
    <meta name="keywords" content="{{ $metaKeywords }}">
    @endif
    <meta name="author" content="{{ $site->name }}">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Theme colors --}}
    <meta name="theme-color" content="{{ $site->theme_color ?? '#ff3131' }}">
    <meta name="msapplication-TileColor" content="{{ $site->theme_color ?? '#304466' }}">

    {{-- ══════════════════════════════════════════════
    CANONICAL & HREFLANG
    ══════════════════════════════════════════════ --}}
    <link rel="canonical" href="{{ $metaUrl }}">
    @if($isAr)
    <link rel="alternate" hreflang="ar" href="{{ $metaUrl }}">
    <link rel="alternate" hreflang="x-default" href="{{ $metaUrl }}">
    @endif
    <meta property="og:type" content="{{
        request()->is('blog*') ? 'article' :
        (request()->is('page*') ? 'page' :
        (request()->is('book*') ? 'book' : 'website'))
    }}">
    <meta property="og:url" content="{{ $metaUrl }}">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:image" content="{{ $metaImage }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:locale" content="{{ $locale }}">
    <meta property="og:site_name" content="{{ $site->name }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <meta name="twitter:image" content="{{ $metaImage }}">
    @stack('meta')

    {{-- ══════════════════════════════════════════════
    FAVICON
    ══════════════════════════════════════════════ --}}
    <link rel="icon" type="image/png" href="{{ asset('storage/' . $site->icon) }}">
    <link rel="apple-touch-icon" href="{{ asset('storage/' . $site->icon) }}">

    {{-- ══════════════════════════════════════════════
    SITEWIDE JSON-LD (WebSite + SearchAction)
    Article pages add their own via @push('scripts')
    ══════════════════════════════════════════════ --}}
    <script type="application/ld+json">
        {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "{{ addslashes($site->name) }}",
        "url": "{{ config('app.url') }}",
        "description": "{{ addslashes(Str::limit($site->description ?? '', 155)) }}",
        "inLanguage": "{{ app()->getLocale() }}",
        "publisher": {
            "@type": "Organization",
            "name": "{{ addslashes($site->name) }}",
            "url": "{{ config('app.url') }}",
            "logo": {
                "@type": "ImageObject",
                "url": "{{ asset('storage/' . $site->image) }}"
            }
        },
        "potentialAction": {
            "@type": "SearchAction",
            "target": {
                "@type": "EntryPoint",
                "urlTemplate": "{{ config('app.url') }}/?search={search_term_string}"
            },
            "query-input": "required name=search_term_string"
        }
    }
    </script>

    {{-- ══════════════════════════════════════════════
    PERFORMANCE: font preconnect before any @import
    ══════════════════════════════════════════════ --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- ══════════════════════════════════════════════
    ASSETS
    ══════════════════════════════════════════════ --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    {{-- ══════════════════════════════════════════════
    FONTS & BASE STYLES
    ══════════════════════════════════════════════ --}}
    @if($isAr)
    <link href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@160..700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: "Readex Pro", serif !important;
            font-optical-sizing: auto;
            font-weight: 500;
            font-style: normal;
            font-variation-settings: "HEXP" 0;
        }

        .home-book-list .book-list .book .book-info {
            padding: 0 31px 10px 0px !important;
        }

        .home-book-list .book-list .book .book-cover img {
            position: absolute;
            right: -20px !important;
            max-width: 110px;
            border-radius: 3px;
            box-shadow: 0 10px 60px 0 rgba(29, 29, 31, .09);
        }
    </style>
    @else
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Raleway", sans-serif;
        }

        p {
            font-size: 17px !important;
            font-weight: 600 !important;
        }

        hr {
            padding: 0 !important;
            margin: 0 !important;
            padding-bottom: 10px !important;
        }
    </style>
    @endif

    {{-- ══════════════════════════════════════════════
    SITE ADMIN: custom header code (analytics etc.)
    ══════════════════════════════════════════════ --}}
    {!! $site->header ?? '' !!}

    {{-- ══════════════════════════════════════════════
    GLOBAL UTILITY STYLES
    ══════════════════════════════════════════════ --}}
    <style>
        figure a img {
            width: 100% !important;
            height: auto !important;
        }

        .attachment__caption {
            display: none !important;
        }
    </style>

    {{-- ══════════════════════════════════════════════
    PER-PAGE STYLES (child views: @push('styles'))
    ══════════════════════════════════════════════ --}}
    @stack('styles')

    {{-- Google Site Verification --}}
    @if($site->google_verification ?? false)
    <meta name="google-site-verification" content="{{ $site->google_verification }}">
    @endif

    {{-- Google AdSense --}}
    @if($site->adsense_client ?? false)
    <script async
        src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ $site->adsense_client }}"
        crossorigin="anonymous"></script>
    @endif

</head>

<body class="bg-gray-50">

    {{-- ── Success Toast ──────────────────────────────────── --}}
    <div x-data="{ show: false, message: '' }"
        x-on:notify.window="message = $event.detail.message; show = true; setTimeout(() => show = false, 3000);"
        x-show="show" x-transition role="alert" aria-live="polite"
        class="fixed top-6 right-6 z-[300] bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg"
        style="display: none;">
        <span x-text="message"></span>
    </div>

    {{-- ── Header ──────────────────────────────────────────── --}}
    <header class="header bg-white shadow-sm relative" x-data="{ mobileOpen: false, searchOpen: false }"
        @keydown.escape.window="mobileOpen = false; searchOpen = false">
        <div class="px-4">
            <div class="flex items-center justify-between gap-4 py-2 sm:py-4">

                {{-- Logo --}}
                <div class="flex-shrink-0">
                    <a href="/" class="block" aria-label="{{ $site->name }}">
                        <img src="{{ asset('storage/' . $site->logo) }}" alt="{{ $site->name }}" width="160" height="48"
                            loading="eager" fetchpriority="high" class="h-8 sm:h-10 lg:h-12 w-auto object-contain">
                    </a>
                </div>

                {{-- Desktop Nav --}}
                <nav class="hidden lg:flex lg:flex-1 lg:justify-center" aria-label="Primary navigation">
                    <ul class="flex items-center gap-6 text-sm font-medium primary-menu">

                        @if($options['books_url'] ?? false)
                        <li>
                            <a href="/books" class="hover:text-primary transition-colors">
                                {{ __('Books') }}
                            </a>
                        </li>
                        @endif

                        @if($options['authors_url'] ?? false)
                        <li>
                            <a href="/authors" class="hover:text-primary transition-colors">
                                {{ __('Authors') }}
                            </a>
                        </li>
                        @endif

                        @if($options['blogs_url'] ?? false)
                        <li>
                            <a href="/blog" class="hover:text-primary transition-colors">
                                {{ __('Blog') }}
                            </a>
                        </li>
                        @endif

                        @if($options['contact_url'] ?? false)
                        <li>
                            <a href="{{ route('contact') }}" class="hover:text-primary transition-colors">
                                {{ __('Contact Us') }}
                            </a>
                        </li>
                        @endif

                        @foreach($site->urls as $url)
                        @if($url->header)
                        <li>
                            <a href="{{ $url->url }}" @if($url->new_tab) target="_blank" rel="noopener noreferrer"
                                @endif
                                class="hover:text-primary transition-colors">
                                {{ $url->name }}
                            </a>
                        </li>
                        @endif
                        @endforeach

                    </ul>
                </nav>

                {{-- Right Actions --}}
                <div class="flex items-center gap-3">

                    {{-- Desktop Search --}}
                    @if($options['books_search'] ?? false)
                    <div class="relative hidden md:block">
                        <form action="/books" method="GET" role="search">
                            <label for="desktop-search" class="sr-only">{{ __('Search books') }}</label>
                            <input id="desktop-search" name="search" type="search" placeholder="{{ __('Search') }}..."
                                class="w-64 px-3 py-2 pr-10 h-11 border border-gray-200 rounded-lg
                                          focus:outline-none focus:ring-2 focus:ring-primary">
                            <button type="submit" aria-label="{{ __('Search') }}"
                                class="absolute right-2 top-1/2 -translate-y-1/2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <circle cx="11" cy="11" r="7"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                            </button>
                        </form>
                    </div>
                    @endif

                    {{-- Auth --}}
                    <div class="flex items-center gap-2">
                        @auth
                        <a href="/profile" class="sm:inline-flex items-center gap-2 font-medium px-3 py-2.5
                                  rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors">
                            {{ Auth::user()->first_name ?? __('Account') }}
                        </a>
                        @endauth

                        @guest
                        @if($options['login_url'] ?? false)
                        <a href="{{ route('auth.login') }}" class="sm:inline-flex items-center gap-2 font-medium px-3 py-2.5
                                      rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors">
                            {{ __('Join us') }}
                        </a>
                        @endif
                        @endguest
                    </div>

                    {{-- Mobile Search Toggle --}}
                    @if($options['books_search'] ?? false)
                    <button @click="searchOpen = !searchOpen" class="md:hidden p-2.5 rounded-xl border border-gray-200"
                        aria-label="{{ __('Toggle search') }}" :aria-expanded="searchOpen">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <circle cx="11" cy="11" r="7"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </button>
                    @endif

                    {{-- Mobile Menu Toggle --}}
                    <button @click="mobileOpen = !mobileOpen" class="lg:hidden p-2.5 rounded-xl border border-gray-200"
                        aria-label="{{ __('Toggle menu') }}" :aria-expanded="mobileOpen" aria-controls="mobile-menu">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                </div>
            </div>

            {{-- Mobile Menu --}}
            <div id="mobile-menu" class="lg:hidden" x-show="mobileOpen" x-cloak>
                <div class="bg-white rounded-lg shadow-xl border border-gray-100
                            overflow-hidden absolute w-11/12 z-50">
                    <nav aria-label="Mobile navigation">
                        <ul class="flex flex-col text-base py-2">

                            @if($options['books_url'] ?? false)
                            <li><a href="/books" class="block px-4 py-3 hover:bg-gray-50">{{ __('Books') }}</a></li>
                            @endif

                            @if($options['authors_url'] ?? false)
                            <li><a href="/authors" class="block px-4 py-3 hover:bg-gray-50">{{ __('Authors') }}</a></li>
                            @endif

                            @if($options['blogs_url'] ?? false)
                            <li><a href="/blog" class="block px-4 py-3 hover:bg-gray-50">{{ __('Blog') }}</a></li>
                            @endif

                            @if($options['contact_url'] ?? false)
                            <li>
                                <a href="{{ route('contact') }}" class="block px-4 py-3 hover:bg-gray-50">
                                    {{ __('Contact Us') }}
                                </a>
                            </li>
                            @endif

                            @foreach($site->urls as $url)
                            @if($url->header)
                            <li>
                                <a href="{{ $url->url }}" @if($url->new_tab) target="_blank" rel="noopener noreferrer"
                                    @endif
                                    class="block px-4 py-3 hover:bg-gray-50">
                                    {{ $url->name }}
                                </a>
                            </li>
                            @endif
                            @endforeach

                        </ul>
                    </nav>
                </div>
            </div>

            {{-- Mobile Search --}}
            @if($options['books_search'] ?? false)
            <div class="lg:hidden absolute left-4 right-4 top-full mt-2 z-50" x-show="searchOpen" x-cloak>
                <div class="bg-white rounded-lg shadow-xl border border-gray-100 p-4">
                    <form action="/books" method="GET" role="search">
                        <label for="mobile-search" class="sr-only">{{ __('Search books') }}</label>
                        <div class="flex gap-2">
                            <input id="mobile-search" name="search" type="search" placeholder="{{ __('Search') }}..."
                                class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg
                                          focus:outline-none focus:ring-2 focus:ring-primary">
                            <button type="submit" class="px-5 py-2.5 bg-primary text-white rounded-lg
                                           hover:opacity-90 transition-opacity">
                                {{ __('Search') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

        </div>
    </header>

    {{-- ── Page Content ─────────────────────────────────── --}}
    <main id="main-content">
        @yield('content')
    </main>

    {{-- ── Footer ──────────────────────────────────────── --}}
    <x-footer />

    {{-- ── Floating Buttons ────────────────────────────── --}}
    <x-telegram-button />

    {{-- ── Admin footer injection (hidden from layout) ─── --}}
    <div class="hidden" aria-hidden="true">
        {!! $site->footer ?? '' !!}
    </div>

    <div id="fb-root"></div>

    {{-- ── Scripts ──────────────────────────────────────── --}}
    @livewireScriptConfig
    @stack('scripts')

</body>

</html>
