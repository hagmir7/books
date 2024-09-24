@extends('layouts.base')
@section('content')
<section class="single-book" data-book="{{ $book->slug }}" itemscope itemtype="http://schema.org/Book">
    <meta itemprop="url" content="/book/{{ $book->slug }}" />
    <meta itemprop="author" content="{{ $book->author->full_name }}" />
    <meta itemprop="publisher" content="{{ $book->author->full_name }}" />

    {!! app("site")->ads !!}

    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="sticky-left-column">
                    <div class="book-cover">
                        <img src="{{ Storage::url($book->image) }}" alt="{{ formatBookTitle($book->name) }}" class="img-fluid" itemprop="image">
                    </div>

                    {{-- <div class="fb-share-button social-btns" data-href="{{ request()->url() }}" data-layout="" data-size="">

                    </div> --}}

                <div class="social-btns">
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
                        href="https://twitter.com/intent/tweet?text={{ urlencode($book->name . ' ' . request()->fullUrl()) }}"
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
                        href="https://pinterest.com/pin/create/button/?url={{ urlencode(request()->fullUrl()) }}&description={{ urlencode($book->name) }}"
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
                        href="whatsapp://send/?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($book->name) }}"
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
                        href="https://telegram.me/share/url?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($book->name) }}"
                        aria-label="@lang('Share with Telegram')" target="blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-brand-telegram">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M15 10l-4 4l6 6l4 -16l-18 7l4 2l2 6l3 -4" />
                        </svg>
                    </a>
                </div>


                    <!-- ads before download -->

