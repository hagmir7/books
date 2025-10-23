<form class="add-review show validate-review" id="addReview" wire:submit.prevent="save">
    @if (session('message'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-2 py-2 rounded mb-4">
        {{ session('message') }}
    </div>
    @endif

    <div class="flex flex-wrap -mx-4">
        <div class="w-full px-4">
            <div class="notes text-sm text-gray-600 mb-4">
                {{ __("Required fields are marked *. Your email address will not be published.") }}
            </div>
        </div>

        <div class="w-full lg:w-1/2 px-4">
            <div class="form-group mb-4">
                <input wire:model.blur="full_name"
                    class="w-full px-3 py-2 border rounded focus:outline-none focus:border-2 @error('full_name') border-red-500 @enderror"
                    placeholder="{{ __("Full name") }} *" type="text" autocomplete="name">
                @error('full_name')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="w-full lg:w-1/2 px-4">
            <div class="form-group mb-4">
                <input wire:model.blur="email"
                    class="w-full px-3 py-2 border rounded focus:outline-none focus:border-2 @error('email') border-red-500 @enderror"
                    placeholder="{{ __("Email") }} *" type="email" autocomplete="email">
                @error('email')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="w-full px-4">
            <div class="form-group mb-4">
                <textarea wire:model.blur="body" cols="30" rows="5"
                    class="w-full px-3 py-2 border rounded focus:outline-none focus:border-2 @error('body') border-red-500 @enderror"
                    placeholder="{{ __("Review") }}*"></textarea>
                @error('body')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="w-full px-4 text-center">
           <button type="submit"
            class="flex cursor-pointer items-center justify-center gap-2 px-6 py-3 bg-green-600 text-white rounded shadow hover:bg-green-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
            wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-not-allowed" wire:target="save">
            <!-- Normal -->
            <span wire:loading.remove wire:target="save" class="inline-flex items-center gap-2">
                <span class="inline-block align-middle">{{ __("Submit") }}</span>
            </span>

            <!-- Loading: inline-flex + items-center makes icon and text stay on same line -->
            <span wire:loading wire:target="save" class="inline-flex items-center gap-2">
                <svg class="animate-spin h-4 w-4 inline-block align-middle" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.4 0 0 5.4 0 12h4zm2 5.3A8 8 0 014 12H0c0 3 1.1 5.8 3 7.9l3-2.6z">
                    </path>
                </svg>
                <span class="inline-block align-middle">{{ __("Submitting...") }}</span>
            </span>
        </button>
        </div>
    </div>
</form>
