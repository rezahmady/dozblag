<?php

namespace Modules\Article\Http\Livewire;

use Livewire\Component;
use Modules\Article\Models\Article;

class PostRender extends Component
{
    public $post;

    public $cats;

    public $author;

    public $similarPosts;

    public function mount(Article $article)
    {
        $this->post = $article->withFakes();

        if($this->post->login_require and !auth()->check()) {
            session(['link' => url()->current()]);
            return redirect()->to(route('auth.login'));
        }
        $cats = $article->pages;

        $catsArray = [];

        foreach ($cats as $key => $value) {
            $catsArray = $this->getCats($value);
        }

        $this->cats = array_reverse($catsArray);

        $this->similarPosts = Article::whereHas('tags', function ($q) use ($article) {
            return $q->whereIn('name', $article->tags->pluck('name'));
        })->where('id', '!=', $article->id)->published()->get();

        $this->author = $article->user->withFakes();

    }

    public function getCats($cats)
    {
        $newCat[] = $cats;
        if(isset($cats->parentRecursive)) {
            $newCat = array_merge($newCat, $this->getCats($cats->parentRecursive));
        }

        return $newCat;

    }

    public function renderWhen(): bool
    {
		if ($this->post->status == 'PUBLISHED') {
			return true;
		}

        return false;
    }


    public function render()
    {
        if(auth()->check() and backpack_user()->can('post update'))
        {
            return view('theme::modules.blog.show')->layout('theme::layouts.app');
        } else {
            if($this->renderWhen()) return view('theme::modules.blog.show')->layout('theme::layouts.app');
            return  '<div></div>'; // delete
        }
    }
}
