<?php

namespace App\Http\Livewire\Partials\Comment;

use Livewire\Component;
use App\Models\Comment;

class Comments extends Component
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
