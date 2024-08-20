<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                {{-- <p>© 2024 {{ Str::upper($site->domain) }}. -- Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</p> --}}

                <div class="navbar">
                    <div class="w-100 pt-3">
                        <ul class="flex-wrap primary-menu d-flex w-100 py-3 d-flex justify-content-center" style="list-style: none">
                            <li class="nav-item">
                                <a href="/" title="{{ __("Home") }}"> {{ __("Home") }} </a>
                            </li>
                            @if ($site->site_options['contact_url'])
                            <li class="nav-item">
                                <a href="{{ route("contact") }}" title="{{ __("Contact Us") }}"> {{ __("Contact Us") }} </a>
                            </li>
                            @endif


                            @foreach ($site->urls as $url)
                            @if ($url->footer)
                            <li class="nav-item">
                                <a href="{{ $url->url }}" @if ($url->new_tab) target="_blanck" @endif title="{{ $url->name }}">{{
                                    $url->name }} </a>
                            </li>
                            @endif
                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button class="back-to-top" id="back-to-top" role="button">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"
            class="icon icon-tabler icons-tabler-filled icon-tabler-arrow-big-up-lines">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path
                d="M10.586 3l-6.586 6.586a2 2 0 0 0 -.434 2.18l.068 .145a2 2 0 0 0 1.78 1.089h2.586v2a1 1 0 0 0 1 1h6l.117 -.007a1 1 0 0 0 .883 -.993l-.001 -2h2.587a2 2 0 0 0 1.414 -3.414l-6.586 -6.586a2 2 0 0 0 -2.828 0z" />
            <path d="M15 20a1 1 0 0 1 .117 1.993l-.117 .007h-6a1 1 0 0 1 -.117 -1.993l.117 -.007h6z" />
            <path d="M15 17a1 1 0 0 1 .117 1.993l-.117 .007h-6a1 1 0 0 1 -.117 -1.993l.117 -.007h6z" />
        </svg>
    </button>
</footer>
