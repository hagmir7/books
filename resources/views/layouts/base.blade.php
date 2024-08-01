<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>{{ isset($title) ? Str::limit($title, 160) : $site->name }}</title>
    <meta name="description" content="{{ isset($description) ? Str::limit($description, 160) : Str::limit($site->description, 160) }}">
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
                        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                            <ul class="navbar-nav primary-menu">
                                @if (json_decode($site->site_options, true)['books_url'])
                                    <li class="nav-item ">
                                        <a href="/books" title="{{ __(" Books") }}"> {{ __("Books") }} </a>
                                    </li>
                                @endif

                                @if (json_decode($site->site_options, true)['authors_url'])
                                <li class="nav-item ">
                                    <a href="/authors" title="{{ __(" Authors") }}">{{ __("Authors") }} </a>
                                </li>
                                @endif



                                @if (json_decode($site->site_options, true)['blogs_url'])
                                    <li class="nav-item ">
                                        <a href="/blog" title="{{ __(" Blog") }}">{{ __("Blog") }} </a>
                                    </li>
                                @endif

                                @if (json_decode($site->site_options, true)['contact_url'])
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
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-user-circle text-white">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                        <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                        <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                                    </svg>
                                </a>
                            @endauth

                            @if (json_decode($site->site_options, true)['login_url'])
                            @guest
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#login">
                                {{ __("Join us") }}
                            </button>
                            @endguest
                            @endif
                        </div>
                    </div>

                    <div class="menu-icons mobile-menu d-flex text-right align-items-center justify-content-end">
                        <button class="btn btn-primary py-1" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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


    @if (json_decode($site->site_options, true)['login_url'])
        @livewire('auth-livewire')
    @endif

    @yield('content')
    <x-footer />
    <div class="d-none">{!! $site->footer !!}</div>


    {{-- Langauge menu --}}

    <script src="{{ asset("js/popper.min.js") }}"></script>
    <script src="{{ asset("js/bootstrap.min.js") }}"></script>
    <script src="{{ asset("js/carousel.min.js") }}"></script>
    <script src="{{ asset("js/plugins.js") }}"></script>
    <script src="{{ asset("js/custom.js") }}"></script>

    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en/sdk.js#xfbml=1&version=v20.0" nonce="O3PMh4xP"></script>

    @yield('footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"> </script>
</body>

</html>
