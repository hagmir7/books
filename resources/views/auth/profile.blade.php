@extends('layouts.base')

@section('content')
<div class="min-h-screen bg-gray-50" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <div class="flex flex-col md:flex-row" x-data="{ activeSection: 'books', sidebarOpen: false }">
        <!-- Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden">
        </div>

        <!-- Sidebar -->
        <aside
            :class="sidebarOpen ? 'translate-x-0' : '{{ app()->getLocale() == 'ar' ? 'translate-x-full' : '-translate-x-full' }}'"
            class="bg-white shadow-sm fixed top-0 h-screen w-64 border-b md:border-b-0 border-gray-200 overflow-y-auto z-50
                      transition-transform duration-300 ease-in-out md:translate-x-0
                      {{ app()->getLocale() == 'ar' ? 'right-0' : 'left-0' }}">
            <div class="p-4 md:p-6">
                <div class="flex-shrink-0 flex justify-center">
                    <a href="/" class="block" :aria-label="$el?.querySelector('img')?.alt || '{{ $site->name }}'">
                        <img src="{{ asset('storage/'.$site->logo) }}" alt="{{ $site->name }}" loading="lazy"
                            class="h-8 sm:h10 lg:h-12 object-contain">
                    </a>
                </div>
                <!-- Profile Header -->
                <div class="text-center mb-6 mt-4">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->first_name) }}&size=96&background=4f46e5&color=fff"
                        class="w-20 h-20 rounded-full mx-auto">
                    <h2 class="mt-3 text-lg font-semibold text-gray-900">
                        {{ $user->first_name }} {{ $user->last_name }}
                    </h2>
                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                </div>

                <!-- Navigation -->
                <nav class="space-y-1">


                    <button @click="activeSection = 'books'; sidebarOpen = false"
                        :class="activeSection === 'books' ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50'"
                        class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-md transition">
                        {{ __('My Books') }}
                    </button>

                    <button @click="activeSection = 'info'; sidebarOpen = false"
                        :class="activeSection === 'info' ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50'"
                        class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-md transition">
                        {{ __('My Info') }}
                    </button>

                    <a href="{{ route('book.create') }}"
                        class="w-full flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-md transition">
                        {{ __('Create Book') }}
                    </a>

                    <button @click="activeSection = 'password'; sidebarOpen = false"
                        :class="activeSection === 'password' ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50'"
                        class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-md transition">
                        {{ __('Password') }}
                    </button>
                </nav>

                <!-- Logout -->
                {{-- <div class="mt-6 pt-4 border-t">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full text-red-600">{{ __('Logout') }}</button>
                    </form>
                </div> --}}

            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-4 md:p-8 md:pt-8 {{ app()->getLocale() == 'ar' ? 'md:mr-64' : 'md:ml-64' }}">

            <div class="text-center mb-6 md:hidden">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->first_name) }}&size=96&background=4f46e5&color=fff"
                    class="w-20 h-20 rounded-full mx-auto">
                <h2 class="mt-3 text-lg font-semibold text-gray-900">
                    {{ $user->first_name }} {{ $user->last_name }}
                </h2>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>
            </div>

            <nav class="space-y-1 md:hidden">


                <button @click="activeSection = 'books'; sidebarOpen = false"
                    :class="activeSection === 'books' ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50'"
                    class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-md transition">
                    {{ __('My Books') }}
                </button>
                <button @click="activeSection = 'info'; sidebarOpen = false"
                    :class="activeSection === 'info' ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50'"
                    class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-md transition">
                    {{ __('My Info') }}
                </button>

                <a href="{{ route('book.create') }}"
                    class="w-full flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-md transition">
                    {{ __('Create Book') }}
                </a>

                <button @click="activeSection = 'password'; sidebarOpen = false"
                    :class="activeSection === 'password' ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50'"
                    class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-md transition">
                    {{ __('Password') }}
                </button>
            </nav>


            <!-- INFO -->
            <template x-if="activeSection === 'info'">
                <section class="mb-8">
                    <div class="bg-white rounded-lg border p-6">
                        <h1 class="text-2xl font-semibold mb-6">{{ __('User Information') }}</h1>

                        <div class="grid sm:grid-cols-2 gap-6">
                            <div>
                                <label class="text-sm text-gray-500">{{ __('Full Name') }}</label>
                                <p>{{ $user->first_name }} {{ $user->last_name }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">{{ __('Email') }}</label>
                                <p>{{ $user->email }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">{{ __('Member Since') }}</label>
                                <p>{{ $user->created_at->format('F j, Y') }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">{{ __('Total Books') }}</label>
                                <p>{{ $user->books_count }}</p>
                            </div>
                        </div>
                    </div>
                </section>
            </template>

            <!-- BOOKS -->
            <template x-if="activeSection === 'books'">
               @livewire('user-books')
            </template>

            <!-- PASSWORD -->
            <template x-if="activeSection === 'password'">
                <section>
                    <form method="POST" action="{{ route('auth.password') }}">
                        @csrf
                        @method('PUT')
                        <button class="mt-4 bg-indigo-600 text-white px-4 py-2 rounded">
                            {{ __('Update Password') }}
                        </button>
                    </form>
                </section>
            </template>

        </main>
    </div>
</div>
@endsection
