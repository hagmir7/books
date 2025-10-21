<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class AuthLivewire extends Component
{
    public $email;
    public $password;
    public $password_confirmation;
    public $first_name;
    public $last_name;
    public $remember = false;
    public $isRegister = false;

    public function toggleMode()
    {
        $this->isRegister = !$this->isRegister;
        $this->reset(['email', 'password', 'password_confirmation', 'first_name', 'last_name']);
        $this->resetValidation();
    }

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->regenerate();
            return redirect()->route('home');
        }

        $this->addError('email', __("Invalid credentials"));
    }

    public function register()
    {
        $validated = $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        session()->regenerate();

        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.auth-livewire');
    }
}
