<?php

namespace Rezahmady\Resource\Traits;

use Rezahmady\Filter\Models\Filter;
use Rezahmady\Filter\Models\FilterItem;
use Rezahmady\SettingOperation\Setting;

trait ResourceTemplates
{
    /*
    |--------------------------------------------------------------------------
    | Resource Templates
    |--------------------------------------------------------------------------
    |
    | Each page template has its own method, that define what fields should show up using the Backpack\CRUD API.
    | Use snake_case for naming and PageManager will make sure it looks pretty in the create/update form
    | template dropdown.
    |
    | Any fields defined here will show up after the standard page fields:
    | - select template
    */

    private function clinic()
    {
        $this->getFilters('clinic');
    }

    private function hospital()
    {
        $this->crud->addFields([
            [   // select_and_order
                'name'    => 'bed_num',
                'label'   => 'تعداد تخت',
                'type'    => 'number',
                'fake'    => true,
                'tab' => 'اختصاصی',
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
            ],
        ]);
        $this->getFilters('hospital');
    }

    protected function getFilters($template) {
        $filters = Setting::get("resources.template_{$template}_filters");

        if($filters) foreach($filters as $key => $item) {
            $item = Filter::findOrFail($item);
            $multiple = ($item->type == 'hasMany') ? true : false;
            switch ($item->field) {
                case 'select2_from_array':
                    $this->crud->addField([
                        'name'    => "filter_{$item->slug}",
                        'label'   => $item->name,
                        'type'        => 'select2_from_array',
                        'fake'    => true,
                        'options' => FilterItem::where('filter_id', $item->id)->get()->pluck('name','id')->toArray(),
                        'tab' => 'فیلترها',
                        'wrapper'   => [ 
                            'class'      => 'form-group col-md-6'
                        ],
                        'multiple' => $multiple,
                        'allows_null' => true,
                    ]);
                    break;
                case 'select_and_order':
                    $this->crud->addField([
                        'name'    => "filter_{$item->slug}",
                        'label'   => $item->name,
                        'type'    => 'select_and_order',
                        'fake'    => true,
                        'options' => FilterItem::where('filter_id', $item->id)->get()->pluck('name','id')->toArray(),
                        'tab' => 'فیلترها',
                    ]);
                    break;
                default:
                    # code...
                    break;
            }
        }
    }

}
