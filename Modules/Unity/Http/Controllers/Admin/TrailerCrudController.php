<?php

namespace Modules\Unity\Http\Controllers\Admin;

use App\Traits\DefaultPermissions;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Modules\Unity\Http\Controllers\Admin\Operations\RestoreOperation;
use Modules\Unity\Http\Requests\TrailerRequest;
use Modules\Unity\Enums\VehicleTypeType;
use Modules\Unity\Models\Trailer;
use Modules\Unity\Models\Unity;

/**
 * Class TrailerCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TrailerCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
     use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
     use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;
    use FetchOperation;
    use RestoreOperation;
    // use \Rezahmady\SettingOperation\SettingOperation;
    use DefaultPermissions;
    Const ENTITY = 'Trailer';

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\Modules\Unity\Models\Trailer::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/trailer');
        CRUD::setEntityNameStrings(trans('unity::unity.trailer_singular'), trans('unity::unity.trailer_plural'));

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
        // check permissions
        if(!backpack_user()->can('Trailer manage all') and backpack_user()->unity) {
            $this->crud->addClause('where', 'unity_id', '=', backpack_user()->unity->id);
        } elseif(!backpack_user()->can('Trailer manage all')) {
            abort(403);
        } else {
            $this->crud->addColumn([
                'name' => 'unity',
                'attribute' => 'fa_name',
                'label' => trans('unity::unity.unity_singular')
            ]);

            $this->crud->addFilter(
                [
                    'name'  => 'unity',
                    'type'  => 'select2',
                    'label' => trans('unity::unity.unity_plural'),
                ],
                Unity::pluck('fa_name', 'id')->toArray(),
                function ($value) { // if the filter is active
                    $this->crud->addClause('whereHas', 'unity' , function($query) use($value) {
                        $query->where('id', $value);
                    });
                }
            );
        }

        $this->crud->addColumns([
            [
                'name' => 'vehicletype',
                'label' => 'نوع',
            ],
            [
                'name' => 'transit_number',
                'label' => 'شماره ترانزیت',
            ],
            [
                'name' => 'status',
                'type' => 'model_function',
                'function_name' => 'getStatusBrowse',
                'label' => 'وضعیت',
            ],
        ]);
    }

    protected function setupShowOperation()
    {
        if(!backpack_user()->can('Trailer manage all') and backpack_user()->unity) {
            if($this->crud->getCurrentEntry()->truck->unity->id !== backpack_user()->unity->id) abort(403);
        } elseif(!backpack_user()->can('Trailer manage all')) {
            abort(403);
        }

        $this->crud->addColumns([
            [
                'name' => 'truck',
                'label'    => 'کشنده',
                'type'     => 'relationship'
            ],
            [
                'name' => 'vehicletype',
                'label' => 'نوع',
            ],
            [
                'name' => 'transit_number',
                'label' => 'شماره ترانزیت',
            ],
            [
                'name' => 'iranian_plates_number',
                'label' => 'شماره شهربانی',
            ],
            [
                'name' => 'model',
                'label' => 'سال ساخت',
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
        CRUD::setValidation(TrailerRequest::class);

        if(!backpack_user()->can('Trailer manage all') and backpack_user()->unity) {
            //
        } elseif(!backpack_user()->can('Trailer manage all')) {
            abort(403);
        } else {
            $this->crud->addField([   // relationship
                'type' => "relationship",
                'name' => 'unity', // the method on your model that defines the relationship
                'ajax' => true,
                // 'inline_create' => [ 'entity' => 'group' ], // specify the entity in singular
                'label' => 'شرکت',
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
                // 'tab' => 'مشخصات',
                'minimum_input_length' => 0,
                'attribute' => "fa_name", // foreign key attribute that is shown to user (identifiable attribute)
                'entity' => 'unity', // the method that defines the relationship in your Model
                'model' => "Modules\Unity\Models\Unity", // foreign key Eloquent model
                'placeholder' => "انتخاب شرکت", // placeholder for the select2 input
            ]);
        }

        Trailer::creating(function($entry) {

            if(!backpack_user()->can('Trailer manage all') and backpack_user()->unity) {
                $entry->unity_id = backpack_user()->unity->id;
            }

        });

        $this->crud->addFields([
            [
                'name' => 'transit_number',
                'label' => trans('unity::unity.trailer_transit_number'),
                'prefix' => '<i class="la la-suitcase"></i>',
                'wrapper' => [
                    'class' => 'form-group col-md-6 required'
                ]
            ],
            [  // Select2
                'label'     => trans('unity::unity.trailer_type'),
                'type'      => 'select2',
                'name'      => 'vehicletype', // the db column for the foreign key

                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
                // optional
                'entity'    => 'vehicletype', // the method that defines the relationship in your Model
                'model'     => "Modules\Unity\Models\Vehicletype", // foreign key model
                'attribute' => 'name', // foreign key attribute that is shown to user
                // 'default'   => 2, // set the default value of the select2

                 // also optional
                'options'   => (function ($query) {
                     return $query->orderBy('name', 'ASC')->where('type', VehicleTypeType::Trailer->value)->get();
                 }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
            ],
            [
                'name' => 'iranian_plates_number',
                'label' => trans('unity::unity.iranian_plates_number'),
                'prefix' => '<i class="la la-i-cursor"></i>',
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ],
                'type' => 'iranian_plates_number',
                'view_namespace' => 'unity::fields'
                // 'tab' => 'مشخصات',
            ],
            [
                'name' => 'status',
                'type'=> 'hidden',
                'value' => 1,
            ],
            [
                'name' => 'model',
                'label' => trans('unity::unity.trailer_model'),
                'prefix' => '<i class="la la-calendar"></i>',
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ]
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

    public function fetchUnity()
    {
        return $this->fetch([
            'model' => Unity::class,
            'searchable_attributes' => ['fa_name', 'en_name']
        ]);
    }
}
