<?php

namespace App\Livewire\Pages;

use App\Models\Article;
use Livewire\Component;
use Livewire\WithPagination;

class Articles extends Component
{
    use WithPagination;

    public $search = '';

    public $selectedCategory = '';

    public $featuredArticles = [];

    public function mount()
    {
        $this->featuredArticles = Article::where('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectedCategory()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Article::when($this->search, function ($query) {
            $query->where('title', 'like', '%'.$this->search.'%')
                ->orWhere('content', 'like', '%'.$this->search.'%');
        })
            ->when($this->selectedCategory, function ($query) {
                $query->where('category', $this->selectedCategory);
            })
            ->where('is_featured', false)
            ->orderBy('created_at', 'desc');

        $articles = $query->paginate(9);

        return view('livewire.pages.articles', [
            'articles' => $articles,
        ]);
    }
}
