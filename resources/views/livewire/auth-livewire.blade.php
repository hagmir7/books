<!-- Requires: Tailwind CSS + Alpine.js (for small toggles). Livewire is untouched. -->
<div class="w-full flex justify-center items-center py-10">
    <div class="bg-white rounded-lg shadow-sm max-w-lg w-full max-h-[90vh] overflow-y-auto" @click.stop
        x-data="{ showPassword: false }" role="dialog" aria-modal="true" aria-labelledby="authTitle">
        <!-- Header -->
        <div class="bg-gradient-to-r from-white to-primary/5 border-b px-6 py-4 rounded-t-lg">
            <div class="flex items-center gap-4">
                <img width="100px" height="50px" src="{{ Storage::url($site->logo) }}" alt="{{ __('Site logo') }}"
                    class="object-contain text-center w-full h-11">
                <div>
                    <h2 id="authTitle" class="text-lg font-semibold text-gray-800">
                        <span x-show="$wire.isRegister" x-cloak>{{ __('Create an account') }}</span>
                        <span x-show="! $wire.isRegister" x-cloak>{{ __('Sign in to your account') }}</span>
                    </h2>
                    <p class="text-sm text-gray-500 mt-0.5">
                        <span x-show="$wire.isRegister" x-cloak>{{ __('Join us — it\'s quick and easy.') }}</span>
                        <span x-show="! $wire.isRegister" x-cloak>{{ __('Welcome back — enter your details to continue.')}}</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="px-6 pb-6">
            <div class="card-body mt-4">

                <!-- Top-level validation/errors -->
                @if (session()->has('error'))
                <div role="alert" class="bg-red-50 border border-red-200 text-red-700 px-4 py-2 rounded mb-4">
                    {{ session('error') }}
                </div>
                @endif

                <!-- REGISTER -->
                @if ($isRegister)
                <form wire:submit.prevent="register" class="space-y-4" novalidate>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">{{ __("First name")
                                }}</label>
                            <input id="first_name" type="text" wire:model.defer="first_name"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                aria-invalid="{{ $errors->has('first_name') ? 'true' : 'false' }}"
                                autocomplete="given-name">
                            @error('first_name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">{{ __("Last name")
                                }}</label>
                            <input id="last_name" type="text" wire:model.defer="last_name"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                aria-invalid="{{ $errors->has('last_name') ? 'true' : 'false' }}"
                                autocomplete="family-name">
                            @error('last_name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">{{ __("Email") }}</label>
                        <input id="email" type="email" wire:model.defer="email"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                            aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}" autocomplete="email">
                        @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">{{ __("Password")
                            }}</label>
                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'" id="password" wire:model.defer="password"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md pr-10 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                                autocomplete="new-password">
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-2 flex items-center px-2"
                                :aria-label="showPassword ? 'Hide password' : 'Show password'">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path x-show="!showPassword" stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path x-show="showPassword" stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 3l18 18M10.58 10.58A3 3 0 0113.42 13.42" />
                                </svg>
                            </button>
                        </div>
                        @error('password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">{{
                            __("Confirm Password") }}</label>
                        <input id="password_confirmation" :type="showPassword ? 'text' : 'password'" required
                            wire:model.defer="password_confirmation"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                            aria-invalid="{{ $errors->has('password_confirmation') ? 'true' : 'false' }}"
                            autocomplete="new-password">
                        @error('password_confirmation') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <button type="submit" wire:loading.attr="disabled" wire:loading.class="opacity-60 cursor-wait"
                            class="w-full inline-flex justify-center items-center gap-2 bg-primary text-white py-2 px-4 rounded-md hover:bg-primary/90 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                            </svg>
                            <span>{{ __("Register") }}</span>
                        </button>
                    </div>

                </form>

                <div class="mt-3 text-center text-sm text-gray-600">
                    {{ __("Already have an account?") }}
                    <button class="text-primary font-medium ml-1" type="button" wire:click="toggleMode">{{ __("Login")
                        }}</button>
                </div>

                @else

                <!-- LOGIN -->
                <form wire:submit.prevent="login" class="space-y-4" novalidate>

                    <div>
                        <label for="email-login" class="block text-sm font-medium text-gray-700 mb-1">{{ __("Email")
                            }}</label>
                        <input id="email-login" type="email" wire:model.defer="email"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                            aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}" autocomplete="email">
                        @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password-login" class="block text-sm font-medium text-gray-700 mb-1">{{ __("Password")
                            }}</label>
                        <div class="relative">
                            <input id="password-login" :type="showPassword ? 'text' : 'password'"
                                wire:model.defer="password"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md pr-10 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                                autocomplete="current-password">
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-2 flex items-center px-2"
                                :aria-label="showPassword ? 'Hide password' : 'Show password'">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path x-show="!showPassword" stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path x-show="showPassword" stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 3l18 18M10.58 10.58A3 3 0 0113.42 13.42" />
                                </svg>
                            </button>
                        </div>
                        @error('password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-between gap-3">
                        <label class="flex items-center text-sm text-gray-700 select-none gap-2">
                            <input type="checkbox" name="rememberMe" wire:model="remember" id="rememberMe"
                                class="h-4 w-4 rounded border-gray-300 focus:ring-primary" />
                            <span class="ml-2">{{ __("Remember me") }}</span>
                        </label>

                        <button type="submit" wire:loading.attr="disabled" wire:loading.class="opacity-60 cursor-wait"
                            class="bg-primary py-2 px-4 rounded-md hover:bg-primary/90 transition shadow">
                            {{ __("Login") }}
                        </button>
                    </div>

                    <div class="text-center text-sm text-gray-600">
                        {{ __("Do not have an account?") }}
                        <button class="text-primary font-medium ml-1" type="button" wire:click="toggleMode">{{ __("Sign Up")}}</button>
                    </div>

                </form>
                @endif

                <!-- Optional: social login area (uncomment / connect to backend if available) -->
                <div class="mt-5">
                    <div class="flex items-center">
                        <div class="flex-1 h-px bg-gray-200"></div>
                        <div class="px-3 text-xs text-gray-400">{{ __("Or continue with") }}</div>
                        <div class="flex-1 h-px bg-gray-200"></div>
                    </div>

                    <div class="mt-3 grid grid-cols-2 gap-3">
                        <button type="button"
                            class="flex items-center justify-center gap-2 border border-gray-200 py-2 rounded-md hover:shadow-sm transition">
                            <!-- Google icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-brand-google">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M20.945 11a9 9 0 1 1 -3.284 -5.997l-2.655 2.392a5.5 5.5 0 1 0 2.119 6.605h-4.125v-3h7.945z" />
                            </svg>
                            <span class="text-sm">Google</span>
                        </button>

                        <button type="button"
                            class="flex items-center justify-center gap-2 border border-gray-200 py-2 rounded-md hover:shadow-sm transition">
                            <!-- GitHub / Other -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-brand-github">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M9 19c-4.3 1.4 -4.3 -2.5 -6 -3m12 5v-3.5c0 -1 .1 -1.4 -.5 -2c2.8 -.3 5.5 -1.4 5.5 -6a4.6 4.6 0 0 0 -1.3 -3.2a4.2 4.2 0 0 0 -.1 -3.2s-1.1 -.3 -3.5 1.3a12.3 12.3 0 0 0 -6.2 0c-2.4 -1.6 -3.5 -1.3 -3.5 -1.3a4.2 4.2 0 0 0 -.1 3.2a4.6 4.6 0 0 0 -1.3 3.2c0 4.6 2.7 5.7 5.5 6c-.6 .6 -.6 1.2 -.5 2v3.5" />
                            </svg>
                            <span class="text-sm">GitHub</span>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
