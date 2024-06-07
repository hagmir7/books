@extends('layouts.base')
@section('content')
<section class="page contacts">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>Contact Us</h1>
            </div>
            <div class="col-lg-12">
                <div class="page-content">
                    <p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry.
                        Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                        unknown printer took a galley of type and scrambled it to make a type specimen book. It has
                        survived not only five centuries, but also the leap into electronic typesetting, remaining
                        essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets
                        containing Lorem Ipsum passages, and more recently with desktop publishing software like
                        Aldus PageMaker including versions of Lorem Ipsum.</p>
                </div>
                <form id="contact-form" method="post" class="validate mb-3 contact-form">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <input class="form-control" placeholder="Email" type="email" name="email">
                        </div>
                        <div class="col-md-6 mb-3">
                            <input class="form-control" placeholder="Full Name" type="text" name="name">
                        </div>
                        <div class="col-md-12 mb-3">
                            <input class="form-control" placeholder="Subject" type="text" name="subject">
                        </div>
                        <div class="col-md-12">
                            <textarea class="form-control mb-3" name="message" rows="3"
                                placeholder="Message"></textarea>
                            <button type="submit" class="btn btn-primary submit">Send Message</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
