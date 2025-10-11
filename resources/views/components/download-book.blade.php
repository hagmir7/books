<div class="py-3 space-y-3">



    @if (Str::upper($site->domain) == "NORKITAB.COM")
    <a rel="nofollow" href="https://file.best/{{ request()->path() }}"
        class="flex items-center justify-center gap-3 ustify-center cursor-pointer transition-colors duration-200 ease-in px-4 py-2 rounded-lg bg-teal-500 text-white hover:bg-teal-400 w-full"
        aria-label="{{ __('Download external') }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
            <path d="M7 11l5 5l5 -5" />
            <path d="M12 4l0 12" />
        </svg>
        <span>{{ __("Download") }}</span>
    </a>

    <a rel="nofollow" href="https://file.best/{{ request()->path() }}"
        class="flex items-center justify-center gap-3 ustify-center cursor-pointer transition-colors duration-200 ease-in px-4 py-2 rounded-lg bg-teal-500 text-white hover:bg-teal-400 w-full"
        aria-label="{{ __('Read') }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="icon icon-tabler icons-tabler-outline icon-tabler-book">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" />
            <path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" />
            <path d="M3 6l0 13" />
            <path d="M12 6l0 13" />
            <path d="M21 6l0 13" />
        </svg>
        <span>{{ __("Read") }}</span>
    </a>
    @else
    <a rel="nofollow" href="{{ 'https://norkitab.com' . Storage::url($book->file) }}"
        class="flex items-center justify-center gap-3 ustify-center cursor-pointer transition-colors duration-200 ease-in px-4 py-2 rounded-lg bg-teal-500 text-white hover:bg-teal-400 w-full"
        aria-label="{{ __('Download file') }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
            <path d="M7 11l5 5l5 -5" />
            <path d="M12 4l0 12" />
        </svg>
        <span>{{ __("Download") }}</span>
    </a>

    <a rel="nofollow" href="{{ 'https://norkitab.com' . Storage::url($book->file) }}"
        class="flex items-center justify-center gap-3 ustify-center cursor-pointer transition-colors duration-200 ease-in px-4 py-2 rounded-lg bg-orange-500 text-white hover:bg-orange-400 w-full"
        aria-label="{{ __('Read file') }}">

        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="icon icon-tabler icons-tabler-outline icon-tabler-book">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" />
            <path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" />
            <path d="M3 6l0 13" />
            <path d="M12 6l0 13" />
            <path d="M21 6l0 13" />
        </svg>
        <span>{{ __("Read") }}</span>
    </a>
    @endif


    {!! app("site")->ads !!}
</div>
