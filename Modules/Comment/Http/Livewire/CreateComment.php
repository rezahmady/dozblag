<?php

namespace Modules\Comment\Http\Livewire;

use Rezahmady\SettingOperation\Setting;
use Livewire\Component;
use Modules\Chat\Models\Room;
use Modules\Comment\Models\Comment;

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

    public $room;

    protected $listeners = [
        'setCommentParentId',
        'rerenderCreateMessage',
    ];

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

    public function rerenderCreateMessage(Room $room)
    {
        $this->room = $room;
    }

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

        session()->flash('success', Setting::get('comments.blog-success-created'));
    }

    public function doctorSubmit()
    {
        $this->validate([
            'body'  => 'required|string',
            'score' => 'required',
        ]);

        // Execution doesn't reach here if validation fails.

        if(auth()->check()) {
            $this->name = auth()->user()->name;
            $this->user_id = auth()->id();
        }
        $status = (auth()->check() and backpack_user()->can('chat join')) ? 1 : 0;

        Comment::create([
            'name'       => $this->name,
            'email'      => $this->email,
            'body'       => $this->body,
            'score'      => $this->score,
            'user_id'    => $this->user_id,
            'module_id'  => $this->moduleId,
            'module'     => $this->module,
            'parent_id'  => $this->parent_id,
            'extras->room_id' => $this->room->id,
            'status'     => $status,
        ]);

        $this->body = $this->parent_id = $this->score = $this->parent_id = $this->reply = null;

        if($status) {
            $this->emit('comments-refresh');
        }

        session()->flash('success', Setting::get('comments.doctor-success-created'));
    }

    public function render()
    {
        return view($this->view);
    }
}
