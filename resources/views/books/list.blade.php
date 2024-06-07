@extends('layouts.base')

@section('content')
<section class="books-listing">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-sm-12 col-xs-12 order-2 order-lg-1" id="book-list">
                    <div class="top-filter row">
                        <div class="col-lg-7 text">
                            Found <span>10699 books</span> in total
                        </div>
                        <div class="col-lg-5 pl-0 pr-0">
                            <div class="input-group">
                                <select name="sortColumn" id="books-sort" class="custom-select">
                                    <option value="Books.creationDateTime" data-order="DESC" selected>Date Descending
                                    </option>
                                    <option value="Books.creationDateTime" data-order="ASC">Date Ascending</option>
                                    <option value="Books.title" data-order="DESC">Title Descending</option>
                                    <option value="Books.title" data-order="ASC">Title Ascending</option>
                                    <option value="Books.publishingYear" data-order="DESC">Year Descending</option>
                                    <option value="Books.publishingYear" data-order="ASC">Year Ascending</option>
                                </select>
                                <div class="input-group-append layout-settings">
                                    <a class="view-type type-grid active" data-type="grid"></a>
                                    <a class="view-type type-list" data-type="list"></a>
                                    <a class="view-type type-mini-list" data-type="miniList"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row book-grid">
                        <div class="col-lg-6 col-md-6">
                            <div class="row book" itemscope itemtype="http://schema.org/Book">
                                <meta itemprop="isbn" content="9798987019276" />
                                <meta itemprop="name" content="A Kiss From a Kraken Free PDF Download" />
                                <meta itemprop="datePublished" content="2023" />
                                <div class="book-cover col-lg-3 col-3">
                                    <a href="/book/10840"><img
                                            src="https://z-pdf.com/images/covers/2024/February/65d79fa4bf1b1/small/9798987019276.jpg"
                                            alt="A Kiss From a Kraken Free PDF Download" class="img-fluid"></a>
                                </div>
                                <div class="book-info col-lg-9 col-9">
                                    <div class="book-title">
                                        <a href="/book/10840">A Kiss From a Kraken Free PDF Download</a>
                                    </div>
                                    <div class="book-attr">
                                        <span class="book-publishing-year">2023, </span> <span class="book-author"
                                            itemprop="author">Charlotte Swan</span>
                                    </div>
                                    <div class="book-rating">



                                        <div class="book-rating-box">
                                            <div class="rating" style="width:0%;"></div>
                                        </div>

                                    </div>
                                    <div class="book-short-description"> Melody Rivers would give anything to go back to
                                        the way things were. Before her father...</div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="row book" itemscope itemtype="http://schema.org/Book">
                                <meta itemprop="isbn" content="9798863173016" />
                                <meta itemprop="name" content="Off the Hook Free PDF Download" />
                                <meta itemprop="datePublished" content="2023" />
                                <div class="book-cover col-lg-3 col-3">
                                    <a href="/book/10839"><img
                                            src="https://z-pdf.com/images/covers/2024/February/65d79f4c27e60/small/9798863173016.jpg"
                                            alt="Off the Hook Free PDF Download" class="img-fluid"></a>
                                </div>
                                <div class="book-info col-lg-9 col-9">
                                    <div class="book-title">
                                        <a href="/book/10839">Off the Hook Free PDF Download</a>
                                    </div>
                                    <div class="book-attr">
                                        <span class="book-publishing-year">2023, </span> <span class="book-author"
                                            itemprop="author">Julie Olivia</span>
                                    </div>
                                    <div class="book-rating">



                                        <div class="book-rating-box">
                                            <div class="rating" style="width:0%;"></div>
                                        </div>

                                    </div>
                                    <div class="book-short-description"> I need a nanny, but I may need her more. I know
                                        about my reputation as Never Harbor's...</div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="row book" itemscope itemtype="http://schema.org/Book">
                                <meta itemprop="isbn" content="9798826308370" />
                                <meta itemprop="name" content="All Downhill With You Free PDF Download" />
                                <meta itemprop="datePublished" content="2022" />
                                <div class="book-cover col-lg-3 col-3">
                                    <a href="/book/10838"><img
                                            src="https://z-pdf.com/images/covers/2024/February/65d79f1e0710d/small/9798826308370.jpg"
                                            alt="All Downhill With You Free PDF Download" class="img-fluid"></a>
                                </div>
                                <div class="book-info col-lg-9 col-9">
                                    <div class="book-title">
                                        <a href="/book/10838">All Downhill With You Free PDF Download</a>
                                    </div>
                                    <div class="book-attr">
                                        <span class="book-publishing-year">2022, </span> <span class="book-author"
                                            itemprop="author">Julie Olivia</span>
                                    </div>
                                    <div class="book-rating">



                                        <div class="book-rating-box">
                                            <div class="rating" style="width:0%;"></div>
                                        </div>

                                    </div>
                                    <div class="book-short-description"> The moment we meet, it's all downhill. My job
                                        is providing happiness and smiles at...</div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="row book" itemscope itemtype="http://schema.org/Book">
                                <meta itemprop="isbn" content="9798771409993" />
                                <meta itemprop="name" content="The Fake Santa Apology Tour Free PDF Download" />
                                <meta itemprop="datePublished" content="2021" />
                                <div class="book-cover col-lg-3 col-3">
                                    <a href="/book/10837"><img
                                            src="https://z-pdf.com/images/covers/2024/February/65d79ee95f702/small/9798771409993.jpg"
                                            alt="The Fake Santa Apology Tour Free PDF Download" class="img-fluid"></a>
                                </div>
                                <div class="book-info col-lg-9 col-9">
                                    <div class="book-title">
                                        <a href="/book/10837">The Fake Santa Apology Tour Free PDF Download</a>
                                    </div>
                                    <div class="book-attr">
                                        <span class="book-publishing-year">2021, </span> <span class="book-author"
                                            itemprop="author">Julie Olivia</span>
                                    </div>
                                    <div class="book-rating">



                                        <div class="book-rating-box">
                                            <div class="rating" style="width:0%;"></div>
                                        </div>

                                    </div>
                                    <div class="book-short-description"> Short-term flings with good looking Santas are
                                        kinda my thing. After my latest holly...</div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="row book" itemscope itemtype="http://schema.org/Book">
                                <meta itemprop="isbn" content="9798749499698" />
                                <meta itemprop="name" content="Straight by Chuck Tingle Free PDF Download" />
                                <meta itemprop="datePublished" content="2021" />
                                <div class="book-cover col-lg-3 col-3">
                                    <a href="/book/10836"><img
                                            src="https://z-pdf.com/images/covers/2024/February/65d79eb20753b/small/9798749499698.jpg"
                                            alt="Straight by Chuck Tingle Free PDF Download" class="img-fluid"></a>
                                </div>
                                <div class="book-info col-lg-9 col-9">
                                    <div class="book-title">
                                        <a href="/book/10836">Straight by Chuck Tingle Free PDF Download</a>
                                    </div>
                                    <div class="book-attr">
                                        <span class="book-publishing-year">2021, </span> <span class="book-author"
                                            itemprop="author">Chuck Tingle</span>
                                    </div>
                                    <div class="book-rating">



                                        <div class="book-rating-box">
                                            <div class="rating" style="width:0%;"></div>
                                        </div>

                                    </div>
                                    <div class="book-short-description">When a strange tear in the cosmos appears within
                                        Earth's annual path, the consequences...</div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="row book" itemscope itemtype="http://schema.org/Book">
                                <meta itemprop="isbn" content="9798728061908" />
                                <meta itemprop="name" content="Free Fall (Wilde Boys #2) Free PDF Download" />
                                <meta itemprop="datePublished" content="2021" />
                                <div class="book-cover col-lg-3 col-3">
                                    <a href="/book/10835"><img
                                            src="https://z-pdf.com/images/covers/2024/February/65d79e349f612/small/9798728061908.jpg"
                                            alt="Free Fall (Wilde Boys #2) Free PDF Download" class="img-fluid"></a>
                                </div>
                                <div class="book-info col-lg-9 col-9">
                                    <div class="book-title">
                                        <a href="/book/10835">Free Fall (Wilde Boys #2) Free PDF Download</a>
                                    </div>
                                    <div class="book-attr">
                                        <span class="book-publishing-year">2021, </span> <span class="book-author"
                                            itemprop="author">Sara Cate</span>
                                    </div>
                                    <div class="book-rating">



                                        <div class="book-rating-box">
                                            <div class="rating" style="width:0%;"></div>
                                        </div>

                                    </div>
                                    <div class="book-short-description">I've moved past what happened on Del Rey, and
                                        I've kept the secret of what I did-what...</div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="row book" itemscope itemtype="http://schema.org/Book">
                                <meta itemprop="isbn" content="9798653526718" />
                                <meta itemprop="name"
                                    content="Trans Wizard Harriet Porber And The Bad Boy Parasaurolophus Free PDF Download" />
                                <meta itemprop="datePublished" content="2020" />
                                <div class="book-cover col-lg-3 col-3">
                                    <a href="/book/10834"><img
                                            src="https://z-pdf.com/images/covers/2024/February/65d79d4a466c8/small/9798653526718.jpg"
                                            alt="Trans Wizard Harriet Porber And The Bad Boy Parasaurolophus Free PDF Download"
                                            class="img-fluid"></a>
                                </div>
                                <div class="book-info col-lg-9 col-9">
                                    <div class="book-title">
                                        <a href="/book/10834">Trans Wizard Harriet Porber And The Bad Boy
                                            Parasaurolophus Free PDF Download</a>
                                    </div>
                                    <div class="book-attr">
                                        <span class="book-publishing-year">2020, </span> <span class="book-author"
                                            itemprop="author">Chuck Tingle</span>
                                    </div>
                                    <div class="book-rating">



                                        <div class="book-rating-box">
                                            <div class="rating" style="width:0%;"></div>
                                        </div>

                                    </div>
                                    <div class="book-short-description">Trans wizard Harriet Porber is a master
                                        spellsmith who's found herself in a bit of a...</div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="row book" itemscope itemtype="http://schema.org/Book">
                                <meta itemprop="isbn" content="9798394140211" />
                                <meta itemprop="name" content="Their Freefall At Last Free PDF Download" />
                                <meta itemprop="datePublished" content="2023" />
                                <div class="book-cover col-lg-3 col-3">
                                    <a href="/book/10833"><img
                                            src="https://z-pdf.com/images/covers/2024/February/65d7970c2dbaf/small/9798394140211.jpg"
                                            alt="Their Freefall At Last Free PDF Download" class="img-fluid"></a>
                                </div>
                                <div class="book-info col-lg-9 col-9">
                                    <div class="book-title">
                                        <a href="/book/10833">Their Freefall At Last Free PDF Download</a>
                                    </div>
                                    <div class="book-attr">
                                        <span class="book-publishing-year">2023, </span> <span class="book-author"
                                            itemprop="author">Julie Olivia</span>
                                    </div>
                                    <div class="book-rating">



                                        <div class="book-rating-box">
                                            <div class="rating" style="width:0%;"></div>
                                        </div>

                                    </div>
                                    <div class="book-short-description"> The hardest part is waiting for the fall. I am
                                        currently in love with, have always...</div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="row book" itemscope itemtype="http://schema.org/Book">
                                <meta itemprop="isbn" content="9798387807190" />
                                <meta itemprop="name" content="Playing by the Rules #2 Free PDF Download" />
                                <meta itemprop="datePublished" content="2023" />
                                <div class="book-cover col-lg-3 col-3">
                                    <a href="/book/10832"><img
                                            src="https://z-pdf.com/images/covers/2024/February/65d79228542f9/small/9798387807190.jpg"
                                            alt="Playing by the Rules #2 Free PDF Download" class="img-fluid"></a>
                                </div>
                                <div class="book-info col-lg-9 col-9">
                                    <div class="book-title">
                                        <a href="/book/10832">Playing by the Rules #2 Free PDF Download</a>
                                    </div>
                                    <div class="book-attr">
                                        <span class="book-publishing-year">2023, </span> <span class="book-author"
                                            itemprop="author">Monica Murphy</span>
                                    </div>
                                    <div class="book-rating">



                                        <div class="book-rating-box">
                                            <div class="rating" style="width:0%;"></div>
                                        </div>

                                    </div>
                                    <div class="book-short-description"> What happens when you fall for your brother's
                                        best friend? Find out in this upcoming...</div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="row book" itemscope itemtype="http://schema.org/Book">
                                <meta itemprop="isbn" content="9798370013140" />
                                <meta itemprop="name" content="Our Ride To Forever Free PDF Download" />
                                <meta itemprop="datePublished" content="2023" />
                                <div class="book-cover col-lg-3 col-3">
                                    <a href="/book/10831"><img
                                            src="https://z-pdf.com/images/covers/2024/February/65d791d827135/small/9798370013140.jpg"
                                            alt="Our Ride To Forever Free PDF Download" class="img-fluid"></a>
                                </div>
                                <div class="book-info col-lg-9 col-9">
                                    <div class="book-title">
                                        <a href="/book/10831">Our Ride To Forever Free PDF Download</a>
                                    </div>
                                    <div class="book-attr">
                                        <span class="book-publishing-year">2023, </span> <span class="book-author"
                                            itemprop="author">Julie Olivia</span>
                                    </div>
                                    <div class="book-rating">



                                        <div class="book-rating-box">
                                            <div class="rating" style="width:0%;"></div>
                                        </div>

                                    </div>
                                    <div class="book-short-description"> Sometimes, the best rides are unexpected. Orson
                                        Mackenzie didn't want a relationship....</div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="row book" itemscope itemtype="http://schema.org/Book">
                                <meta itemprop="isbn" content="9798353058403" />
                                <meta itemprop="name" content="The Fiction Between Us Free PDF Download" />
                                <meta itemprop="datePublished" content="2022" />
                                <div class="book-cover col-lg-3 col-3">
                                    <a href="/book/10830"><img
                                            src="https://z-pdf.com/images/covers/2024/February/65d7919f64da2/small/9798353058403.jpg"
                                            alt="The Fiction Between Us Free PDF Download" class="img-fluid"></a>
                                </div>
                                <div class="book-info col-lg-9 col-9">
                                    <div class="book-title">
                                        <a href="/book/10830">The Fiction Between Us Free PDF Download</a>
                                    </div>
                                    <div class="book-attr">
                                        <span class="book-publishing-year">2022, </span> <span class="book-author"
                                            itemprop="author">Julie Olivia</span>
                                    </div>
                                    <div class="book-rating">



                                        <div class="book-rating-box">
                                            <div class="rating" style="width:0%;"></div>
                                        </div>

                                    </div>
                                    <div class="book-short-description"> Some fairytales may be real, but ours is
                                        strictly fiction. I've been Queen Bee at our...</div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="row book" itemscope itemtype="http://schema.org/Book">
                                <meta itemprop="isbn" content="9781984806628" />
                                <meta itemprop="name" content="The Queen's Bargain Free PDF Download" />
                                <meta itemprop="datePublished" content="2020" />
                                <div class="book-cover col-lg-3 col-3">
                                    <a href="/book/10829"><img
                                            src="https://z-pdf.com/images/covers/2024/February/65d790fb4dd77/small/9781984806628.jpg"
                                            alt="The Queen's Bargain Free PDF Download" class="img-fluid"></a>
                                </div>
                                <div class="book-info col-lg-9 col-9">
                                    <div class="book-title">
                                        <a href="/book/10829">The Queen's Bargain Free PDF Download</a>
                                    </div>
                                    <div class="book-attr">
                                        <span class="book-publishing-year">2020, </span> <span class="book-author"
                                            itemprop="author">Anne Bishop</span>
                                    </div>
                                    <div class="book-rating">



                                        <div class="book-rating-box">
                                            <div class="rating" style="width:0%;"></div>
                                        </div>

                                    </div>
                                    <div class="book-short-description"> POWER HAS A PRICE. SO DOES LOVE. Return to the
                                        dark, sensual, and powerful world of...</div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="row book" itemscope itemtype="http://schema.org/Book">
                                <meta itemprop="isbn" content="9781982180027" />
                                <meta itemprop="name" content="Lassiter (Black Dagger Brotherhood #21) Free PDF Download" />
                                <meta itemprop="datePublished" content="2023" />
                                <div class="book-cover col-lg-3 col-3">
                                    <a href="/book/10828"><img
                                            src="https://z-pdf.com/images/covers/2024/February/65d7905061b3d/small/9781982180027.jpg"
                                            alt="Lassiter (Black Dagger Brotherhood #21) Free PDF Download"
                                            class="img-fluid"></a>
                                </div>
                                <div class="book-info col-lg-9 col-9">
                                    <div class="book-title">
                                        <a href="/book/10828">Lassiter (Black Dagger Brotherhood #21) Free PDF
                                            Download</a>
                                    </div>
                                    <div class="book-attr">
                                        <span class="book-publishing-year">2023, </span> <span class="book-author"
                                            itemprop="author">J.R. Ward</span>
                                    </div>
                                    <div class="book-rating">



                                        <div class="book-rating-box">
                                            <div class="rating" style="width:0%;"></div>
                                        </div>

                                    </div>
                                    <div class="book-short-description"> Destiny, duty, and desire clash in this epic
                                        new novel in J.R. Ward’s #1 New York...</div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="row book" itemscope itemtype="http://schema.org/Book">
                                <meta itemprop="isbn" content="9781982129705" />
                                <meta itemprop="name" content="Marley by Jon Clinch Free PDF Download" />
                                <meta itemprop="datePublished" content="2019" />
                                <div class="book-cover col-lg-3 col-3">
                                    <a href="/book/10827"><img
                                            src="https://z-pdf.com/images/covers/2024/February/65d78f5d1feb5/small/9781982129705.jpg"
                                            alt="Marley by Jon Clinch Free PDF Download" class="img-fluid"></a>
                                </div>
                                <div class="book-info col-lg-9 col-9">
                                    <div class="book-title">
                                        <a href="/book/10827">Marley by Jon Clinch Free PDF Download</a>
                                    </div>
                                    <div class="book-attr">
                                        <span class="book-publishing-year">2019, </span> <span class="book-author"
                                            itemprop="author">Jon Clinch</span>
                                    </div>
                                    <div class="book-rating">



                                        <div class="book-rating-box">
                                            <div class="rating" style="width:0%;"></div>
                                        </div>

                                    </div>
                                    <div class="book-short-description"> “By some uncanny act of artistic appropriation,
                                        [Clinch] has, without imitating...</div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="row book" itemscope itemtype="http://schema.org/Book">
                                <meta itemprop="isbn" content="9781958598023" />
                                <meta itemprop="name" content="Linghun by Ai Jiang Free PDF Download" />
                                <meta itemprop="datePublished" content="2023" />
                                <div class="book-cover col-lg-3 col-3">
                                    <a href="/book/10826"><img
                                            src="https://z-pdf.com/images/covers/2024/February/65d78f0d5bdf2/small/9781958598023.jpg"
                                            alt="Linghun by Ai Jiang Free PDF Download" class="img-fluid"></a>
                                </div>
                                <div class="book-info col-lg-9 col-9">
                                    <div class="book-title">
                                        <a href="/book/10826">Linghun by Ai Jiang Free PDF Download</a>
                                    </div>
                                    <div class="book-attr">
                                        <span class="book-publishing-year">2023, </span> <span class="book-author"
                                            itemprop="author">Ai Jiang</span>
                                    </div>
                                    <div class="book-rating">



                                        <div class="book-rating-box">
                                            <div class="rating" style="width:0%;"></div>
                                        </div>

                                    </div>
                                    <div class="book-short-description"> From acclaimed author Ai Jiang, follow Wenqi,
                                        Liam, and Mrs. to the mysterious town of...</div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="row book" itemscope itemtype="http://schema.org/Book">
                                <meta itemprop="isbn" content="9781956830262" />
                                <meta itemprop="name" content="Madame (Salacious Players Club #6) Free PDF Download" />
                                <meta itemprop="datePublished" content="2023" />
                                <div class="book-cover col-lg-3 col-3">
                                    <a href="/book/10825"><img
                                            src="https://z-pdf.com/images/covers/2024/February/65d78ea46b7d8/small/9781956830262.jpg"
                                            alt="Madame (Salacious Players Club #6) Free PDF Download"
                                            class="img-fluid"></a>
                                </div>
                                <div class="book-info col-lg-9 col-9">
                                    <div class="book-title">
                                        <a href="/book/10825">Madame (Salacious Players Club #6) Free PDF Download</a>
                                    </div>
                                    <div class="book-attr">
                                        <span class="book-publishing-year">2023, </span> <span class="book-author"
                                            itemprop="author">Sara Cate</span>
                                    </div>
                                    <div class="book-rating">



                                        <div class="book-rating-box">
                                            <div class="rating" style="width:0%;"></div>
                                        </div>

                                    </div>
                                    <div class="book-short-description"> They think they know me, but they have no idea.
                                        As a professional Domme, I see men and...</div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="row book" itemscope itemtype="http://schema.org/Book">
                                <meta itemprop="isbn" content="9781956830255" />
                                <meta itemprop="name" content="The Anti-Hero #1 Free PDF Download" />
                                <meta itemprop="datePublished" content="2023" />
                                <div class="book-cover col-lg-3 col-3">
                                    <a href="/book/10824"><img
                                            src="https://z-pdf.com/images/covers/2024/February/65d78e6763bfd/small/9781956830255.jpg"
                                            alt="The Anti-Hero #1 Free PDF Download" class="img-fluid"></a>
                                </div>
                                <div class="book-info col-lg-9 col-9">
                                    <div class="book-title">
                                        <a href="/book/10824">The Anti-Hero #1 Free PDF Download</a>
                                    </div>
                                    <div class="book-attr">
                                        <span class="book-publishing-year">2023, </span> <span class="book-author"
                                            itemprop="author">Sara Cate</span>
                                    </div>
                                    <div class="book-rating">



                                        <div class="book-rating-box">
                                            <div class="rating" style="width:0%;"></div>
                                        </div>

                                    </div>
                                    <div class="book-short-description"> I’ve been good long enough. As the eldest son
                                        of Austin’s most prominent preacher,...</div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="row book" itemscope itemtype="http://schema.org/Book">
                                <meta itemprop="isbn" content="9781956830064" />
                                <meta itemprop="name" content="Gravity (Wilde Boys #1) Free PDF Download" />
                                <meta itemprop="datePublished" content="2021" />
                                <div class="book-cover col-lg-3 col-3">
                                    <a href="/book/10823"><img
                                            src="https://z-pdf.com/images/covers/2024/February/65d78e2e4eb4f/small/9781956830064.jpg"
                                            alt="Gravity (Wilde Boys #1) Free PDF Download" class="img-fluid"></a>
                                </div>
                                <div class="book-info col-lg-9 col-9">
                                    <div class="book-title">
                                        <a href="/book/10823">Gravity (Wilde Boys #1) Free PDF Download</a>
                                    </div>
                                    <div class="book-attr">
                                        <span class="book-publishing-year">2021, </span> <span class="book-author"
                                            itemprop="author">Sara Cate</span>
                                    </div>
                                    <div class="book-rating">



                                        <div class="book-rating-box">
                                            <div class="rating" style="width:0%;"></div>
                                        </div>

                                    </div>
                                    <div class="book-short-description"> Three months on a private island. Two men. One
                                        million dollars. All I have to do is...</div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="row book" itemscope itemtype="http://schema.org/Book">
                                <meta itemprop="isbn" content="9781925498547" />
                                <meta itemprop="name" content="Beautiful Mess Free PDF Download" />
                                <meta itemprop="datePublished" content="2017" />
                                <div class="book-cover col-lg-3 col-3">
                                    <a href="/book/10822"><img
                                            src="https://z-pdf.com/images/covers/2024/February/65d78df77287c/small/9781925498547.jpg"
                                            alt="Beautiful Mess Free PDF Download" class="img-fluid"></a>
                                </div>
                                <div class="book-info col-lg-9 col-9">
                                    <div class="book-title">
                                        <a href="/book/10822">Beautiful Mess Free PDF Download</a>
                                    </div>
                                    <div class="book-attr">
                                        <span class="book-publishing-year">2017, </span> <span class="book-author"
                                            itemprop="author">Claire Christian</span>
                                    </div>
                                    <div class="book-rating">



                                        <div class="book-rating-box">
                                            <div class="rating" style="width:0%;"></div>
                                        </div>

                                    </div>
                                    <div class="book-short-description">• The 2016 winner of the Text Prize for
                                        Children's and YA Writing brings us a raw,...</div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="row book" itemscope itemtype="http://schema.org/Book">
                                <meta itemprop="isbn" content="9781922330819" />
                                <meta itemprop="name" content="West Side Honey Free PDF Download" />
                                <meta itemprop="datePublished" content="2023" />
                                <div class="book-cover col-lg-3 col-3">
                                    <a href="/book/10821"><img
                                            src="https://z-pdf.com/images/covers/2024/February/65d78db875d6e/small/9781922330819.jpg"
                                            alt="West Side Honey Free PDF Download" class="img-fluid"></a>
                                </div>
                                <div class="book-info col-lg-9 col-9">
                                    <div class="book-title">
                                        <a href="/book/10821">West Side Honey Free PDF Download</a>
                                    </div>
                                    <div class="book-attr">
                                        <span class="book-publishing-year">2023, </span> <span class="book-author"
                                            itemprop="author">Claire Christian</span>
                                    </div>
                                    <div class="book-rating">



                                        <div class="book-rating-box">
                                            <div class="rating" style="width:0%;"></div>
                                        </div>

                                    </div>
                                    <div class="book-short-description"> Cleo has a few things going on. Two beautiful
                                        kids and a less beautiful ex-husband, a...</div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="row book" itemscope itemtype="http://schema.org/Book">
                                <meta itemprop="isbn" content="9781915534033" />
                                <meta itemprop="name" content="A Sword from the Embers Free PDF Download" />
                                <meta itemprop="datePublished" content="2023" />
                                <div class="book-cover col-lg-3 col-3">
                                    <a href="/book/10820"><img
                                            src="https://z-pdf.com/images/covers/2024/February/65d78d6da93ae/small/9781915534033.jpg"
                                            alt="A Sword from the Embers Free PDF Download" class="img-fluid"></a>
                                </div>
                                <div class="book-info col-lg-9 col-9">
                                    <div class="book-title">
                                        <a href="/book/10820">A Sword from the Embers Free PDF Download</a>
                                    </div>
                                    <div class="book-attr">
                                        <span class="book-publishing-year">2023, </span> <span class="book-author"
                                            itemprop="author">Chloe C. Peñaranda</span>
                                    </div>
                                    <div class="book-rating">



                                        <div class="book-rating-box">
                                            <div class="rating" style="width:0%;"></div>
                                        </div>

                                    </div>
                                    <div class="book-short-description"> The action-packed, captivating fifth instalment
                                        in the bestselling series AN HEIR...</div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="row book" itemscope itemtype="http://schema.org/Book">
                                <meta itemprop="isbn" content="9781909490093" />
                                <meta itemprop="name" content="The French for Love Free PDF Download" />
                                <meta itemprop="datePublished" content="2013" />
                                <div class="book-cover col-lg-3 col-3">
                                    <a href="/book/10819"><img
                                            src="https://z-pdf.com/images/covers/2024/February/65d78d1e0a9a7/small/9781909490093.jpg"
                                            alt="The French for Love Free PDF Download" class="img-fluid"></a>
                                </div>
                                <div class="book-info col-lg-9 col-9">
                                    <div class="book-title">
                                        <a href="/book/10819">The French for Love Free PDF Download</a>
                                    </div>
                                    <div class="book-attr">
                                        <span class="book-publishing-year">2013, </span> <span class="book-author"
                                            itemprop="author">Fiona Valpy</span>
                                    </div>
                                    <div class="book-rating">



                                        <div class="book-rating-box">
                                            <div class="rating" style="width:0%;"></div>
                                        </div>

                                    </div>
                                    <div class="book-short-description"> Like a glass of wine in the French afternoon
                                        sunshine - The French for Love is the...</div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="row book" itemscope itemtype="http://schema.org/Book">
                                <meta itemprop="isbn" content="9781838933616" />
                                <meta itemprop="name" content="The Temple of Fortuna Free PDF Download" />
                                <meta itemprop="datePublished" content="2023" />
                                <div class="book-cover col-lg-3 col-3">
                                    <a href="/book/10818"><img
                                            src="https://z-pdf.com/images/covers/2024/February/65d78cd47b49e/small/9781838933616.jpg"
                                            alt="The Temple of Fortuna Free PDF Download" class="img-fluid"></a>
                                </div>
                                <div class="book-info col-lg-9 col-9">
                                    <div class="book-title">
                                        <a href="/book/10818">The Temple of Fortuna Free PDF Download</a>
                                    </div>
                                    <div class="book-attr">
                                        <span class="book-publishing-year">2023, </span> <span class="book-author"
                                            itemprop="author">Elodie Harper</span>
                                    </div>
                                    <div class="book-rating">



                                        <div class="book-rating-box">
                                            <div class="rating" style="width:0%;"></div>
                                        </div>

                                    </div>
                                    <div class="book-short-description"> The final instalment in Elodie Harper's Sunday
                                        Times bestselling Wolf Den Trilogy A...</div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="row book" itemscope itemtype="http://schema.org/Book">
                                <meta itemprop="isbn" content="9781838248093" />
                                <meta itemprop="name" content="A Clash of Three Courts Free PDF Download" />
                                <meta itemprop="datePublished" content="2022" />
                                <div class="book-cover col-lg-3 col-3">
                                    <a href="/book/10817"><img
                                            src="https://z-pdf.com/images/covers/2024/February/65d78c91c3488/small/9781838248093.jpg"
                                            alt="A Clash of Three Courts Free PDF Download" class="img-fluid"></a>
                                </div>
                                <div class="book-info col-lg-9 col-9">
                                    <div class="book-title">
                                        <a href="/book/10817">A Clash of Three Courts Free PDF Download</a>
                                    </div>
                                    <div class="book-attr">
                                        <span class="book-publishing-year">2022, </span> <span class="book-author"
                                            itemprop="author">Chloe C Peñaranda</span>
                                    </div>
                                    <div class="book-rating">



                                        <div class="book-rating-box">
                                            <div class="rating" style="width:0%;"></div>
                                        </div>

                                    </div>
                                    <div class="book-short-description"> In the bestselling AN HEIR COMES TO RISE
                                        series, read the tensely seductive fourth...</div>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="books-per-page d-flex">
                        <nav class="m-auto">
                            <ul class="pagination">
                                <li class="page-item  active">
                                    <a href="/books" class="page-link ajax-page">
                                        1
                                    </a>
                                </li>
                                <li class="page-item ">
                                    <a href="/books/page/2" class="page-link ajax-page">
                                        2
                                    </a>
                                </li>
                                <li class="page-item ">
                                    <a href="/books/page/3" class="page-link ajax-page">
                                        3
                                    </a>
                                </li>
                                <li class="page-item ">
                                    <a href="/books/page/2" class="page-link ajax-page">
                                        <i class="fa fa-angle-right"></i> </a>
                                </li>
                                <li class="page-item ">
                                    <a href="/books/page/446" class="page-link ajax-page">
                                        Last Page
                                    </a>
                                </li>

                            </ul>
                        </nav>

                    </div>

                    <div class="top-filter row">
                        <div class="col-lg-8 text">
                            Books per page:
                        </div>
                        <div class="col-lg-4 pr-0 pl-0">
                            <select name="perPage" id="countPerPage" class="custom-select">
                                <option value="8">8 Books</option>
                                <option value="16">16 Books</option>
                                <option value="24" selected>24 Books</option>
                                <option value="32">32 Books</option>
                                <option value="48">48 Books</option>

                            </select>
                        </div>
                    </div>

                </div>
                <div class="col-lg-3 col-sm-12 col-xs-12 order-lg-2 order-1">
                    <div class="sidebar">
                        <div class="book-filter">
                            <h2 class="text-lg-center text-left">Book Filter</h2>
                            <button class="show-filter" data-toggle="collapse" data-target="#book-filter"
                                aria-expanded="false" aria-controls="book-filter">
                                <i class="ti-filter"></i></button>
                            <form action="" id="book-filter">
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <label>Publisher</label>
                                        <select name="publisherIds[]" id="publishers" multiple="multiple"></select>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label>Genres</label>
                                        <select name="genreIds[]" id="genres" multiple="multiple"></select>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label>Authors</label>
                                        <select name="authorIds[]" id="authors" multiple="multiple"></select>
                                    </div>

                                    <div class="col-md-12 mb-2">
                                        <label>Year</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <select name="startYear" class="custom-select">
                                                    <option value=""></option>
                                                    <option value="1960">1960</option>
                                                    <option value="1961">1961</option>
                                                    <option value="1962">1962</option>
                                                    <option value="1963">1963</option>
                                                    <option value="1964">1964</option>
                                                    <option value="1965">1965</option>
                                                    <option value="1966">1966</option>
                                                    <option value="1967">1967</option>
                                                    <option value="1968">1968</option>
                                                    <option value="1969">1969</option>
                                                    <option value="1970">1970</option>
                                                    <option value="1971">1971</option>
                                                    <option value="1972">1972</option>
                                                    <option value="1973">1973</option>
                                                    <option value="1974">1974</option>
                                                    <option value="1975">1975</option>
                                                    <option value="1976">1976</option>
                                                    <option value="1977">1977</option>
                                                    <option value="1978">1978</option>
                                                    <option value="1979">1979</option>
                                                    <option value="1980">1980</option>
                                                    <option value="1981">1981</option>
                                                    <option value="1982">1982</option>
                                                    <option value="1983">1983</option>
                                                    <option value="1984">1984</option>
                                                    <option value="1985">1985</option>
                                                    <option value="1986">1986</option>
                                                    <option value="1987">1987</option>
                                                    <option value="1988">1988</option>
                                                    <option value="1989">1989</option>
                                                    <option value="1990">1990</option>
                                                    <option value="1991">1991</option>
                                                    <option value="1992">1992</option>
                                                    <option value="1993">1993</option>
                                                    <option value="1994">1994</option>
                                                    <option value="1995">1995</option>
                                                    <option value="1996">1996</option>
                                                    <option value="1997">1997</option>
                                                    <option value="1998">1998</option>
                                                    <option value="1999">1999</option>
                                                    <option value="2000">2000</option>
                                                    <option value="2001">2001</option>
                                                    <option value="2002">2002</option>
                                                    <option value="2003">2003</option>
                                                    <option value="2004">2004</option>
                                                    <option value="2005">2005</option>
                                                    <option value="2006">2006</option>
                                                    <option value="2007">2007</option>
                                                    <option value="2008">2008</option>
                                                    <option value="2009">2009</option>
                                                    <option value="2010">2010</option>
                                                    <option value="2011">2011</option>
                                                    <option value="2012">2012</option>
                                                    <option value="2013">2013</option>
                                                    <option value="2014">2014</option>
                                                    <option value="2015">2015</option>
                                                    <option value="2016">2016</option>
                                                    <option value="2017">2017</option>
                                                    <option value="2018">2018</option>
                                                    <option value="2019">2019</option>
                                                    <option value="2020">2020</option>
                                                    <option value="2021">2021</option>
                                                    <option value="2022">2022</option>
                                                    <option value="2023">2023</option>
                                                    <option value="2024">2024</option>

                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <select name="endYear" class="custom-select">
                                                    <option value=""></option>
                                                    <option value="1960">1960</option>
                                                    <option value="1961">1961</option>
                                                    <option value="1962">1962</option>
                                                    <option value="1963">1963</option>
                                                    <option value="1964">1964</option>
                                                    <option value="1965">1965</option>
                                                    <option value="1966">1966</option>
                                                    <option value="1967">1967</option>
                                                    <option value="1968">1968</option>
                                                    <option value="1969">1969</option>
                                                    <option value="1970">1970</option>
                                                    <option value="1971">1971</option>
                                                    <option value="1972">1972</option>
                                                    <option value="1973">1973</option>
                                                    <option value="1974">1974</option>
                                                    <option value="1975">1975</option>
                                                    <option value="1976">1976</option>
                                                    <option value="1977">1977</option>
                                                    <option value="1978">1978</option>
                                                    <option value="1979">1979</option>
                                                    <option value="1980">1980</option>
                                                    <option value="1981">1981</option>
                                                    <option value="1982">1982</option>
                                                    <option value="1983">1983</option>
                                                    <option value="1984">1984</option>
                                                    <option value="1985">1985</option>
                                                    <option value="1986">1986</option>
                                                    <option value="1987">1987</option>
                                                    <option value="1988">1988</option>
                                                    <option value="1989">1989</option>
                                                    <option value="1990">1990</option>
                                                    <option value="1991">1991</option>
                                                    <option value="1992">1992</option>
                                                    <option value="1993">1993</option>
                                                    <option value="1994">1994</option>
                                                    <option value="1995">1995</option>
                                                    <option value="1996">1996</option>
                                                    <option value="1997">1997</option>
                                                    <option value="1998">1998</option>
                                                    <option value="1999">1999</option>
                                                    <option value="2000">2000</option>
                                                    <option value="2001">2001</option>
                                                    <option value="2002">2002</option>
                                                    <option value="2003">2003</option>
                                                    <option value="2004">2004</option>
                                                    <option value="2005">2005</option>
                                                    <option value="2006">2006</option>
                                                    <option value="2007">2007</option>
                                                    <option value="2008">2008</option>
                                                    <option value="2009">2009</option>
                                                    <option value="2010">2010</option>
                                                    <option value="2011">2011</option>
                                                    <option value="2012">2012</option>
                                                    <option value="2013">2013</option>
                                                    <option value="2014">2014</option>
                                                    <option value="2015">2015</option>
                                                    <option value="2016">2016</option>
                                                    <option value="2017">2017</option>
                                                    <option value="2018">2018</option>
                                                    <option value="2019">2019</option>
                                                    <option value="2020">2020</option>
                                                    <option value="2021">2021</option>
                                                    <option value="2022">2022</option>
                                                    <option value="2023">2023</option>
                                                    <option value="2024">2024</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label>Bindings</label>
                                        <select name="bindings[]" id="bindings" multiple="multiple">
                                            <option value="Hardcover">Hardcover</option>
                                            <option value="Softcover">Softcover</option>

                                        </select>
                                    </div>



                                    <div class="col-md-12 text-center">
                                        <button class="btn btn-secondary btn-block mt-2" id="filterIt" type="submit">Filter
                                            It!</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
