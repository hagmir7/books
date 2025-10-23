@extends('layouts.base')

@section('content')
<section class="page contacts py-12">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap">
            <!-- Page Title -->
            <div class="w-full mb-6">
                <h1 class="text-3xl font-semibold text-gray-900">{{ __("Contact Us") }}</h1>
            </div>

            <!-- Contact Content -->
            <div class="w-full">
                <div class="page-content max-w-4xl">
                    <!-- Intro Message -->
                    <p class="text-gray-700 text-base leading-relaxed mb-6">
                        {{ __("contact.message") }}
                    </p>

                    <!-- Get in Touch Section -->
                    <h2 id="get-in-touch" class="text-2xl font-bold text-gray-900 mb-4 mt-8">
                        {{ __("Get in Touch") }}
                    </h2>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-start gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="text-primary flex-shrink-0 mt-0.5">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                                <path d="M3 7l9 6l9 -6" />
                            </svg>
                            <span class="text-gray-700">
                                <strong class="font-semibold text-gray-900">{{ __("Email") }}:</strong>
                                @if (app("site")->email)
                                <a href="mailto:{{ app('site')->email }}"
                                    class="text-primary hover:underline transition-colors">
                                    {{ app("site")->email }}
                                </a>
                                @endif
                            </span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="text-primary flex-shrink-0 mt-0.5">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M12 7v5l3 3" />
                            </svg>
                            <span class="text-gray-700">
                                <strong class="font-semibold text-gray-900">{{ __("Hours") }}:</strong>
                                {{ __("Monday - Friday, 9:00 AM - 5:00 PM EST") }}
                            </span>
                        </li>
                    </ul>

                    <!-- Send Message Section -->
                    <h2 id="send-us-a-message" class="text-2xl font-bold text-gray-900 mb-4 mt-8">
                        {{ __("Send Us a Message") }}
                    </h2>
                    <p class="text-gray-700 text-base leading-relaxed mb-6">
                        {{ __("Use the form below to send us a message, and we'll get back to you as soon as possible.")
                        }}
                    </p>
                </div>

                <!-- Contact Form -->
                <div class="max-w-4xl">
                    @livewire('contact-form')
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
