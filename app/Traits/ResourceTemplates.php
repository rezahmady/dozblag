<?php

namespace App\Traits;

use App\Models\FilterItem;

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

        $this->crud->addFields([
            [   // select_and_order
                'name'    => 'services',
                'label'   => 'خدمات',
                'type'    => 'select_and_order',
                'fake'    => true,
                'options' => FilterItem::where('filter_id', 5)->get()->pluck('name','id')->toArray(),
                'tab' => 'خدمات',
            ],
        ]);
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
    }

}
