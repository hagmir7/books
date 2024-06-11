@extends('layouts.base')

@section('content')
@livewire('book-list-livewire', ['category' => $category], key($category->slug))
@endsection
