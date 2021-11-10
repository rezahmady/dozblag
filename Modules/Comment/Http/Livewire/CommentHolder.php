<?php

namespace Modules\Comment\Http\Livewire;

use Livewire\Component;

class CommentHolder extends Component
{
    public $view;

    public $comments;

    public $module;

    public $moduleId;

    public $hasMore;

    public $counter = 20;

    protected $listeners = [
        'comments-refresh' => 'setComments',
    ];

    public function setComments()
    {
        $this->emit('comment-refresh');
    }

    public function moreComments()
    {
        $this->counter = $this->counter+10;

    }

    public function mount($module)
    {
        $this->module = $module;
        $this->moduleId = $module->id;
    }

    public function render()
    {
        $this->comments = $this->module->comments()->latest()->take($this->counter)->get();
        $this->hasMore = ($this->comments->count() >= $this->module->comments->count()) ? false : true;
        return view($this->view);
    }
}
