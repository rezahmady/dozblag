<?php

namespace Modules\TraficPermit\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Operations\ExportOperation;
use App\Traits\DefaultPermissions;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\DB;
use Modules\TraficPermit\Enums\TransactionType;
use Modules\TraficPermit\Http\Requests\TransactionRequest;
use Modules\TraficPermit\Models\Transaction;
use Modules\Unity\Models\Driver;
use Modules\Unity\Models\Truck;
use Modules\Unity\Models\Unity;

/**
 * Class TransactionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TransactionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
    use \Rezahmady\SettingOperation\SettingOperation;
    use DefaultPermissions;
    use ExportOperation;
    Const ENTITY = 'TraficPermitTransaction';

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\Modules\TraficPermit\Models\Transaction::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/transaction');
        CRUD::setEntityNameStrings(trans('traficpermit::traficpermit.transaction_singular'), trans('traficpermit::traficpermit.transaction_plural'));

        $this->setupExportDefaults();

        /*
        |--------------------------------------------------------------------------
        | PERMISSIONS
        |--------------------------------------------------------------------------
        */
        $this->setPermissions();

        (backpack_user()->can('TraficPermitTransaction manage all')) ? $this->crud->allowAccess('export') : $this->crud->denyAccess('export');
    }

    /**
     * Eager-load relations used during export to prevent N+1 queries.
     */
    public function exportWithRelations(): array
    {
        return [
            'unity',
            'export.order.truck',
            'export.order.trailer',
            'export.order.driver',
        ];
    }

    /**
     * Custom filename for the XLSX file.
     */
    public function exportFileName(): string
    {
        return 'transaction_' . now()->format('Ymd_His') . '.xlsx';
    }


    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {

        CRUD::column('id')->label('#');

        if(!backpack_user()->can('TraficPermitTransaction manage all') and backpack_user()->unity) {
            $this->crud->addClause('where', 'unity_id', '=', backpack_user()->unity->id);
        } elseif(!backpack_user()->can('TraficPermitTransaction manage all')) {
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

            // $this->crud->addFilter(
            //     [
            //         'name'  => 'truck',
            //         'type'  => 'select2',
            //         'label' => trans('unity::unity.truck_singular'),
            //     ],
            //     Truck::pluck('transit_number', 'id')->toArray(),
            //     function ($value) { // if the filter is active
            //         $this->crud->addClause('whereHas', 'export', function($query) use($value) {
            //             $query->where('truck_id', $value);
            //         });
            //     }
            // );

            $this->crud->addFilter(
                [
                    'name'  => 'driver',
                    'type'  => 'select2',
                    'label' => trans('unity::unity.driver_singular'),
                ],
                Driver::pluck('fa_name', 'id')->toArray(),
                function ($value) { // if the filter is active
                    $this->crud->addClause('whereHas', 'export', function($query) use($value) {
                        $query->where('driver_id', $value);
                    });
                }
            );
        }

        $this->crud->addColumn([
            'name' => 'truck',
            'label' => trans('unity::unity.truck_singular'),
            'type'  => 'model_function',
            'function_name' => 'getTruckName',
        ]);

        $this->crud->addColumn([
            'name' => 'driver',
            'label' => trans('unity::unity.driver_singular'),
            'type'  => 'model_function',
            'function_name' => 'getDriverName',
        ]);

        $this->crud->addColumn([
            'name' => 'type',
            'label' => 'نوع',
            'type'  => 'model_function',
            'function_name' => 'getType',
        ]);

        $this->crud->addColumn([
            'name' => 'amount',
            'type'  => 'model_function',
            'function_name' => 'getAmount',
            'label' => 'مبلغ'
        ]);

        $this->crud->addColumn([
            // 1-n relationship
            'label'     => 'تاریخ', // Table column heading
            'type'      => 'model_function',
            'name'      => 'date', // the column that contains the ID of that connected entity;
            'function_name' => 'getDate', // the method in your Model
        ]);

        $this->crud->addFilter([
            'name'  => 'status',
            'type'  => 'select2',
            'label' => 'نوع',
        ],
            function() { // if the filter is active
                return TransactionType::get_translated_array();
            } ,
            function($value) { // if the filter is active
                $this->crud->addClause('where', 'type', $value); // apply the "active" eloquent scope
            }
        );
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(TransactionRequest::class);

        Transaction::creating(function($entry) {
            $entry->type = 'deposit';
        });

        $this->crud->addFields([
            [   // relationship
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
            ],
            [
                'type' => 'number',
                'name' => 'amount',
                'label' => 'مبلغ',
                'prefix' => '<i class="la la-dollar"></i>',
                'suffix' => 'تومان',
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
            ],
            [
                'name' => 'transactionId',
                'label' => 'شماره تراکنش',
                'prefix' => '<i class="la la-qrcode"></i>',
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
            ],
            [
                'name' => 'date',
                'label' => 'تاریخ',
                'type' => 'jdate_picker',
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
                'date_picker_options' => [
                    'autoClose' => true,
                    // 'initialValue' => false
                ],
            ],
            [
                'name'    => 'description',
                'type'    => 'summernote',
                'options' => [
                    'toolbar' => [],
                ],
                'wrapper'      => [
                    'class'  => "form-group col-md-12"
                ],
                'label'   => 'توضیحات',
            ],
        ]);

        CRUD::field('amount');
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
        $this->crud->addFields([
            [
                'type' => 'number',
                'name' => 'tax',
                'label' => 'مالیات',
                'prefix' => '<i class="la la-dollar"></i>',
                'suffix' => '%',
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
            ],
            [
                'type' => 'number',
                'name' => 'default_price',
                'label' => 'قیمت فروش اصلی',
                'prefix' => '<i class="la la-dollar"></i>',
                'suffix' => 'تومان',
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
            ],
            [   // repeatable
                'name'  => 'second_prices',
                'label' => 'قیمت های فرعی',
                'type'  => 'repeatable',
                'subfields' => [
                    [
                        'type' => 'number',
                        'name' => 'price',
                        'label' => 'قیمت',
                        'prefix' => '<i class="la la-dollar"></i>',
                        'suffix' => 'تومان',
                        'wrapper'      => [
                            'class'  => "form-group col-md-12"
                        ],
                    ],
                ],

                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],

                // optional
                'new_item_label'  => 'افزودن قیمت', // customize the text of the button
                'init_rows' => 0, // number of empty rows to be initialized, by default 1
                'min_rows' => 0,
                'max_rows' => 5,
                'reorder' => true,
            ],
        ]);
    }

    public function fetchUnity()
    {
        return $this->fetch(Unity::class);
    }
}
