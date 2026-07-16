<?php

namespace Modules\Unity\Http\Controllers\Admin;

use App\Traits\DefaultPermissions;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Request;
use Modules\Unity\Enums\TruckContractStatus;
use Modules\Unity\Enums\VehicleTypeType;
use Modules\Unity\Http\Requests\TruckRequest;
use Modules\Unity\Models\Trailer;
use Modules\Unity\Models\Truck;
use Modules\Unity\Models\TruckContract;
use Modules\Unity\Models\Unity;
use Modules\Unity\Models\Vehicletype;

use function PHPSTORM_META\type;

/**
 * Class TruckCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TruckCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation; // { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation; // { update as traitUpdate; }
    //use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
    use \Rezahmady\SettingOperation\SettingOperation;
    use DefaultPermissions;
    Const ENTITY = 'truck';

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\Modules\Unity\Models\Truck::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/truck');
        CRUD::setEntityNameStrings(trans('unity::unity.truck_singular'), trans('unity::unity.truck_plural'));

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
        if(!backpack_user()->can('truck manage all') and backpack_user()->unity) {
            $this->crud->addClause('where', 'unity_id', '=', backpack_user()->unity->id);
        } elseif(!backpack_user()->can('truck manage all')) {
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

        // add columns
        $this->crud->addColumns([
            [
                'name' => 'transit_number',
                'label' => 'شماره ترانزیت',
            ],
            [
                'name' => 'vehicletype',
                'label' => 'نوع',
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
        // check permissions
        if(!backpack_user()->can('truck manage all') and backpack_user()->unity) {
            if($this->crud->getCurrentEntry()->unity->id !== backpack_user()->unity->id) abort(403);
        } elseif(!backpack_user()->can('truck manage all')) {
            abort(403);
        } else {
            $this->crud->addColumn([
                'name' => 'unity',
                'label'    => 'شرکت',
                'attribute' => 'fa_name'
            ]);
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
            [
                'name' => 'iranian_plates_number',
                'label' => 'پلاک',
            ],
            [
                'name' => 'chassis_number',
                'label' => 'شاسی',
            ],
            [
                'name' => 'engine_number',
                'label' => 'موتور',
            ],
            [
                'name' => 'model',
                'label' => trans('unity::unity.model'),
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
        $this->crud->setValidation(TruckRequest::class);

        if(!backpack_user()->can('truck manage all') and backpack_user()->unity) {
            //
        } elseif(!backpack_user()->can('truck manage all')) {
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

        // Events
        Truck::created(function($entry) {

            if($entry->unity) {
                TruckContract::create([
                    'user_id' => backpack_user()->id,
                    'truck_id' => $entry->id,
                    'unity_id' => $entry->unity->id,
                    'contract_status' => TruckContractStatus::Active->value,
                    'start_date' => Carbon::now()->format('Y/m/d'),
                ]);
            }

            // $trailer = json_decode(Request::get('trailer'), false);
            // $this->crud->getRequest()->request->remove('trailer');


        });

        Truck::creating(function($entry) {

            if(!backpack_user()->can('truck manage all') and backpack_user()->unity) {
                $entry->unity_id = backpack_user()->unity->id;
            }

        });

        $this->crud->addFields([
            [
                'name' => 'transit_number',
                'label' => trans('unity::unity.transit_number'),
                'prefix' => '<i class="la la-suitcase"></i>',
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ],
                // 'tab' => 'مشخصات',
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
            [  // Select2
                'label'     => "نوع",
                'type'      => 'select2',
                'name'      => 'vehicletype', // the db column for the foreign key

                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
                // 'tab' => 'مشخصات',
                // optional
                'entity'    => 'vehicletype', // the method that defines the relationship in your Model
                'model'     => "Modules\Unity\Models\Vehicletype", // foreign key model
                'attribute' => 'name', // foreign key attribute that is shown to user
                // 'default'   => 2, // set the default value of the select2

                 // also optional
                'options'   => (function ($query) {
                     return $query->orderBy('name', 'ASC')->where('type', VehicleTypeType::Truck->value)->get();
                 }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
            ],
            [
                'name' => 'chassis_number',
                'label' => trans('unity::unity.chassis_number'),
                'prefix' => '<i class="la la-qrcode"></i>',
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ],
                // 'tab' => 'مشخصات',
            ],
            [
                'name' => 'engine_number',
                'label' => trans('unity::unity.engine_number'),
                'prefix' => '<i class="la la-qrcode"></i>',
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ],
                // 'tab' => 'مشخصات',
            ],
            [
                'name' => 'model',
                'label' => trans('unity::unity.model'),
                'prefix' => '<i class="la la-calendar"></i>',
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ],
                // 'tab' => 'مشخصات',
            ],
            [
                'name' => 'status',
                'type' => 'toggle',
                'label' => 'فعال',
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ],
                'default' => true,
                // 'tab' => 'مشخصات',
            ],
//            [   // repeatable
//                'name'  => 'trailer',
//                'label' => '',
//                'tab' => trans('unity::unity.trailer'),
//                'type'  => 'repeatable',
//                'subfields' => [
//                    [
//                        'name' => 'transit_number',
//                        'label' => trans('unity::unity.trailer_transit_number'),
//                        'prefix' => '<i class="la la-suitcase"></i>',
//                        'wrapper' => [
//                            'class' => 'form-group col-md-6 required'
//                        ]
//                    ],
//                    [  // Select2
//                        'label'     => trans('unity::unity.trailer_type'),
//                        'type'      => 'select2_from_array',
//                        'name'      => 'vehicletype_id', // the db column for the foreign key
//
//                        'wrapper'      => [
//                            'class'  => "form-group col-md-6 required"
//                        ],
//
//                        'options' => Vehicletype::where(['status' => 1, 'type' => VehicleTypeType::Trailer->value])->pluck('name', 'id')->toArray(),
//                    ],
//                    [
//                        'name' => 'iranian_plates_number',
//                        'label' => trans('unity::unity.iranian_plates_number'),
//                        'prefix' => '<i class="la la-i-cursor"></i>',
//                        'wrapper' => [
//                            'class' => 'form-group col-md-6'
//                        ],
//                        'type' => 'iranian_plates_number',
//                        'view_namespace' => 'unity::fields'
//                        // 'tab' => 'مشخصات',
//                    ],
//                    [
//                        'name' => 'status',
//                        'type'=> 'hidden',
//                        'value' => 1,
//                    ],
//                    [
//                        'name' => 'model',
//                        'label' => trans('unity::unity.trailer_model'),
//                        'prefix' => '<i class="la la-calendar"></i>',
//                        'wrapper' => [
//                            'class' => 'form-group col-md-6'
//                        ]
//                    ],
//                ],
//
//                'init_rows' => 1, // number of empty rows to be initialized, by default 1
//                'max_rows' => 1,
//                'min_rows' =>1,
//            ],
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
        Truck::updating(function($entry) {

            if(!backpack_user()->can('truck manage all') and backpack_user()->unity) {
                $entry->unity_id = backpack_user()->unity->id;
            }

        });

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

//    public function store()
//    {
//
//        $trailer = json_decode(Request::get('trailer'), true)[0];
//
//        $this->crud->removeField('trailer');
//
//        $response = $this->traitStore();
//
//        $this->crud->getCurrentEntry()->trailer()->create($trailer);
//
//        return $response;
//    }

//    public function update()
//    {
//        $trailer = json_decode(Request::get('trailer'), true)[0];
//        unset($trailer['section1']);
//        unset($trailer['section2']);
//        unset($trailer['section3']);
//        unset($trailer['section4']);
//        $this->crud->removeField('trailer');
//        $response = $this->traitUpdate();
//        $this->crud->getCurrentEntry()->trailer()->update($trailer);
//        return $response;
//    }
}
