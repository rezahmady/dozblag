<?php

namespace App\Http\Livewire\Widgets;

use App\Http\Livewire\Traits\WidgetRender;
use Modules\Page\Models\Page;
use App\Models\Widget;
use Livewire\Component;

class Menu extends Component
{
    use WidgetRender;

    public Widget $widget;

    public $menu;

    public $view;

    public function mount()
    {
        $this->widget = $this->widget->withFakes();
        switch ($this->widget->type) {
            case 'all_pages':
                $pages = Page::where(['parent_id' => null])->with('childrenRecursive')->where('extras->show', 1)->orderBy('lft')->get()->toArray();
                $this->menu = $this->makeList($pages);
                break;
            case 'custom_menu':
                $this->menu = false;
                break;

            default:
                $pages = Page::where(['parent_id' => null, 'template' => $this->widget->type])->with('childrenRecursive')->where('extras->show', 1)->orderBy('lft')->get()->toArray();
                $this->menu = $this->makeList($pages);
                break;
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

        switch ($this->widget->type) {
            case 'all_pages':
                $pages = Page::where(['parent_id' => null])->with('childrenRecursive')->orderBy('lft')->get()->toArray();
                $this->menu = $this->makeList($pages);
                break;
            case 'custom_menu':
                $this->menu = false;
                break;

            default:
                $pages = Page::where(['parent_id' => null, 'template' => $this->widget->type])->with('childrenRecursive')->orderBy('lft')->get()->toArray();
                $this->menu = $this->makeList($pages);
                break;
        }

        $this->dispatchBrowserEvent("contentChanged:{$this->widget->name}");
    }

    public function makeList($array, $id = false) {

        //Base case: an empty array produces no list
        if (empty($array)) return ;

        $start = ($id) ? '<ul class="submenu">' : '';
        //Recursive Step: make a list with child lists
        $output = $start;
        foreach ($array as $subArray) {
            if(isset($subArray['extras']['show']) and $subArray['extras']['show']) {
                $has_child = (empty($subArray['children_recursive'])) ? '' : ' <i class="fas fa-chevron-down"></i> ';
                $li_class = (empty($subArray['children_recursive'])) ? '' : 'has-submenu';
                $output .= '<li class="'.$li_class.'"><a href="'.url($subArray['slug']).'" >
                '.$subArray['title'].$has_child.'</a>'
                . $this->makeList($subArray['children_recursive'], $subArray['id'] ) . '</li>';
            }
        }
        $output .= ($id) ? '</ul>' : '';

        return $output;
    }

}
