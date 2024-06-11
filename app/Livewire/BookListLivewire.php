<?php

namespace App\Livewire;

use App\Models\Book;
use App\Models\BookCategory;
use Livewire\Component;

class BookListLivewire extends Component
{

    public $amount = 15;
    public $total = 0;

    public BookCategory $category;


    public function mount(BookCategory $category)
    {
        $this->category = $category;
        $this->total = Book::all()->count();
    }

    public function loadMore()
    {
        $this->amount += 15;
    }
    public function render()
    {
        $books = $this->category->name
            ? $this->category->books()->with(['author'])->take($this->amount)->orderBy('created_at', 'asc')->get()
            : Book::with(['author'])->take($this->amount)->orderBy('created_at', 'asc')->get();
        return view('livewire.book-list-livewire', [
            'books' => $books
        ]);
    }
}
