<?php

namespace App\Http\Livewire\Widgets;

use App\Http\Livewire\Traits\WidgetRender;
use App\Models\Page;
use App\Models\Widget;
use Livewire\Component;

class ListGroup extends Component
{
    use WidgetRender;
    
    public $view;
    
    public Widget $widget;

    public $categories;
    
    public function mount()
    {
        $this->widget = $this->widget->withFakes();

        $this->categories = Page::whereIn('id', $this->widget->category_filter)->get()->take($this->widget->category_filter_max);
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
        $this->categories = Page::whereIn('id', $this->widget->category_filter)->get()->take($this->widget->category_filter_max);

        $this->dispatchBrowserEvent("contentChanged:{$this->widget->name}");
    }
}
