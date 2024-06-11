<?php

namespace App\Livewire;

use App\Models\Author;
use Livewire\Component;

class AuthorsListLivewire extends Component
{


    public $search = '';


    public function render()
    {
        return view('livewire.authors-list-livewire', [
            'authors' =>  Author::withCount('books')->orderBy('books_count', 'desc')->paginate(20)
        ]);
    }
}
