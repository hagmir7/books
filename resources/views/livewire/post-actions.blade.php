<div class="py-1">
    @if (session('status'))
    <div class="alert alert-success p-2 my-2">
        {{ session('status') }}
    </div>
    @endif
    <button type="button" class="btn btn-danger" wire:click="delete"
        wire:confirm="Are you sure you want to delete this post?">
        {{ __("Delete") }}
    </button>

    {{-- <button type="button" class="btn btn-warning" wire:click="hidde"
        wire:confirm="Are you sure you want to hidde this book?">
        {{ __("Hidde") }}
    </button> --}}

    <a href="{{ route('filament.admin.resources.posts.edit', $post->slug) }}" class="btn btn-success">
        {{ __("Edit") }}
    </a>
</div>
