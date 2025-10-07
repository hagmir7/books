<footer class="footer">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap">
            <div class="w-full">
                <p class="text-center text-gray-600 py-4">
                    {{ __("Copyright") }} © {{ Str::upper($site->domain) }} 2024. {{ __("All rights reserved") }}.
                    {{-- -- Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }}) --}}
                </p>
                <div class="navbar">
                    <div class="w-full pt-3">
                        <ul class="flex flex-wrap primary-menu w-full py-3 justify-center gap-x-6 gap-y-2 list-none">
                            <li class="nav-item">
                                <a href="/" title="{{ __('Home') }}" class="hover:text-primary transition-colors">
                                    {{ __("Home") }}
                                </a>
                            </li>

                            @if ($site->site_options['contact_url'])
                            <li class="nav-item">
                                <a href="{{ route('contact') }}" title="{{ __('Contact Us') }}"
                                    class="hover:text-primary transition-colors">
                                    {{ __("Contact Us") }}
                                </a>
                            </li>
                            @endif

                            @foreach ($site->urls as $url)
                            @if ($url->footer)
                            <li class="nav-item">
                                <a href="{{ $url->url }}" @if ($url->new_tab) target="_blank" @endif
                                    title="{{ $url->name }}"
                                    class="hover:text-primary transition-colors">
                                    {{ $url->name }}
                                </a>
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button
        class="back-to-top fixed bottom-6 right-6 rtl:right-auto rtl:left-6 bg-primary text-white p-3 rounded-full shadow-lg hover:bg-primary/90 transition-all opacity-0 invisible hover:scale-110"
        id="back-to-top" role="button" aria-label="Back to top">
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

<style>
    /* Show back to top button when scrolled */
    .back-to-top.show {
        opacity: 1 !important;
        visibility: visible !important;
    }
</style>

<script>
    // Back to top button functionality
    document.addEventListener('DOMContentLoaded', function() {
        const backToTopButton = document.getElementById('back-to-top');

        if (backToTopButton) {
            // Show button when scrolled down
            window.addEventListener('scroll', function() {
                if (window.scrollY > 300) {
                    backToTopButton.classList.add('show');
                } else {
                    backToTopButton.classList.remove('show');
                }
            });

            // Scroll to top on click
            backToTopButton.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }
    });
</script>
