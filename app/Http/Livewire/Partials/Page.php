<?php

namespace App\Http\Livewire\Partials;

use App\Http\Livewire\Traits\HasWidget;
use Modules\Page\Models\Page as ModelsPage;
use Livewire\Component;

class Page extends Component
{
    use HasWidget;
    
    public $page;

    public $view;

    public function render()
    {
        return view($this->view);
    }

}
