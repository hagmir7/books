<?php

namespace App\Livewire;

use App\Models\Report;
use App\Models\Book;
use Livewire\Component;


class ReportForm extends Component
{
    public $full_name;
    public $subject;
    public $email;
    public $readed_at;
    public $content;
    public $book_id;

    // Preload books for the dropdown
    public $books = [];

    protected $rules = [
        'full_name' => 'required|string|max:255',
        'subject'   => 'required|string|max:255',
        'email'     => 'required|email|max:255',
        'readed_at' => 'nullable|date',
        'content'   => 'required|string',
        'book_id'   => 'nullable|exists:books,id',
    ];

    public function mount()
    {
        // Load all books when component initializes
        $this->books = Book::all();
    }

    public function save()
    {
        $this->validate();

        Report::create([
            'full_name' => $this->full_name,
            'subject'   => $this->subject,
            'email'     => $this->email,
            'readed_at' => $this->readed_at,
            'content'   => $this->content,
            'book_id'   => $this->book_id,
        ]);

        $this->reset(['full_name', 'subject', 'email', 'readed_at', 'content', 'book_id']);

        session()->flash('success', 'Report created successfully!');
    }

    public function render()
    {
        return view('livewire.report-form');
    }
}
