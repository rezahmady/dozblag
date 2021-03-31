<?php

namespace App\Http\Livewire\Widgets;

use App\Http\Livewire\Traits\WidgetRender;
use App\Models\Widget;
use Livewire\Component;

class Custom extends Component
{
    use WidgetRender;

    public Widget $widget;

    public $view;

    public function mount()
    {
        $this->widget = $this->widget->withFakes();
    }
    
    protected $listeners = ['lityClosed' => 'updateComponent'];

    public function updateComponent()
    {
        $this->widget = $this->widget->withFakes();
    }

}
