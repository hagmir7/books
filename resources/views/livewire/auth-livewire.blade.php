<div class="modal login-box" wire:ignore.self id="login" tabindex="-1" aria-labelledby="loginLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card card-no-border">
                    <div class="card-body">
                        <img width="100px" src="{{ Storage::url($site->logo) }}" class="d-flex ml-auto mr-auto mb-4 mt-2 img-fluid" alt="{{ __("Login") }}">
                        @if ($isRegister)
                        <form wire:submit.prevent="register">
                            <div class="mb-3 row ">
                                <div class="col-md-6">
                                    <label for="first_name" class="form-label">{{ __("First name") }}</label>
                                    <input type="text" class="form-control" wire:model="first_name" id="first_name">
                                    @error('first_name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="last_name" class="form-label">{{ __("Last name") }}</label>
                                    <input type="text" class="form-control" wire:model="last_name" id="last_name">
                                    @error('last_name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __("Email") }}</label>
                                <input type="email" class="form-control" wire:model="email" id="email">
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __("Password") }}</label>
                                <input type="password" class="form-control" wire:model="password" id="password">
                                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">{{ __("Confirm Password") }}</label>
                                <input type="password" class="form-control" required wire:model="password_confirmation" id="password_confirmation">
                                @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">{{ __("Register") }}</button>
                        </form>
                        <button class="btn btn-link" type="button" wire:click="toggleMode">{{ __("Already have an account? Login") }}</button>
                        @else
                        <form wire:submit.prevent="login">
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __("Email") }}</label>
                                <input type="email" class="form-control" wire:model="email" id="email">
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __("Password") }}</label>
                                <input type="password" class="form-control" wire:model="password" id="password">
                                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-8 col-xs-8 text-left">
                                        <div class="custom-control custom-checkbox mt-2">
                                            <input type="checkbox" name="rememberMe" class="custom-control-input" id="rememberMe">
                                            <label class="custom-control-label" for="rememberMe">{{ __("Remember me") }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-xs-4">
                                        <button type="submit" class="btn btn-primary shadow btn-block">{{ __("Login") }}</button>
                                    </div>
                                </div>
                                <div class="text-black-50 mt-3 additional-text text-center">{{ __("Do not have an account?") }}
                                    <button class="btn bnt-link" type="button" wire:click="toggleMode">{{ __("Sign Up") }}</button>
                                </div>
                            </div>
                        </form>
                        @endif

                        @if (session()->has('error'))
                        <div class="alert alert-danger mt-3 p-2">{{ session('error') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


