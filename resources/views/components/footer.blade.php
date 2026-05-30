@php
$options = $site->site_options ?? [];
@endphp

<footer class="bg-gray-50 border-t border-gray-200 mt-10" itemscope itemtype="https://schema.org/WPFooter"
    aria-label="{{ __('Site footer') }}">

    <div class="container mx-auto px-4 py-8">

        {{-- ── Logo ──────────────────────────────────────────── --}}
        <div class="flex justify-center mb-6">
            <a href="/" aria-label="{{ $site->name }} — {{ __('Home') }}">
                <img src="{{ asset('storage/' . $site->logo) }}" alt="{{ $site->name }}" width="120" height="36"
                    loading="lazy" decoding="async"
                    class="h-8 w-auto object-contain opacity-80 hover:opacity-100 transition-opacity">
            </a>
        </div>

        {{-- ── Footer Navigation ──────────────────────────────── --}}
        <nav aria-label="{{ __('Footer navigation') }}">
            <ul class="flex flex-wrap justify-center gap-x-6 gap-y-3 mb-6
                        text-gray-600 text-sm font-medium">

                <li>
                    <a href="/" title="{{ __('Home') }}" class="hover:text-primary transition-colors">
                        {{ __('Home') }}
                    </a>
                </li>

                @if($options['blogs_url'] ?? false)
                <li>
                    <a href="/blog" title="{{ __('Blog') }}" class="hover:text-primary transition-colors">
                        {{ __('Blog') }}
                    </a>
                </li>
                @endif

                @if($options['contact_url'] ?? false)
                <li>
                    <a href="{{ route('contact') }}" title="{{ __('Contact Us') }}"
                        class="hover:text-primary transition-colors">
                        {{ __('Contact Us') }}
                    </a>
                </li>
                @endif

                @foreach($site->urls as $url)
                @if($url->footer)
                <li>
                    <a href="{{ $url->url }}" title="{{ $url->name }}" @if($url->new_tab)
                        target="_blank"
                        rel="noopener noreferrer"
                        @endif
                        class="hover:text-primary transition-colors">
                        {{ $url->name }}
                    </a>
                </li>
                @endif
                @endforeach

            </ul>
        </nav>

        {{-- ── Copyright ──────────────────────────────────────── --}}
        <div class="text-center text-gray-500 text-sm border-t border-gray-200 pt-4">
            <p>
                &copy; {{ date('Y') }}
                <a href="/" class="font-semibold text-gray-700 hover:text-primary transition-colors">
                    {{ Str::upper($site->domain) }}
                </a>.
                {{ __('All rights reserved.') }}
            </p>
        </div>

    </div>

    {{-- ── Back to Top ─────────────────────────────────────────── --}}
    <button id="back-to-top" type="button" aria-label="{{ __('Back to top') }}" aria-hidden="true"
        class="fixed bottom-6
                   end-6
                   bg-primary text-white p-3 rounded-full shadow-lg
                   transition-all duration-300
                   opacity-0 invisible pointer-events-none
                   hover:opacity-90 hover:scale-110
                   focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M12 5l0 14" />
            <path d="M18 11l-6 -6" />
            <path d="M6 11l6 -6" />
        </svg>
    </button>

</footer>

{{-- ── Back to Top: styles + script ──────────────────────────────── --}}
<style>
    #back-to-top.is-visible {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
    }
</style>

<script>
    (function () {
    const btn       = document.getElementById('back-to-top');
    const threshold = 300;
    if (!btn) return;

    // Toggle visibility
    const onScroll = () => {
        const visible = window.scrollY > threshold;
        btn.classList.toggle('is-visible', visible);
        btn.setAttribute('aria-hidden', String(!visible));
    };

    // Throttle scroll handler for performance
    let ticking = false;
    window.addEventListener('scroll', () => {
        if (!ticking) {
            requestAnimationFrame(() => { onScroll(); ticking = false; });
            ticking = true;
        }
    }, { passive: true });

    // Scroll to top
    btn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
        // Return focus to top of page for keyboard/screen reader users
        document.querySelector('main, header, body').focus({ preventScroll: true });
    });

    // Run once on load in case page is already scrolled (e.g. back navigation)
    onScroll();
})();
</script>
