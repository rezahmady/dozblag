<?php

namespace Rezahmady\Article\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Rezahmady\Article\Models\Tag;

class TagRender extends Component
{
    use WithPagination;

    public $tag;

    public $query;

    protected $queryString = [
        'page' => ['except' => 1],
    ];

    protected $pp = 15;

    public function mount(Tag $tag) {
        $this->tag = $tag->withFakes();
    }

    public function render()
    {
        return view('theme::modules.blog.tag-show',[
            'posts' => $this->tag->articles()->published()->orderBy('id','Desc')->paginate($this->pp),
        ]);
    }
}

