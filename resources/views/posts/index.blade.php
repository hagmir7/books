@extends('layouts.base')


@section('content')
<section class="blog-posts">
    <div class="container">
        <div class="row text-center justify-content-center">
            <div class="py-5 col-md-6">
                <h1 class="h3">{{ $site->site_options['blog_title'] }}</h1>
                <form action="/blog" method="GET">
                    <div class="input-group rounded-pill border-2 overflow-hidden">
                        <button class="btn btn-info" id="Search Button" title="Search Button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
                                    <path d="M21 12a9 9 0 1 1-18 0a9 9 0 0 1 18 0"></path>
                                    <path d="M13.856 13.85a3.429 3.429 0 1 0-4.855-4.842a3.429 3.429 0 0 0 4.855 4.842m0 0L16 16">
                                    </path>
                                </g>
                            </svg>
                        </button>
                        <input type="search" name="q" class="form-control rounded-end-pill" value="{{ request()->query('q', '') }}"
                            placeholder="{{ app('site')?->site_options['search_label'] ?? __("Search") . '...' }}">
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            @forelse ($posts as $post)
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="post">
                        <div class="post-img">
                            <a href="{{ route('blog.show', $post->slug) }}">
                                <img src="{{ Storage::url($post->image) }}"
                                    alt="{{ $post->title }}">
                            </a>
                        </div>
                        <div class="post-info">
                            <div class="post-meta">
                                {{ $post->created_at->locale(app()->getLocale())->translatedFormat('M d, Y') }}
                            </div>
                            <a href="{{ route('blog.show', $post->slug) }}" class="post-title">
                                <h2 class="h4 text-black">{{ $post->title }}</h2>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="d-flex justify-content-center">
                    <img src="{{ asset("imgs/empty.png") }}" alt="Empty image">
                </div>
            @endforelse
        </div>
        <div class="mt-3 pb-4">{{ $posts->links() }}</div>
    </div>
</section>
@endsection
