<div class="py-3">
    @if (session('status'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-2 py-2 my-2 rounded">
        {{ session('status') }}
    </div>
    @endif

    <div class="flex flex-wrap gap-2">
        <button type="button" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition"
            wire:click="delete" wire:confirm="{{ __(" Are you sure you want to delete this author?") }}">
            {{ __("Delete") }}
        </button>

        <button type="button" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition"
            wire:click="hidde" wire:confirm="{{ __(" Are you sure you want to hide this author?") }}">
            {{ __("Hidde") }}
        </button>

        <a href="{{ route('filament.admin.resources.authors.edit', $author->slug) }}"
            class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
            {{ __("Edit") }}
        </a>
    </div>
</div>
