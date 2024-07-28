<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class PostActions extends Component
{

    public Post $post;


    public function delete()
    {
        $this->post->delete();
        session()->flash('status', 'post successfully deleted.');
    }

    public function render()
    {
        return view('livewire.post-actions');
    }
}
