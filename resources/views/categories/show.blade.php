@extends('layouts.base')

@section('content')
<div class="px-3 py-3">
    <h1 class="h2">{{ isset($title) ? $title : "No title" }}</h1>
</div>
@livewire('book-list-livewire', ['category' => $category], key($category->slug))
@endsection
