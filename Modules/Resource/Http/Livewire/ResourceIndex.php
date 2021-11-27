<?php

namespace Modules\Resource\Http\Livewire;

use Livewire\Component;
use Modules\Resource\Models\Resource;
use Modules\Resource\Traits\ResourceTemplates;

class ResourceIndex extends Component
{


    public $resources;

    public $templates;

    public function mount() {
        $this->resources = $this->getTemplatesArray();
        $this->loadTemplates();
    }

    public function loadTemplates()
    {
        foreach ($this->resources as $key => $value) {
            $this->templates[$key] = Resource::where('template', $key)->published()->take(10)->get();
        }

    }

    /**
     * Get all defined template as an array.
     *
     * Used to populate the template dropdown in the create/update forms.
     */
    public function getTemplatesArray()
    {
        $templates = $this->getTemplates();

        foreach ($templates as $template) {
            $templates_array[$template->name] = trans('resource::resource.function_name.'.$template->name);
        }

        return $templates_array;
    }

    /**
     * Get all defined templates.
     */
    public function getTemplates(): array
    {
        $templates_trait = new \ReflectionClass(ResourceTemplates::class);
        $templates = $templates_trait->getMethods(\ReflectionMethod::IS_PRIVATE);

        if (! count($templates)) {
            abort(503, trans('backpack::permissionmanager.template_not_found'));
        }

        return $templates;
    }

    public function render()
    {
        return view("theme::modules.resource.resource-index");
    }
}
