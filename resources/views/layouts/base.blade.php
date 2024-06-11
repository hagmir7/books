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
                        <div class="search-box">
                            <a href="#" class="search-open">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                    <path d="M21 21l-6 -6" />
                                </svg>
                            </a>
                        </div>
                        <div class="user-dropdown">
                            <a href="#" data-toggle="modal" data-target="#login-box" class="open-login-box">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-login">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M15 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                                    <path d="M21 12h-13l3 -3" />
                                    <path d="M11 15l-3 -3" />
                                </svg>
                            </a>
                        </div>
                        <div class="languages">
                            <a href="#" class="lang-select" data-toggle="dropdown" role="button" aria-haspopup="true"
                                aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-language">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 5h7" />
                                    <path d="M9 3v2c0 4.418 -2.239 8 -5 8" />
                                    <path d="M5 9c0 2.144 2.952 3.908 6.7 4" />
                                    <path d="M12 20l4 -9l4 9" />
                                    <path d="M19.1 18h-6.2" />
                                </svg>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item active" href="/languageChange/en_US">
                                         English
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="menu-toggler" data-toggle="collapse" data-target="#header-menu" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <div class="bar"></div>
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

    <div class="modal login-box" id="login-box" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card card-no-border">
                        <div class="card-body">
                            <img width="50px" src="{{ Storage::url($site->logo) }}"
                                class="d-flex ml-auto mr-auto mb-4 mt-2 img-fluid" alt="Login">
                            <div class="social-login">
                            </div>
                            <form action="/login" method="post" class="form-horizontal">
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <input name="login" class="form-control" placeholder="Login" value=""
                                            type="text" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <input name="password" class="form-control" placeholder="Password"
                                            type="password" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-8 col-xs-8 text-left">
                                            <div class="custom-control custom-checkbox mt-2">
                                                <input type="checkbox" name="rememberMe" class="custom-control-input"
                                                    id="rememberMe">
                                                <label class="custom-control-label" for="rememberMe">Remember me</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xs-4">
                                            <button class="btn btn-primary shadow btn-block">Login</button>
                                        </div>
                                        <div class="col-md-12 mt-3 additional-text text-center">
                                            <a href="/password-recovery">Forgot password?</a>
                                        </div>
                                    </div>
                                    <div class="text-black-50 mt-3 additional-text text-center">Do not have an account?
                                        <a href="/registration">Sign Up</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @yield('content')
    <x-footer />
    {!! $site->footer !!}


    {{-- Langauge menu --}}

    <script src="{{ asset("js/popper.min.js") }}"></script>
    <script src="{{ asset("js/bootstrap.min.js") }}"></script>

    <script src="{{ asset("js/carousel.min.js") }}"></script>

    <script src="{{ asset("js/plugins.js") }}"></script>
    <script src="{{ asset("js/custom.js") }}"></script>



    <script>
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
</body>

</html>
