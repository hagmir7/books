<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AuthLivewire extends Component
{
    // --- State ---
    public bool $isRegister = false;
    public bool $remember = false;

    #[Validate('required|email', attribute:'Email', translate:true)]
    public string $email = '';

    #[Validate('required|min:6')]
    public string $password = '';

    #[Validate('required_with:isRegister|same:password')]
    public ?string $password_confirmation = null;

    #[Validate('required_with:isRegister|string|max:255')]
    public ?string $first_name = null;

    #[Validate('required_with:isRegister|string|max:255')]
    public ?string $last_name = null;


    // --- Mode Switch ---
    public function toggleMode(): void
    {
        $this->isRegister = !$this->isRegister;
        $this->reset(['email', 'password', 'password_confirmation', 'first_name', 'last_name']);
        $this->resetValidation();
    }

    // --- Auth Methods ---
    public function login(): void
    {
        $this->validateOnly('email');
        $this->validateOnly('password');

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->addError('email', __('auth.failed'));
            return;
        }

        session()->regenerate();

        $this->redirectRoute('home', navigate: true);
    }

    public function register(): void
    {
        $validated = $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'email'      => $validated['email'],
            'password'   => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        session()->regenerate();

        $this->redirectRoute('home', navigate: true);
    }

    // --- View ---
    #[Layout('layouts.guest')] // Optional: specify layout
    public function render()
    {
        return view('livewire.auth-livewire');
    }
}
