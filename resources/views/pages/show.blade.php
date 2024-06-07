@extends('layouts.base')

@section('content')
<section class="page">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>{{ $page->title }}</h1>
                </div>
                <div class="col-lg-12">
                    <div class="page-content">
                        {!! $page->body !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
