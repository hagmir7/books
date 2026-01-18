<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;

class UpdateUser extends Component
{
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';

    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function mount()
    {
        $user = Auth::user();

        $this->first_name = $user->first_name;
        $this->last_name  = $user->last_name;
        $this->email      = $user->email;
    }

    /**
     * Update user basic information
     */
    public function updateInfo()
    {
        $user = Auth::user();

        $validated = $this->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'email'      => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
        ]);

        $user->update($validated);

        $this->dispatch(
            'notify',
            type: 'success',
            message: __('Profile information updated successfully.')
        );
    }

    /**
     * Update user password
     */
    public function updatePassword()
    {
        $user = Auth::user();

        $this->validate([
            'current_password' => ['required'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        if (! Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', __("Current password is incorrect."));
            return;
        }

        $user->update([
            'password' => $this->password,
        ]);

        // Reset password fields
        $this->reset([
            'current_password',
            'password',
            'password_confirmation',
        ]);

        $this->dispatch(
            'notify',
            type: 'success',
            message: __('Password updated successfully.')
        );
    }

    public function render()
    {
        return view('livewire.update-user');
    }
}
