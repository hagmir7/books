@extends('layouts.base')

@section('content')
<section class="single-post py-8">
    {!! app("site")->ads !!}

    <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "Article",
            "mainEntityOfPage": {
                "@type": "WebPage",
                "@id": "{{ request()->url() }}"
            },
            "headline": "{{ $post->title }}",
            "image": [
                "{{ asset('storage/'.$post->image) }}"
            ],
            "datePublished": "{{ $post->created_at->toIso8601String() }}",
            "dateModified": "{{ $post->updated_at->toIso8601String() }}",
            "author": {
                "@type": "Organization",
                "name": "{{ $site->name }}"
            },
            "publisher": {
                "@type": "Organization",
                "name": "{{ $site->name }}",
                "logo": {
                    "@type": "ImageObject",
                    "url": "{{ asset('storage/'.$site->image) }}"
                }
            },
            "description": "{{ $post->description }}"
        }
    </script>

    <style>
        .post-body pre,
        .post-body pre code,
        .post-body code {
            direction: ltr !important;
            unicode-bidi: isolate;
            text-align: left;
        }

        .post-body table tr:nth-child(even) td {
            background-color: #f9fafb;
        }

        .post-body ul>li::marker {
            color: #16a34a;
        }

        .post-body ol>li::marker {
            color: #16a34a;
            font-weight: 600;
        }
    </style>

    <div class="container mx-auto px-4">
        <div class="flex flex-wrap">
            <div class="w-full">
                <div class="post-content max-w-4xl mx-auto">
                    <!-- Post Title -->
                    <h1 class="text-xl md:text-2xl font-bold text-gray-900 mb-4 text-center">
                        {{ $post->title }}
                    </h1>

                    <!-- Post Meta -->
                    <div class="post-meta text-center mt-2">
                        <span class="time flex justify-center items-center gap-2 text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="flex-shrink-0">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M12 12l3 -2" />
                                <path d="M12 7v5" />
                            </svg>
                            <span class="text-lg font-medium">
                                {{ $post->created_at->locale(app()->getLocale())->translatedFormat('M d, Y') }}
                            </span>
                        </span>
                    </div>

                    <!-- Social Share Buttons -->
                    <div class="social-btns mt-6 flex flex-wrap justify-center gap-3">
                        <!-- Facebook -->
                        <a target="_blank" aria-label="{{ __('Share with Facebook') }}"
                            href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                            class="facebook inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" />
                            </svg>
                        </a>

                        <!-- Twitter/X -->
                        <a target="_blank" aria-label="{{ __('Share with X') }}"
                            href="https://twitter.com/intent/tweet?text={{ urlencode($post->title . ' ' . request()->fullUrl()) }}"
                            class="twitter inline-flex items-center justify-center w-10 h-10 rounded-full bg-sky-500 text-white hover:bg-sky-600 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M22 4.01c-1 .49 -1.98 .689 -3 .99c-1.121 -1.265 -2.783 -1.335 -4.38 -.737s-2.643 2.06 -2.62 3.737v1c-3.245 .083 -6.135 -1.395 -8 -4c0 0 -4.182 7.433 4 11c-1.872 1.247 -3.739 2.088 -6 2c3.308 1.803 6.913 2.423 10.034 1.517c3.58 -1.04 6.522 -3.723 7.651 -7.742a13.84 13.84 0 0 0 .497 -3.753c0 -.249 1.51 -2.772 1.818 -4.013z" />
                            </svg>
                        </a>

                        <!-- Pinterest -->
                        <a target="_blank" aria-label="{{ __('Share with Pinterest') }}"
                            href="https://pinterest.com/pin/create/button/?url={{ urlencode(request()->fullUrl()) }}&description={{ urlencode($post->title) }}"
                            class="pinterest inline-flex items-center justify-center w-10 h-10 rounded-full bg-red-600 text-white hover:bg-red-700 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M8 20l4 -9" />
                                <path
                                    d="M10.7 14c.437 1.263 1.43 2 2.55 2c2.071 0 3.75 -1.554 3.75 -4a5 5 0 1 0 -9.7 1.7" />
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                            </svg>
                        </a>

                        <!-- WhatsApp -->
                        <a target="_blank" aria-label="{{ __('Share with WhatsApp') }}"
                            href="whatsapp://send/?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($post->title) }}"
                            class="whatsapp inline-flex items-center justify-center w-10 h-10 rounded-full bg-green-500 text-white hover:bg-green-600 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9" />
                                <path
                                    d="M9 10a.5 .5 0 0 0 1 0v-1a.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a.5 .5 0 0 0 0 -1h-1a.5 .5 0 0 0 0 1" />
                            </svg>
                        </a>

                        <!-- Telegram -->
                        <a target="_blank" aria-label="{{ __('Share with Telegram') }}"
                            href="https://telegram.me/share/url?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($post->title) }}"
                            class="telegram inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-500 text-white hover:bg-blue-600 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M15 10l-4 4l6 6l4 -16l-18 7l4 2l2 6l3 -4" />
                            </svg>
                        </a>
                    </div>

                    <!-- Post Actions (Livewire) -->
                    @if (auth()->user()?->email_verified_at)
                    <div class="mt-6">
                        @livewire('post-actions', ['post' => $post, key($post->slug)])
                    </div>
                    @endif

                    {!! app("site")->ads !!}

                    <!-- Post Image -->
                    <div class="my-6">
                        <img width="100%" height="auto" class="rounded-lg shadow-md"
                            src="{{ asset('storage/'.$post->image) }}" alt="{{ $post->title }}">
                    </div>

                    <!-- Post Content -->
                    <div class="post-body prose max-w-none mt-4

                        prose-headings:font-bold prose-headings:text-gray-900
                        prose-headings:mt-4 prose-headings:mb-1
                        prose-h2:text-[1.5rem] prose-h2:border-b prose-h2:border-gray-200 prose-h2:pb-1
                        prose-h3:text-[1.4rem]
                        prose-h4:text-[1.3rem]
                        prose-h5:text-[1.2rem]
                        prose-h6:text-[1.1rem]

                        prose-p:text-[16px] prose-p:leading-6 prose-p:text-gray-700
                        prose-p:mt-0 prose-p:mb-2

                        prose-ul:text-[16px] prose-ul:text-gray-700 prose-ul:leading-6
                        prose-ul:mt-1 prose-ul:mb-2 prose-ul:ps-4
                        prose-ol:text-[16px] prose-ol:text-gray-700 prose-ol:leading-6
                        prose-ol:mt-1 prose-ol:mb-2 prose-ol:ps-4
                        prose-li:my-0.5

                        prose-hr:border-gray-200 prose-hr:my-3

                        prose-table:text-[13px] prose-table:w-full
                        prose-thead:bg-gray-50
                        prose-th:text-left prose-th:font-semibold prose-th:text-gray-800
                        prose-th:px-2 prose-th:py-1.5 prose-th:border prose-th:border-gray-200
                        prose-td:px-2 prose-td:py-1.5 prose-td:border prose-td:border-gray-200
                        prose-td:text-gray-700

                        prose-blockquote:border-l-4 prose-blockquote:border-green-500
                        prose-blockquote:bg-green-50 prose-blockquote:rounded-r-md
                        prose-blockquote:px-3 prose-blockquote:py-1 prose-blockquote:my-3
                        prose-blockquote:text-gray-600 prose-blockquote:not-italic

                        prose-code:text-[12px] prose-code:bg-transparent
                        prose-code:border-0 prose-code:text-rose-600 prose-code:font-mono
                        prose-code:before:content-none prose-code:after:content-none

                        prose-pre:bg-gray-950 prose-pre:text-gray-100
                        prose-pre:rounded-lg prose-pre:px-4 prose-pre:py-3
                        prose-pre:overflow-x-auto prose-pre:my-3
                        prose-pre:text-[12px] prose-pre:leading-5
                        [&_pre_code]:bg-transparent [&_pre_code]:border-0
                        [&_pre_code]:p-0 [&_pre_code]:text-gray-100 [&_pre_code]:text-[14px]

                        prose-a:text-green-600 prose-a:underline prose-a:underline-offset-2
                        hover:prose-a:text-green-700
                        dark:prose-a:text-green-400 dark:hover:prose-a:text-green-300

                        prose-img:rounded-xl prose-img:shadow-sm prose-img:my-3
                        prose-strong:text-gray-900 prose-strong:font-semibold">
                        {!! $post->body !!}
                    </div>

                    {!! app("site")->ads !!}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
