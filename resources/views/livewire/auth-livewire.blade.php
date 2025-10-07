<div x-data="{ open: false }" @open-login-modal.window="open = true" @keydown.escape.window="open = false">

    <!-- Modal Backdrop -->
    <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black bg-opacity-50 z-40" @click="open = false" style="display: none;">
    </div>

    <!-- Modal Content -->
    <div x-show="open" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        class="fixed inset-0 z-50 flex items-center justify-center p-4" wire:ignore.self style="display: none;">

        <div class="bg-white rounded-lg shadow-xl max-w-lg w-full max-h-[90vh] overflow-y-auto" @click.stop>

            <!-- Close Button -->
            <div class="flex justify-end p-2">
                <button @click="open = false" class="text-gray-400 hover:text-gray-600 transition-colors"
                    aria-label="Close modal">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="px-6 pb-6">
                <div class="card-body">
                    <img width="100" src="{{ Storage::url($site->logo) }}" class="flex mx-auto mb-4 mt-2"
                        alt="{{ __('Login') }}">

                    @if ($isRegister)
                    <!-- Register Form -->
                    <form wire:submit.prevent="register">
                        <div class="mb-3 flex flex-wrap -mx-2">
                            <div class="w-full md:w-1/2 px-2 mb-3">
                                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __("First name") }}
                                </label>
                                <input type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                    wire:model="first_name" id="first_name">
                                @error('first_name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="w-full md:w-1/2 px-2 mb-3">
                                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __("Last name") }}
                                </label>
                                <input type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                    wire:model="last_name" id="last_name">
                                @error('last_name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __("Email") }}
                            </label>
                            <input type="email"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                wire:model="email" id="email">
                            @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __("Password") }}
                            </label>
                            <input type="password"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                wire:model="password" id="password">
                            @error('password')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __("Confirm Password") }}
                            </label>
                            <input type="password"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                required wire:model="password_confirmation" id="password_confirmation">
                            @error('password_confirmation')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit"
                            class="w-full bg-primary text-white py-2 px-4 rounded-md hover:bg-primary/90 transition-colors">
                            {{ __("Register") }}
                        </button>
                    </form>

                    <button class="w-full mt-3 text-primary hover:underline" type="button" wire:click="toggleMode">
                        {{ __("Already have an account? Login") }}
                    </button>

                    @else
                    <!-- Login Form -->
                    <form wire:submit.prevent="login">
                        <div class="mb-3">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __("Email") }}
                            </label>
                            <input type="email"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                wire:model="email" id="email">
                            @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __("Password") }}
                            </label>
                            <input type="password"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                wire:model="password" id="password">
                            @error('password')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="flex flex-wrap items-center mb-4">
                                <div class="w-full md:w-2/3 mb-3 md:mb-0">
                                    <div class="flex items-center">
                                        <input type="checkbox" name="rememberMe"
                                            class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary"
                                            id="rememberMe">
                                        <label class="ml-2 text-sm text-gray-700" for="rememberMe">
                                            {{ __("Remember me") }}
                                        </label>
                                    </div>
                                </div>
                                <div class="w-full md:w-1/3">
                                    <button type="submit"
                                        class="w-full bg-primary text-white py-2 px-4 rounded-md hover:bg-primary/90 transition-colors shadow">
                                        {{ __("Login") }}
                                    </button>
                                </div>
                            </div>

                            <div class="text-gray-600 mt-3 text-center">
                                {{ __("Do not have an account?") }}
                                <button class="text-primary hover:underline" type="button" wire:click="toggleMode">
                                    {{ __("Sign Up") }}
                                </button>
                            </div>
                        </div>
                    </form>
                    @endif

                    @if (session()->has('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mt-3">
                        {{ session('error') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
