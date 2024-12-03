<?php

namespace App\Livewire;

use App\Models\Author;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Parsedown;

class AuthorAi extends Component
{


    public Author $author;
    public $data;



    public function generate(){
        $response = Http::get('https://books.amtar.shop/en/ai?author=' . $this->author->full_name);
        if ($response->successful()) {
            $parsedown = new Parsedown();
            $description = $parsedown->text($response->json()['message']);
            $this->author->description = $description;
            $this->author->save();

        } else {
            abort($response->status(), 'Error fetching JSON file.');
        }
    }


    public function render()
    {
        return view('livewire.author-ai');
    }
}
