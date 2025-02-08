<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === "ar" ? "rtl" : "ltr" }}">

<head>
    <meta charset="UTF-8">
    <title>{{ isset($title) ? Str::limit($title, 160) : $site->name }}</title>
    <meta name="description" content="{{ isset($description) ? Str::limit($description, 160) : Str::limit($site->description, 160) }}">
    <meta name="keywords" content="{{ isset($tags) ? $tags :  $site->keywords }}">
    <link rel="icon" type="image/png" href="{{ Storage::url($site->icon) }}" />
    <meta itemprop="image" content="{{ isset($image) ? Storage::url($image)  : Storage::url($site->image) }}">
    <link rel='canonical' href='{{ request()->fullUrl() }}' />
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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



            .books-listing .book-grid .book .book-info{
                padding: 0 31px 10px 0px !important;
            }

            .home-book-list .book-list .book .book-info {
                padding: 0 31px 10px 0px !important;
            }

            .home-book-list .book-list .book .book-cover img {
                position: absolute;
                right: -20px!important;
                max-width: 110px;
                border-radius: 3px;
                box-shadow: 0 10px 60px 0 rgba(29, 29, 31, .09);
            }
        </style>
    @endif

    @if (app()->getLocale() == 'ar')
        @vite(['resources/js/app.js'])
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
    @else
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @endif
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    {!! $site->header !!}

    <style>
            figure a img{
                width: 100%!important;
                height:auto!important;
            }
            .attachment__caption{
                display: none!important;
            }
    </style>
</head>

<body>
    <header class="header shadow-sm">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="logo">
                        <a href="/"><img src="{{ Storage::url($site->logo) }}" alt="{{ $site->name }}"></a>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <nav class="navbar navbar-expand-lg">
                        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                            <ul class="navbar-nav primary-menu">
                                @if ($site->site_options['books_url'])
                                <li class="nav-item ">
                                    <a href="/books" title="{{ __(" Books") }}"> {{ __("Books") }} </a>
                                </li>
                                @endif

                                @if ($site->site_options['authors_url'])
                                <li class="nav-item ">
                                    <a href="/authors" title="{{ __(" Authors") }}">{{ __("Authors") }} </a>
                                </li>
                                @endif
                                @if ($site->site_options['blogs_url'])
                                <li class="nav-item ">
                                    <a href="/blog" title="{{ __(" Blog") }}">{{ __("Blog") }} </a>
                                </li>
                                @endif

                                @if ($site->site_options['contact_url'])
                                <li class="nav-item ">
                                    <a href="{{ route("contact") }}" title="{{ __("Contact Us") }}"> {{ __("Contact Us") }} </a>
                                </li>
                                @endif

                                @foreach ($site->urls as $url)
                                @if ($url->header)
                                <li class="nav-item ">
                                    <a href="{{ $url->url }}" @if ($url->new_tab) target="_blanck" @endif title="{{ $url->name }}">{{ $url->name }} </a>
                                </li>
                                @endif
                                @endforeach
                            </ul>
                        </div>
                    </nav>
                </div>
                <div class="col-6 col-lg-3 col-md-6 d-flex gap-2 p-0 m-0 justify-content-end">
                    <div class="menu-icons d-flex text-right align-items-center justify-content-end">
                        <div class="user-dropdown">
                            @auth
                            <a href="#!" class="btn btn-primary p-1 px-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-user-circle text-white">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                    <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                    <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                                </svg>
                            </a>
                            @endauth

                            @if ($site->site_options['login_url'])
                            @guest
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#login">
                                {{ __("Join us") }}
                            </button>
                            @endguest
                            @endif
                        </div>
                    </div>

                    <div class="menu-icons mobile-menu d-flex text-right align-items-center justify-content-end">
                        <button class="btn btn-primary py-1" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
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

                <div class="col-12">
                    <div class="search-header hide">
                        <form action="/book/search" method="post">
                            <input class="form-control search-input" name="searchText" aria-describedby="search"
                                type="search">
                            <button type="submit" class="btn" id="header-search">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                    <path d="M21 21l-6 -6" />
                                </svg>
                            </button>
                            <span class="search-close">
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
    <div class="d-none">{!! $site->footer !!}</div>
    <div id="fb-root"></div>
    @yield('footer')
</body>

</html>
