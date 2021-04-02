<?php

namespace App\Http\Controllers\Admin;

use App\Traits\DefaultPermissions;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class SettingCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use DefaultPermissions;
    Const ENTITY = 'setting';

    public function setup()
    {
        CRUD::setModel("Backpack\Settings\app\Models\Setting");
        CRUD::setEntityNameStrings(trans('backpack::settings.setting_singular'), trans('backpack::settings.setting_plural'));
        CRUD::setRoute(backpack_url('setting'));

        /*
        |--------------------------------------------------------------------------
        | PERMISSIONS
        |--------------------------------------------------------------------------
        */
        $this->setPermissions();
    }

    public function setupListOperation()
    {
        // only show settings which are marked as active
        CRUD::addClause('where', 'active', 1);

        // columns to show in the table view
        CRUD::setColumns([
            [
                'name'  => 'name',
                'label' => trans('backpack::settings.name'),
            ],
            [
                'name'  => 'value',
                'label' => trans('backpack::settings.value'),
            ],
            [
                'name'  => 'description',
                'label' => trans('backpack::settings.description'),
            ],
            [
                'name'  => 'key',
                'label' => 'کلید',
            ],
        ]);
    }

    public function setupUpdateOperation()
    {
        $disable = (backpack_user()->can(self::ENTITY.' edit name') ) ? null : ['disabled' => 'disabled'];
        CRUD::addField([
            'name'       => 'name',
            'label'      => trans('backpack::settings.name'),
            'type'       => 'text',
            'attributes' => $disable
        ]);

        if (backpack_user()->can(self::ENTITY.' edit key') ) CRUD::addField([
            'name'       => 'key',
            'label'      => 'کلید',
            'type'       => 'text',
        ]);

        if (backpack_user()->can(self::ENTITY.' edit key') ) CRUD::addField([
            'name'       => 'description',
            'label'      => 'توضیحات',
            'type'       => 'textarea',
        ]);

        CRUD::addField(json_decode(CRUD::getCurrentEntry()->field, true));
    }
}
