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
                        <img src="{{ Storage::url($book->image) }}" alt="{{ formatBookTitle($book->name) }}" class="img-fluid" itemprop="image">
                    </div>

                    {{-- <div class="fb-share-button social-btns" data-href="{{ request()->url() }}" data-layout="" data-size="">

                    </div> --}}

                    <div class="social-btns">
                        <a target="_blank"
                            aria-label="{{ __("Share with Facebook")}}"
                            href="https://www.facebook.com/sharer/sharer.php?u={{ request()->url() }}&title={{ formatBookTitle($book->name) }}"
                            class="fb-xfbml-parse-ignore btn facebook">

                            <svg class="facebook" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-brand-facebook">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" />
                            </svg>
                            <span class="d-none">{{ __("Share in facebook") }}</span>
                        </a>
                        <a class="btn twitter"
                            href="https://twitter.com/share?ref_src=twsrc%5Etfw"
                            data-show-count="false"
                            aria-label="{{ __("Share with X")}}"
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
                        <a class="btn pinterest"
                            href="https://pinterest.com/pin/create/button/?url={{ request()->url() }}&description={{ formatBookTitle($book->name) }}"
                            aria-label="{{ __("Share with Pintrest")}}"
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
                        <a class="btn email"
                            aria-label="{{ __("Share with Email")}}"
                            href="mailto:?subject=Check%20out%20{{ $title }}%20&amp;body=I%20thought%20you%20might%20be%20interested%20in%20this%20page:%20{{ url()->current() }}%20-%20{{ $book->name }}" target="blank">
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
                            <td>{{ __("Language") }}:</td>
                            <td itemprop="Language">
                                {{ $book->language->name }}
                            </td>
                        </tr>
                        <tr>
                            <td>{{ __("Type") }}:</td>
                            <td>
                                <div class="badge badge-danger p-2">{{ $book->type }}</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                {{-- Book Actions --}}
                @if (auth()->user()?->email_verified_at)
                    @livewire('book-actions', ['book' => $book, key($book->slug)])
                @endif
                {{-- Body --}}
                <div class="book-description" itemprop="description">
                    {!! $book->body !!}
                </div>

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
