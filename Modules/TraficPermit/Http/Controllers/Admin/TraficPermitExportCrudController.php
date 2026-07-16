<?php

namespace Modules\TraficPermit\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Operations\ExportOperation;
use App\Support\Export\ExportContext;
use App\Traits\DefaultPermissions;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Modules\TraficPermit\Http\Requests\TraficPermitExportRequest;
use Modules\TraficPermit\Models\Country;
use Modules\TraficPermit\Models\PermitOrder;
use Modules\TraficPermit\Models\TraficPermit;
use Modules\Unity\Models\Trailer;
use Modules\Unity\Models\Truck;
use Modules\Unity\Models\Unity;

/**
 * Class TraficPermitExportCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TraficPermitExportCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    // use \Rezahmady\SettingOperation\SettingOperation;
    use DefaultPermissions;
    use ExportOperation;
    Const ENTITY = 'TraficPermitExport';

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\Modules\TraficPermit\Models\TraficPermitExport::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/trafic-permit-export');
        CRUD::setEntityNameStrings(trans('traficpermit::traficpermit.trafic_permit_export_singular'), trans('traficpermit::traficpermit.trafic_permit_export_plural'));

        $this->crud->addClause('where', 'status' , 1);

        $this->setupExportDefaults();
        /*
        |--------------------------------------------------------------------------
        | PERMISSIONS
        |--------------------------------------------------------------------------
        */
        $this->setPermissions();

        (backpack_user()->can('TraficPermitReport manage all')) ? $this->crud->allowAccess('export') : $this->crud->denyAccess('export');
    }

    /**
     * Define eager-loaded relations for export to prevent N+1 queries.
     *
     * @return array
     */
    public function exportWithRelations(): array
    {
        return [
            'order.truck',
            'order.trailer',
            'order.driver',
            'order.destination',
            'order.unity',
            'traficpermit.repository.country',
        ];
    }

    /**
     * Custom filename for the XLSX export.
     */
    public function exportFileName(): string
    {
        return 'trafic_permit_export_' . now()->format('Ymd_His') . '.xlsx';
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // $this->crud->enableExportButtons();

        if(!backpack_user()->can('TraficPermitReport manage all') and backpack_user()->unity) {
            $unity_id = backpack_user()->unity->id;
            $this->crud->addClause('whereHas', 'order', function($query) use($unity_id) {
                $query->where('unity_id', $unity_id);
            });
        } elseif(!backpack_user()->can('TraficPermitReport manage all')) {
            abort(403);
        } else {
            $this->crud->addFilter(
                [
                    'name'  => 'unity',
                    'type'  => 'select2',
                    'label' => trans('unity::unity.unity_plural'),
                ],
                Unity::pluck('fa_name', 'id')->toArray(),
                function ($value) { // if the filter is active
                    $this->crud->addClause('whereHas', 'order', function($query) use($value) {
                        $query->where('unity_id', $value);
                    });
                }
            );
        }

        $this->crud->addFilter([
            'name'        => 'traficpermit',
            'type'        => 'text',
            'label'       => 'سریال مجوز',
            'placeholder' => '',
            'method'      => 'POST', // by default is GET
            // when returning a paginated instance you can specify the attribute and the key to be used:
            'select_attribute' => 'serial_number', // by default it's name
            'select_key' => 'id' // by default it's id
          ],
          url('api/traficpermit/all'), // the ajax route, you can also use FetchOperation here, just make sure you define `'method' => 'POST'` in your filter.
          function($value) { // if the filter is active
              $this->crud->addClause('whereHas', 'traficpermit', function($query) use($value) {
                $query->where('serial_number', $value);
              });
          });

        $this->crud->addFilter([
            'name'  => 'country',
            'type'  => 'select2_multiple',
            'label' => 'کشور',
        ],
            function() {
                return Country::all()->pluck('fa_name', 'id')->toArray();
            } ,
            function($value) {
                $this->crud->addClause('whereHas', 'traficpermit', function($query) use($value) {
                    $query->whereHas('repository',function($q) use($value) {
                        $q->where('country_id', json_decode($value));
                    });
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
                $this->crud->addClause('whereHas', 'order', function($query) use($value) {
                    $query->where('truck_id', $value);
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
                $this->crud->addClause('whereHas', 'order', function($query) use($value) {
                    $query->where('trailer_id', $value);
                });
            }
        );

        CRUD::filter('birthday')
            ->type('text')
            ->label('سال')
            ->whenActive(function($value) {
                $this->crud->addClause('whereHas', 'traficpermit', function($query) use($value) {
                    $query->whereHas('repository',function($q) use($value) {
                        $q->where('year', "$value-01-01");
                    });
                });
            });


        $this->crud->addColumns([
            [
                // 1-n relationship
                'label'     => 'مشخصات مجوز', // Table column heading
                'type'      => 'select',
                'name'      => 'permit-order', // the column that contains the ID of that connected entity;
                'entity'    => 'traficpermit', // the method that defines the relationship in your Model
                'attribute' => 'full_name', // foreign key attribute that is shown to user
                'escaped' => false,
                'limit' => 1000,
            ],
            [
                // 1-n relationship
                'label'     => 'شماره سریال مجوز', // Table column heading
                'type'      => 'select',
                'name'      => 'traficpermit_serial_number', // the column that contains the ID of that connected entity;
                'entity'    => 'traficpermit', // the method that defines the relationship in your Model
                'attribute' => 'serial_number', // foreign key attribute that is shown to user
                'exportOnlyField' => true,
                'visibleInTable' => false
            ],
            [
                // 1-n relationship
                'label'     => 'کشور مجوز', // Table column heading
                'type'      => 'select',
                'name'      => 'traficpermit_country_fa_name', // the column that contains the ID of that connected entity;
                'type'  => 'model_function',
                'function_name' => 'getCountry', // the method in your Model
                'escaped' => false,
                'limit' => 1000,// foreign key attribute that is shown to user
                // 'exportOnlyField' => true,
                // 'visibleInTable' => false
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'unity',
                'label' => 'شرکت', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getOrderRelationAttributes', // the method in your Model
                'function_parameters' => ['unity', 'fa_name'],
            ],
            // [
            //     // run a function on the CRUD model and show its return value
            //     'name'  => 'truck',
            //     'label' => 'کشنده', // Table column heading
            //     'type'  => 'model_function',
            //     'function_name' => 'getOrderRelationAttributes', // the method in your Model
            //     'function_parameters' => ['truck', 'transit_number'],
            // ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'truck',
                'label' => 'وسیله نقلیه', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getTruck', // the method in your Model
                'escaped' => false,
                'limit' => 1000,
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'driver',
                'label' => 'راننده', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getOrderRelationAttributes', // the method in your Model
                'function_parameters' => ['driver', 'fa_name'],
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'destination',
                'label' => 'مقصد', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getOrderRelationAttributes', // the method in your Model
                'function_parameters' => ['destination', 'fa_name'],
            ],
            [
                // 1-n relationship
                'label'     => 'شماره کارنه', // Table column heading
                'type'      => 'select',
                'name'      => 'carnet_number', // the column that contains the ID of that connected entity;
                'entity'    => 'order', // the method that defines the relationship in your Model
                'attribute' => 'carnet_number', // foreign key attribute that is shown to user
            ],
            [
                'name' => 'export_date',
                'label' => 'تاریخ صدور',
            ],
            [
                'name' => 'get_carcasses_at',
                'type'  => 'model_function',
                'function_name' => 'receivedDate',
                'label' => 'تاریخ تحویل',
            ],
            [
                'name'  => 'year',
                'label' => 'سال', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getYear'
            ],
        ]);
    }

    public function setupExportOperation() {
        $this->setupListOperation();

        $this->crud->removeColumn('permit-order');
        $this->crud->removeColumn('truck');
        CRUD::addColumns([
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'truck',
                'label' => 'وسیله نقلیه', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getTruckOnly', // the method in your Model
                'escaped' => false,
                'limit' => 1000,
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'trailer',
                'label' => 'کشنده', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getTrailerOnly', // the method in your Model
                'escaped' => false,
                'limit' => 1000,
            ],
            [
                'name'  => 'year',
                'label' => 'سال', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getYear'
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
        CRUD::setValidation(TraficPermitExportRequest::class);


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
