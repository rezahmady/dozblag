<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Home extends Component
{
    protected $listeners = ['update-widget' => 'widgetUpdate'];

    public $widget;

    public function widgetUpdate()
    {
        $this->emit("widget-updated:{$this->widget}");
    }

    public function render()
    {
        return view('theme::modules.pages.home')
        ->layout('theme::layouts.app-state');
    }
}
