<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <title>{{ isset($title) ? Str::limit($title, 160) : $site->name }}</title>
    <meta name="description"
        content="{{ isset($description) ? Str::limit($description, 160) : Str::limit($site->description, 160) }}">
    <meta name="keywords" content="{{ isset($tags) ? $tags :  $site->keywords }}">
    <link rel="icon" type="image/png" href="{{ asset('storage/'.$site->icon) }}" />
    <meta itemprop="image" content="{{ isset($image) ? asset('storage/'.$image)  : asset('storage/'.$site->image) }}">
    <link rel='canonical' href='{{ request()->fullUrl() }}' />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- @vite('resources/css/app.css') --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('head')
    @livewireStyles

    @if (app()->getLocale() == 'ar')
    <link href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@160..700&display=swap" rel="stylesheet">
    <style>
        * {
            /* text-align: right; */
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
        *{
            font-weight: 600!important;
        }
        body {
            font-family: "Raleway", sans-serif;
        }
        p{
            font-size: 17px!important;
            font-weight: 600!important;
        }
        hr{
            padding: 0!important;
            margin: 0!important;
            padding-bottom: 10px!important;
        }
    </style>
    @endif

    @vite(['resources/js/app.js'])
    {!! $site->header !!}

    <style>
        figure a img {
            width: 100% !important;
            height: auto !important;
        }

        .attachment__caption {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-50">

<header class="header bg-white shadow-sm relative" x-data="{ mobileOpen: false, searchOpen: false }"
    @keydown.escape.window="mobileOpen = false; searchOpen = false">
    <div class="px-4">
        <div class="flex items-center justify-between gap-4 py-2 sm:py-4">

            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="/" class="block" :aria-label="$el?.querySelector('img')?.alt || '{{ $site->name }}'">
                    <img src="{{ asset('storage/'.$site->logo) }}" alt="{{ $site->name }}" loading="lazy" class="h-8 sm:h10 lg:h-12 object-contain">
                </a>
            </div>

            <!-- Desktop Nav (center) -->
            <nav class="hidden lg:flex lg:flex-1 lg:justify-center" aria-label="Primary">
                <ul class="flex items-center gap-6 text-sm font-medium primary-menu">
                    @if ($site->site_options['books_url'])
                    <li><a href="/books" class="hover:text-primary transition-colors" title="{{ __('Books') }}">{{
                            __('Books') }}</a></li>
                    @endif

                    @if ($site->site_options['authors_url'])
                    <li><a href="/authors" class="hover:text-primary transition-colors" title="{{ __('Authors') }}">{{
                            __('Authors') }}</a></li>
                    @endif

                    @if ($site->site_options['blogs_url'])
                    <li><a href="/blog" class="hover:text-primary transition-colors" title="{{ __('Blog') }}">{{
                            __('Blog') }}</a></li>
                    @endif

                    @if ($site->site_options['contact_url'])
                    <li><a href="{{ route('contact') }}" class="hover:text-primary transition-colors"
                            title="{{ __('Contact Us') }}">{{ __('Contact Us') }}</a></li>
                    @endif

                    @foreach ($site->urls as $url)
                    @if ($url->header)
                    <li>
                        <a href="{{ $url->url }}" @if ($url->new_tab) target="_blank" rel="noopener" @endif
                            class="hover:text-primary transition-colors" title="{{ $url->name }}">
                            {{ $url->name }}
                        </a>
                    </li>
                    @endif
                    @endforeach
                </ul>
            </nav>

            <!-- Right actions -->
            <div class="flex items-center gap-3">

                <!-- Search (desktop visible) -->
                <div class="relative hidden md:block">
                    <form action="/books" method="GET" class="relative" role="search" aria-label="Site search">
                        <input name="search" type="search" aria-describedby="search"
                            placeholder="{{ __('Search') }}..."
                            class="w-64 px-3 py-2 pr-10 h-11  border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2" aria-label="Search">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="11" cy="11" r="7"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </button>
                    </form>
                </div>

                <!-- Auth / Join -->
                <div class="flex items-center gap-2">
                    @auth
                    <a href="#!"
                        class="sm:inline-flex items-center gap-2 bg-primar font-medium px-3 py-2.5 rounded-xl border border-gray-200 hover:bg-primary/90 hover:shadow-lg active:scale-95 transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary/50"
                        title="Profile">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8z"></path>
                            <path d="M6 20v-1a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v1"></path>
                        </svg>
                        <span class="hidden sm:inline">{{ Auth::user()->first_name ?? __('Account') }}</span>
                    </a>
                    @endauth

                    @guest
                    @if ($site->site_options['login_url'])
                    <a href="{{ route("auth.login") }}" class="sm:inline-flex items-center gap-2 bg-primar font-medium px-3 py-2.5 rounded-xl border border-gray-200 hover:bg-primary/90 hover:shadow-lg active:scale-95 transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary/50">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-user">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                        </svg>
                        <span class="hidden md:block whitespace-nowrap">{{ __('Join us') }}</span>
                    </a>
                    @endif
                    @endguest
                </div>

                <!-- Mobile: search toggle -->
                <button @click="searchOpen = !searchOpen"
                    class="md:hidden items-center gap-2 bg-primar font-medium px-3 py-2.5 rounded-xl border border-gray-200 hover:bg-primary/90 hover:shadow-lg active:scale-95 transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary/50"
                    :aria-pressed="searchOpen.toString()" aria-label="Toggle search">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="7"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>

                <!-- Mobile: hamburger -->
                <button @click="mobileOpen = !mobileOpen" :aria-expanded="mobileOpen.toString()"
                    aria-controls="mobile-menu"
                    class="md:hidden items-center gap-2 bg-primar font-medium px-3 py-2.5 rounded-xl border border-gray-200 hover:bg-primary/90 hover:shadow-lg active:scale-95 transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary/50"
                    aria-label="Toggle navigation">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

    <!-- Mobile menu (collapsible dropdown) -->
    <div id="mobile-menu" class="lg:hidden" x-show="mobileOpen" x-cloak
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4"
        :aria-hidden="(!mobileOpen).toString()" class="absolute  top-full mt-2 z-50">
        <div class="bg-white rounded-lg shadow-xl border border-gray-100 overflow-hidden absolute w-11/12 z-50">
            <nav aria-label="Mobile Primary">
                <ul class="flex flex-col text-base py-2">
                    @if ($site->site_options['books_url'])
                    <li class="border-b border-gray-50 last:border-b-0">
                        <a href="/books"
                            class="block px-4 py-3 hover:bg-gradient-to-r hover:from-primary/5 hover:to-transparent transition-all duration-200 hover:pl-5 active:bg-primary/10">
                            <span class="font-medium text-gray-700 hover:text-primary transition-colors">{{ __('Books')
                                }}</span>
                        </a>
                    </li>
                    @endif

                    @if ($site->site_options['authors_url'])
                    <li class="border-b border-gray-50 last:border-b-0">
                        <a href="/authors"
                            class="block px-4 py-3 hover:bg-gradient-to-r hover:from-primary/5 hover:to-transparent transition-all duration-200 hover:pl-5 active:bg-primary/10">
                            <span class="font-medium text-gray-700 hover:text-primary transition-colors">{{ __('Authors')
                                }}</span>
                        </a>
                    </li>
                    @endif

                    @if ($site->site_options['blogs_url'])
                    <li class="border-b border-gray-50 last:border-b-0">
                        <a href="/blog"
                            class="block px-4 py-3 hover:bg-gradient-to-r hover:from-primary/5 hover:to-transparent transition-all duration-200 hover:pl-5 active:bg-primary/10">
                            <span class="font-medium text-gray-700 hover:text-primary transition-colors">{{ __('Blog')
                                }}</span>
                        </a>
                    </li>
                    @endif

                    @if ($site->site_options['contact_url'])
                    <li class="border-b border-gray-50 last:border-b-0">
                        <a href="{{ route('contact') }}"
                            class="block px-4 py-3 hover:bg-gradient-to-r hover:from-primary/5 hover:to-transparent transition-all duration-200 hover:pl-5 active:bg-primary/10">
                            <span class="font-medium text-gray-700 hover:text-primary transition-colors">{{ __('Contact Us') }}</span>
                        </a>
                    </li>
                    @endif

                    @foreach ($site->urls as $url)
                    @if ($url->header)
                    <li class="border-b border-gray-50 last:border-b-0">
                        <a href="{{ $url->url }}" @if ($url->new_tab) target="_blank" rel="noopener" @endif
                            class="block px-4 py-3 hover:bg-gradient-to-r hover:from-primary/5 hover:to-transparent
                            transition-all duration-200 hover:pl-5 active:bg-primary/10">
                            <span
                                class="font-medium text-gray-700 hover:text-primary transition-colors inline-flex items-center gap-2">
                                {{ $url->name }}
                                @if ($url->new_tab)
                                <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                @endif
                            </span>
                        </a>
                    </li>
                    @endif
                    @endforeach
                </ul>
            </nav>
        </div>
    </div>

    <!-- Mobile search (separate floating panel) -->
    <div id="mobile-search-wrapper" class="lg:hidden absolute left-4 right-4 top-full mt-2 z-50" x-show="searchOpen" x-cloak
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4">
        <div class="bg-white rounded-lg shadow-xl border border-gray-100 p-4">
            <form action="/books" method="GET" role="search" aria-label="Mobile search">
                <div class="flex gap-2">
                    <input name="search" type="search" placeholder="{{ __('Search') }}..."
                        class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent bg-white shadow-sm text-sm"
                        autofocus>
                    <button type="submit"
                        class="px-5 py-2.5 bg-primary rounded-lg font-medium hover:bg-primary/90 active:bg-primary/80 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 whitespace-nowrap">
                        {{ __('Search') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    </div>
</header>

    @yield('content')

    <x-footer />
    <x-telegram-button />

    <div class="hidden">{!! $site->footer !!}</div>
    <div id="fb-root"></div>
    {{-- @livewireScripts --}}
    @livewireScriptConfig
    @yield('footer')
</body>

</html>
