@if (count(app("site")->socials))
<!-- Social Media Links -->
<div class="w-full flex justify-center mb-7">
    <div class="flex items-center gap-3 justify-start md:justify-end mt-4 md:mt-0">
        @foreach (app("site")->socials as $item)
        <a style="background-color: {{ $item->color }}" target="_blank" rel="noopener noreferrer"
            href="{{ $item->pivot->url }}" aria-label="{{ $item->name }}"
            class="w-8 h-8 rounded-full flex items-center justify-center text-white shadow-md hover:opacity-80 transition">
            <span class="text-sm" aria-hidden="true">{!! $item->icon !!}</span>
        </a>
        @endforeach
    </div>
</div>
@endif
