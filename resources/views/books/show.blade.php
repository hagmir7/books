@extends('layouts.base')
@section('content')
<section class="single-book" data-book="{{ $book->slug }}" itemscope itemtype="http://schema.org/Book">
    <meta itemprop="url" content="/book/{{ $book->slug }}" />
    <meta itemprop="author" content="{{ $book->author->full_name }}" />
    <meta itemprop="publisher" content="{{ $book->author->full_name }}" />

    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="sticky-left-column">
                    <div class="book-cover">
                        <img src="{{ Storage::url($book->image) }}" alt="{{ $book->title }}" class="img-fluid" itemprop="image">
                    </div>
                    <div class="social-btns">
                        <a class="btn facebook"
                            href="https://www.facebook.com/share.php?u={{ request()->url() }}&title={{ $book->title }}"
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
                            href="https://twitter.com/intent/tweet?status={{ $book->title }}+{{ request()->url() }}"
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
                            href="https://pinterest.com/pin/create/button/?url={{ request()->url() }}&description={{ $book->title }}"
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
                        <a class="btn email" href="#" target="blank">
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


                    <!-- ads before download -->


                    <div class="download read py-3">
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
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <h1 itemprop="name" class="h3" dir="auto">{{ $book->title }}</h1>
                <div class="book-rating general" itemprop="aggregateRating" itemscope
                    itemtype="http://schema.org/AggregateRating">
                    <div class="d-flex align-items-center gap-2">
                        <div id="rating-container"></div>
                        <div class="whole-rating">
                            <span class="average">{{ $rating ? $rating : 0 }} {{ __("Avg rating") }}</span><span
                                class="separator">—</span><span>{{ $book->comments->count() }}</span>
                            {{ __("Votes") }}
                        </div>
                    </div>
                    <meta itemprop="ratingValue" content="{{ $rating ? $rating : 0 }}" />
                    <meta itemprop="ratingCount" content="{{ $book->comments->count() }}" />
                </div>
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
                            <td>{{ __("Language") }}:</td>
                            <td itemprop="Language">
                                {{ $book->language->name }}
                            </td>
                        </tr>
                        <tr>
                            <td>{{ __("Type") }}:</td>
                            <td>
                                {{ $book->type }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="book-description" itemprop="description">
                    {!! $book->body !!}
                </div>
                <!--ads before review-->
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
            displayStars({{ $rating ? $rating : 0 }});
        });
</script>
@endsection
