<?php

namespace App\Livewire;

use App\Models\Subscriber;
use Livewire\Component;
use Livewire\Attributes\Validate;

class Newsletter extends Component
{
    #[Validate('required|string|max:255')]
    public string $full_name = '';

    #[Validate('required|email|max:255')]
    public string $email = '';

    public bool $subscribed = false;

    public function subscribe(): void
    {
        $this->validate();

        Subscriber::create([
            'site_id' => app("site")->id,
            'language_id' => app("site")->language_id,
            'full_name' => $this->full_name,
            'email' => $this->email
        ]);

        $this->reset('full_name', 'email');
        $this->subscribed = true;
    }

    public function render()
    {
        return view('livewire.newsletter');
    }
}
