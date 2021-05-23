<?php

namespace Rezahmady\Resource\Http\Livewire;

use Livewire\Component;
use Rezahmady\Resource\Models\Resource;

class ResourceShow extends Component
{


    public $resource;

    public $services;

    public function mount(Resource $resource) {
        $this->resource = $resource->withFakes();

        $this->services = $this->resource->servicesFilter();

        // dd($this->resource);
    }

    public function render()
    {
        return view("theme::modules.resource.resource-show");
    }
}
