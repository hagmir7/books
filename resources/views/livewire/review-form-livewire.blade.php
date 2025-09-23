<form class="add-review show validate-review collapse" id="addReview" wire:submit.prevent="save">
    @if (session('message'))
    <div class="alert alert-success p-2">
        {{ session('message') }}
    </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <div class="notes">{{ __("Required fields are marked *. Your email address will not be published.") }}</div>
        </div>

        <div class="col-lg-6">
            <div class="form-group">
                <input wire:model.blur="full_name" class="form-control @error('full_name') is-invalid @enderror"
                    placeholder="{{ __("Full name") }} *" type="text" autocomplete="name">
                @error('full_name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group">
                <input wire:model.blur="email" class="form-control @error('email') is-invalid @enderror"
                    placeholder="{{ __("Email") }} *" type="email" autocomplete="email">
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group">
                <textarea wire:model.blur="body" cols="30" rows="5"
                    class="form-control @error('body') is-invalid @enderror" placeholder="{{ __("Review")
                    }}*"></textarea>
                @error('body')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-lg-12 text-center">
            <button type="submit" class="btn btn-primary shadow submit-review" wire:loading.attr="disabled"
                wire:loading.class="disabled" wire:target="save">

                <span wire:loading.remove wire:target="save">{{ __("Submit") }}</span>
                <span wire:loading wire:target="save">
                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                    {{ __("Submitting...") }}
                </span>
            </button>
        </div>
    </div>
</form>
