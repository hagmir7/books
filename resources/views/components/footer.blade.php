<footer class="bg-gray-50 border-t border-gray-200 mt-10">
    <div class="container mx-auto px-4 py-8">
        <!-- Footer Navigation -->
        <nav class="flex flex-wrap justify-center gap-x-6 gap-y-3 mb-6 text-gray-700 text-sm font-medium">
            <a href="/" title="{{ __('Home') }}" class="hover:text-primary transition-colors">
                {{ __('Home') }}
            </a>

            @if ($site->site_options['contact_url'])
            <a href="{{ route('contact') }}" title="{{ __('Contact Us') }}"
                class="hover:text-primary transition-colors">
                {{ __('Contact Us') }}
            </a>
            @endif

            @foreach ($site->urls as $url)
            @if ($url->footer)
            <a href="{{ $url->url }}" @if ($url->new_tab) target="_blank" @endif
                title="{{ $url->name }}"
                class="hover:text-primary transition-colors">
                {{ $url->name }}
            </a>
            @endif
            @endforeach
        </nav>

        <!-- Copyright -->
        <div class="text-center text-gray-600 text-sm border-t border-gray-200 pt-4">
            <p>
                &copy; {{ date('Y') }} <span class="font-semibold text-gray-800">{{ Str::upper($site->domain) }}</span>.
                {{ __('All rights reserved.') }}
            </p>
        </div>
    </div>

    <!-- Back to Top Button -->
    <button id="back-to-top"
        class="fixed bottom-6 right-6 rtl:right-auto rtl:left-6 bg-primary text-white p-3 rounded-full shadow-lg transition-all duration-300 opacity-0 invisible hover:bg-primary/90 hover:scale-110"
        aria-label="Back to top">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 24 24"
            class="mx-auto">
            <path d="M12 3l-7 7h4v7h6v-7h4zM5 20h14v2H5z" />
        </svg>
    </button>
</footer>

<!-- Styles -->
<style>
    .back-to-top.show {
        opacity: 1 !important;
        visibility: visible !important;
    }
</style>

<!-- Back to Top Script -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const backToTopButton = document.getElementById('back-to-top');
        window.addEventListener('scroll', () => {
            backToTopButton.classList.toggle('show', window.scrollY > 300);
        });
        backToTopButton.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });
</script>
