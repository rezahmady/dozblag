<?php

namespace App\Http\Livewire\Partials\Comment;

use Livewire\Component;

class Comment extends Component
{
    public $view;

    public $comment;

    public $user;

    public function mount($comment)
    {
        $this->comment = $comment;
        $this->user = ($comment->user) ? $comment->user->withFakes() : null;
    }

    protected $listeners = [
        'comment-refresh' => '$refresh',
    ];

    public function reply($id)
    {
        $this->emit('setCommentParentId', $id);
    }
    
    public function renderWhen(): bool
    {
		if ($this->comment->status == 1) {
			return true;
		}

        return false;
    }

    public function render()
    {
        if($this->renderWhen()) return view($this->view);
        return '<div></div>';
    }
}
