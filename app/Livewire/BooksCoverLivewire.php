<?php

namespace App\Livewire;

use App\Models\Book;
use Livewire\Component;

class BooksCoverLivewire extends Component
{
    public function render()
    {
        $colors = ['green-bg', 'purple-bg', 'blue-bg', 'burgundy-bg', 'beige-bg', 'pink-bg', 'green-bg', 'purple-bg', 'blue-bg', 'burgundy-bg'];
        return view('livewire.books-cover-livewire', [
            "books" => Book::with(['category', 'author'])->inRandomOrder()->limit(10)->get(),
            "colors" => $colors
        ]);
    }
}
