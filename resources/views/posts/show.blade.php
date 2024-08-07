@extends('layouts.base')


@section('content')
<section class="single-post">

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
                        <a class="btn facebook"
                            href="https://www.facebook.com/share.php?u={{ request()->url() }}&title={{ $post->title }}"
                            target="blank">
                            <svg class="facebook" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-brand-facebook">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" />
                            </svg>
                            <span class="d-none">{{ __("Share in facebook") }}</span>
                        </a>
                        <a class="btn twitter"
                            href="https://twitter.com/intent/tweet?status={{ $post->title }}+{{ request()->url() }}"
                            target="blank">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-brand-x">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 4l11.733 16h4.267l-11.733 -16z" />
                                <path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772" />
                            </svg>
                            <span class="d-none">{{ __("Share in x") }}</span>

                        </a>
                        <a class="btn vk" href="http://vk.com/share.php?url={{ request()->url() }}"
                            target="blank">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-brand-vk">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M14 19h-4a8 8 0 0 1 -8 -8v-5h4v5a4 4 0 0 0 4 4h0v-9h4v4.5l.03 0a4.531 4.531 0 0 0 3.97 -4.496h4l-.342 1.711a6.858 6.858 0 0 1 -3.658 4.789h0a5.34 5.34 0 0 1 3.566 4.111l.434 2.389h0h-4a4.531 4.531 0 0 0 -3.97 -4.496v4.5z" />
                            </svg>
                            <span class="d-none">{{ __("Share in vk") }}</span>
                        </a>
                        <a class="btn pinterest"
                            href="https://pinterest.com/pin/create/button/?url={{ request()->url() }}&description={{ $post->title }}"
                            target="blank">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-brand-pinterest">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M8 20l4 -9" />
                                <path d="M10.7 14c.437 1.263 1.43 2 2.55 2c2.071 0 3.75 -1.554 3.75 -4a5 5 0 1 0 -9.7 1.7" />
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                            </svg>
                        <span class="d-none">{{ __("Share in pinterest") }}</span>
                        </a>
                        <a class="btn email" href="mailto:?subject=Check%20out%20{{ $title }}%20&amp;body=I%20thought%20you%20might%20be%20interested%20in%20this%20page:%20{{ url()->current() }}%20-%20{{ $post->description }}" target="blank">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-mail">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                                <path d="M3 7l9 6l9 -6" />
                            </svg>
                            <span class="d-none">{{ __("Share with email") }}</span>

                        </a>
                    </div>
                    @if (auth()->user()?->email_verified_at)
                        @livewire('post-actions', ['post' => $post, key($post->slug)])
                    @endif

                    <div class="post-text">
                        {!! $post->body !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
