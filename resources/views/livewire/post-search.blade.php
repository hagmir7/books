<div>
    <section class="py-10">
        <div class="container mx-auto px-4">

            {{-- ── Logo + Site Name ─────────────────────────────── --}}
            <div class="flex flex-col items-center mb-8">
                <a href="/" aria-label="{{ $site->name }} — {{ __('Home') }}">
                    <img src="{{ asset('storage/' . $site->logo) }}" alt="{{ $site->name }}" width="160" height="64"
                        loading="eager" fetchpriority="high" decoding="async" class="h-16 w-auto object-contain">
                </a>
                <p class="mt-3 text-center text-xl font-semibold text-gray-800" aria-label="{{ $site->name }}">
                    {{ $site->name }}
                </p>
            </div>

            {{-- ── Search Box ───────────────────────────────────── --}}
            <div class="flex justify-center">
                <div class="w-full sm:w-10/12 md:w-8/12 lg:w-7/12">

                    {{-- Wrapper: position relative for dropdown --}}
                    <div class="relative" x-data="{ focused: false }">

                        {{-- Input Card --}}
                        <div class="bg-white rounded-xl shadow-sm overflow-visible ring-1 ring-gray-100">
                            <div class="p-3">
                                <div class="relative">

                                    {{-- Label (visually hidden) --}}
                                    <label for="post-search-input" class="sr-only">
                                        {{ app('site')?->site_options['search_label'] ?? __('Search') }}
                                    </label>

                                    {{-- Input --}}
                                    <input id="post-search-input" type="search" autocomplete="off" spellcheck="false"
                                        role="combobox" aria-autocomplete="list" aria-controls="search-results-dropdown"
                                        aria-expanded="{{ $search && $posts->isNotEmpty() ? 'true' : 'false' }}"
                                        placeholder="{{ app('site')?->site_options['search_label'] ?? __('Search...') }}"
                                        wire:model.live.debounce.500ms="search" @focus="focused = true"
                                        @blur="setTimeout(() => focused = false, 200)" class="w-full py-2 text-base rounded-lg border-0
                                               focus:outline-none focus:ring-2 focus:ring-primary
                                               {{ app()->getLocale() === 'ar' ? 'pr-10 pl-4' : 'pl-10 pr-4' }}">

                                    {{-- Search Icon (hidden while loading) --}}
                                    <span wire:loading.remove class="absolute top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none
                                                 {{ app()->getLocale() === 'ar' ? 'right-3' : 'left-3' }}"
                                        aria-hidden="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <circle cx="11" cy="11" r="6" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21 21l-4.35-4.35" />
                                        </svg>
                                    </span>

                                    {{-- Spinner (shown while Livewire is loading) --}}
                                    <span wire:loading class="absolute top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none
                                                 {{ app()->getLocale() === 'ar' ? 'right-3' : 'left-3' }}"
                                        aria-hidden="true">
                                        <svg class="w-5 h-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4" />
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
                                        </svg>
                                    </span>

                                    {{-- Clear button (shown when there's a query) --}}
                                    @if($search)
                                    <button type="button" wire:click="$set('search', '')"
                                        aria-label="{{ __('Clear search') }}" class="absolute top-1/2 -translate-y-1/2 text-gray-400
                                                   hover:text-gray-600 transition-colors
                                                   {{ app()->getLocale() === 'ar' ? 'left-3' : 'right-3' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"
                                            aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                    @endif

                                </div>
                            </div>
                        </div>

                        {{-- ── Results Dropdown ─────────────────────── --}}
                        <div wire:loading.remove>
                            @if($search)

                            @if($posts->isNotEmpty())
                            {{-- Results list --}}
                            <div id="search-results-dropdown" role="listbox" aria-label="{{ __('Search results') }}"
                                class="absolute z-50 mt-2 w-full max-h-80 overflow-y-auto
                                            bg-white rounded-xl shadow-lg
                                            ring-1 ring-black/5 divide-y divide-gray-100">

                                {{-- Header --}}
                                <div class="px-4 py-2.5 bg-gray-50 rounded-t-xl
                                                flex items-center justify-between">
                                    <span class="text-sm font-semibold text-gray-500">
                                        {{ __('Search Results') }}
                                    </span>
                                    <span class="text-xs text-gray-400">
                                        {{ $posts->count() }} {{ __('found') }}
                                    </span>
                                </div>

                                {{-- Items --}}
                                @foreach($posts as $post)
                                <div role="option" aria-selected="false"
                                    class="px-4 py-3 hover:bg-gray-50 transition-colors">

                                    <a href="{{ route('blog.show', $post->slug) }}" class="block group">

                                        {{-- Post title --}}
                                        <h4 class="text-sm font-semibold text-gray-900
                                                        group-hover:text-primary transition-colors
                                                        line-clamp-1">
                                            {{-- Highlight matching query in title --}}
                                            {!! preg_replace(
                                            '/(' . preg_quote(e($search), '/') . ')/iu',
                                            '<mark class="bg-yellow-100 text-gray-900 rounded px-0.5">$1</mark>',
                                            e($post->title)
                                            ) !!}
                                        </h4>

                                        {{-- Post date --}}
                                        <time datetime="{{ $post->created_at->toIso8601String() }}"
                                            class="text-xs text-gray-400 mt-0.5 block">
                                            {{ $post->created_at->locale(app()->getLocale())->translatedFormat('M d, Y')
                                            }}
                                        </time>

                                    </a>
                                </div>
                                @endforeach

                            </div>

                            @else
                            {{-- No results --}}
                            <div id="search-results-dropdown" role="status" aria-live="polite" class="absolute z-50 mt-2 w-full bg-white rounded-xl
                                            shadow-lg ring-1 ring-black/5">
                                <div class="flex flex-col items-center text-center py-10 px-4 gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-300" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                        <circle cx="11" cy="11" r="6" stroke-linecap="round" stroke-linejoin="round" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35" />
                                    </svg>
                                    <p class="text-gray-500 text-sm font-medium">
                                        {{ __('No results for') }}
                                        "<strong class="text-gray-700">{{ $search }}</strong>"
                                    </p>
                                    <p class="text-gray-400 text-xs">
                                        {{ __('Try different keywords.') }}
                                    </p>
                                </div>
                            </div>
                            @endif

                            @endif
                        </div>

                    </div>{{-- /.relative --}}
                </div>
            </div>

        </div>
    </section>
</div>
