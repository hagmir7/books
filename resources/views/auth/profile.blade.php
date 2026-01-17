@extends('layouts.base')

@section('content')
<div class="min-h-screen bg-gray-50" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <div class="flex flex-col md:flex-row" x-data="{ activeSection: 'info' }">
        <!-- Sidebar -->
        <aside class="w-full md:w-64 bg-white border-b md:border-b-0 md:border-e border-gray-200">
            <div class="p-4 md:p-6">
                <!-- Profile Header -->
                <div class="text-center mb-6">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->first_name) }}&size=96&background=4f46e5&color=fff"
                        alt="Profile" class="w-20 h-20 rounded-full mx-auto">
                    <h2 class="mt-3 text-lg font-semibold text-gray-900">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h2>
                    <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                </div>

                <!-- Navigation -->
                <nav class="space-y-1">
                    <button @click="activeSection = 'info'"
                        :class="activeSection === 'info' ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50'"
                        class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-md transition">
                        <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        {{ __('User Info') }}
                    </button>

                    <button @click="activeSection = 'books'"
                        :class="activeSection === 'books' ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50'"
                        class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-md transition">
                        <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        {{ __('My Books') }}
                    </button>

                    <a href="{{ route('book.create') }}"
                        class="w-full flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-md transition">
                        <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        {{ __('Create Book') }}
                    </a>

                    <button @click="activeSection = 'password'"
                        :class="activeSection === 'password' ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50'"
                        class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-md transition">
                        <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        {{ __('Password') }}
                    </button>
                </nav>

                <!-- Logout -->
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <form method="POST" action="">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50 rounded-md transition">
                            <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            {{ __('Logout') }}
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-4 md:p-8">
            <!-- User Info Section -->
            <section x-show="activeSection === 'info'" class="mb-8">
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h1 class="text-2xl font-semibold text-gray-900 mb-6">{{ __('User Information') }}</h1>

                    <div class="grid sm:grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm font-medium text-gray-500">{{ __('Full Name') }}</label>
                            <p class="mt-1 text-gray-900">{{ auth()->user()->name }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">{{ __('Email Address') }}</label>
                            <p class="mt-1 text-gray-900">{{ auth()->user()->email }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">{{ __('Member Since') }}</label>
                            <p class="mt-1 text-gray-900">{{ auth()->user()->created_at->format('F j, Y') }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">{{ __('Total Books') }}</label>
                            <p class="mt-1 text-gray-900">{{ $user->books_count }} {{ __('Books') }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Books Section -->
            <section x-show="activeSection === 'books'">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                    <h2 class="text-2xl font-semibold text-gray-900">{{ __('My Books') }}</h2>
                    <a href="{{ route('book.create') }}"
                        class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition">
                        <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        {{ __('Add New Book') }}
                    </a>
                </div>

                @if(auth()->user()->books->isEmpty())
                <div class="bg-white rounded-lg border border-gray-200 p-12 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('No books yet') }}</h3>
                    <p class="text-gray-500 mb-4">{{ __('Start your collection by creating your first book!') }}</p>
                    <a href="{{ route('book.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition">
                        {{ __('Create Your First Book') }}
                    </a>
                </div>
                @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    @foreach(auth()->user()->books as $book)
                    <div
                        class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:border-gray-300 transition">
                        <div class="aspect-[3/4] bg-gray-100 relative">
                            @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                                class="w-full h-full object-cover">
                            @else
                            <div
                                class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-200 to-gray-300">
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            @endif
                        </div>

                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 mb-1 truncate">{{ $book->title }}</h3>
                            <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $book->description ?? __('No
                                description available.') }}</p>

                            <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
                                <span>{{ $book->created_at->format('M d, Y') }}</span>
                                <span>{{ $book->pages ?? 0 }} {{ __('pages') }}</span>
                            </div>

                            <a href="{{ route('book.show', $book->id) }}"
                                class="block w-full px-3 py-2 bg-indigo-600 text-white text-sm font-medium text-center rounded-md hover:bg-indigo-700 transition">
                                {{ __('View Book') }}
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ auth()->user()->books->links() }}
                </div>
                @endif
            </section>

            <!-- Password Section -->
            <section x-show="activeSection === 'password'">
                <div class="bg-white rounded-lg border border-gray-200 p-6 max-w-md">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-6">{{ __('Change Password') }}</h2>

                    <form method="POST" action="{{ route('auth.password') }}">
                        @csrf
                        @method('PUT')

                        <div class="space-y-4">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">{{
                                    __('Current Password') }}</label>
                                <input type="password" id="current_password" name="current_password" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div>
                                <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">{{
                                    __('New Password') }}</label>
                                <input type="password" id="new_password" name="password" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div>
                                <label for="password_confirmation"
                                    class="block text-sm font-medium text-gray-700 mb-1">{{ __('Confirm New Password')
                                    }}</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <button type="submit"
                                class="w-full px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition">
                                {{ __('Update Password') }}
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </main>
    </div>
</div>
@endsection
