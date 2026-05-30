@extends('layouts.base')

@section('content')

    @push('meta')
    <meta property="article:published_time" content="{{ $post->created_at->toIso8601String() }}">
    <meta property="article:modified_time" content="{{ $post->updated_at->toIso8601String() }}">
    <meta property="article:author" content="{{ $site->domain }}">

    @if($post->category ?? false)
    <meta property="article:section" content="{{ $post->category }}">
    @endif

    @if($post->tags ?? false)
    <meta property="article:tag" content="{{ $post->tags }}">
    @endif
    @endpush

    <section class="single-post py-8">
        <script type="application/ld+json">
            {
        "@context": "https://schema.org",
        "@type": "Article",
        "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "{{ request()->url() }}"
        },
        "headline": "{{ addslashes($post->title) }}",
        "description": "{{ addslashes($post->description) }}",
        "image": {
            "@type": "ImageObject",
            "url": "{{ asset('storage/'.$post->image) }}",
            "width": 1200,
            "height": 630
        },
        "datePublished": "{{ $post->created_at->toIso8601String() }}",
        "dateModified":  "{{ $post->updated_at->toIso8601String() }}",
        "inLanguage": "ar",
        @if($post->tags ?? false)
        "keywords": "{{ addslashes($post->tags) }}",
        @endif
        "author": {
            "@type": "Organization",
            "name": "{{ addslashes($site->name) }}",
            "url": "{{ config('app.url') }}"
        },
        "publisher": {
            "@type": "Organization",
            "name": "{{ addslashes($site->name) }}",
            "url": "{{ config('app.url') }}",
            "logo": {
                "@type": "ImageObject",
                "url": "{{ asset('storage/'.$site->image) }}",
                "width": 600,
                "height": 60
            }
        },
        "breadcrumb": {
            "@type": "BreadcrumbList",
            "itemListElement": [
                {
                    "@type": "ListItem",
                    "position": 1,
                    "name": "{{ __('Home') }}",
                    "item": "{{ config('app.url') }}"
                },
                {
                    "@type": "ListItem",
                    "position": 2,
                    "name": "{{ __('Blog') }}",
                    "item": "{{ config('app.url') }}/blog"
                },
                {
                    "@type": "ListItem",
                    "position": 3,
                    "name": "{{ addslashes($post->title) }}",
                    "item": "{{ request()->url() }}"
                }
            ]
        }
    }
        </script>

        {{-- ── Code block direction fix ─────────────────────────────── --}}
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

            /* Table of Contents */
            #toc a {
                color: #15803d;
                text-decoration: none;
            }

            #toc a:hover {
                text-decoration: underline;
            }

            #toc ol {
                counter-reset: toc-counter;
                list-style: none;
                padding: 0;
            }

            #toc ol li {
                counter-increment: toc-counter;
                padding: 4px 0;
                font-size: 0.9rem;
            }

            #toc ol li::before {
                content: counter(toc-counter) ". ";
                color: #16a34a;
                font-weight: 600;
            }
        </style>

        <div class="container mx-auto px-4">
            <div class="w-full">
                <div class="post-content max-w-4xl mx-auto">

                    {{-- ── Breadcrumb Navigation ────────────────────────── --}}
                    <nav aria-label="{{ __('Breadcrumb') }}" class="mb-6 text-sm text-gray-500">
                        <ol class="flex flex-wrap items-center gap-1.5" itemscope
                            itemtype="https://schema.org/BreadcrumbList">

                            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                                <a href="{{ config('app.url') }}" itemprop="item"
                                    class="hover:text-green-600 transition-colors">
                                    <span itemprop="name">{{ __('Home') }}</span>
                                </a>
                                <meta itemprop="position" content="1">
                            </li>

                            <li class="text-gray-300" aria-hidden="true">/</li>

                            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                                <a href="{{ config('app.url') }}/blog" itemprop="item"
                                    class="hover:text-green-600 transition-colors">
                                    <span itemprop="name">{{ __('Blog') }}</span>
                                </a>
                                <meta itemprop="position" content="2">
                            </li>

                            <li class="text-gray-300" aria-hidden="true">/</li>

                            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"
                                class="text-gray-700 font-medium line-clamp-1 max-w-xs sm:max-w-sm">
                                <span itemprop="name">{{ $post->title }}</span>
                                <meta itemprop="position" content="3">
                            </li>
                        </ol>
                    </nav>

                    {{-- ── Post Title ───────────────────────────────────── --}}
                    <h1 class="text-xl md:text-2xl font-bold text-gray-900 mb-4 text-center" itemprop="headline">
                        {{ $post->title }}
                    </h1>

                    {{-- ── Post Meta (date + reading time) ─────────────── --}}
                    <div class="post-meta flex flex-wrap justify-center items-center gap-4 mt-2 text-gray-500 text-sm">

                        {{-- Date --}}
                        <span class="flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" aria-hidden="true">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M12 12l3 -2" />
                                <path d="M12 7v5" />
                            </svg>
                            <time datetime="{{ $post->created_at->toIso8601String() }}" class="font-medium">
                                {{ $post->created_at->locale(app()->getLocale())->translatedFormat('M d, Y') }}
                            </time>
                        </span>

                        {{-- Reading time (approx. 200 words/min for Arabic) --}}
                        @php
                        $wordCount = str_word_count(strip_tags($post->body));
                        $readingMin = max(1, (int) ceil($wordCount / 200));
                        @endphp
                        <span class="flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" aria-hidden="true">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" />
                                <path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" />
                                <path d="M3 6l0 13" />
                                <path d="M12 6l0 13" />
                                <path d="M21 6l0 13" />
                            </svg>
                            <span>{{ $readingMin }} {{ __('min read') }}</span>
                        </span>
                    </div>

                    {{-- ── Social Share Buttons ────────────────────────── --}}
                    <div class="social-btns mt-6 flex flex-wrap justify-center gap-3"
                        aria-label="{{ __('Share this article') }}">

                        {{-- Facebook --}}
                        <a target="_blank" rel="noopener noreferrer" aria-label="{{ __('Share on Facebook') }}"
                            href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}&quote={{ urlencode($post->title) }}"
                            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" aria-hidden="true">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" />
                            </svg>
                        </a>

                        {{-- Twitter / X --}}
                        <a target="_blank" rel="noopener noreferrer" aria-label="{{ __('Share on X') }}"
                            href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(request()->url()) }}"
                            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-sky-500 text-white hover:bg-sky-600 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" aria-hidden="true">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M22 4.01c-1 .49 -1.98 .689 -3 .99c-1.121 -1.265 -2.783 -1.335 -4.38 -.737s-2.643 2.06 -2.62 3.737v1c-3.245 .083 -6.135 -1.395 -8 -4c0 0 -4.182 7.433 4 11c-1.872 1.247 -3.739 2.088 -6 2c3.308 1.803 6.913 2.423 10.034 1.517c3.58 -1.04 6.522 -3.723 7.651 -7.742a13.84 13.84 0 0 0 .497 -3.753c-.249 1.51 -2.772 1.818 -4.013z" />
                            </svg>
                        </a>

                        {{-- WhatsApp --}}
                        <a target="_blank" rel="noopener noreferrer" aria-label="{{ __('Share on WhatsApp') }}"
                            href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . request()->url()) }}"
                            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-green-500 text-white hover:bg-green-600 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" aria-hidden="true">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9" />
                                <path
                                    d="M9 10a.5 .5 0 0 0 1 0v-1a.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a.5 .5 0 0 0 0 -1h-1a.5 .5 0 0 0 0 1" />
                            </svg>
                        </a>

                        {{-- Telegram --}}
                        <a target="_blank" rel="noopener noreferrer" aria-label="{{ __('Share on Telegram') }}"
                            href="https://telegram.me/share/url?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}"
                            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-500 text-white hover:bg-blue-600 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" aria-hidden="true">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M15 10l-4 4l6 6l4 -16l-18 7l4 2l2 6l3 -4" />
                            </svg>
                        </a>

                        {{-- Pinterest --}}
                        <a target="_blank" rel="noopener noreferrer" aria-label="{{ __('Share on Pinterest') }}"
                            href="https://pinterest.com/pin/create/button/?url={{ urlencode(request()->url()) }}&description={{ urlencode($post->title) }}&media={{ urlencode(asset('storage/'.$post->image)) }}"
                            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-red-600 text-white hover:bg-red-700 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" aria-hidden="true">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M8 20l4 -9" />
                                <path
                                    d="M10.7 14c.437 1.263 1.43 2 2.55 2c2.071 0 3.75 -1.554 3.75 -4a5 5 0 1 0 -9.7 1.7" />
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                            </svg>
                        </a>
                    </div>

                    {{-- ── Admin Actions (SECURED — auth + verified only) ── --}}
                    @auth
                    @if(auth()->user()->email_verified_at && auth()->user()->isAdmin())
                    <div class="mt-4">
                        @livewire('post-actions', ['post' => $post], key($post->slug))
                    </div>
                    @endif
                    @endauth

                    {{-- ── Ad slot (above fold, after header content) ───── --}}
                    {!! app('site')->ads !!}

                    {{-- ── Hero Image (LCP — eager + high priority) ──────── --}}
                    <div class="my-6">
                        <img src="{{ asset('storage/'.$post->image) }}" alt="{{ $post->title }}" width="1200"
                            height="630" class="rounded-lg shadow-md w-full h-auto" loading="eager" fetchpriority="high"
                            decoding="sync" itemprop="image">
                    </div>

                    {{-- ── Table of Contents (auto-built from H2 headings) ── --}}
                    <div id="toc" class="bg-gray-50 border border-gray-200 rounded-xl p-5 my-6 hidden"
                        aria-label="{{ __('Table of Contents') }}">
                        <p class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" aria-hidden="true">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M9 6l11 0" />
                                <path d="M9 12l11 0" />
                                <path d="M9 18l11 0" />
                                <path d="M5 6l0 .01" />
                                <path d="M5 12l0 .01" />
                                <path d="M5 18l0 .01" />
                            </svg>
                            {{ __('Table of Contents') }}
                        </p>
                        <ol id="toc-list"></ol>
                    </div>

                    {{-- ── Post Body ────────────────────────────────────── --}}
                    <div id="post-body" class="post-body prose max-w-none mt-4

                    prose-headings:font-bold prose-headings:text-gray-900
                    prose-headings:mt-4 prose-headings:mb-1
                    prose-h2:text-[1.5rem] prose-h2:border-b prose-h2:border-gray-200 prose-h2:pb-1
                    prose-h3:text-[1.4rem]
                    prose-h4:text-[1.3rem]
                    prose-h5:text-[1.2rem]
                    prose-h6:text-[1.1rem]

                    prose-p:text-[17px] prose-p:leading-6 prose-p:text-gray-700
                    prose-p:mt-0 prose-p:mb-2

                    prose-ul:text-[17px] prose-ul:text-gray-700 prose-ul:leading-6
                    prose-ul:mt-1 prose-ul:mb-2 prose-ul:ps-4
                    prose-ol:text-[17px] prose-ol:text-gray-700 prose-ol:leading-6
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

                    prose-code:text-[16px] prose-code:bg-transparent
                    prose-code:border-0 prose-code:text-rose-600 prose-code:font-mono
                    prose-code:before:content-none prose-code:after:content-none

                    prose-pre:bg-gray-700 prose-pre:text-gray-100
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

                    {{-- ── Ad slot (end of article — best performing position) --}}
                    <div class="mt-8">
                        {!! app('site')->ads !!}
                    </div>

                    {{-- ── Article Footer: tags + share reminder ───────── --}}
                    @if($post->tags ?? false)
                    <div class="mt-6 flex flex-wrap gap-2" aria-label="{{ __('Tags') }}">
                        @foreach(explode(',', $post->tags) as $tag)
                        <span class="text-xs bg-green-50 text-green-700 border border-green-200
                                 rounded-full px-3 py-1 font-medium">
                            #{{ trim($tag) }}
                        </span>
                        @endforeach
                    </div>
                    @endif

                </div>{{-- /.post-content --}}
            </div>
        </div>

    </section>

    {{-- ── Table of Contents Builder (JS) ────────────────────────────── --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    const body    = document.getElementById('post-body');
    const toc     = document.getElementById('toc');
    const tocList = document.getElementById('toc-list');
    if (!body || !toc || !tocList) return;

    const headings = body.querySelectorAll('h2');
    if (headings.length < 3) return; // only show TOC for longer articles

    headings.forEach(function (h, i) {
        // Give the heading an id if it doesn't have one
        if (!h.id) {
            h.id = 'heading-' + i + '-' + h.textContent.trim()
                       .replace(/\s+/g, '-')
                       .replace(/[^\w\u0600-\u06FF-]/g, '')
                       .substring(0, 50);
        }
        const li = document.createElement('li');
        const a  = document.createElement('a');
        a.href        = '#' + h.id;
        a.textContent = h.textContent.trim();
        li.appendChild(a);
        tocList.appendChild(li);
    });

    toc.classList.remove('hidden');
});
    </script>

    @endsection
