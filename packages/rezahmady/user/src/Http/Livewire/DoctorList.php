<?php

namespace Rezahmady\User\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Rezahmady\Filter\Models\Filter;
use Rezahmady\SettingOperation\Facades\Setting;

class DoctorList extends Component
{
    use WithPagination;

    public $filters = [];

    public $filter = [];

    public $filterShow;

    public $query;

    protected $queryString = [
        // 'jensiat',
        'page' => ['except' => 1],
        // "filter" => ['except' => 0],
    ];

    protected $pp = 15;

    public function mount() {
        $filtersId = Setting::get('users.template_doctor_filters');
        $this->filters = Filter::whereIn('id', $filtersId)->active()->orderBy('lft', 'ASC')->get();
    }

    public function loadList() {

        $filter = [];
        
        $query = ['template' => 'doctor'];

        $objects = User::where($query);

        if(!empty($this->filter["gender"])){
            $filter = [];
            foreach ($this->filter["gender"] as $key => $value) {
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
        $this->filter = [];
    }


    public function render()
    {
        return view('theme::modules.user.doctor-list', [
            'doctors' => $this->loadList()->paginate($this->pp),
        ]);
    }
}
