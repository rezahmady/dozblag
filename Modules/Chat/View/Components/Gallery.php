<?php

namespace Modules\Chat\View\Components;

use Illuminate\View\Component;

class Gallery extends Component
{
    public $id;

    public $class;

    public $photos;

    public $total;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($photos, $id, $class = '')
    {
        $this->photos = $photos;
        $this->id = $id;
        $this->class = $class;
        $this->total = sizeof($photos);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('chat::skin.gallery');
    }
}
