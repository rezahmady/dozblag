<?php

namespace App\Services\Widget;

use App\Support\Collection;

class Widget
{
    public function get_all(): array
    {
        $widgets = [];
        $db_widgets =  \App\Models\Widget::where('type', 'admin')->get();
        foreach ($db_widgets as $key => $widget) {
            $widgets[$key] = json_decode($widget['extras'], true);
            $widgets[$key]['id'] = $widget->name;
        }
        return $widgets;
    }

    public function get($key)
    {
        return \App\Models\Widget::where('name', $key)->first();
    }

    public function update($widget)
    {

        if($this->get($widget['id'])) {
            $this->get($widget['id'])->update([
                'extras' => json_encode([
                    'lg' => $widget['lg'],
                    'md' => $widget['md'],
                    'sm' => $widget['sm'],
                    'xsm' => $widget['xsm'],
                    'active' => $widget['active'],
                ])
            ]);
        } else {
//            return $widget;
            $this->store($widget);
        }

        return $widget;
    }

    public function store($widget) {
        $new_widget = new \App\Models\Widget();
        $new_widget->name = $widget['id'];
        $new_widget->type = 'admin';
        $new_widget->status = 1;
        $new_widget->theme_id = 0;
        $new_widget->extras = json_encode([
            'lg' => $widget['lg'],
            'md' => $widget['md'],
            'sm' => $widget['sm'],
            'xsm' => $widget['xsm'],
            'active' => $widget['active'],
        ]);
        $new_widget->save();
    }

    public function fetch($modules_widgets) {
        $db_widgets = $this->get_all();
        foreach ($modules_widgets as $key => $widget) {
            $db_widget = $this->find($db_widgets, 'id', $widget['id']);
            if($db_widget) {
                $matched_widget = $this->match($widget, $db_widget);
                $modules_widgets[$key] = $matched_widget;
            }
        }
        return $modules_widgets;
    }

    public function match($widget, &$db_widget): array {
        $db_widget['view'] = $widget['view'];
        return $db_widget;
    }

    public function find($array, $key, $value)
    {
        if (is_array($array)) {
            foreach ($array as $ar) {
                if (is_array($ar) && isset($ar[$key]) && $ar[$key] == $value) {
                    return $ar;
                }
            }
        }

        return false;
    }

}
