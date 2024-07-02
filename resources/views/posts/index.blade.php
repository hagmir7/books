@extends('layouts.base')


@section('content')
<section class="blog-posts">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-12">
                <h1 class="h3">{{ json_decode($site->site_options, true)['blog_title'] }}</h1>
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
                                {{ $post->created_at->format('M d, Y') }}
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
    </div>
</section>
@endsection
