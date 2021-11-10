<?php

namespace Modules\Resource\Http\Livewire;

use App\Models\Ostan;
use App\Models\Shahrestan;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Filter\Models\Filter;
use Modules\Resource\Models\Resource;
use Rezahmady\SettingOperation\Facades\Setting;

class ResourceList extends Component
{
    use WithPagination;

    public $resource;

    public $filters = [];

    public $filter = [
        'ostan' => null,
        'shahrestan' => null
    ];

    public $filterShow;

    public $query;

    public $ostans;

    public $shahrestans;

    protected $queryString = [
        // 'jensiat',
        'page' => ['except' => 1],
        // "filter" => ['except' => 0],
    ];

    protected $pp = 15;

    public function mount(Resource $resource) {
        $this->resource = $resource;
        $filtersId = Setting::get('resources.template_clinic_filters');
        $this->filters = Filter::whereIn('id', $filtersId)->active()->orderBy('lft', 'ASC')->get();
        $this->ostans = Ostan::pluck('name','id');
        $this->shahrestans = [];
    }


    public function loadList() {

        if($this->filter['ostan']) $this->shahrestans = Shahrestan::where('ostan_id', $this->filter['ostan'])->pluck('name', 'id');

        $filter = [];

        $query = ['template' => $this->resource->template];

        $objects = Resource::where($query);

        if($this->filter["ostan"]){
            $filter = $this->filter["ostan"];
            $objects->where('extras->ostan_id', $filter );
        }

        if($this->filter["shahrestan"]){
            $filter = $this->filter["shahrestan"];
            $objects->where('extras->shahrestan_id', $filter );
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
            if(!empty($this->filter["{$filter->slug}"])){
                $filterValues = [];
                foreach ($this->filter["{$filter->slug}"] as $key => $value) {
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
        $this->filter = [
            'ostan' => null,
            'shahrestan' => null
        ];
    }


    public function render()
    {
        try {
            return view("theme::modules.resource.{$this->resource->template}-list", [
                'items' => $this->loadList()->paginate($this->pp),
            ]);
        } catch (\Throwable $th) {
            return view("theme::modules.resource.resource-list", [
                'items' => $this->loadList()->paginate($this->pp),
            ]);
        }

    }
}
