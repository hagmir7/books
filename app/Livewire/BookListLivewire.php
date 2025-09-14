<?php

namespace App\Livewire;

use App\Models\Book;
use App\Models\BookCategory;
use Livewire\Component;

class BookListLivewire extends Component
{

    public $amount = 30;
    public $total = 0;

    public BookCategory $category;


    public function mount(BookCategory $category)
    {
        $this->category = $category;
        $this->total = Book::whereHas('language', fn($query) => ($query->where('code', app()->getLocale())))->count();
    }

    public function loadMore()
    {
        $this->amount += 30;
    }
    public function render()
    {
        $books = $this->category->name
            // if
            ? $this->category->books()
                ->with(['author', 'language'])
                ->where('verified', true)
                ->whereHas('language', fn($query) => ($query->where('code', app()->getLocale())))
                ->take($this->amount)
                ->orderBy('updated_at', 'desc')
                ->where('is_public', 1)
                ->get()
            // else
            : Book::with(['author', 'language'])
                ->whereHas('language', fn($query) => ($query->where('code', app()->getLocale())))
                ->where('verified', true)
                ->where('is_public', 1)
                ->take($this->amount)

                ->orderBy('updated_at', 'desc')
                ->get();


        return view('livewire.book-list-livewire', [
            'books' => $books
        ]);
    }
}
