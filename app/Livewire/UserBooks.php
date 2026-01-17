<?php

namespace App\Livewire;

use App\Models\Book;
use Livewire\Component;

class UserBooks extends Component
{

    public $amount = 27;
    public $total = 0;



    public function mount()
    {
        $this->total = Book::whereHas('language', fn($query) => ($query->where('code', app()->getLocale())))->count();
    }

    public function loadMore()
    {
        $this->amount += 27;
    }



    public function render()
    {

        $books = Book::with(['author', 'language', 'category'])
            // ->whereHas('language', fn($query) => ($query->where('code', app()->getLocale())))
            // ->where('verified', true)
            // ->where('is_public', 1)
            ->orderBy('updated_at', 'desc')
            ->where('user_id', auth()->id())
            ->take($this->amount)
            ->get();
        return view('livewire.user-books', [
            'books' => $books
        ]);
    }
}
