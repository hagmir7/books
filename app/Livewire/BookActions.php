<?php

namespace App\Livewire;

use App\Models\Book;
use Livewire\Component;

class BookActions extends Component
{

    public Book $book;


    public function hidde(){
        $book_status = !$this->book->is_public ? true : false;
        $this->book->update(['is_public' => $book_status, "copyright_date" => now()]);
        session()->flash('status', 'Book successfully hidded.');
    }

    public function delete()
    {
        $this->book->delete();
        session()->flash('status', 'Book successfully deleted.');
    }


    public function render()
    {
        return view('livewire.book-actions');
    }
}
