<?php

namespace Modules\Article\Http\Livewire;

use Modules\Article\Models\Article;
use Livewire\Component;

class ShareHolder extends Component
{
    public $post;

    public $view;

    public $like = 0;

    public $dislike = 0;

    public $whatsapp = 0;

    public $telegram = 0;

    public $comment = 0;

    public $class;

    public function mount(Article $article, $class = '')
    {
        $this->post = $article->withFakes();
        $this->like = $article->like;
        $this->dislike = $article->dislike;
        $this->whatsapp = $article->whatsapp;
        $this->telegram = $article->telegram;
        $this->class = $class;
        $this->comment = $article->allComments()->count();
    }

    public function like()
    {
        if (session()->has("post.{$this->post->id}.like")) {
            $this->like--;
            $this->post->update(['like' => $this->post->like-1]);
            session()->forget("post.{$this->post->id}.like");
        } else {
            if (session()->has("post.{$this->post->id}.dislike")) {
                $this->dislike--;
                $this->post->update(['dislike' => $this->post->dislike-1]);
                session()->forget("post.{$this->post->id}.dislike");
            }
            $this->like++;
            $this->post->update(['like' => $this->post->like+1]);
            session()->put("post.{$this->post->id}.like", 1);
        }
    }

    public function dislike()
    {
        if (session()->has("post.{$this->post->id}.dislike")) {
            $this->dislike--;
            $this->post->update(['dislike' => $this->post->dislike-1]);
            session()->forget("post.{$this->post->id}.dislike");
        } else {
            if (session()->has("post.{$this->post->id}.like")) {
                $this->like--;
                $this->post->update(['like' => $this->post->like-1]);
                session()->forget("post.{$this->post->id}.like");
            }
            $this->dislike++;
            $this->post->update(['dislike' => $this->post->dislike+1]);
            session()->put("post.{$this->post->id}.dislike", 1);
        }
    }

    public function telegram()
    {
        $this->telegram++;
        $this->post->update(['telegram' => $this->post->telegram+1]);
    }

    public function whatsapp()
    {
        $this->whatsapp++;
        $this->post->update(['whatsapp' => $this->post->whatsapp+1]);
    }

    public function render()
    {
        return view($this->view);
    }
}
