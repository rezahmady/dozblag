<?php

namespace App\Http\Livewire\Partials;

use App\Models\Page as ModelsPage;
use Livewire\Component;

class Page extends Component
{
    public $page;

    public $view;

    public function render()
    {
        return view($this->view);
    }

}
