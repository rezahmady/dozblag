<?php

namespace Rezahmady\Page\Http\Livewire\Widgets;

use App\Http\Livewire\Traits\WidgetRender;
use Rezahmady\Page\Models\Page;
use Livewire\Component;
use App\Models\Widget;
use Illuminate\Database\Eloquent\Collection;

class ListGrouped extends Component
{

    use WidgetRender;
    
    public $view;

    public Widget $widget;

    public $filters;

    public $items;

    
    public function mount()
    {
        $this->widget = $this->widget->withFakes();
        $pages = Page::whereTemplate($this->widget->tabs_filter)->get();
        $this->filters = $pages->take($this->widget->tabs_filter_max)->take($this->widget->tabs_filter_max);
        $this->items = null;
        foreach($pages as $key => $page) {

            if(sizeOf($page->items($this->widget->tabs_filter)->get())) {
                if($this->items == null) {
                    $this->items = $page->items($this->widget->tabs_filter)->published()->take($this->widget->tabs_filter_item_max)->get();
                } else {
                    $items = new Collection($this->items) ;
                    $merged = $items->merge($page->items($this->widget->tabs_filter)->published()->take($this->widget->tabs_filter_item_max)->get());
                    $this->items = $merged->all();
                }
            };
        }
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
        $pages = Page::whereTemplate($this->widget->tabs_filter)->get();
        $this->filters = $pages->take($this->widget->tabs_filter_max)->take($this->widget->tabs_filter_max);
        $this->items = null;
        foreach($pages as $key => $page) {

            if(sizeOf($page->items($this->widget->tabs_filter)->get())) {
                if($this->items == null) {
                    $this->items = $page->items($this->widget->tabs_filter)->published()->take($this->widget->tabs_filter_item_max)->get();
                } else {
                    $items = new Collection($this->items) ;
                    $merged = $items->merge($page->items($this->widget->tabs_filter)->published()->take($this->widget->tabs_filter_item_max)->get());
                    $this->items = $merged->all();
                }
            };
        }

        $this->dispatchBrowserEvent("contentChanged:{$this->widget->name}");
    }
}
