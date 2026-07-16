<?php

namespace Modules\Unity\Http\Controllers\Admin;

use App\Traits\DefaultPermissions;
use App\Traits\DropzoneTrait;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Modules\Unity\Enums\TruckContractStatus;
use Modules\Unity\Http\Controllers\Admin\Operations\TruckContractTerminateOperation;
use Modules\Unity\Http\Requests\TruckContractRequest;
use Modules\Unity\Models\Truck;
use Modules\Unity\Models\TruckContract;
use Modules\Unity\Models\Unity;

/**
 * Class TruckContractCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TruckContractCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
    use \Rezahmady\SettingOperation\SettingOperation;
    use TruckContractTerminateOperation;
    use DefaultPermissions;
    use DropzoneTrait;
    Const ENTITY = 'truckcontract';

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\Modules\Unity\Models\TruckContract::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/truckcontract');
        CRUD::setEntityNameStrings(trans('unity::unity.truck_contract_singular'), trans('unity::unity.truck_contract_plural'));
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
        if(!backpack_user()->can('truckcontract manage all') and backpack_user()->unity) {
            $this->crud->addClause('where', 'unity_id', '=', backpack_user()->unity->id);
        } elseif(!backpack_user()->can('truckcontract manage all')) {
            abort(403);
        } else {
            $this->crud->addColumn([
                'name' => 'unity',
                'attribute' => 'fa_name',
                'type' => 'relationship',
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

            $this->crud->addFilter(
                [
                    'name'  => 'truck',
                    'type'  => 'select2',
                    'label' => trans('unity::unity.truck_singular'),
                ],
                Truck::pluck('transit_number', 'id')->toArray(),
                function ($value) { // if the filter is active
                    $this->crud->addClause('whereHas', 'truck' , function($query) use($value) {
                        $query->where('id', $value);
                    });
                }
            );
        }

        $this->crud->addFilter(
            [
                'name'  => 'status',
                'type'  => 'select2',
                'label' => 'وضعیت',
            ],
            TruckContractStatus::get_translated_array(),
            function($value) { // if the filter is active
                $this->crud->addClause('where', 'contract_status', $value); // apply the "active" eloquent scope
            }
        );

        // add columns
        $this->crud->addColumns([
            [
                'name' => 'truck',
                'type' => 'relationship',
                'label' => trans('unity::unity.truck_singular')
            ],
            [
                'name' => 'status',
                'type' => 'model_function',
                'function_name' => 'getStatusBrowse',
                'label' => 'وضعیت',
            ],
        ]);
    }

    public function setupShowOperation()
    {
        // check permissions
        if(!backpack_user()->can('truckcontract manage all') and backpack_user()->unity) {
            if($this->crud->getCurrentEntry()->unity->id !== backpack_user()->unity->id) abort(403);
        } elseif(!backpack_user()->can('truckcontract manage all')) {
            abort(403);
        } else {
            $this->crud->addColumn([
                'name' => 'unity',
                'type' => 'relationship',
                'attribute' => 'fa_name',
                'label' => trans('unity::unity.unity_singular')
            ],);
        }
        $this->crud->addColumns([
            [
                'name' => 'truck',
                'type' => 'relationship',
                'label' => trans('unity::unity.truck_singular')
            ],
            [
                'name' => 'status',
                'type' => 'model_function',
                'function_name' => 'getStatusBrowse',
                'label' => 'وضعیت',
            ],
            [
                'name' => 'image',
                'label' => 'تصویر',
                'type'  => 'model_function',
                'function_name' => 'getLogo',
            ],
        ]);
    }

    protected function setupTruckContractTerminateOperation()
    {
        $this->crud->addFields([
            [
                'name' => 'end_date',
                'label' => trans('unity::unity.end_date'),
                'type' => 'jdate_picker',
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
                'date_picker_options' => [
                    'autoClose' => true,
                    // 'initialValue' => false,
                    // 'viewMode' => 'year'
                ],
            ],
            [
                'name'    => 'description',
                'type'    => 'summernote',
                'options' => [
                    'toolbar' => [],
                ],
                'label'   =>  trans('unity::unity.contract_description'),
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
        $this->crud->setValidation(TruckContractRequest::class);

        TruckContract::creating(function($entry) {

            $entry->user_id = backpack_user()->id;
            if(!backpack_user()->can('truckcontract manage all') and backpack_user()->unity) {
                $entry->unity_id = backpack_user()->unity->id;
                $entry->contract_status = TruckContractStatus::Pending->value;
            }
            $entry->user_id = backpack_user()->id;

        });

        if(backpack_user()->can('truckcontract manage all')) {
            $this->crud->addField([   // relationship
                'type' => "relationship",
                'name' => 'unity', // the method on your model that defines the relationship
                'ajax' => true,
                // 'inline_create' => [ 'entity' => 'group' ], // specify the entity in singular
                'label' => 'شرکت',
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
                'minimum_input_length' => 0,
                // OPTIONALS:
                // 'label' => "Category",
                'attribute' => "fa_name", // foreign key attribute that is shown to user (identifiable attribute)
                'entity' => 'unity', // the method that defines the relationship in your Model
                'model' => "Modules\Unity\Models\Unity", // foreign key Eloquent model
                'placeholder' => "انتخاب شرکت", // placeholder for the select2 input
            ]);
        }

        $this->crud->addFields([
            [   // relationship
                'type' => "relationship",
                'name' => 'truck', // the method on your model that defines the relationship
                'ajax' => true,
                // 'inline_create' => [ 'entity' => 'group' ], // specify the entity in singular
                'label' => 'کامیون',
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
                'minimum_input_length' => 0,
                // OPTIONALS:
                // 'label' => "Category",
                'attribute' => "transit_number", // foreign key attribute that is shown to user (identifiable attribute)
                'entity' => 'truck', // the method that defines the relationship in your Model
                'model' => "Modules\Unity\Models\Truck", // foreign key Eloquent model
                'placeholder' => "انتخاب کامیون", // placeholder for the select2 input
            ],
            [
                'name' => 'start_date',
                'label' => trans('unity::unity.start_date'),
                'type' => 'jdate_picker',
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
                'date_picker_options' => [
                    'autoClose' => true,
                    // 'initialValue' => false
                ],
            ],
            // [
            //     'name' => 'end_date',
            //     'label' => trans('unity::unity.end_date'),
            //     'type' => 'jdate_picker',
            //     'wrapper'      => [
            //         'class'  => "form-group col-md-6"
            //     ],
            //     'date_picker_options' => [
            //         'autoClose' => true,
            //         // 'initialValue' => false,
            //         // 'viewMode' => 'year'
            //     ],
            // ],
        ]);

        $this->crud->addFields([
            [
                'name'    => 'description',
                'type'    => 'summernote',
                'options' => [
                    'toolbar' => [],
                ],
                'label'   =>  trans('unity::unity.contract_description'),
            ],
            // [
            //     'name' => 'images',
            //     'label' => 'تصویر نامه',
            //     'type' => 'dropzone',
            //     'disk' => 'local',
            //     'destination_path' => 'uploads/images/truck_contracts',
            //     'mimes' => 'image/*',
            //     'thumb_prefix' => '/',
            //     // 'image_width'      => 200,
            //     // 'image_height'     => 200,
            //     'max_file_size'    => 5,
            //     'max_file' => 1,
            // ]
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

    public function fetchTruck()
    {
        return $this->fetch([
            'model' => Truck::class,
            'query' => function($model) {
                return $model->whereNull('unity_id');
            },
        ]);
    }
}
