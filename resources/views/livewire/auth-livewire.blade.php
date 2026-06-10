<div class="min-h-screen flex items-center justify-center px-4">
<div class="bg-white rounded-lg w-full max-w-3xl shadow-sm max-h-[90vh] overflow-y-auto" @click.stop
    x-data="{ showPassword: false, showConfirmPassword: false }" role="dialog" aria-modal="true"
    aria-labelledby="authTitle">
    {{-- Header --}}
    <div class="border-b px-6 py-4 rounded-t-lg">
        <div class="flex flex-col items-center gap-3">
            <img width="100px" height="50px" src="{{ asset('storage/'.$site->logo) }}" alt="{{ __('Site logo') }}"
                class="object-contain h-11">

            {{-- Tab switcher --}}
            <div class="flex w-full border border-gray-200 rounded-lg overflow-hidden text-sm font-medium">
                <button type="button" class="flex-1 py-2 transition cursor-pointer" :class="$wire.isRegister
                                ? 'bg-white text-gray-600 hover:bg-gray-50'
                                : 'bg-(--color-primary) text-white'" wire:click="$set('isRegister', false)">
                    {{ __('Sign in') }}
                </button>
                <button type="button" class="flex-1 py-2 transition cursor-pointer" :class="$wire.isRegister
                                ? 'bg-(--color-primary) text-white'
                                : 'bg-white text-gray-600 hover:bg-gray-50'" wire:click="$set('isRegister', true)">
                    {{ __('Create account') }}
                </button>
            </div>
        </div>
    </div>

    <div class="px-6 pb-6">
        <div class="mt-4">

            {{-- Top-level errors --}}
            @if (session()->has('error'))
            <div role="alert" class="bg-red-50 border border-red-200 text-red-700 px-4 py-2 rounded mb-4 text-sm">
                {{ session('error') }}
            </div>
            @endif

            {{-- ── REGISTER ── --}}
            @if ($isRegister)
            <form wire:submit.prevent="register" class="space-y-4" novalidate>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('First name') }}</label>
                        <input id="first_name" type="text" wire:model.defer="first_name" autocomplete="given-name"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md text-sm
                                           focus:outline-none focus:ring-2 focus:ring-(--color-primary) focus:border-transparent"
                            aria-invalid="{{ $errors->has('first_name') ? 'true' : 'false' }}">
                        @error('first_name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Last name') }}</label>
                        <input id="last_name" type="text" wire:model.defer="last_name" autocomplete="family-name"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md text-sm
                                           focus:outline-none focus:ring-2 focus:ring-(--color-primary) focus:border-transparent" aria-invalid="{{ $errors->has('last_name') ? 'true' : 'false' }}">
                        @error('last_name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="reg_email" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Email')
                        }}</label>
                    <input id="reg_email" type="email" wire:model.defer="email" autocomplete="email"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md text-sm
                                       focus:outline-none focus:ring-2 focus:ring-(--color-primary) focus:border-transparent" aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}">
                    @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="reg_password" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Password')
                        }}</label>
                    <div class="relative">
                        <input id="reg_password" :type="showPassword ? 'text' : 'password'" wire:model.defer="password"
                            autocomplete="new-password"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md pr-10 text-sm
                                           focus:outline-none focus:ring-2 focus:ring-(--color-primary) focus:border-transparent"
                            aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}">
                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-2 flex items-center px-2 text-gray-400 hover:text-gray-600 cursor-pointer"
                            :aria-label="showPassword ? '{{ __('Hide password') }}' : '{{ __('Show password') }}'">
                            <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M21 9c-2.4 2.667 -5.4 4 -9 4c-3.6 0 -6.6 -1.333 -9 -4" />
                                <path d="M3 15l2.5 -3.8" />
                                <path d="M21 14.976l-2.492 -3.776" />
                                <path d="M9 17l.5 -4" />
                                <path d="M15 17l-.5 -4" />
                            </svg>
                            <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                <path
                                    d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                            </svg>
                        </button>
                    </div>
                    @error('password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">{{
                        __('Confirm password') }}</label>
                    <div class="relative">
                        <input id="password_confirmation" :type="showConfirmPassword ? 'text' : 'password'"
                            wire:model.defer="password_confirmation" autocomplete="new-password"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md pr-10 text-sm
                                           focus:outline-none focus:ring-2 focus:ring-(--color-primary) focus:border-transparent"
                            aria-invalid="{{ $errors->has('password_confirmation') ? 'true' : 'false' }}">
                        <button type="button" @click="showConfirmPassword = !showConfirmPassword"
                            class="absolute inset-y-0 right-2 flex items-center px-2 text-gray-400 hover:text-gray-600 cursor-pointer"
                            :aria-label="showConfirmPassword ? '{{ __('Hide password') }}' : '{{ __('Show password') }}'">
                            <svg x-show="!showConfirmPassword" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M21 9c-2.4 2.667 -5.4 4 -9 4c-3.6 0 -6.6 -1.333 -9 -4" />
                                <path d="M3 15l2.5 -3.8" />
                                <path d="M21 14.976l-2.492 -3.776" />
                                <path d="M9 17l.5 -4" />
                                <path d="M15 17l-.5 -4" />
                            </svg>
                            <svg x-show="showConfirmPassword" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                <path
                                    d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                            </svg>
                        </button>
                    </div>
                    @error('password_confirmation') <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" wire:loading.attr="disabled" wire:loading.class="opacity-60 cursor-wait"
                    class="bg-(--color-primary) text-white py-2 px-4 rounded-md
                                   hover:bg-(--color-primary)/90 transition shadow w-full text-sm font-medium cursor-pointer">
                    {{ __('Create account') }}
                </button>

            </form>

            @else

            {{-- ── LOGIN ── --}}
            <form wire:submit="login" class="space-y-4" novalidate>

                <div>
                    <label for="login_email" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Email')
                        }}</label>
                    <input id="login_email" type="email" wire:model.defer="email" autocomplete="email"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md text-sm
                                       focus:outline-none focus:ring-2 focus:ring-(--color-primary) focus:border-transparent" aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}">
                    @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="login_password" class="block text-sm font-medium text-gray-700 mb-1">{{
                        __('Password') }}</label>
                    <div class="relative">
                        <input id="login_password" :type="showPassword ? 'text' : 'password'"
                            wire:model.defer="password" autocomplete="current-password"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md pr-10 text-sm
                                           focus:outline-none focus:ring-2 focus:ring-(--color-primary) focus:border-transparent"
                            aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}">
                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-2 flex items-center px-2 text-gray-400 hover:text-gray-600 cursor-pointer"
                            :aria-label="showPassword ? '{{ __('Hide password') }}' : '{{ __('Show password') }}'">
                            <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M21 9c-2.4 2.667 -5.4 4 -9 4c-3.6 0 -6.6 -1.333 -9 -4" />
                                <path d="M3 15l2.5 -3.8" />
                                <path d="M21 14.976l-2.492 -3.776" />
                                <path d="M9 17l.5 -4" />
                                <path d="M15 17l-.5 -4" />
                            </svg>
                            <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                <path
                                    d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                            </svg>
                        </button>
                    </div>
                    @error('password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center justify-between gap-3">
                    <label class="flex items-center gap-2 text-sm text-gray-600 select-none cursor-pointer">
                        <input type="checkbox" wire:model="remember" id="rememberMe"
                            class="size-4 rounded border-gray-300 accent-(--color-primary)">
                        {{ __('Remember me') }}
                    </label>
                    <button type="submit" wire:loading.attr="disabled" wire:loading.class="opacity-60 cursor-wait"
                        class="bg-(--color-primary) text-white py-2 px-5 rounded-md
                                       hover:bg-(--color-primary)/90 transition shadow text-sm font-medium cursor-pointer">
                        {{ __('Sign in') }}
                    </button>
                </div>

            </form>
            @endif

            {{-- ── Social login (shared by both panels) ── --}}
            <div class="mt-5">
                <div class="flex items-center gap-3">
                    <div class="flex-1 h-px bg-gray-200"></div>
                    <span class="text-xs text-gray-400">{{ __('Or continue with') }}</span>
                    <div class="flex-1 h-px bg-gray-200"></div>
                </div>

                <div class="mt-3 flex  gap-2">


                    @if (isset(app('site')->site_options['GOOGLE_CLIENT_ID'], app('site')->site_options['GOOGLE_CLIENT_SECRET']))
                        {{-- Google --}}
                        <a href="{{ route('google.login') }}" class="flex items-center justify-center gap-2.5 w-full border border-gray-200 py-2 rounded-md
                                                               hover:bg-gray-50 transition text-sm text-gray-700">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path
                                    d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                                    fill="#4285F4" />
                                <path
                                    d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                                    fill="#34A853" />
                                <path
                                    d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"
                                    fill="#FBBC05" />
                                <path
                                    d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                                    fill="#EA4335" />
                            </svg>
                            Google
                        </a>
                    @endif

                    @if (isset(app('site')->site_options['FACEBOOK_CLIENT_ID'], app('site')->site_options['FACEBOOK_CLIENT_SECRET']))
                        {{-- Facebook --}}
                        <a href="{{ route('facebook.login') }}" class="flex items-center justify-center gap-2.5 w-full border border-gray-200 py-2 rounded-md
                                                               hover:bg-gray-50 transition text-sm text-gray-700">
                            <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M12 0C5.373 0 0 5.373 0 12c0 5.989 4.388 10.952 10.125 11.854V15.47H7.078V12h3.047V9.356c0-3.007 1.792-4.669 4.533-4.669 1.313 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874V12h3.328l-.532 3.47h-2.796v8.385C19.612 22.952 24 17.989 24 12c0-6.627-5.373-12-12-12z"
                                    fill="#1877F2" />
                            </svg>
                            Facebook
                        </a>
                    @endif


                    @if (isset(app('site')->site_options['GITHUB_CLIENT_ID'], app('site')->site_options['GITHUB_CLIENT_SECRET']))
                        {{-- GitHub --}}
                        <a href="{{ route('github.login') }}" class="flex items-center justify-center gap-2.5 w-full border border-gray-200 py-2 rounded-md
                                                               hover:bg-gray-50 transition text-sm text-gray-700">
                            <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true" class="text-gray-800">
                                <path
                                    d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0 1 12 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"
                                    fill="currentColor" />
                            </svg>
                            GitHub
                        </a>
                    @endif



                </div>
            </div>

        </div>
    </div>
</div>
</div>
