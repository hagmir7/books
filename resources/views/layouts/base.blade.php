<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>{{ $site->name }}</title>
    <meta name="description" content="{{ $site->description }}">
    <meta name="keywords" content="{{ $site->keywords }}">
    <link rel="icon" type="image/png" href="{{ Storage::url($site->icon) }}" />
    <meta name=viewport content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://www.z-pdf.com/themes/default/resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://www.z-pdf.com/themes/default/resources/css/plugins.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <link rel="stylesheet" href="https://www.z-pdf.com/themes/default/resources/css/owl.carousel.min.css">
   {!! $site->header !!}

</head>

<body>
    <header class="header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="logo">
                        <a href="/"><img src="https://z-pdf.com/images/site-view-options/Z-PDF.png" alt="Logo"></a>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <nav class="navbar navbar-expand-lg">
                        <div class="collapse navbar-collapse justify-content-center" id="header-menu">

                            <ul class="navbar-nav primary-menu">
                                <li class="nav-item ">
                                    <a href="/books" class="">
                                        Books </a>
                                </li>

                                <li class="nav-item ">
                                    <a href="/authors" class="">
                                        Authors </a>
                                </li>

                                <li class="nav-item ">
                                    <a href="/contact-us" class="">
                                        Contact Us </a>
                                </li>

                                <li class="nav-item ">
                                    <a href="/blog" class="">
                                        Blog </a>
                                </li>


                            </ul>
                        </div>
                    </nav>
                </div>
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="menu-icons d-flex text-right align-items-center justify-content-end">
                        <div class="search-box">
                            <a href="#" class="search-open"><i class="ti-search"></i></a>
                        </div>
                        <div class="user-dropdown">
                            <a href="#" data-toggle="modal" data-target="#login-box" class="open-login-box">
                                <i class="ti-lock"></i>
                            </a>
                        </div>
                        <div class="languages">
                            <a href="#" class="lang-select" data-toggle="dropdown" role="button" aria-haspopup="true"
                                aria-expanded="false"><i class="ti-world"></i></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item active" href="/languageChange/en_US"><i
                                            class="flag flag-us"></i> English
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
                            <button type="submit" class="btn" id="header-search"><i class="ti-search"></i></button>
                            <span class="search-close">
                                <i class="ti-close"></i>
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
                            <img src="https://z-pdf.com/images/site-view-options/Z-PDF.png"
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
    <script src="https://www.z-pdf.com/themes/default/resources/js/popper.min.js"></script>
    <script src="https://www.z-pdf.com/themes/default/resources/js/bootstrap.min.js"></script>

    <script src="https://www.z-pdf.com/themes/default/resources/js/owl.carousel.min.js"></script>

    <script src="https://www.z-pdf.com/themes/default/resources/js/plugins.js"></script>
    <script src="https://www.z-pdf.com/themes/default/resources/js/custom.js"></script>

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

</body>

</html>
