<div class="max-w-4xl mx-auto space-y-10">

    {{-- Profile Info --}}
    <div class="bg-white dark:bg-gray-900 shadow rounded-xl p-6">
        <h2 class="text-lg font-semibold mb-6 flex gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-user">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
            </svg>
            <span>{{ __("Profile Information") }}</span>
        </h2>

        <form wire:submit="updateInfo" class="space-y-6">
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="text-sm font-medium">{{ __("First Name") }}</label>
                    <input type="text" wire:model.blur="first_name"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    @error('first_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="text-sm font-medium">{{ __("Last Name") }}</label>
                    <input type="text" wire:model.blur="last_name"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    @error('last_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="text-sm font-medium">{{ __("Email") }}</label>
                <input type="email" wire:model.blur="email"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <button class="btn-primary" wire:loading.attr="disabled" >
                {{ __("Save Changes") }} <span wire:loading wire:target="updateInfo">...</span>
            </button>
        </form>
    </div>

    {{-- Password --}}
    <div class="bg-white dark:bg-gray-900 shadow rounded-xl p-6">
        <h2 class="text-lg font-semibold mb-6 flex gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-lock-password">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2l0 -6" />
                <path d="M8 11v-4a4 4 0 1 1 8 0v4" />
                <path d="M15 16h.01" />
                <path d="M12.01 16h.01" />
                <path d="M9.02 16h.01" />
            </svg>
            <span>{{ __("Change Password") }}</span>
        </h2>

        <form wire:submit="updatePassword" class="space-y-6">
            <div>
                <label class="text-sm font-medium">{{ __("Current Password") }}</label>
                <input type="password" wire:model.blur="current_password"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                @error('current_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="text-sm font-medium">{{ __("New Password") }}</label>
                    <input type="password" wire:model.blur="password"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="text-sm font-medium">{{ __("Confirm Password") }}</label>
                    <input type="password" wire:model.blur="password_confirmation"
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>
            </div>

            <button class="btn-danger" wire:loading.attr="disabled" >
                {{ __("Update Password") }} <span wire:loading wire:target="updatePassword">...</span>
            </button>
        </form>
    </div>

</div>
