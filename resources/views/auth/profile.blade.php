@extends('layouts.base')

@section('content')
<div class="min-h-screen bg-gray-50" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <div class="flex flex-col md:flex-row" x-data="{ activeSection: 'info' }">

        <!-- Sidebar -->
        <aside class="w-full md:w-64 bg-white border-b md:border-b-0 md:border-e border-gray-200">
            <div class="p-4 md:p-6">

                <!-- Profile Header -->
                <div class="text-center mb-6">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->first_name) }}&size=96&background=4f46e5&color=fff"
                        class="w-20 h-20 rounded-full mx-auto">
                    <h2 class="mt-3 text-lg font-semibold text-gray-900">
                        {{ $user->first_name }} {{ $user->last_name }}
                    </h2>
                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                </div>

                <!-- Navigation -->
                <nav class="space-y-1">
                    <button @click="activeSection = 'info'"
                        :class="activeSection === 'info' ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50'"
                        class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-md transition">
                        {{ __('User Info') }}
                    </button>

                    <button @click="activeSection = 'books'"
                        :class="activeSection === 'books' ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50'"
                        class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-md transition">
                        {{ __('My Books') }}
                    </button>

                    <a href="{{ route('book.create') }}"
                        class="w-full flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-md transition">
                        {{ __('Create Book') }}
                    </a>

                    <button @click="activeSection = 'password'"
                        :class="activeSection === 'password' ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50'"
                        class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-md transition">
                        {{ __('Password') }}
                    </button>
                </nav>

                <!-- Logout -->
                <div class="mt-6 pt-4 border-t">
                    <form method="POST" action="">
                        @csrf
                        <button class="w-full text-red-600">{{ __('Logout') }}</button>
                    </form>
                </div>

            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-4 md:p-8">

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
                <section>

                    @if($books->isEmpty())
                    <div class="bg-white p-12 text-center">
                        {{ __('No books yet') }}
                    </div>
                    @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach($books as $book)
                        <div class="bg-white border rounded-lg">
                            <div class="p-4">
                                <h3 class="font-semibold">{{ $book->title }}</h3>
                                <a href="{{ route('book.show', $book->id) }}" class="block mt-2 text-indigo-600">
                                    {{ __('View Book') }}
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $books->links() }}
                    </div>
                    @endif

                </section>
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
