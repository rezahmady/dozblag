<?php

namespace Modules\TraficPermit\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Operations\ExportOperation;
use App\Support\Export\ExportContext;
use App\Traits\DefaultPermissions;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Modules\TraficPermit\Enums\TraficPermitStatus;
use Modules\TraficPermit\Http\Requests\TraficPermitRequest;
use Modules\TraficPermit\Models\Country;
use Modules\TraficPermit\Models\Repository;
use Modules\TraficPermit\Models\TraficPermitExport;
use Modules\TraficPermit\Models\TraficPermitType;
use Modules\Unity\Models\Trailer;
use Modules\Unity\Models\Truck;
use Modules\Unity\Models\Unity;

/**
 * Class TraficPermitCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TraficPermitReportCrudController extends CrudController
{
//    use ExportOperation;
    // use \RedSquirrelStudio\LaravelBackpackExportOperation\ExportOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    //use \Modules\Unity\Http\Controllers\Admin\Operations\RestoreOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Rezahmady\SettingOperation\SettingOperation;
    // use CarcassDeliveryOperation;
    // use CorrectionTraficPermitOperation;
    // use UndoCorrectionTraficPermitOperation;
    // use UndoExportTraficPermitOperation;
    use FetchOperation;
    use DefaultPermissions;
    use ExportOperation;
    Const ENTITY = 'TraficPermitReport';

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\Modules\TraficPermit\Models\TraficPermit::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/trafic-permit-report');
        CRUD::setEntityNameStrings(trans('traficpermit::traficpermit.trafic_permit_singular'), trans('traficpermit::traficpermit.trafic_permit_plural'));

        $this->crud->query->orderByRaw("CASE
                    WHEN status = 'issued' THEN 1
                    ELSE 2
                  END")
        ->orderBy('status')
        ->select('*')
            ->with(['exports' => function($query) {
                $query->where('status', 1)->latest();
            }])
            ->orderByRaw('ISNULL(60 - DATEDIFF(NOW(), (SELECT MAX(date) FROM permit_order_trafic_permit WHERE permit_order_trafic_permit.status = 1 AND permit_order_trafic_permit.trafic_permit_id = trafic_permits.id))) DESC')
            ->orderByRaw('(60 - DATEDIFF(NOW(), (SELECT MAX(date) FROM permit_order_trafic_permit WHERE permit_order_trafic_permit.status = 1 AND permit_order_trafic_permit.trafic_permit_id = trafic_permits.id))) ASC');
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
     * Define eager loading relations used during export to prevent N+1 queries.
     *
     * Only string-based dot-notation relations are allowed here.
     * Closures cannot be serialized by the queue system.
     *
     * The exports() relationship already applies where('status', 1) internally,
     * so filtering is preserved without needing a closure.
     *
     * @return array
     */
    public function exportWithRelations(): array
    {
        return [
            'repository.country',
            'types',
        ];
    }

    /**
     * Preload data needed by model accessors to avoid N+1 queries during export.
     *
     * For each TraficPermit, the columns repeatedly call
     * `$this->exports()->latest()->where('status', 1)->first()`. On a
     * million-row table that is millions of queries.
     *
     * Here we pre-compute, in one grouped query, the latest active export
     * for every trafic_permit_id that will appear in the result set, and
     * stash it in ExportContext for the model methods to read instead of
     * re-querying.
     *
     * @param Builder $base The fully-filtered base query (clone of crud->query)
     */
    public function exportPreloadCallback(Builder $base): void
    {
        // Get the list of trafic_permit IDs the export will touch.
        // We iterate this in chunks too, to keep memory flat.
        $ids = (clone $base)->toBase()->pluck($base->getModel()->getQualifiedKeyName());

        if ($ids->isEmpty()) {
            return;
        }

        // Find the latest active export per trafic_permit_id
        $latestIdsSub = TraficPermitExport::query()
            ->select(DB::raw('MAX(id) as id'))
            ->where('status', 1)
            ->whereIn('trafic_permit_id', $ids)
            ->groupBy('trafic_permit_id');

        // Eager-load every relation that the model methods reach into.
        $exports = TraficPermitExport::query()
            ->whereIn('id', $latestIdsSub)
            ->with([
                'order.truck',
                'order.trailer',
                'order.driver',
                'order.destination',
                'order.unity',
            ])
            ->get();

        $map = [];
        foreach ($exports as $export) {
            $map[$export->trafic_permit_id] = $export;
        }

        ExportContext::put('latest_export_per_permit', $map);
    }

    /**
     * Custom filename for the XLSX file.
     */
    public function exportFileName(): string
    {
        return 'trafic_permit_report_' . now()->format('Ymd_His') . '.xlsx';
    }

    public function setupExportOperation()
    {
        $this->setupListOperation();

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
        ]);
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
//        $this->crud->enableExportButtons();

        if(!backpack_user()->can('TraficPermitReport manage all') and backpack_user()->unity) {

            $unity_id = backpack_user()->unity->id;

            $this->crud->addClause('whereHas', 'exports' , function($exports) use($unity_id) {
                $exports->whereExists(function ($query) use($unity_id) {
                    $query
                    ->select(DB::raw('*'))
                    ->from('permit_orders')
                    ->whereColumn('permit_orders.id', 'permit_order_id')
                    ->where('permit_order_trafic_permit.is_recursive', 0)
                    ->where('permit_order_trafic_permit.status', 1)
                    ->join('unities', 'unities.id', '=', 'permit_orders.unity_id')
                    ->where('unities.id', $unity_id);
                });
            });

        } elseif(!backpack_user()->can('TraficPermitReport manage all')) {
            abort(403);
        } else {
            $this->crud->addColumn([
                    'label' => 'شرکت',
                    'name' => 'export_unity',
                    'type' => 'model_function',
                    'function_name' => 'exportUnity',
            ]);

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

            $this->crud->addFilter(
                [
                    'name'  => 'recursive_unity',
                    'type'  => 'select2',
                    'label' => 'شرکت (بازگشتی)',
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
                                ->where('permit_order_trafic_permit.is_recursive', 1)
                                ->join('unities', 'unities.id', '=', 'permit_orders.unity_id')
                                ->where('unities.id', $value);

                        });
                    });
                }
            );

            $this->crud->addFilter(
                [
                    'name'  => 'country',
                    'type'  => 'select2_multiple',
                    'label' => 'کشور',
                ],
                function() {
                    return Country::all()->pluck('fa_name', 'id')->toArray();
                } ,
                function($value) {
                    $this->crud->addClause('whereHas', 'repository', function($query) use($value) {
                        $query->where('country_id', json_decode($value));
                    });
                }
            );

            CRUD::filter('year')
                ->type('text')
                ->label('سال')
                ->whenActive(function($value) {
                    $this->crud->addClause('whereHas', 'repository', function($query) use($value) {
                        $query->where('year', "$value-01-01");
                    });
                });



            $this->crud->addFilter([
                'type'  => 'text',
                'name'  => 'serial_number',
                'label' => 'سریال',
            ],
                false,
                function($value) { // if the filter is active
                    $this->crud->addClause('where', 'serial_number', '=', $value);
                });

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
                                ->where('permit_order_trafic_permit.is_recursive', 0)
                                ->where('permit_order_trafic_permit.status', 1)
                                ->join('trucks', 'trucks.id', '=', 'permit_orders.truck_id')
                                ->where('trucks.id', $value);
                        });
                    });
                }
            );

            $this->crud->addFilter(
                [
                    'name'  => 'recursive_truck',
                    'type'  => 'select2',
                    'label' => 'وسیله نقلیه (بازگشتی)',
                ],
                Truck::pluck('transit_number', 'id')->toArray(),
                function ($value) { // if the filter is active
                    $this->crud->addClause('whereHas', 'exports' , function($exports) use($value) {

                        $exports->whereExists(function ($query) use($value) {
                            $query
                                ->select(DB::raw('*'))
                                ->from('permit_orders')
                                ->whereColumn('permit_orders.id', 'permit_order_id')
                                ->where('permit_order_trafic_permit.is_recursive', 1)
                                ->where('permit_order_trafic_permit.status', 1)
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
                                ->where('permit_order_trafic_permit.is_recursive', 0)->where('permit_order_trafic_permit.status', 1)
                                ->join('trailers', 'trucks.id', '=', 'permit_orders.trailer_id')
                                ->where('trailers.id', $value);
                        });
                    });
                }
            );
        }

        $this->crud->addColumns([

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
                'type'      => 'model_function',
                'name'      => 'carnet_number', // the column that contains the ID of that connected entity;
                'function_name' => 'getOrderAttributes', // the method in your Model
                'function_parameters' => ['carnet_number'],
            ],
            [
                'label' => 'تاریخ صدور',
                'name' => 'export_date',
                'type' => 'model_function',
                'function_name' => 'exportDate',
            ],
            [
                // 1-n relationship
                'label'     => 'تاریخ درخواست', // Table column heading
                'type'      => 'model_function',
                'name'      => 'order_date', // the column that contains the ID of that connected entity;
                'function_name' => 'getOrderAttributes', // the method in your Model
                'function_parameters' => ['created_at', 'date'],
            ],
            [
                'label' => 'تاریخ دریافت لاشه',
                'name' => 'carcass_delivery_date',
                'type' => 'model_function',
                'function_name' => 'getCarcassDelivery',
            ],
            [
                // 1-n relationship
                'label'     => 'تاریخ کارنه\u200cتیر', // Table column heading
                'type'      => 'model_function',
                'name'      => 'carnet_date', // the column that contains the ID of that connected entity;
                'function_name' => 'getOrderAttributes', // the method in your Model
                'function_parameters' => ['carnet_date', 'date'],
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

    public function normalize_persian_numbers($string) {
        $persian = ['\u06f0', '\u06f1', '\u06f2', '\u06f3', '\u06f4', '\u06f5', '\u06f6', '\u06f7', '\u06f8', '\u06f9'];
        $arabic = ['\u0660', '\u0661', '\u0662', '\u0663', '\u0664', '\u0665', '\u0666', '\u0667', '\u0668', '\u0669'];

        $num = range(0, 9);
        $convertedPersianNums = str_replace($persian, $num, $string);
        $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);

        return $englishNumbersOnly;
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
