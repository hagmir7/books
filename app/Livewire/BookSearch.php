<?php

namespace App\Livewire;

use App\Models\Book;
use App\Models\Author;
use App\Models\BookCategory;
use App\Models\Language;
use Livewire\Component;

class BookSearch extends Component
{

    public $search = '';


    protected $queryString = [
        'search' => ['except' => ''],
    ];


    public function clearFilters()
    {
        $this->search = '';
    }

    public function render()
    {
        // Only search when user has typed something
        if (empty($this->search)) {
            return view('livewire.book-search', [
                'books' => collect(),
            ]);
        }

        $books = Book::query()
            ->with(['author', 'category'])
            ->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orWhere('tags', 'like', '%' . $this->search . '%');
            })
            ->get();

        return view('livewire.book-search', compact('books'));
    }
}
