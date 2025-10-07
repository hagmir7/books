<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <title>{{ isset($title) ? Str::limit($title, 160) : $site->name }}</title>
    <meta name="description"
        content="{{ isset($description) ? Str::limit($description, 160) : Str::limit($site->description, 160) }}">
    <meta name="keywords" content="{{ isset($tags) ? $tags :  $site->keywords }}">
    <link rel="icon" type="image/png" href="{{ Storage::url($site->icon) }}" />
    <meta itemprop="image" content="{{ isset($image) ? Storage::url($image)  : Storage::url($site->image) }}">
    <link rel='canonical' href='{{ request()->fullUrl() }}' />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    @yield('head')

    @if (app()->getLocale() == 'ar')
    <link href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@160..700&display=swap" rel="stylesheet">
    <style>
        * {
            text-align: right;
            font-family: "Readex Pro", serif !important;
            font-optical-sizing: auto;
            font-weight: 500;
            font-style: normal;
            font-variation-settings: "HEXP" 0;
        }

        .books-listing .book-grid .book .book-info {
            padding: 0 31px 10px 0px !important;
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

<body>
    <header class="header shadow-sm">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap items-center">
                <!-- Logo -->
                <div class="w-1/2 lg:w-1/4 md:w-1/2">
                    <div class="logo">
                        <a href="/"><img src="{{ Storage::url($site->logo) }}" alt="{{ $site->name }}"></a>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="w-full lg:w-1/2 order-3 lg:order-2">
                    <nav class="navbar">
                        <div class="hidden lg:flex justify-center" id="navbarNav">
                            <ul class="flex space-x-6 rtl:space-x-reverse primary-menu">
                                @if ($site->site_options['books_url'])
                                <li class="nav-item">
                                    <a href="/books" title="{{ __('Books') }}"
                                        class="hover:text-primary transition-colors">{{ __("Books") }}</a>
                                </li>
                                @endif

                                @if ($site->site_options['authors_url'])
                                <li class="nav-item">
                                    <a href="/authors" title="{{ __('Authors') }}"
                                        class="hover:text-primary transition-colors">{{ __("Authors") }}</a>
                                </li>
                                @endif

                                @if ($site->site_options['blogs_url'])
                                <li class="nav-item">
                                    <a href="/blog" title="{{ __('Blog') }}"
                                        class="hover:text-primary transition-colors">{{ __("Blog") }}</a>
                                </li>
                                @endif

                                @if ($site->site_options['contact_url'])
                                <li class="nav-item">
                                    <a href="{{ route('contact') }}" title="{{ __('Contact Us') }}"
                                        class="hover:text-primary transition-colors">{{ __("Contact Us") }}</a>
                                </li>
                                @endif

                                @foreach ($site->urls as $url)
                                @if ($url->header)
                                <li class="nav-item">
                                    <a href="{{ $url->url }}" @if ($url->new_tab) target="_blank" @endif title="{{
                                        $url->name }}" class="hover:text-primary transition-colors">{{ $url->name }}</a>
                                </li>
                                @endif
                                @endforeach
                            </ul>
                        </div>
                    </nav>
                </div>

                <!-- User Menu & Mobile Toggle -->
                <div class="w-1/2 lg:w-1/4 md:w-1/2 flex gap-2 justify-end order-2 lg:order-3">
                    <div class="menu-icons flex items-center justify-end">
                        <div class="user-dropdown">
                            @auth
                            <a href="#!"
                                class="inline-flex items-center justify-center bg-primary text-white py-1 px-4 rounded hover:bg-primary/90 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-user-circle">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                    <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                    <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                                </svg>
                            </a>
                            @endauth

                            @if ($site->site_options['login_url'])
                            @guest
                            <button type="button"
                                class="bg-primary text-white px-4 py-2 rounded hover:bg-primary/90 transition-colors"
                                data-modal-toggle="login">
                                {{ __("Join us") }}
                            </button>
                            @endguest
                            @endif
                        </div>
                    </div>

                    <div class="menu-icons mobile-menu flex items-center justify-end lg:hidden">
                        <button class="bg-primary text-white py-1 px-3 rounded hover:bg-primary/90 transition-colors"
                            type="button" onclick="document.getElementById('navbarNav').classList.toggle('hidden')"
                            aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-menu-2">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 6l16 0" />
                                    <path d="M4 12l16 0" />
                                    <path d="M4 18l16 0" />
                                </svg>
                            </span>
                        </button>
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="w-full order-4">
                    <div class="search-header hidden">
                        <form action="/book/search" method="post" class="relative">
                            <input
                                class="w-full px-4 py-2 pr-20 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary search-input"
                                name="searchText" aria-describedby="search" type="search"
                                placeholder="{{ __('Search...') }}">
                            <button type="submit"
                                class="absolute right-12 top-1/2 -translate-y-1/2 rtl:right-auto rtl:left-12"
                                id="header-search">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                    <path d="M21 21l-6 -6" />
                                </svg>
                            </button>
                            <span
                                class="search-close absolute right-2 top-1/2 -translate-y-1/2 cursor-pointer rtl:right-auto rtl:left-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M18 6l-12 12" />
                                    <path d="M6 6l12 12" />
                                </svg>
                            </span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    @if ($site->site_options['login_url'])
    @livewire('auth-livewire')
    @endif

    @yield('content')

    <x-footer />

    <div class="hidden">{!! $site->footer !!}</div>
    <div id="fb-root"></div>

    @yield('footer')
</body>

</html>
