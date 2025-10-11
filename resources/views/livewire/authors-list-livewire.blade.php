{{-- Authors --}}
<div class="w-full lg:w-3/12 px-4">
    <div class="flex flex-wrap -mx-4">
        <div class="w-full px-4">
            <div class="mb-4">
                <h2 class="text-2xl font-bold mb-3">{{ __("Popular Authors") }}</h2>
            </div>
        </div>
        @foreach ($authors as $author)
        <div class="w-full md:w-1/2 lg:w-full px-4 mb-3">
            <div class="flex gap-3 bg-gray-100 p-2 rounded">
                <div>
                    <a href="{{ route("authors.show", $author->slug) }}" class="text-center">
                        <img src="{{ $author->image ? 'https://norkitab.com' . Storage::url($author->image) : '/storage/default/author.png' }}"
                            alt="{{ $author->full_name }}" class="rounded-full w-[43px] h-[43px] object-cover">
                    </a>
                </div>
                <div>
                    <h3 class="text-base font-semibold mb-1">
                        <a href="{{ route("authors.show", $author->slug) }}" class="no-underline hover:underline">
                            {{ $author->full_name }}
                        </a>
                    </h3>
                    <small class="text-gray-500 text-sm">{{ $author->books_count }} {{ __("books") }}</small>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
