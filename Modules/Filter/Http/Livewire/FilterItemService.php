<?php

namespace Modules\Filter\Http\Livewire;

use Modules\Filter\Models\FilterItem;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Filter\Models\Filter;
use Rezahmady\SettingOperation\Facades\Setting;

class FilterItemService extends Component
{
    use WithPagination;

    public $filters = [];

    public $filterarray = [];

    public $filterShow;

    public $query;

    public $filterItem;

    protected $queryString = [
        'page' => ['except' => 1],
    ];

    protected $pp = 15;

    public function mount(Filter $filter, FilterItem $filterItem) {
        $this->filterItem = $filterItem->withFakes();
        $filtersId = Setting::get('users.template_doctor_filters');
        $this->filters = Filter::whereIn('id', $filtersId)->active()->orderBy('lft', 'ASC')->get();
    }

    public function loadList() {

        $filterarray = [];

        $query = ['template' => 'doctor'];

        $objects = $this->filterItem->doctors();// User::where($query);

        if(!empty($this->filterarray["gender"])){
            $filter = [];
            foreach ($this->filterarray["gender"] as $key => $value) {
                if($value) array_push($filter,$key);
            }
            if(!empty($filter)) $objects->whereIn('extras->gender', $filter );
        }

        $this->filterShow =  (!empty($filter)) ? true : false;

        $objects = $this->addFilters($objects);

        if(round($objects->count() < ($this->page-1)*$this->pp)) {
            $this->page = 1;
        }

        $this->dispatchBrowserEvent('scrollToTop');

        return $objects;
    }

    public function addFilters($objects)
    {
        foreach($this->filters as $key => $filter) {
            if(!empty($this->filterarray["{$filter->slug}"])){
                $filterValues = [];
                foreach ($this->filterarray["{$filter->slug}"] as $key => $value) {
                    if($value) array_push($filterValues,$key);
                }

                switch ($filter->type) {
                    case 'belongsTo':
                        if(!empty($filterValues)) $objects->whereIn("extras->filter_{$filter->slug}", $filterValues );
                        break;
                    case 'hasMany':
                        if(!empty($filterValues)) $objects->where(function($query) use($filterValues, $filter){
                            $query->whereRaw("JSON_CONTAINS(JSON_EXTRACT(extras, '$.filter_".$filter->slug."'), '\"{$filterValues[0]}\"')");
                            for($i = 1; $i < count($filterValues); $i++) {
                               $query->orWhereRaw("JSON_CONTAINS(JSON_EXTRACT(extras, '$.filter_".$filter->slug."'), '\"{$filterValues[$i]}\"')");
                            }
                            return $query;
                        });
                        break;
                    default:
                        # code...
                        break;
                }
            }
        }

        if(!empty($filterValues)) $this->filterShow = true;
        return $objects;
    }

    public function setNullFilterArray()
    {
        $this->filterarray = [];
    }


    public function render()
    {
        return view('theme::modules.filter.filter-item-services', [
            'doctors' => $this->loadList()->paginate($this->pp),
        ]);
    }
}

