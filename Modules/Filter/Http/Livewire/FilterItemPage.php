<?php

namespace Modules\Filter\Http\Livewire;

use App\Http\Livewire\Traits\WithAlert;
use Livewire\Component;
use Modules\Filter\Models\Filter;
use Modules\Filter\Models\FilterItem;

class FilterItemPage extends Component
{
    use WithAlert;

    public $widget;

    public $filter;

    public $filterItem;

    protected $listeners = ["widget-updated:self-page" => '$refresh', 'update-widget' => 'widgetUpdate'];

    public function widgetUpdate()
    {
        $this->emit("widget-updated:{$this->widget}");
    }

    public function mount(Filter $filter, FilterItem $filterItem) {
        $this->filterItem = $filterItem->withFakes();
        $this->filter = $filter;
    }

    public function dehydrate()
    {
        $this->dehydrateWithAlert();
    }


    public function render()
    {
        return view('theme::modules.filter.filter-item-page')->layout('theme::layouts.app-state');
    }
}

