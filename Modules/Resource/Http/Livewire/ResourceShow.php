<?php

namespace Modules\Resource\Http\Livewire;

use Livewire\Component;
use Modules\Resource\Models\Resource;

class ResourceShow extends Component
{


    public $resource;

    public $services;

    public function mount(Resource $resource) {
        $this->resource = $resource->withFakes();

        $this->services = $this->resource->servicesFilter();

    }

    public function renderWhen(): bool
    {
        if ($this->resource->status) {
            return true;
        }

        return false;
    }

    public function render()
    {

        if(auth()->check() and backpack_user()->can('post update'))
        {
            return view("theme::modules.resource.resource-show");
        } else {
            if($this->renderWhen()) return view("theme::modules.resource.resource-show");
            return  '<div></div>'; // delete
        }
    }
}
