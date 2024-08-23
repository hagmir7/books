<?php

namespace App\Livewire;

use App\Models\Book;
use Livewire\Component;

class BookNavigator extends Component
{

    public Book $book;


    // Get the next book based on ID
    public function next()
    {
        return static::where('id', '>', $this->id)
            ->orderBy('id', 'asc')
            ->first();
    }

    // Get the previous book based on ID
    public function previous()
    {
        return static::where('id', '<', $this->id)
            ->orderBy('id', 'desc')
            ->first();
    }


    public function render()
    {
        return view('livewire.book-navigator');
    }
}
