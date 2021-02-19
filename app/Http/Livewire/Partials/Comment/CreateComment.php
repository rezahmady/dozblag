<?php

namespace App\Http\Livewire\Partials\Comment;

use Rezahmady\SettingOperation\Setting;
use Livewire\Component;
use App\Models\Comment;

class CreateComment extends Component
{
    public $view;

    public $module;
    
    public $moduleId;

    public $parent_id;

    public $name;

    public $email;

    public $body;

    public $user_id;

    public $score;

    public $reply;

    protected $listeners = ['setCommentParentId'];

    public function setCommentParentId($id)
    {
        $this->parent_id = $id;
        $this->reply = Comment::find($id);
        $this->dispatchBrowserEvent('scrollTo', ['hash' => 'create-comment']);
    }

    public function removeReply()
    {
        $this->parent_id = null;
        $this->reply = null;
    }

    protected function rules()
    {
        return (auth()->check()) ?
        [
            'body' => 'required|string',
        ] :
        [
            'name' => 'required|string',
            'email' => 'required|email',
            'body' => 'required|string',
        ];
    }

    protected $validationAttributes = [
        'body' => 'نظر'
    ];

    public function submit()
    {
        $this->validate();
        
        // Execution doesn't reach here if validation fails.

        if(auth()->check()) {
            $this->name = auth()->user()->name;
            $this->user_id = auth()->id();
        }
        $status = (auth()->check() and backpack_user()->can('post update')) ? 1 : 0;
        
        Comment::create([
            'name'       => $this->name,
            'email'      => $this->email,
            'body'       => $this->body,
            'score'      => $this->score,
            'user_id'    => $this->user_id,
            'module_id'  => $this->moduleId,
            'module'     => $this->module,
            'parent_id'  => $this->parent_id,
            'status'     => $status,
        ]);

        $this->body = $this->parent_id = $this->score = $this->parent_id = $this->reply = null;

        if($status) {
            $this->emit('comments-refresh');
        }

        session()->flash('success', Setting::get('comments.success-created'));
    }

    public function render()
    {
        return view($this->view);
    }
}
