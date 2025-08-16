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
    public Book $book;


    protected $rules = [
        'full_name' => 'required|string|max:255',
        'subject'   => 'required|string|max:255',
        'email'     => 'required|email|max:255',
        'content'   => 'required|string',
    ];


    public function save()
    {
        $this->validate();

        Report::create([
            'full_name' => $this->full_name,
            'subject'   => $this->subject,
            'email'     => $this->email,
            'content'   => $this->content,
            'book_id'   => $this->book->id,
        ]);

        $this->reset(['full_name', 'subject', 'email', 'content']);

        session()->flash('success', 'Report created successfully!');
    }

    public function render()
    {
        return view('livewire.report-form');
    }
}
