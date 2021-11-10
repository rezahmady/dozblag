<?php

namespace Modules\Filter\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Filter\Models\Filter;
use Rezahmady\SettingOperation\Facades\Setting;

class FilterPage extends Component
{
    public $filter;

    public $filterItems;

    public $query;

    public function mount(Filter $filter) {
        $this->filter = $filter;
        $this->filterItems = $filter->filterItems;
    }

    public function render()
    {
        return view('theme::modules.filter.filter-page');
    }
}

