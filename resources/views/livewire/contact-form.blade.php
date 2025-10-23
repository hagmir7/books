<form wire:submit.prevent='save' id="contact-form" method="post" class="mb-6 contact-form">
    <!-- Success Message -->
    @if (session('status'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6" role="alert">
        <div class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="flex-shrink-0">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                <path d="M9 12l2 2l4 -4" />
            </svg>
            <span>{{ session('status') }}</span>
        </div>
    </div>
    @endif

    <div class="flex flex-wrap -mx-2">
        <!-- Full Name Field -->
        <div class="w-full md:w-1/2 px-2 mb-4">
            <input wire:model='full_name'
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-colors @error('full_name') border-red-500 @enderror"
                placeholder="{{ __('Full Name') }}" type="text">
            @error('full_name')
            <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-2 rounded-lg mt-2 text-sm" role="alert">
                <div class="flex items-start gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="flex-shrink-0 mt-0.5">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                        <path d="M12 8v4" />
                        <path d="M12 16h.01" />
                    </svg>
                    <span>{{ $message }}</span>
                </div>
            </div>
            @enderror
        </div>

        <!-- Email Field -->
        <div class="w-full md:w-1/2 px-2 mb-4">
            <input wire:model='email'
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-colors @error('email') border-red-500 @enderror"
                placeholder="{{ __('Email') }}" type="email">
            @error('email')
            <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-2 rounded-lg mt-2 text-sm" role="alert">
                <div class="flex items-start gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="flex-shrink-0 mt-0.5">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                        <path d="M12 8v4" />
                        <path d="M12 16h.01" />
                    </svg>
                    <span>{{ $message }}</span>
                </div>
            </div>
            @enderror
        </div>

        <!-- Message Field -->
        <div class="w-full px-2 mb-4">
            <textarea wire:model='body'
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-colors resize-y min-h-[120px] @error('body') border-red-500 @enderror"
                rows="5" placeholder="{{ __('Message') }}"></textarea>
            @error('body')
            <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-2 rounded-lg mt-2 text-sm" role="alert">
                <div class="flex items-start gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="flex-shrink-0 mt-0.5">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                        <path d="M12 8v4" />
                        <path d="M12 16h.01" />
                    </svg>
                    <span>{{ $message }}</span>
                </div>
            </div>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="w-full px-2">
            <button type="submit"
                class="bg-primary text-white px-6 py-3 rounded-lg hover:bg-primary/90 transition-colors font-medium inline-flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                wire:loading.attr="disabled">
                <span>{{ __("Send Message") }}</span>
                <span wire:loading class="inline-block">
                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </span>
            </button>
        </div>
    </div>

</form>


