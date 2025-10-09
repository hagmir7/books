<div x-data="{ open: false }">
    <!-- Button trigger modal -->
    <button type="button" @click="open = true" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition cursor-pointer">
        {{ __("Report The Book") }}
    </button>

    <!-- Modal -->
    <div x-show="open" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="reportModalLabel"
        role="dialog" aria-modal="true">

        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/50 transition-opacity" @click="open = false" x-show="open"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

        <!-- Modal Content -->
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white rounded-lg shadow-xl max-w-lg w-full" x-show="open"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" @click.stop>

                <!-- Modal Header -->
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="text-lg font-semibold" id="reportModalLabel">
                        {{ __("Report The Book") }}
                    </h3>
                    <button type="button" @click="open = false" class="text-gray-400 hover:text-gray-600 transition cursor-pointer"
                        aria-label="{{ __('Close') }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-4">
                    <form wire:submit.prevent="save">
                        <div class="mb-3">
                            <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __("Full Name") }}
                            </label>
                            <input type="text" id="full_name" wire:model="full_name"
                                class="w-full px-3 py-2 border-2 rounded focus:outline-none focus:ring-2 focus:ring-black @error('full_name') border-red-500 @enderror">
                            @error('full_name')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __("Subject") }}
                            </label>
                            <input type="text" id="subject" wire:model="subject"
                                class="w-full px-3 py-2 border-2 rounded focus:outline-none focus:ring-2 focus:ring-black @error('subject') border-red-500 @enderror">
                            @error('subject')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __("Email") }}
                            </label>
                            <input type="email" id="email" wire:model="email"
                                class="w-full px-3 py-2 border-2 rounded focus:outline-none focus:ring-2 focus:ring-black @error('email') border-red-500 @enderror">
                            @error('email')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __("Message Content") }}
                            </label>
                            <textarea id="content" rows="5" wire:model="content"
                                class="w-full px-3 py-2 border-2 rounded focus:outline-none focus:ring-2 focus:ring-black @error('content') border-red-500 @enderror"></textarea>
                            @error('content')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition flex justify-center cursor-pointer">
                            <span>{{ __("Send Report") }}</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
