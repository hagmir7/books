@extends('layouts.base')


@section('content')
<section class="single-post">
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
                    "Storage::url({{ $post->image }})"
                   ],
                                 "datePublished": "",
                  "dateModified": "",
                                "author": {
                    "@type": "{{ $site->name }}",
                    "name": "{{ $site->name }}"
                  },
                                 "publisher": {
                    "@type": "Organization",
                    "name": "{{ $site->name }}",
                    "logo": {
                      "@type": "ImageObject",
                      "url": "{{ Storage::url($site->image) }}"
                    }
                  },
                  "description": "{{ $post->description }}"
                }


    </script>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="post-content">
                    <h1>{{ $post->title }}</h1>
                    <div class="post-meta text-center mt-1">
                        <span class="time d-flex justify-content-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-clock-hour-2">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M12 12l3 -2" />
                                <path d="M12 7v5" />
                            </svg>
                            <span class="h6">{{ $post->created_at->format('M d, Y') }}</span>
                        </span>
                    </div>
                <div class="social-btns mt-1">
                    <a target="_blank" aria-label="@lang('Share with Facebook')"
                        href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                        class="fb-xfbml-parse-ignore btn facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-brand-facebook">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" />
                        </svg>
                    </a>
                    <a class="btn twitter"
                        href="https://twitter.com/intent/tweet?text={{ urlencode($post->title . ' ' . request()->fullUrl()) }}"
                        data-show-count="false" aria-label="@lang('Share with X')" target="blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-brand-twitter">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M22 4.01c-1 .49 -1.98 .689 -3 .99c-1.121 -1.265 -2.783 -1.335 -4.38 -.737s-2.643 2.06 -2.62 3.737v1c-3.245 .083 -6.135 -1.395 -8 -4c0 0 -4.182 7.433 4 11c-1.872 1.247 -3.739 2.088 -6 2c3.308 1.803 6.913 2.423 10.034 1.517c3.58 -1.04 6.522 -3.723 7.651 -7.742a13.84 13.84 0 0 0 .497 -3.753c0 -.249 1.51 -2.772 1.818 -4.013z" />
                        </svg>
                    </a>
                    <a class="btn pinterest"
                        href="https://pinterest.com/pin/create/button/?url={{ urlencode(request()->fullUrl()) }}&description={{ urlencode($post->title) }}"
                        aria-label="@lang('Share with Pinterest')" target="blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-brand-pinterest">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M8 20l4 -9" />
                            <path d="M10.7 14c.437 1.263 1.43 2 2.55 2c2.071 0 3.75 -1.554 3.75 -4a5 5 0 1 0 -9.7 1.7" />
                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                        </svg>
                    </a>
                    <a class="btn whatsapp"
                        href="whatsapp://send/?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($post->title) }}"
                        aria-label="@lang('Share with WhatsApp')" target="blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-brand-whatsapp">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9" />
                            <path d="M9 10a.5 .5 0 0 0 1 0v-1a.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a.5 .5 0 0 0 0 -1h-1a.5 .5 0 0 0 0 1" />
                        </svg>
                    </a>
                    <a class="btn telegram"
                        href="https://telegram.me/share/url?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($post->title) }}"
                        aria-label="@lang('Share with Telegram')" target="blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-brand-telegram">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M15 10l-4 4l6 6l4 -16l-18 7l4 2l2 6l3 -4" />
                        </svg>
                    </a>
                </div>
                    @if (auth()->user()?->email_verified_at)
                        @livewire('post-actions', ['post' => $post, key($post->slug)])
                    @endif
                    {!! app("site")->ads !!}
                    <div class="my-3">
                        <img width="100%" height="auto" class="rounded" src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}">
                    </div>
                    <div class="post-text">
                        {!! $post->body !!}
                    </div>
                    {!! app("site")->ads !!}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
