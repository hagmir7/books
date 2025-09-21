<?php

namespace App\Livewire;

use App\Models\Book;
use Livewire\Component;

class BookActions extends Component
{

    public Book $book;


    public function hidde(){
        if(auth()->user()->hasRole("super_admin")){
            $book_status = !$this->book->is_public ? true : false;
            $this->book->update(['is_public' => $book_status, "copyright_date" => now()]);
            session()->flash('status', __('Book successfully hidded.'));
        }
    }

    public function delete()
    {
        if(auth()->user()->hasRole("super_admin")){
            $this->book->delete();
            session()->flash('status', __('Book successfully deleted.'));
        }
    }


    public function render()
    {
        return view('livewire.book-actions');
    }
}
