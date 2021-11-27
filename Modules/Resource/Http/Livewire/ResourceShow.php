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

    public function render()
    {
        return view("theme::modules.resource.resource-show");
    }
}
