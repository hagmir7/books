<!-- Floating Telegram Button -->
@php
$telegramUsername = app('site')->site_options['telegram_username'] ?? null;
@endphp

@if($telegramUsername)
<a href="https://t.me/{{ $telegramUsername }}" target="_blank" rel="noopener noreferrer"
    aria-label="Visit our Telegram channel" title="Visit our Telegram channel"
    class="fixed bottom-5 left-5 z-50 flex h-8 md:h-14 w-8 md:w-14 items-center justify-center rounded-full bg-gradient-to-b from-[#24A1DE] to-[#24A1DE] shadow-lg shadow-sky-500/40 transition-transform duration-150 hover:scale-105 active:scale-95 focus:outline-none focus:ring-4 focus:ring-sky-300">
    <svg xmlns="http://www.w3.org/2000/svg" class="text-white h-5 md:h-7 w-5 md:w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor"
        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
        class="icon icon-tabler icons-tabler-outline icon-tabler-brand-telegram">
        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
        <path d="M15 10l-4 4l6 6l4 -16l-18 7l4 2l2 6l3 -4" />
    </svg>
</a>
@endif
