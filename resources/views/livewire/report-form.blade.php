<div>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        {{ __("Report The Book") }}
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ __("Report The Book") }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="{{ __('Close') }}"></button>
                </div>
                <div class="modal-body">

                    <form wire:submit.prevent="save">
                        @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif

                        <div class="mb-3">
                            <label for="full_name" class="form-label">{{ __("Full Name") }}</label>
                            <input type="text" id="full_name" wire:model="full_name"
                                class="form-control @error('full_name') is-invalid @enderror">
                            @error('full_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label">{{ __("Subject") }}</label>
                            <input type="text" id="subject" wire:model="subject"
                                class="form-control @error('subject') is-invalid @enderror">
                            @error('subject') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __("Email") }}</label>
                            <input type="email" id="email" wire:model="email"
                                class="form-control @error('email') is-invalid @enderror">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">{{ __("Message Content") }}</label>
                            <textarea id="content" rows="5" wire:model="content"
                                class="form-control @error('content') is-invalid @enderror"></textarea>
                            @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <button type="submit" class="btn btn-danger w-100">{{ __("Send Report") }}</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
