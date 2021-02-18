<?php

namespace App\Http\Livewire\Partials;

use Livewire\Component;

class Custom extends Component
{
    public $them;

    public $view;

    public function mount()
    {
        $theme_model = config('themes.models.theme');

        $theme = $theme_model::where('active', '=', 1)->first();

        $this->theme = $theme;
    }

    
    protected $listeners = ['lityClosed' => 'updateComponent'];

    public function updateComponent()
    {
        //
    }

    public function render()
    {
        return view($this->view);
    }

}
