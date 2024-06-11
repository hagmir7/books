<?php

namespace App\Livewire;

use App\Models\Contact;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ContactForm extends Component
{


    #[Validate('required|max:100|min:4')]
    public $full_name;
    #[Validate('required|email|max:50|min:4')]
    public $email;
    #[Validate('required|min:10|max:400')]
    public $body;

    public function save(){
        $this->validate();
        Contact::create($this->validate());
        session()->flash('status', __("Your message was sent successfully!"));
        $this->reset();
    }


    public function render()
    {
        return view('livewire.contact-form');
    }
}
