<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Traits\WithAlert;
use Livewire\Component;
use Rezahmady\SettingOperation\Setting;

class Home extends Component
{
    use WithAlert;
    
    protected $listeners = ['update-widget' => 'widgetUpdate'];

    public $widget;

    public $editable;

    public function mount()
    {
        $this->editable = Setting::get('themes.editable', true);
    }

    public function widgetUpdate()
    {
        $this->emit("widget-updated:{$this->widget}");
    }

    public function toggleEdite()
    {
        $status = (Setting::get('themes.editable') == true) ? false: true;
        $this->editable = $status;
        Setting::set('themes.editable', $status);
    }

    public function dehydrate()
    {
        $this->dehydrateWithAlert();
    }

    public function render()
    {
        return view('theme::modules.pages.home')
        ->layout('theme::layouts.app-state');
    }
}
