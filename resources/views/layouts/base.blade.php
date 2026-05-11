<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    @php
    $options = $site->site_options ?? [];
    @endphp

    <meta charset="UTF-8">
    <title>
        {{ isset($title) ? Str::limit($title, 160) : $site->name }}
    </title>

    <meta name="description"
        content="{{ isset($description) ? Str::limit($description, 160) : Str::limit($site->description, 160) }}">

    <meta name="keywords" content="{{ isset($tags) ? $tags : ($site->keywords ?? '') }}">

    <link rel="icon" type="image/png" href="{{ asset('storage/' . $site->icon) }}" />

    <meta itemprop="image"
        content="{{ isset($image) ? asset('storage/' . $image) : asset('storage/' . $site->image) }}">

    <link rel="canonical" href="{{ request()->fullUrl() }}" />

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('head')

    @livewireStyles

    @if (app()->getLocale() == 'ar')
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
    <style>
        * {
            font-weight: 600 !important;
        }

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

    {!! $site->header ?? '' !!}

    <style>
        figure a img {
            width: 100% !important;
            height: auto !important;
        }

        .attachment__caption {
            display: none !important;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-gray-50">

    {{-- Success Toast --}}
    <div x-data="{ show: false, message: '' }" x-on:notify.window="
            message = $event.detail.message;
            show = true;
            setTimeout(() => show = false, 3000);
        " x-show="show" x-transition
        class="fixed top-6 right-6 z-[100] bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg"
        style="display: none; z-index: 300;">

        <span x-text="message"></span>
    </div>

    <header class="header bg-white shadow-sm relative" x-data="{ mobileOpen: false, searchOpen: false }"
        @keydown.escape.window="mobileOpen = false; searchOpen = false">

        <div class="px-4">

            <div class="flex items-center justify-between gap-4 py-2 sm:py-4">

                {{-- Logo --}}
                <div class="flex-shrink-0">
                    <a href="/" class="block" :aria-label="$el?.querySelector('img')?.alt || '{{ $site->name }}'">

                        <img src="{{ asset('storage/' . $site->logo) }}" alt="{{ $site->name }}" loading="lazy"
                            class="h-8 sm:h10 lg:h-12 object-contain">
                    </a>
                </div>

                {{-- Desktop Nav --}}
                <nav class="hidden lg:flex lg:flex-1 lg:justify-center" aria-label="Primary">

                    <ul class="flex items-center gap-6 text-sm font-medium primary-menu">

                        @if (($options['books_url'] ?? false))
                        <li>
                            <a href="/books" class="hover:text-primary transition-colors">
                                {{ __('Books') }}
                            </a>
                        </li>
                        @endif

                        @if (($options['authors_url'] ?? false))
                        <li>
                            <a href="/authors" class="hover:text-primary transition-colors">
                                {{ __('Authors') }}
                            </a>
                        </li>
                        @endif

                        @if (($options['blogs_url'] ?? false))
                        <li>
                            <a href="/blog" class="hover:text-primary transition-colors">
                                {{ __('Blog') }}
                            </a>
                        </li>
                        @endif

                        @if (($options['contact_url'] ?? false))
                        <li>
                            <a href="{{ route('contact') }}" class="hover:text-primary transition-colors">
                                {{ __('Contact Us') }}
                            </a>
                        </li>
                        @endif

                        @foreach ($site->urls as $url)
                        @if ($url->header)
                        <li>
                            <a href="{{ $url->url }}" @if ($url->new_tab) target="_blank" rel="noopener" @endif
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

                    {{-- Search --}}
                    @if (($options['books_search'] ?? false))
                    <div class="relative hidden md:block">

                        <form action="/books" method="GET" class="relative">

                            <input name="search" type="search" placeholder="{{ __('Search') }}..."
                                class="w-64 px-3 py-2 pr-10 h-11 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">

                            <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2">

                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2">

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
                        <a href="/profile"
                            class="sm:inline-flex items-center gap-2 font-medium px-3 py-2.5 rounded-xl border border-gray-200">

                            <span>
                                {{ Auth::user()->first_name ?? __('Account') }}
                            </span>

                        </a>
                        @endauth

                        @guest
                        @if (($options['login_url'] ?? false))
                        <a href="{{ route('auth.login') }}"
                            class="sm:inline-flex items-center gap-2 font-medium px-3 py-2.5 rounded-xl border border-gray-200">

                            <span>
                                {{ __('Join us') }}
                            </span>

                        </a>
                        @endif
                        @endguest

                    </div>

                    {{-- Mobile Search Toggle --}}
                    <button @click="searchOpen = !searchOpen"
                        class="md:hidden items-center gap-2 font-medium px-3 py-2.5 rounded-xl border border-gray-200">

                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">

                            <circle cx="11" cy="11" r="7"></circle>

                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>

                    </button>

                    {{-- Mobile Menu Toggle --}}
                    <button @click="mobileOpen = !mobileOpen"
                        class="md:hidden items-center gap-2 font-medium px-3 py-2.5 rounded-xl border border-gray-200">

                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">

                            <path d="M4 6h16M4 12h16M4 18h16"></path>

                        </svg>

                    </button>

                </div>
            </div>

            {{-- Mobile Menu --}}
            <div id="mobile-menu" class="lg:hidden" x-show="mobileOpen" x-cloak>

                <div class="bg-white rounded-lg shadow-xl border border-gray-100 overflow-hidden absolute w-11/12 z-50">

                    <nav>

                        <ul class="flex flex-col text-base py-2">

                            @if (($options['books_url'] ?? false))
                            <li>
                                <a href="/books" class="block px-4 py-3">
                                    {{ __('Books') }}
                                </a>
                            </li>
                            @endif

                            @if (($options['authors_url'] ?? false))
                            <li>
                                <a href="/authors" class="block px-4 py-3">
                                    {{ __('Authors') }}
                                </a>
                            </li>
                            @endif

                            @if (($options['blogs_url'] ?? false))
                            <li>
                                <a href="/blog" class="block px-4 py-3">
                                    {{ __('Blog') }}
                                </a>
                            </li>
                            @endif

                            @if (($options['contact_url'] ?? false))
                            <li>
                                <a href="{{ route('contact') }}" class="block px-4 py-3">
                                    {{ __('Contact Us') }}
                                </a>
                            </li>
                            @endif

                            @foreach ($site->urls as $url)
                            @if ($url->header)
                            <li>
                                <a href="{{ $url->url }}" @if ($url->new_tab) target="_blank" rel="noopener" @endif
                                    class="block px-4 py-3">

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
            @if (($options['books_search'] ?? false))
            <div class="lg:hidden absolute left-4 right-4 top-full mt-2 z-50" x-show="searchOpen" x-cloak>

                <div class="bg-white rounded-lg shadow-xl border border-gray-100 p-4">

                    <form action="/books" method="GET">

                        <div class="flex gap-2">

                            <input name="search" type="search" placeholder="{{ __('Search') }}..."
                                class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg">

                            <button type="submit" class="px-5 py-2.5 bg-primary rounded-lg">

                                {{ __('Search') }}

                            </button>

                        </div>

                    </form>

                </div>

            </div>
            @endif

        </div>

    </header>

    @yield('content')

    <x-footer />

    <x-telegram-button />

    <div class="hidden">
        {!! $site->footer ?? '' !!}
    </div>

    <div id="fb-root"></div>

    @livewireScriptConfig

    @yield('footer')

    @stack('scripts')

</body>

</html>
