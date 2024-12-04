<form wire:submit.prevent='save' id="contact-form" method="post" class="validate mb-3 contact-form">
    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif
    <div class="row">
        <div class="col-md-6 mb-3">
            <input wire:model='full_name' class="form-control" placeholder="{{ __("Full Name") }}" type="text">
            @error('full_name') <div class="alert alert-danger p-2 mt-2">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-6 mb-3">
            <input wire:model='email' class="form-control" placeholder="{{ __("Email") }}" type="email">
            @error('email') <div class="alert alert-danger p-2 mt-2">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-12">
            <textarea wire:model='body' class="form-control mb-3" rows="3" placeholder="{{ __("Message") }}"></textarea>
            @error('body') <div class="alert alert-danger p-2 mt-2">{{ $message }}</div> @enderror
            <button type="submit" class="btn btn-primary submit">{{ __("Send Message") }} <span wire:loading class="loader"></span></button>
        </div>
    </div>
</form>
