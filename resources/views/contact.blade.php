@extends('layouts.base')
@section('content')
<section class="page contacts">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="h3">{{ __("Contact Us") }}</h1>
            </div>
            <div class="col-lg-12">
                <div class="page-content">

                    <p>{{ __("contact.message") }}</p>
                    <h2 id="get-in-touch">{{ __("Get in Touch") }}</h2>
                    <ul>
                        <li><strong>{{ __("Email") }}:</strong> @if (app("site")->email) <a href="mailto:{{ app("site")->email }}">{{ app("site")->email }}</a> @endif </li>
                        <li><strong>{{ __("Hours") }}:</strong> {{ __("Monday - Friday, 9:00 AM - 5:00 PM EST") }}</li>
                    </ul>
                    <h2 id="send-us-a-message">{{ __("Send Us a Message") }}</h2>
                    <p>{{ __("Use the form below to send us a message, and we'll get back to you as soon as possible.") }}</p>
                </div>
                @livewire('contact-form')
            </div>
        </div>
    </div>
</section>
@endsection
