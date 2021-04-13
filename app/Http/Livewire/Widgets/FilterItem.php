<?php

namespace App\Http\Livewire\Widgets;

use App\Http\Livewire\Traits\WidgetRender;
use App\Models\Filter;
use App\Models\FilterItem as ModelsFilterItem;
use App\Models\Widget;
use Livewire\Component;

class FilterItem extends Component
{
    use WidgetRender;
    
    public $view;
    
    public Widget $widget;

    public $filter;

    public $filterItem;
    
    public function mount()
    {
        $this->widget = $this->widget->withFakes();

        $this->filter = Filter::findOrFail($this->widget->filter);

        $this->filterItem = ModelsFilterItem::whereIn('id', $this->widget->filterItem)->get();
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

        $this->filter = Filter::findOrFail($this->widget->filter);

        $this->filterItem = ModelsFilterItem::whereIn('id', $this->widget->filterItem)->get();

        $this->dispatchBrowserEvent("contentChanged:{$this->widget->name}");
    }
}
