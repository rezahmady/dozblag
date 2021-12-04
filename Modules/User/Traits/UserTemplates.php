<?php

namespace Modules\User\Traits;

use Modules\Filter\Models\Filter;
use Modules\Filter\Models\FilterItem;
use Rezahmady\SettingOperation\Setting;
use Modules\Subscribtion\Models\Subscribtion;

trait UserTemplates
{
    /*
    |--------------------------------------------------------------------------
    | User Templates
    |--------------------------------------------------------------------------
    |
    | Each page template has its own method, that define what fields should show up using the Backpack\CRUD API.
    | Use snake_case for naming and PageManager will make sure it looks pretty in the create/update form
    | template dropdown.
    |
    | Any fields defined here will show up after the standard page fields:
    | - select template
    */

    private function user()
    {
        $this->crud->addField([
            // two interconnected entities
            'label'             => trans('backpack::permissionmanager.user_role_permission'),
            'tab'               => trans('backpack::permissionmanager.user_role_permission'),
            'field_unique_name' => 'user_role_permission',
            'type'              => 'checklist_dependency',
            'name'              => ['roles', 'permissions'],
            'tab'               => 'دسترسی',
            'subfields'         => [
                'primary' => [
                    'label'            => trans('backpack::permissionmanager.roles'),
                    'name'             => 'roles', // the method that defines the relationship in your Model
                    'entity'           => 'roles', // the method that defines the relationship in your Model
                    'entity_secondary' => 'permissions', // the method that defines the relationship in your Model
                    'attribute'        => 'name', // foreign key attribute that is shown to user
                    'model'            => config('permission.models.role'), // foreign key model
                    'pivot'            => true, // on create&update, do you need to add/delete pivot table entries?]
                    'number_columns'   => 3, //can be 1,2,3,4,6
                ],
                'secondary' => [
                    'label'          => ucfirst(trans('backpack::permissionmanager.permission_singular')),
                    'name'           => 'permissions', // the method that defines the relationship in your Model
                    'entity'         => 'permissions', // the method that defines the relationship in your Model
                    'entity_primary' => 'roles', // the method that defines the relationship in your Model
                    'attribute'      => 'display_name', // foreign key attribute that is shown to user
                    'model'          => config('permission.models.permission'), // foreign key model
                    'pivot'          => true, // on create&update, do you need to add/delete pivot table entries?]
                    'number_columns' => 3, //can be 1,2,3,4,6
                ],
            ],
        ]);
    }

    protected function getFilters($template) {
        $filters = Setting::get("users.template_{$template}_filters");

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
                        'allows_multiple' => $multiple,
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
