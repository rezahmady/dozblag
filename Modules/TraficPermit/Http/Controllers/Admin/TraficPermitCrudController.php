<?php

namespace Modules\TraficPermit\Http\Controllers\Admin;

use App\Traits\DefaultPermissions;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\DB;
use Modules\TraficPermit\Enums\TraficPermitStatus;
use Modules\TraficPermit\Http\Controllers\Admin\Operations\CarcassDeliveryOperation;
use Modules\TraficPermit\Http\Controllers\Admin\Operations\CorrectionTraficPermitOperation;
use Modules\TraficPermit\Http\Controllers\Admin\Operations\UndoCorrectionTraficPermitOperation;
use Modules\TraficPermit\Http\Controllers\Admin\Operations\UndoExportTraficPermitOperation;
use Modules\TraficPermit\Http\Requests\TraficPermitRequest;
use Modules\TraficPermit\Models\Country;
use Modules\TraficPermit\Models\Repository;
use Modules\TraficPermit\Models\TraficPermitType;
use Modules\Unity\Models\Trailer;
use Modules\Unity\Models\Truck;
use Modules\Unity\Models\Unity;

/**
 * Class TraficPermitCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TraficPermitCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
     use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    //use \Modules\Unity\Http\Controllers\Admin\Operations\RestoreOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Rezahmady\SettingOperation\SettingOperation;
    use CarcassDeliveryOperation;
    use CorrectionTraficPermitOperation;
    use UndoCorrectionTraficPermitOperation;
    use UndoExportTraficPermitOperation;
    use FetchOperation;
    use DefaultPermissions;
    Const ENTITY = 'TraficPermit';

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\Modules\TraficPermit\Models\TraficPermit::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/trafic-permit');
        CRUD::setEntityNameStrings(trans('traficpermit::traficpermit.trafic_permit_singular'), trans('traficpermit::traficpermit.trafic_permit_plural'));

        /*
        |--------------------------------------------------------------------------
        | PERMISSIONS
        |--------------------------------------------------------------------------
        */
        $this->setPermissions();
        if(backpack_user()->can('TraficPermit update')) {
            $this->crud->allowAccess('carcassDelivery');
            $this->crud->allowAccess('correctionTraficPermit');
            $this->crud->allowAccess('undoCorrectionTraficPermit');
            $this->crud->allowAccess('undoExportTraficPermit');
        } else {
            $this->crud->denyAccess('carcassDelivery');
            $this->crud->denyAccess('correctionTraficPermit');
            $this->crud->denyAccess('undoCorrectionTraficPermit');
            $this->crud->denyAccess('undoExportTraficPermit');
        }
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        //$this->crud->enableExportButtons();

        $this->crud->addFilter(
            [
                'name'  => 'unity',
                'type'  => 'select2',
                'label' => trans('unity::unity.unity_plural'),
            ],
            Unity::pluck('fa_name', 'id')->toArray(),
            function ($value) { // if the filter is active
                $this->crud->addClause('whereHas', 'exports' , function($exports) use($value) {

                    $exports->whereExists(function ($query) use($value) {
                        $query
                        ->select(DB::raw('*'))
                        ->from('permit_orders')
                        ->whereColumn('permit_orders.id', 'permit_order_id')
                        ->where('permit_order_trafic_permit.status', 1)
                            ->where('permit_order_trafic_permit.is_recursive', 0)
                        ->join('unities', 'unities.id', '=', 'permit_orders.unity_id')
                        ->where('unities.id', $value);
                    });
                });
            }
        );

        $this->crud->addFilter([
            'name'  => 'country',
            'type'  => 'select2_multiple',
            'label' => 'کشور',
        ],
          function() { // if the filter is active
            return Country::all()->pluck('fa_name', 'id')->toArray();
          } ,
          function($value) { // if the filter is active
            $this->crud->addClause('whereHas', 'repository', function($query) use($value) {
                $query->where('country_id', json_decode($value));
            });; // apply the "active" eloquent scope
          }
        );

        $this->crud->addFilter([
            'name'  => 'type',
            'type'  => 'select2_multiple',
            'label' => 'نوع',
        ],
            function() { // if the filter is active
                return TraficPermitType::pluck('title', 'id')->toArray();
            } ,
            function($values) { // if the filter is active
                $values = json_decode($values);
                foreach ($values as $value) {
                    $this->crud->addClause('whereHas', 'types', function($query) use($value) {
                        $query->where('trafic_permit_types.id', $value);
                    });
                }

                $this->crud->addClause('whereDoesntHave', 'types', function($query) use($values) {
                    $query->whereNotIn('trafic_permit_types.id', $values);
                });
            }
        );

        $this->crud->addFilter([
            'name'  => 'status',
            'type'  => 'select2',
            'label' => 'وضعیت',
        ],
            function() { // if the filter is active
                return TraficPermitStatus::get_translated_array();
            } ,
            function($value) { // if the filter is active
                if($value == TraficPermitStatus::Recursive->value) {
                    $this->crud->addClause(function ($query) {
                        return $query->with('exports')->where('status', TraficPermitStatus::Active->value)->whereHas('exports', function ($q) {
                            $q->where('is_recursive', 1);
                        });
                    });
                } else {
                    $this->crud->addClause('where', 'status', $value); // apply the "active" eloquent scope
                }
            }
        );

        $this->crud->addFilter([
            'type'  => 'text',
            'name'  => 'serial_number',
            'label' => 'سریال',
          ],
          false,
          function($value) { // if the filter is active
            $this->crud->addClause('where', 'serial_number', '=', $value);
          });

        CRUD::filter('birthday')
            ->type('text')
            ->label('سال')
            ->whenActive(function($value) {
                $this->crud->addClause('whereHas', 'repository', function($query) use($value) {
                    $query->where('year', "$value-01-01");
                });
            });

        $this->crud->addFilter(
            [
                'name'  => 'truck',
                'type'  => 'select2',
                'label' => trans('unity::unity.truck_singular'),
            ],
            Truck::pluck('transit_number', 'id')->toArray(),
            function ($value) { // if the filter is active
                $this->crud->addClause('whereHas', 'exports' , function($exports) use($value) {

                    $exports->whereExists(function ($query) use($value) {
                        $query
                            ->select(DB::raw('*'))
                            ->from('permit_orders')
                            ->whereColumn('permit_orders.id', 'permit_order_id')
                            ->where('permit_order_trafic_permit.status', 1)
                            ->where('permit_order_trafic_permit.is_recursive', 0)
                            ->join('trucks', 'trucks.id', '=', 'permit_orders.truck_id')
                            ->where('trucks.id', $value);
                    });
                });
            }
        );

        $this->crud->addFilter(
            [
                'name'  => 'trailer',
                'type'  => 'select2',
                'label' => trans('unity::unity.trailer_singular'),
            ],
            Trailer::pluck('transit_number', 'id')->toArray(),
            function ($value) { // if the filter is active
                $this->crud->addClause('whereHas', 'exports' , function($exports) use($value) {

                    $exports->whereExists(function ($query) use($value) {
                        $query
                            ->select(DB::raw('*'))
                            ->from('permit_orders')
                            ->whereColumn('permit_orders.id', 'permit_order_id')
                            ->where('permit_order_trafic_permit.status', 1)
                            ->where('permit_order_trafic_permit.is_recursive', 0)
                            ->join('trailers', 'trucks.id', '=', 'permit_orders.trailer_id')
                            ->where('trailers.id', $value);
                    });
                });
            }
        );

        $this->crud->addColumns([
            [
                'label' => 'شرکت',
                'name' => 'export_unity',
                'type' => 'model_function',
                'function_name' => 'exportUnity',
            ],
            [
                'name'  => 'name',
                'label' => 'کشور', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getCountry', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 100, // Limit the number of characters shown
                'escaped' => false, // echo using {!! !!} instead of {{ }}, in order to render HTML
                'searchLogic' => function ($query, $column, $searchTerm) {
                    $query->orWhereHas('repository', function($repositories) use($searchTerm) {
                        $repositories->whereExists(function ($q) use($searchTerm) {
                            $q
                            ->select(DB::raw('*'))
                            ->from('countries')
                            ->whereColumn('countries.id', 'country_id')
                            // ->join('countries', 'repositories.country_id', '=', 'countries.id')
                            ->where('countries.fa_name', 'like', '%'.$searchTerm.'%')->orWhere('countries.en_name', 'like', '%'.$searchTerm.'%');
                        });

                    });
                }
            ],[
                'name'  => 'year',
                'label' => 'سال', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getYear'
            ],
            [
                'name'  => 'serial_number',
                'label' => 'سریال', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'serialNumber', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 1000, // Limit the number of characters shown
                // 'escaped' => false, // echo using {!! !!} instead of {{ }}, in order to render HTML
                'searchLogic' => function ($query, $column, $searchTerm) {
                    $query->orWhere('serial_number', 'like', '%'.$searchTerm.'%');
                }
            ],
            [
                'name' => 'types',
                'attribute' => 'title',
                'label' => 'نوع',
            ],
            [
                'name' => 'serial_number',
                'label' => 'سریال',
            ],
            [
                'name'  => 'status',
                'label' => 'وضعیت',
                'type'  => 'select_from_array',
                'options' => TraficPermitStatus::get_translated_array(),
            ],
            [
                'label' => 'محلت تحویل(روز)',
                'name' => 'exportDeadline',
                'type' => 'model_function',
                'function_name' => 'deadlineToComBack',
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'truck',
                'label' => 'وسیله نقلیه', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getTruck', // the method in your Model
                'escaped' => false,
                'limit' => 1000,
                'visibleInTable'  => false, // no point, since it's a large text
                'visibleInModal'  => false, // would make the modal too big
                'visibleInExport' => true, // not important enough
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'driver',
                'label' => 'راننده', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getOrderRelationAttributes', // the method in your Model
                'function_parameters' => ['driver', 'fa_name'],
                'visibleInTable'  => false, // no point, since it's a large text
                'visibleInModal'  => false, // would make the modal too big
                'visibleInExport' => true, // not important enough
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'destination',
                'label' => 'مقصد', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getOrderRelationAttributes', // the method in your Model
                'function_parameters' => ['destination', 'fa_name'],
                'visibleInTable'  => false, // no point, since it's a large text
                'visibleInModal'  => false, // would make the modal too big
                'visibleInExport' => true, // not important enough
            ],
            [
                // 1-n relationship
                'label'     => 'شماره کارنه', // Table column heading
                'type'      => 'model_function',
                'name'      => 'carnet_number', // the column that contains the ID of that connected entity;
                'function_name' => 'getOrderAttributes', // the method in your Model
                'function_parameters' => ['carnet_number'],
                'visibleInTable'  => false, // no point, since it's a large text
                'visibleInModal'  => false, // would make the modal too big
                'visibleInExport' => true, // not important enough
            ],
        ]);

    }

    protected function setupShowOperation()
    {
        $this->crud->addColumns([
            [
                'name'  => 'name',
                'label' => 'کشور', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getCountry', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 100, // Limit the number of characters shown
                'escaped' => false, // echo using {!! !!} instead of {{ }}, in order to render HTML
                // 'searchLogic' => function ($query, $column, $searchTerm) {
                //     $query->where('fa_name', 'like', '%'.$searchTerm.'%')->orWhere('en_name', 'like', '%'.$searchTerm.'%');
                // }
            ],
            [
                'name'  => 'serial_number',
                'label' => 'سریال', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'serialNumber', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                'limit' => 1000, // Limit the number of characters shown
                // 'escaped' => false, // echo using {!! !!} instead of {{ }}, in order to render HTML
                'searchLogic' => function ($query, $column, $searchTerm) {
                    $query->where('serial_number', 'like', '%'.$searchTerm.'%');
                }
            ],
            [
                'name' => 'types',
                'attribute' => 'title',
                'label' => 'نوع',
            ],
            [
                'name' => 'serial_number',
                'label' => 'سریال',
            ],
            [
                'name'  => 'status',
                'label' => 'وضعیت',
                'type'  => 'select_from_array',
                'options' => TraficPermitStatus::get_translated_array(),
            ],
        ]);

    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation($prefix = false)
    {
        $this->crud->setValidation(TraficPermitRequest::class);

        $this->crud->addFields([
            [   // relationship
                'type' => "relationship",
                'name' => 'repository', // the method on your model that defines the relationship
                'ajax' => true,
                // 'inline_create' => [ 'entity' => 'group' ], // specify the entity in singular
                'label' => 'مخزن',
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
                'minimum_input_length' => 0,
                // OPTIONALS:
                // 'label' => "Category",
                'attribute' => "full_name", // foreign key attribute that is shown to user (identifiable attribute)
                // 'entity' => 'Repository', // the method that defines the relationship in your Model
                // 'model' => "Modules\TraficPermit\Models\Repository", // foreign key Eloquent model
                'placeholder' => "انتخاب مخزن", // placeholder for the select2 input
            ],
            [
                'name' => 'serial_number',
                'label' => trans('traficpermit::traficpermit.serial_number'),
                'prefix' => '<i class="la la-qrcode"></i>',
                'suffix' => $prefix,
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ],
                'attributes' => [
                    'class' => 'form-control text-left'
                ]
            ],
            [ // Text
                'name'  => 'types',
                'label' => '<i class="la la-folder"></i>  '.trans('traficpermit::traficpermit.trafic_permit_type_singular'),
                'type'  => 'checklist',
                'entity' => 'types',
                // 'options' => $country->types->pluck('title', 'id')->toArray(),
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
            ],
            // [ // Text
            //     'name'  => 'status',
            //     'label' => '<i class="la la-flag-o"></i> وضعیت',
            //     'type'  => 'radio',
            //     'options' => TraficPermitStatus::get_translated_array(),
            //     'default' => TraficPermitStatus::Active->value,
            //     'wrapper'      => [
            //         'class'  => "form-group col-md-6"
            //     ],
            // ],
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
        $prefix = $this->crud->getCurrentEntry()->country->prefix;
        $this->setupCreateOperation($prefix);
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

    public function fetchRepository()
    {
        return $this->fetch(Repository::class);
    }
}
