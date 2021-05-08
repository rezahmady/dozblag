<?php

namespace Rezahmady\User\Http\Livewire\Widgets;

use App\Http\Livewire\Traits\WidgetRender;
use App\Models\User;
use App\Models\Widget;
use Livewire\Component;

class ListUser extends Component
{
    use WidgetRender;
    
    public $view;
    
    public Widget $widget;

    public $users;
    
    public function mount()
    {
        $this->widget = $this->widget->withFakes();

        $this->users = User::whereIn('id', $this->widget->users)->get();
    }
    
    protected function getListeners()
    {
        return [
            "widget-updated:{$this->widget->name}" => 'updateComponent'
        ];
    }

    public function updateComponent()
    {
        $this->widget = $this->widget->withFakes();

        $this->users = User::whereIn('id', $this->widget->users)->get();

        $this->dispatchBrowserEvent("contentChanged:{$this->widget->name}");
    }
}
