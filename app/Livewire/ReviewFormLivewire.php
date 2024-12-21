<?php

namespace App\Livewire;

use App\Models\Book;
use App\Models\Comment;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ReviewFormLivewire extends Component
{

    #[Validate('required|min:3', attribute: "Full name")]
    public $full_name;

    #[Validate('required|email|min:3', attribute:"Email")]
    public $email;

    #[Validate('required|min:3', attribute: "Review", translate:true)]
    public $body;

    public Book $book;

    public function mount(){
        if(auth()->check()){
            $this->full_name = auth()->user()->first_name . " " . auth()->user()->last_name;
            $this->email = auth()->user()->email;
        }
    }


    public function save()
    {
        $this->validate();
        Comment::create([
            "full_name" => $this->full_name,
            "email" => $this->email,
            "body" => $this->body,
            "book_id" => $this->book->id,
            "stars" => 5,
            "user_id" => auth()->check() ? auth()->user()->id : null,
        ]);
        session()->flash('message', __('Thank you! Your review is submited successfully'));
        $this->reset('body');
    }


    public function render()
    {
        return view('livewire.review-form-livewire');
    }
}
