<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Traits\WithAlert;
use Livewire\Component;

class Home extends Component
{
    use WithAlert;
    
    protected $listeners = ['update-widget' => 'widgetUpdate'];

    public $widget;

    public function widgetUpdate()
    {
        $this->emit("widget-updated:{$this->widget}");
    }

    public function dehydrate()
    {
        $this->dehydrateWithAlert();
    }

    public function render()
    {
        // dd(session()->get('alert_messages'));
        return view('theme::modules.pages.home')
        ->layout('theme::layouts.app-state');
    }
}
