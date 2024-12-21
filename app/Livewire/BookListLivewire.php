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
        $this->total = Book::whereHas('language', fn($query) => ($query->where('code', app()->getLocale())))->count();
    }

    public function loadMore()
    {
        $this->amount += 15;
    }
    public function render()
    {
        $books = $this->category->name
            // if
            ? $this->category->books()
                ->with(['author', 'language'])
                ->whereHas('language', fn($query) => ($query->where('code', app()->getLocale())))
                ->take($this->amount)
                ->orderBy('created_at', 'asc')
                ->where('is_public', 1)
                ->get()
            // else
            : Book::with(['author', 'language'])
                ->whereHas('language', fn($query) => ($query->where('code', app()->getLocale())))
                ->take($this->amount)
                ->where('is_public', 1)
                ->orderBy('created_at', 'asc')
                ->get();


        return view('livewire.book-list-livewire', [
            'books' => $books
        ]);
    }
}
