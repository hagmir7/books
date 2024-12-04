<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AuthLivewire extends Component
{


    #[Validate('required|email|min:4|max:100', as:"Email", translate:true)]
    public $email;

    #[Validate('required|min:4|max:100', as: "Passowrd", translate:true)]
    public $password;

    public $password_confirmation;
    public $first_name;

    public $last_name;
    public $isRegister = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    public function toggleMode()
    {
        $this->isRegister = !$this->isRegister;
        // $this->dispatch('toggle-mode');
    }

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            return redirect()->route('home');
        } else {
            session()->flash('error', __("Invalid credentials"));
        }
    }

    public function register()
    {
        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }


    public function render()
    {
        return view('livewire.auth-livewire');
    }
}
