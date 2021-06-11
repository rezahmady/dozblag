<?php

namespace Rezahmady\Filter\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Rezahmady\Filter\Models\Filter;
use Rezahmady\Filter\Models\FilterItem;

class FilterItemArticles extends Component
{
    use WithPagination;

    public $filter;

    public $filterItem;

    public $query;

    protected $queryString = [
        'page' => ['except' => 1],
    ];

    protected $pp = 15;

    public function mount(Filter $filter, FilterItem $filterItem) {
        $this->filter = $filter;
        $this->filterItem = $filterItem->withFakes();
    }

    public function render()
    {
        return view('theme::modules.filter.filter-item-articles',[
            'posts' => $this->filterItem->articles()->orderBy('id','Desc')->paginate($this->pp),
        ]);
    }
}

