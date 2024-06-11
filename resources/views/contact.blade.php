@extends('layouts.base')
@section('content')
<section class="page contacts">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>Contact Us</h1>
            </div>
            <div class="col-lg-12">
                {{-- <div class="page-content">
                    <p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry.
                        Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                        unknown printer took a galley of type and scrambled it to make a type specimen book. It has
                        survived not only five centuries, but also the leap into electronic typesetting, remaining
                        essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets
                        containing Lorem Ipsum passages, and more recently with desktop publishing software like
                        Aldus PageMaker including versions of Lorem Ipsum.</p>
                </div> --}}
                @livewire('contact-form')
            </div>
        </div>
    </div>
</section>
@endsection
