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

    // public $doctors;

    public $filters = [];

    public $filter = [
        "search" => "",
        "gender" => [],
        "specilty" => [],
    ];

    public $filterShow;

    protected $queryString = [
        // 'jensiat',
        'page' => ['except' => 1],
    ];

    public function add($param)
    {
        array_push( $this->filter[$param[0]] ,$param[1]);
    }

    protected $pp = 15;

    public function mount() {
        $filtersId = Setting::get('users.template_doctor_filters');
        $this->filters = Filter::whereIn('id', $filtersId)->active()->get();
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

        if(!empty($this->filter["specilty"])){
            $filter = [];
            foreach ($this->filter["specilty"] as $key => $value) {
                if($value) array_push($filter,$key);
            }
            if(!empty($filter)) $objects->whereIn('extras->filter_specilty', $filter );
        }

        $this->filterShow =  (!empty($filter)) ? true : false;
        
        if(round($objects->count()/$this->pp,false) < $this->page) {
            $this->page = 1;
        }
 
        $this->dispatchBrowserEvent('scrollToTop');

        return $objects;
    }

    public function removeFilters()
    {
        $this->filter['gender'] = $this->filter['specilty'] = [];
    }


    public function render()
    {
        return view('theme::modules.user.doctor-list', [
            'doctors' => $this->loadList()->paginate($this->pp),
        ]);
    }
}
