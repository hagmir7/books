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

    public function mount(Book $book)
    {
        $this->book = $book;
    }

    public function save()
    {
        $this->validate();

        // Additional check to ensure book is still valid
        if (!$this->book || !$this->book->exists) {
            session()->flash('error', __('Invalid book selected.'));
            return;
        }

        try {
            Report::create([
                'full_name' => $this->full_name,
                'subject'   => $this->subject,
                'email'     => $this->email,
                'content'   => $this->content,
                'book_id'   => $this->book->id,
            ]);

            // $this->reset(['full_name', 'subject', 'email', 'content']);

            session()->flash('success', __('Report created successfully!'));

            // Check if book has slug property before using it
            if (isset($this->book->slug)) {
                return redirect()->route('book.show', $this->book->slug);
            } else {
                return redirect()->route('book.show', $this->book->id);
            }
        } catch (\Exception $e) {
            session()->flash('error', __('Failed to create report. Please try again.'));
            \Log::error('Report creation failed: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.report-form');
    }
}
