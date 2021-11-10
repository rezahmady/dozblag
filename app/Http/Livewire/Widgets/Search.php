<?php

namespace App\Http\Livewire\Widgets;

use App\Http\Livewire\Traits\WidgetRender;
use App\Models\User;
use App\Models\Widget;
use Livewire\Component;
use Modules\Article\Models\Article;
use Modules\Filter\Models\FilterItem;
use Modules\Resource\Models\Resource;

class Search extends Component
{

    public Widget $widget;

    public $view;

    public $searchTerm;

    public $result;

    public $users;

    public $resources;

    public $filters;

    public $mags;

    public function mount()
    {
        $this->widget = $this->widget->withFakes();
    }

    protected function getListeners()
    {
        return [
            "widget-updated:{$this->widget->name}" => 'updateComponent'
        ];
    }

    public function updateComponent()
    {
        $this->widget = $this->widget->withFakes();

        $this->dispatchBrowserEvent("contentChanged:{$this->widget->name}");
    }

    public function renderWhen(): bool
    {
		if ($this->widget->status) {
			return true;
		}

        return false;
    }

    public function submit()
    {
        //
    }


    public function render()
    {
        if(strlen($this->searchTerm) > 0) {
            $searchTerm = '%'. $this->searchTerm .'%';
            $this->users = User::where('template', 'doctor')->where('name', 'like', $searchTerm)->take(4)->get();
            $this->resources = Resource::where('name', 'like', $searchTerm)->take(4)->get();
            $this->filters = FilterItem::where('slug', '!=', 'services')->where('name', 'like', $searchTerm)->take(4)->get();
            $this->mags = Article::where('title', 'like', $searchTerm)->published()->take(4)->get();
        } else {
            $this->users = $this->resources = $this->filters = $this->mags = null;
        }
        $this->dispatchBrowserEvent("contentChanged:{$this->widget->name}");
        $this->result = ($this->users || $this->resources || $this->filters || $this->mags) ? true : false;
        $this->widget = $this->widget->withFakes();
        if($this->renderWhen()) return view($this->view);
        return  '<div></div>';
    }

}
