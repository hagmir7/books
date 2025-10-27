@extends('layouts.base')

@section('content')
<div class="px-3 py-3 flex gap-2 items-center">
    <h1 class="text-md md:text-xl">{{ isset($title) ? $title : "No title" }}</h1>
    <h2 class="hidden">{{ $category->name }}</h2>
    @if (auth()?->user()?->email_verified_at)<a class="text-blue-500 hover:text-blue-800" href="/admin/book-categories?search={{ $category->name }}" target="_blank">Edit</a>@endif
</div>
<p class="px-3 mb-3" itemprop="description" class="text-gray-600 text-sm md:text-base mt-2">{{ isset($description) ? $description : "" }}</p>

@livewire('book-list-livewire', ['category' => $category], key($category->slug))
@endsection
