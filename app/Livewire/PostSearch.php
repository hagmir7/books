<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class PostSearch extends Component
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
        if (empty($this->search)) {
            return view('livewire.post-search', [
                'posts' => collect(),
            ]);
        }

        $posts = Post::query()
            ->whereHas('language', fn($query) => $query->where('code', app()->getLocale()))
            ->where('site_id', app('site')->id)
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%')
                        ->orWhere('body', 'like', '%' . $this->search . '%')
                        ->orWhere('tags', 'like', '%' . $this->search . '%');
                });
            })
            ->limit(10)
            ->get();

        return view('livewire.post-search', compact('posts'));
    }
}
