<?php

namespace App\Livewire\Pages;

use App\Models\Article;
use Livewire\Component;

class ArticleDetail extends Component
{
    public $article;

    public $relatedArticles = [];

    public function mount(Article $article)
    {
        $this->article = $article;

        // Load related articles
        $this->relatedArticles = Article::where('id', '!=', $article->id)
            ->where('category', $article->category)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
    }

    public function render()
    {
        return view('livewire.pages.article-detail');
    }
}
