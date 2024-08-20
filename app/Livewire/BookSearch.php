<?php

namespace App\Livewire;

use App\Models\Book;
use Livewire\Component;

class BookSearch extends Component
{


    public $query = "";



    public function search()
    {

    }


    public function render()
    {
        return view('livewire.book-search');
    }
}
