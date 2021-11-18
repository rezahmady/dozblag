<?php

namespace Modules\Comment\View\Widgets;

use App\Models\User;
use Illuminate\View\Component;
use Modules\Comment\Models\Comment;

class CommentsNumber extends Component
{
    public $comments;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->comments = Comment::where('module', 'Article')->count();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('comment::admin.widgets.comments-number');
    }
}
