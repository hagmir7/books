<?php

namespace App\Livewire;

use App\Models\Author;
use Livewire\Component;

class AuthorActions extends Component
{

    public Author $author;

    public function hidde()
    {
        if (auth()->user()->hasRole("super_admin")) {
            $this->author->update([
                'verified' => false
            ]);
            session()->flash('status', __('The author successfully hid.'));
        }
    }

    public function delete()
    {
        if (auth()->user()->hasRole("super_admin")) {
            $this->author->delete();
            session()->flash('status', __('The author successfully deleted.'));
        }
    }



    public function render()
    {
        return view('livewire.author-actions');
    }
}
