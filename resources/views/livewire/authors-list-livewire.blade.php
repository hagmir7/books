{{-- Authors Section --}}
<div class="w-full lg:w-3/12 px-4">
    <div class="space-y-4">
        <div>
            <h2 class="text-2xl font-bold mb-3">{{ __("Popular Authors") }}</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-3">
            @foreach ($authors as $author)
            <div
                class="flex items-center gap-3 bg-gray-100 hover:bg-gray-200 transition-colors p-3 rounded-xl shadow-sm">
                <a href="{{ route('authors.show', $author->slug) }}" class="flex-shrink-0">
                    <img src="{{ $author->image ? asset('storage/' . $author->image) : '/storage/default/author.png' }}"
                        alt="{{ $author->full_name }}" class="w-12 h-12 rounded-full object-cover">
                </a>
                <div>
                    <h3 class="text-base font-semibold text-gray-800 leading-tight">
                        <a href="{{ route('authors.show', $author->slug) }}"
                            class="hover:underline hover:text-blue-600 transition-colors">
                            {{ $author->full_name }}
                        </a>
                    </h3>
                    <p class="text-sm text-gray-500">{{ $author->books_count }} {{ __("books") }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