{{--
                    <div class="download read py-3">
                        {!! app("site")->ads !!}
                        <a download href="{{ Storage::url($book->file) }}" class="w-100 btn btn-primary btn-rounded d-flex justify-content-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                <path d="M7 11l5 5l5 -5" />
                                <path d="M12 4l0 12" />
                            </svg>
                            <span class="mx-2">{{ __("Download") }}</span>
                        </a>

                        <a href="{{ Storage::url($book->file) }}" class="w-100 mt-4 btn btn-warning btn-rounded d-flex justify-content-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-book">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" />
                                <path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" />
                                <path d="M3 6l0 13" />
                                <path d="M12 6l0 13" />
                                <path d="M21 6l0 13" />
                            </svg>
                            <span class="mx-2">{{ __("Read") }}</span>

                        </a>
                        {!! app("site")->ads !!}
                    </div> --}}
                </div>
            </div>

            <div class="col-lg-9">
                {!! app("site")->ads !!}
                <h1 itemprop="name" class="h3" dir="auto">{{ formatBookTitle($book->name) }}</h1>
                <div class="book-rating general" itemprop="aggregateRating" itemscope
                    itemtype="http://schema.org/AggregateRating">
                    <div class="d-flex align-items-center gap-2">
                        <div id="rating-container"></div>
                        <div class="whole-rating">
                            <span class="average">{{ $rating ? $rating : 5 }} {{ __("Avg rating") }}</span><span
                                class="separator">—</span><span>{{ $book->comments->count() ? $book->comments->count() : 2 }}</span>
                            {{ __("Votes") }}
                        </div>
                    </div>
                    <meta itemprop="ratingValue" content="{{ $rating ? $rating : 5 }}" />
                    <meta itemprop="ratingCount" content="{{ $book->comments->count() ? $book->comments->count() : 2  }}" />
                </div>
                {{-- Book info --}}
                <table class="table book-meta" style="--bs-body-bg: none;">
                    <tbody>
                        <tr>
                            <td>{{ __("Book name") }}:</td>
                            <td>
                                <span itemprop="bookName">{{ $book->name }}</span>
                                <span >({{ $book->created_at->format("Y") }})</span>
                            </td>
                        </tr>
                        <tr>
                            <td>{{ __("Category") }}:</td>
                            <td>
                                <a itemprop="category" href="{{ route("category.show", $book->category->slug) }}">{{ $book->category->name }}</a>
                            </td>
                        </tr>
                        <tr>
                            <td>{{ __("Authors") }}:</td>
                            <td>
                                <a href="{{ route("authors.show", $book->author->slug) }}" itemprop="author">{{ $book->author->full_name }} </a>
                            </td>
                        </tr>
                        <tr>
                            <td>{{ __("Pages") }}:</td>
                            <td>
                                <span itemprop="numberOfPages">{{ $book->pages ? $book->pages : "__" }} {{ __("pages") }}</span>
                            </td>
                        </tr>

                        <tr>
                            <td>{{ __("ISBN13") }}:</td>
                            <td>
                                <span itemprop="isbn">{{ $book->isbn ? $book->isbn : "__" }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>{{ __("Language") }}:</td>
                            <td itemprop="Language">
                                {{ $book->language->name }}
                            </td>
                        </tr>
                        {{-- <tr>
                            <td>{{ __("Type") }}:</td>
                            <td>
                                <div class="badge badge-danger p-2">{{ $book->type }}</div>
                            </td>
                        </tr> --}}
                    </tbody>
                </table>
                {!! app("site")->ads !!}
                {{-- Book Actions --}}
                @if (auth()->user()?->email_verified_at)
                    @livewire('book-actions', ['book' => $book, key($book->slug)])
                @endif
                <div class="mt-5 d-flex justify-content-center">
                    <nav aria-label="Next and Previous navigation" class="w-100">
                        <ul class="pagination d-flex justify-content-between">
                            @if($book->previous())
                            <li class="page-item">
                                <a class="page-link btn btn-primary" href="{{ route('book.show', $book->previous()->slug) }}" aria-label="Previous">
                                    <span aria-hidden="true">&laquo; {{ __("Previous") }}</span>
                                </a>
                            </li>
                            @endif
                            @if($book->next())
                            <li class="page-item">
                                <a class="page-link btn btn-primary" href="{{ route('book.show', $book->next()->slug) }}" aria-label="Next">
                                    <span aria-hidden="true">{{ __("Next") }} &raquo;</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </nav>
                </div>

                {{-- Body --}}
                <div class="book-description" itemprop="description">
                    {!! $book->body !!}
                </div>
                {!! app("site")->ads !!}

                {{-- Reviews --}}
                <div class="row mt-5 mb-3">
                    <div class="col-lg-6 col-6">
                        <h2>{{ __("Book reviews") }}</h2>
                    </div>
                    <div class="col-lg-6 col-6 text-right">
                        <button class="btn btn-primary btn-rounded shadow add-review-collapse" data-toggle="collapse"
                            data-target="#addReview" aria-expanded="false" aria-controls="addReview">
                            {{ __("Write areview") }}
                        </button>
                    </div>
                </div>
                @livewire('review-form-livewire', ['book' => $book], key($book->slug))
            </div>
        </div>
    </div>
</section>
@endsection


@section('footer')
<script>
    // Function to generate star icons based on average rating
        function displayStars(averageRating) {
            const container = document.getElementById('rating-container');
            container.innerHTML = ''; // Clear previous content

            // Round the rating to the nearest half
            const roundedRating = Math.round(averageRating * 2) / 2;

            for (let i = 1; i <= 5; i++) {
                const star = document.createElement('span');
                if (i <= roundedRating) {
                    star.classList.add('star');
                    star.innerHTML = '&#9733;'; // Filled star
                } else if (i - roundedRating === 0.5) {
                    star.classList.add('star');
                    star.innerHTML = '&#9734;'; // Half star (use different icon or style if needed)
                } else {
                    star.classList.add('star', 'empty-star');
                    star.innerHTML = '&#9733;'; // Empty star
                }
                container.appendChild(star);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            displayStars({{ $rating ? $rating : 5 }});
        });
</script>

@endsection
