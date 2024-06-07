@extends('layouts.base')

@section('content')
<section class="authors-listing">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="authors-list">
                    <div class="top-filter row">
                        <div class="col-lg-8 text">
                            Found <span>5815 authors</span> in total
                        </div>
                        <div class="col-lg-4 pr-0 pl-0">
                            <select name="sortColumn" id="books-sort" class="custom-select">
                                <option value="Authors.lastName" data-order="DESC">Name Descending</option>
                                <option value="Authors.lastName" data-order="ASC">Name Ascending</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-md-3 col-lg-2 col-6">
                            <div class="author">
                                <div class="author-photo">
                                    <a href="/author/1/books" class="text-center"><img
                                            src="https://z-pdf.com/resources/images/comingsoon.png"
                                            alt="Stephen King "></a>
                                </div>
                                <div class="author-info">
                                    <h4 class="author-name">
                                        <a href="/author/1/books">Stephen King </a>
                                    </h4>
                                    <span class="author-books">77 books</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3 col-lg-2 col-6">
                            <div class="author">
                                <div class="author-photo">
                                    <a href="/author/2/books" class="text-center"><img
                                            src="https://z-pdf.com/resources/images/comingsoon.png"
                                            alt="Nikki St. Crowe "></a>
                                </div>
                                <div class="author-info">
                                    <h4 class="author-name">
                                        <a href="/author/2/books">Nikki St. Crowe </a>
                                    </h4>
                                    <span class="author-books">5 books</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3 col-lg-2 col-6">
                            <div class="author">
                                <div class="author-photo">
                                    <a href="/author/3/books" class="text-center"><img
                                            src="https://z-pdf.com/resources/images/comingsoon.png"
                                            alt="Johnny Cash "></a>
                                </div>
                                <div class="author-info">
                                    <h4 class="author-name">
                                        <a href="/author/3/books">Johnny Cash </a>
                                    </h4>
                                    <span class="author-books">1 books</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3 col-lg-2 col-6">
                            <div class="author">
                                <div class="author-photo">
                                    <a href="/author/4/books" class="text-center"><img
                                            src="https://z-pdf.com/resources/images/comingsoon.png"
                                            alt="Patrick Carr "></a>
                                </div>
                                <div class="author-info">
                                    <h4 class="author-name">
                                        <a href="/author/4/books">Patrick Carr </a>
                                    </h4>
                                    <span class="author-books">1 books</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3 col-lg-2 col-6">
                            <div class="author">
                                <div class="author-photo">
                                    <a href="/author/5/books" class="text-center"><img
                                            src="https://z-pdf.com/resources/images/comingsoon.png"
                                            alt="Agatha Christie "></a>
                                </div>
                                <div class="author-info">
                                    <h4 class="author-name">
                                        <a href="/author/5/books">Agatha Christie </a>
                                    </h4>
                                    <span class="author-books">70 books</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3 col-lg-2 col-6">
                            <div class="author">
                                <div class="author-photo">
                                    <a href="/author/6/books" class="text-center"><img
                                            src="https://z-pdf.com/resources/images/comingsoon.png"
                                            alt="Anthony De Mello "></a>
                                </div>
                                <div class="author-info">
                                    <h4 class="author-name">
                                        <a href="/author/6/books">Anthony De Mello </a>
                                    </h4>
                                    <span class="author-books">2 books</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3 col-lg-2 col-6">
                            <div class="author">
                                <div class="author-photo">
                                    <a href="/author/7/books" class="text-center"><img
                                            src="https://z-pdf.com/resources/images/comingsoon.png"
                                            alt="George R. R. Martin "></a>
                                </div>
                                <div class="author-info">
                                    <h4 class="author-name">
                                        <a href="/author/7/books">George R. R. Martin </a>
                                    </h4>
                                    <span class="author-books">11 books</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3 col-lg-2 col-6">
                            <div class="author">
                                <div class="author-photo">
                                    <a href="/author/8/books" class="text-center"><img
                                            src="https://z-pdf.com/resources/images/comingsoon.png"
                                            alt="Carl Gustav Jung "></a>
                                </div>
                                <div class="author-info">
                                    <h4 class="author-name">
                                        <a href="/author/8/books">Carl Gustav Jung </a>
                                    </h4>
                                    <span class="author-books">5 books</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3 col-lg-2 col-6">
                            <div class="author">
                                <div class="author-photo">
                                    <a href="/author/9/books" class="text-center"><img
                                            src="https://z-pdf.com/resources/images/comingsoon.png"
                                            alt="Ray Bradbury "></a>
                                </div>
                                <div class="author-info">
                                    <h4 class="author-name">
                                        <a href="/author/9/books">Ray Bradbury </a>
                                    </h4>
                                    <span class="author-books">11 books</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3 col-lg-2 col-6">
                            <div class="author">
                                <div class="author-photo">
                                    <a href="/author/10/books" class="text-center"><img
                                            src="https://z-pdf.com/resources/images/comingsoon.png"
                                            alt="Arundhati Roy "></a>
                                </div>
                                <div class="author-info">
                                    <h4 class="author-name">
                                        <a href="/author/10/books">Arundhati Roy </a>
                                    </h4>
                                    <span class="author-books">1 books</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3 col-lg-2 col-6">
                            <div class="author">
                                <div class="author-photo">
                                    <a href="/author/11/books" class="text-center"><img
                                            src="https://z-pdf.com/resources/images/comingsoon.png"
                                            alt="Michael Morpurgo "></a>
                                </div>
                                <div class="author-info">
                                    <h4 class="author-name">
                                        <a href="/author/11/books">Michael Morpurgo </a>
                                    </h4>
                                    <span class="author-books">2 books</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3 col-lg-2 col-6">
                            <div class="author">
                                <div class="author-photo">
                                    <a href="/author/12/books" class="text-center"><img
                                            src="https://z-pdf.com/resources/images/comingsoon.png"
                                            alt="Clive Staples Lewis "></a>
                                </div>
                                <div class="author-info">
                                    <h4 class="author-name">
                                        <a href="/author/12/books">Clive Staples Lewis </a>
                                    </h4>
                                    <span class="author-books">4 books</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3 col-lg-2 col-6">
                            <div class="author">
                                <div class="author-photo">
                                    <a href="/author/13/books" class="text-center"><img
                                            src="https://z-pdf.com/resources/images/comingsoon.png"
                                            alt="Garth Nix "></a>
                                </div>
                                <div class="author-info">
                                    <h4 class="author-name">
                                        <a href="/author/13/books">Garth Nix </a>
                                    </h4>
                                    <span class="author-books">5 books</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3 col-lg-2 col-6">
                            <div class="author">
                                <div class="author-photo">
                                    <a href="/author/14/books" class="text-center"><img
                                            src="https://z-pdf.com/resources/images/comingsoon.png"
                                            alt="Jean-Dominique Bauby "></a>
                                </div>
                                <div class="author-info">
                                    <h4 class="author-name">
                                        <a href="/author/14/books">Jean-Dominique Bauby </a>
                                    </h4>
                                    <span class="author-books">1 books</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3 col-lg-2 col-6">
                            <div class="author">
                                <div class="author-photo">
                                    <a href="/author/15/books" class="text-center"><img
                                            src="https://z-pdf.com/resources/images/comingsoon.png"
                                            alt="Philippa Gregory "></a>
                                </div>
                                <div class="author-info">
                                    <h4 class="author-name">
                                        <a href="/author/15/books">Philippa Gregory </a>
                                    </h4>
                                    <span class="author-books">5 books</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3 col-lg-2 col-6">
                            <div class="author">
                                <div class="author-photo">
                                    <a href="/author/16/books" class="text-center"><img
                                            src="https://z-pdf.com/resources/images/comingsoon.png"
                                            alt="Oliver Jeffers "></a>
                                </div>
                                <div class="author-info">
                                    <h4 class="author-name">
                                        <a href="/author/16/books">Oliver Jeffers </a>
                                    </h4>
                                    <span class="author-books">4 books</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3 col-lg-2 col-6">
                            <div class="author">
                                <div class="author-photo">
                                    <a href="/author/17/books" class="text-center"><img
                                            src="https://z-pdf.com/resources/images/comingsoon.png"
                                            alt="John Gray "></a>
                                </div>
                                <div class="author-info">
                                    <h4 class="author-name">
                                        <a href="/author/17/books">John Gray </a>
                                    </h4>
                                    <span class="author-books">1 books</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3 col-lg-2 col-6">
                            <div class="author">
                                <div class="author-photo">
                                    <a href="/author/18/books" class="text-center"><img
                                            src="https://z-pdf.com/resources/images/comingsoon.png"
                                            alt="Paulo Coelho "></a>
                                </div>
                                <div class="author-info">
                                    <h4 class="author-name">
                                        <a href="/author/18/books">Paulo Coelho </a>
                                    </h4>
                                    <span class="author-books">4 books</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3 col-lg-2 col-6">
                            <div class="author">
                                <div class="author-photo">
                                    <a href="/author/19/books" class="text-center"><img
                                            src="https://z-pdf.com/resources/images/comingsoon.png"
                                            alt="Hilary Mantel "></a>
                                </div>
                                <div class="author-info">
                                    <h4 class="author-name">
                                        <a href="/author/19/books">Hilary Mantel </a>
                                    </h4>
                                    <span class="author-books">10 books</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3 col-lg-2 col-6">
                            <div class="author">
                                <div class="author-photo">
                                    <a href="/author/20/books" class="text-center"><img
                                            src="https://z-pdf.com/resources/images/comingsoon.png"
                                            alt="Dr. Seuss "></a>
                                </div>
                                <div class="author-info">
                                    <h4 class="author-name">
                                        <a href="/author/20/books">Dr. Seuss </a>
                                    </h4>
                                    <span class="author-books">5 books</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3 col-lg-2 col-6">
                            <div class="author">
                                <div class="author-photo">
                                    <a href="/author/21/books" class="text-center"><img
                                            src="https://z-pdf.com/resources/images/comingsoon.png"
                                            alt="Geraldine Brooks "></a>
                                </div>
                                <div class="author-info">
                                    <h4 class="author-name">
                                        <a href="/author/21/books">Geraldine Brooks </a>
                                    </h4>
                                    <span class="author-books">3 books</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3 col-lg-2 col-6">
                            <div class="author">
                                <div class="author-photo">
                                    <a href="/author/22/books" class="text-center"><img
                                            src="https://z-pdf.com/resources/images/comingsoon.png"
                                            alt="Henri Charriere "></a>
                                </div>
                                <div class="author-info">
                                    <h4 class="author-name">
                                        <a href="/author/22/books">Henri Charriere </a>
                                    </h4>
                                    <span class="author-books">1 books</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3 col-lg-2 col-6">
                            <div class="author">
                                <div class="author-photo">
                                    <a href="/author/23/books" class="text-center"><img
                                            src="https://z-pdf.com/resources/images/comingsoon.png"
                                            alt="Richard Mabey "></a>
                                </div>
                                <div class="author-info">
                                    <h4 class="author-name">
                                        <a href="/author/23/books">Richard Mabey </a>
                                    </h4>
                                    <span class="author-books">1 books</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3 col-lg-2 col-6">
                            <div class="author">
                                <div class="author-photo">
                                    <a href="/author/24/books" class="text-center"><img
                                            src="https://z-pdf.com/resources/images/comingsoon.png"
                                            alt="Daniel Gilbert "></a>
                                </div>
                                <div class="author-info">
                                    <h4 class="author-name">
                                        <a href="/author/24/books">Daniel Gilbert </a>
                                    </h4>
                                    <span class="author-books">1 books</span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="books-per-page d-flex">
                        <nav class="m-auto">
                            <ul class="pagination">
                                <li class="page-item  active">
                                    <a href="/authors" class="page-link ajax-page">
                                        1
                                    </a>
                                </li>
                                <li class="page-item ">
                                    <a href="/authors/page/2" class="page-link ajax-page">
                                        2
                                    </a>
                                </li>
                                <li class="page-item ">
                                    <a href="/authors/page/3" class="page-link ajax-page">
                                        3
                                    </a>
                                </li>
                                <li class="page-item ">
                                    <a href="/authors/page/2" class="page-link ajax-page">
                                        <i class="fa fa-angle-right"></i> </a>
                                </li>
                                <li class="page-item ">
                                    <a href="/authors/page/243" class="page-link ajax-page">
                                        Last Page
                                    </a>
                                </li>

                            </ul>
                        </nav>

                    </div>
                    <div class="top-filter row">
                        <div class="col-lg-8 text">
                            <p class="m-0">Authors per page:</p>
                        </div>
                        <div class="col-lg-4 pr-0 pl-0">
                            <select name="perPage" id="countPerPage" class="custom-select">
                                <option value="6">6 Authors</option>
                                <option value="12">12 Authors</option>
                                <option value="24" selected>24 Authors</option>
                                <option value="36">36 Authors</option>
                                <option value="48">48 Authors</option>

                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
