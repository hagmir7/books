<section class="w-full mt-10">
    <div
        class="w-full bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 overflow-hidden">

        {{-- Hero --}}
        <div class="px-8 py-4">
            <div class="flex gap-2 items-center">
                <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-black" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-black">{{ __('Subscribe to our newsletter') }}</h2>
            </div>
        </div>

        {{-- Form --}}
        <div class="px-8 py-8">
            <form wire:submit="subscribe" class="space-y-5" novalidate>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    {{-- Full name --}}
                    <div>
                        <label for="nl-name" class="block text-xs font-medium text-gray-500 mb-1.5">
                            {{ __('Full name') }}
                        </label>
                        <input id="nl-name" type="text" wire:model="full_name" required autocomplete="name"
                            placeholder="{{ __('Hassan Alami') }}" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 dark:border-gray-700
                                   bg-gray-50 dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-100
                                   focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent
                                   placeholder:text-gray-300 dark:placeholder:text-gray-600 transition">
                        @error('full_name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="nl-email" class="block text-xs font-medium text-gray-500 mb-1.5">
                            {{ __('Email address') }}
                        </label>
                        <input id="nl-email" type="email" wire:model="email" required autocomplete="email"
                            placeholder="{{ __('hassan@example.com') }}" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 dark:border-gray-700
                                   bg-gray-50 dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-100
                                   focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent
                                   placeholder:text-gray-300 dark:placeholder:text-gray-600 transition">
                        @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>


                    {{-- Submit --}}
                    <div>
                        {{-- <label for=""></label> --}}
                        <button type="submit" wire:loading.attr="disabled"
                            class="w-full flex items-center justify-center gap-2 mt-5.5
                                                                       bg-red-600 hover:bg-red-800 active:scale-[0.99]
                                                                       disabled:opacity-60 disabled:cursor-not-allowed
                                                                       text-white text-sm font-medium
                                                                       px-4 py-2.5 rounded-lg transition-all duration-150">
                            <svg wire:loading.remove xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            <svg wire:loading class="w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4" />
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
                            </svg>
                            <span wire:loading.remove>{{ __('Subscribe') }}</span>
                            <span wire:loading>{{ __('Subscribing…') }}</span>
                        </button>
                    </div>

                </div>



                {{-- Success --}}
                @if($subscribed)
                <div role="status" aria-live="polite" class="flex items-center gap-2 text-sm text-red-700 dark:text-red-400
                               bg-red-50 dark:bg-red-950 border border-red-100 dark:border-red-900
                               rounded-lg px-4 py-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ __("Thanks! You're subscribed. Check your inbox for a confirmation email.") }}
                </div>
                @endif

            </form>
        </div>

        {{-- Stats --}}
        <div
            class="grid grid-cols-3 divide-x divide-gray-100 dark:divide-gray-800 border-t border-gray-100 dark:border-gray-800">
            <div class="py-4 text-center">
                <p class="text-base font-semibold text-gray-900 dark:text-gray-100">12k+</p>
                <p class="text-xs text-gray-400 mt-0.5">{{ __('Subscribers') }}</p>
            </div>
            <div class="py-4 text-center">
                <p class="text-base font-semibold text-gray-900 dark:text-gray-100">{{ __('Weekly') }}</p>
                <p class="text-xs text-gray-400 mt-0.5">{{ __('Frequency') }}</p>
            </div>
            <div class="py-4 text-center">
                <p class="text-base font-semibold text-gray-900 dark:text-gray-100">{{ __('Free') }}</p>
                <p class="text-xs text-gray-400 mt-0.5">{{ __('Always') }}</p>
            </div>
        </div>


    </div>
</section>
