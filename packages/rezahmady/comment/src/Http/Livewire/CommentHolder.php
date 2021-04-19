<?php

namespace Rezahmady\Comment\Http\Livewire;

use Livewire\Component;

class CommentHolder extends Component
{
    public $view;

    public $comments;

    public $post;

    public $postId;

    protected $listeners = [
        'comments-refresh' => 'setComments',
    ];

    public function setComments()
    {
        $this->comments = $this->post->comments;
        $this->emit('comment-refresh');
    }

    public function mount($post)
    {
        $this->comments = $post->comments;
        $this->postId = $post->id;
    }

    public function render()
    {
        return view($this->view);
    }
}
