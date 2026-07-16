<?php

namespace Modules\Unity\Http\Controllers\Admin;

use App\Traits\DefaultPermissions;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Modules\Unity\Http\Controllers\Admin\Operations\RestoreOperation;
use Modules\Unity\Enums\VehicleTypeType;
use Modules\Unity\Http\Requests\VehicletypeRequest;

/**
 * Class VehicletypeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class VehicletypeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Rezahmady\SettingOperation\SettingOperation;
    use DefaultPermissions;
    use RestoreOperation;
    Const ENTITY = 'vehicletype';

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\Modules\Unity\Models\Vehicletype::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/vehicletype');
        CRUD::setEntityNameStrings(trans('unity::unity.vehicletype_singular'), trans('unity::unity.vehicletype_plural'));

        /*
        |--------------------------------------------------------------------------
        | PERMISSIONS
        |--------------------------------------------------------------------------
        */
        $this->setPermissions();
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addColumns([
            [
                'name' => 'name',
                'label' => 'عنوان'
            ],
            [
                'name' => 'status',
                'type' => 'model_function',
                'function_name' => 'getStatusBrowse',
                'label' => 'وضعیت',
            ],
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(VehicletypeRequest::class);

        CRUD::addFields([
            [
                'name' => 'name',
                'label' => 'عنوان',
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
            ],
            [
                'name' => 'type',
                'label' => 'دسته',
                'type' => 'select2_from_array',
                'options' => VehicleTypeType::get_translated_array(),
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
            ],
            [
                'name' => 'status',
                'type' => 'toggle',
                'label' => 'فعال',
                'default' => true,
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
            ],
        ]);

        
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    /**
    * Define what happens when the Setting operation is loaded.
    *
    * @see https://github.com/rezahmady/setting-operation
    * @return void
    */
    protected function setupSettingOperation()
    {
        //
    }
}
