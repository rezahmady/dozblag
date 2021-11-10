<?php

namespace App\Http\Livewire\Widgets;

use App\Http\Livewire\Traits\WidgetRender;
use Modules\Page\Models\Page;
use App\Models\Widget;
use Livewire\Component;

class MenuRaque extends Component
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


    }

    protected $listeners = ['lityClosed' => 'updateComponent'];

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
    }

    public function makeList($array, $id = false) {

        //Base case: an empty array produces no list
        if (empty($array)) return ;

        $start = ($id) ? '<ul class="dropdown-menu">' : '';
        //Recursive Step: make a list with child lists
        $output = $start;
        foreach ($array as $subArray) {
            $has_child = (empty($subArray['children_recursive'])) ? '' : ' <i class="bx bx-chevron-down"></i> ';
            $output .= '<li class="nav-item"><a href="'.url($subArray['slug']).'" class="nav-link">
            '.$subArray['title'].$has_child.'</a>'
            . $this->makeList($subArray['children_recursive'], $subArray['id'] ) . '</li>';
        }
        $output .= ($id) ? '</ul>' : '';

        return $output;
    }

}
