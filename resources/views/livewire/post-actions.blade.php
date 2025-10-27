<div class="py-1">
    @if (session('status'))
    <div class="p-3 my-2 text-sm text-green-700 bg-green-100 border border-green-300 rounded-lg">
        {{ session('status') }}
    </div>
    @endif

    <div class="flex items-center gap-3 mt-2">
        <button type="button" wire:click="delete" wire:confirm="Are you sure you want to delete this post?"
            class="px-4 py-2 text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
            {{ __("Delete") }}
        </button>

        <a href="{{ route('filament.admin.resources.posts.edit', $post->slug) }}"
            class="px-4 py-2 text-white bg-green-600 hover:bg-green-700 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
            {{ __("Edit") }}
        </a>
    </div>
</div>
