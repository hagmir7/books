<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>{{ isset($title) ? $title : $site->name }}</title>
    <meta name="description" content="{{ isset($description) ? $description : $site->description }}">
    <meta name="keywords" content="{{ isset($tags) ? $tags :  $site->keywords }}">
    <link rel="icon" type="image/png" href="{{ Storage::url($site->icon) }}" />
    <meta itemprop="image" content="{{ isset($image) ? Storage::url($image)  : Storage::url($site->image) }}">
    <link rel='canonical' href='{{ request()->url() }}' />
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/carousel.min.css') }}">

    @yield('head')
   {!! $site->header !!}
</head>

<body>
    <header class="header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="logo">
                        <a href="/"><img src="{{ Storage::url($site->logo) }}" alt="{{ $site->name }}"></a>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <nav class="navbar navbar-expand-lg">
                        <div class="collapse navbar-collapse justify-content-center" id="header-menu">
                            <ul class="navbar-nav primary-menu">
                                <li class="nav-item ">
                                    <a href="/books" title="{{ __("Books") }}"> {{ __("Books") }} </a>
                                </li>

                                <li class="nav-item ">
                                    <a href="/authors" title="{{ __("Authors") }}">{{ __("Authors") }} </a>
                                </li>

                                <li class="nav-item ">
                                    <a href="{{ route("contact") }}" title="{{ __("Contact Us") }}"> {{ __("Contact Us") }} </a>
                                </li>

                                <li class="nav-item ">
                                    <a href="/blog" title="{{ __("Blog") }}">{{ __("Blog") }} </a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="menu-icons d-flex text-right align-items-center justify-content-end">
                        <div class="user-dropdown">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#login">
                                {{ __("Join us") }}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="search-header hide">
                        <form action="/book/search" method="post">
                            <input class="form-control search-input" name="searchText" aria-describedby="search"
                                type="search">
                            <button type="submit" class="btn" id="header-search">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                    <path d="M21 21l-6 -6" />
                                </svg>
                            </button>
                            <span class="search-close">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-x">
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
        <!--HeaderCode-->
    </header>


    @livewire('auth-livewire')

    @yield('content')
    <x-footer />
    <div class="d-none">{!! $site->footer !!}</div>


    {{-- Langauge menu --}}

    {{-- <script src="{{ asset("js/popper.min.js") }}"></script>
    <script src="{{ asset("js/bootstrap.min.js") }}"></script>

    <script src="{{ asset("js/carousel.min.js") }}"></script>

    <script src="{{ asset("js/plugins.js") }}"></script>
    <script src="{{ asset("js/custom.js") }}"></script> --}}



    {{-- <script>
        $('.home-book-carousel').owlCarousel({
            center: true,
            items: 3,
            loop: true,
            margin: 0,
            merge: true,
            responsive: {
                2600: {
                    items: 6
                },
                2000: {
                    items: 5
                },
                1800: {
                    items: 4
                },
                1200: {
                    items: 3

         },
                600: {
                    items: 2
                },
                0: {
                    items: 1
                }
            }
        });
    </script>
    @yield('footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script> --}}
</body>

</html>
