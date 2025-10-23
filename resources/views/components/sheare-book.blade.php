<div class="social-btns flex flex-wrap gap-2 my-4">
    <a target="_blank" aria-label="{{ __(" Share with Facebook") }}"
        href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
        class="inline-flex items-center justify-center px-3 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 transition">
        {{-- facebook svg --}}
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2">
            <path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" />
        </svg>
    </a>

    <a class="inline-flex items-center justify-center px-3 py-2 rounded bg-black text-white hover:bg-gray-800 transition"
        href="https://twitter.com/intent/tweet?text={{ urlencode($book->name . ' ' . request()->fullUrl()) }}"
        aria-label="{{ __(" Share with X") }}" target="_blank">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2">
            <path
                d="M22 4.01c-1 .49 -1.98 .689 -3 .99c-1.121 -1.265 -2.783 -1.335 -4.38 -.737s-2.643 2.06 -2.62 3.737v1c-3.245 .083 -6.135 -1.395 -8 -4c0 0 -4.182 7.433 4 11c-1.872 1.247 -3.739 2.088 -6 2c3.308 1.803 6.913 2.423 10.034 1.517c3.58 -1.04 6.522 -3.723 7.651 -7.742a13.84 13.84 0 0 0 .497 -3.753c0 -.249 1.51 -2.772 1.818 -4.013z" />
        </svg>
    </a>

    <a class="inline-flex items-center justify-center px-3 py-2 rounded bg-red-600 text-white hover:bg-red-700 transition"
        href="https://pinterest.com/pin/create/button/?url={{ urlencode(request()->fullUrl()) }}&description={{ urlencode($book->name) }}"
        aria-label="{{ __(" Share with Pinterest") }}" target="_blank">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2">
            <path d="M8 20l4 -9" />
            <path d="M10.7 14c.437 1.263 1.43 2 2.55 2c2.071 0 3.75 -1.554 3.75 -4a5 5 0 1 0 -9.7 1.7" />
            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
        </svg>
    </a>

    <a class="inline-flex items-center justify-center px-3 py-2 rounded bg-green-500 text-white hover:bg-green-600 transition"
        href="whatsapp://send/?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($book->name) }}"
        aria-label="{{ __(" Share with WhatsApp") }}" target="_blank">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2">
            <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9" />
            <path d="M9 10a.5 .5 0 0 0 1 0v-1a.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a.5 .5 0 0 0 0 -1h-1a.5 .5 0 0 0 0 1" />
        </svg>
    </a>

    <a class="inline-flex items-center justify-center px-3 py-2 rounded bg-blue-500 text-white hover:bg-blue-600 transition"
        href="https://telegram.me/share/url?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($book->name) }}"
        aria-label="{{ __(" Share with Telegram") }}" target="_blank">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2">
            <path d="M15 10l-4 4l6 6l4 -16l-18 7l4 2l2 6l3 -4" />
        </svg>
    </a>
</div>
