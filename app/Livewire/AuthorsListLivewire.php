<?php

namespace App\Livewire;

use App\Models\Author;
use Livewire\Component;

class AuthorsListLivewire extends Component
{


    public $search = '';


    public function render()
    {
        // $authors = Author::select('authors.*')
        // ->join('books', 'books.author_id', '=', 'authors.id')
        // ->withCount('books')
        //     ->groupBy('authors.id')
        //     ->orderByDesc('books_count')
        //     ->limit(30)
        //     ->get();
        return view('livewire.authors-list-livewire', [
            'authors' =>  Author::where('verified', true)->withCount('books')->orderBy('books_count', 'desc')->paginate(20)
        ]);
    }
}
