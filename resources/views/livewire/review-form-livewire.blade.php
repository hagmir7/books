<form class="add-review show validate-review collapse" id="addReview" wire:submit='save'>
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
                <input wire:model.blur="full_name"  class="form-control" placeholder="{{ __("Full name") }} *" type="text">
                @error('full_name') <div class="alert alert-danger p-2 mt-2"> {{ $message }}</div> @enderror
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <input wire:model="email" class="form-control" placeholder="{{ __("Email") }} *" type="text">
                @error('email') <div class="alert alert-danger p-2 mt-2"> {{ $message }}</div> @enderror
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <textarea wire:model="body" cols="30" rows="5" class="form-control" placeholder="Review"></textarea>
                @error('body') <div class="alert alert-danger p-2 mt-2"> {{ $message }}</div> @enderror
            </div>
        </div>
        <div class="col-lg-12 text-center">
            <button class="btn btn-primary shadow submit-review">{{ __("Submit") }}</button>
        </div>
    </div>
</form>
