<?php

namespace Modules\TraficPermit\Http\Controllers\Admin;

use App\Traits\DefaultPermissions;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Modules\TraficPermit\Http\Requests\CorrectedExportRequest;
use Modules\TraficPermit\Models\Country;
use Modules\Unity\Models\Unity;

/**
 * Class CorrectedExportCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CorrectedExportCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    // use \Rezahmady\SettingOperation\SettingOperation;
    use DefaultPermissions;
    Const ENTITY = 'CorrectedExport';

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\Modules\TraficPermit\Models\TraficPermit::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/corrected-export');
        CRUD::setEntityNameStrings(trans('traficpermit::traficpermit.corrected_export_singular'), trans('traficpermit::traficpermit.corrected_export_plural'));

        $this->crud->query->whereHas('exports', operator: '>', count: 1);

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
        
        // $this->crud->enableExportButtons();
        // $this->crud->addFilter(
        //     [
        //         'name'  => 'unity',
        //         'type'  => 'select2',
        //         'label' => trans('unity::unity.unity_plural'),
        //     ],
        //     Unity::pluck('fa_name', 'id')->toArray(),
        //     function ($value) { // if the filter is active
        //         $this->crud->addClause('whereHas', 'exports' , function($exports) use($value) {

        //             $exports->whereExists(function ($query) use($value) {
        //                 $query
        //                 ->select(DB::raw('*'))
        //                 ->from('permit_orders')
        //                 ->whereColumn('permit_orders.id', 'permit_order_id')
        //                 // ->join('permit_order_trafic_permit', 'permit_order_trafic_permit.permit_order_id', '=', 'permit_orders.id')
        //                 ->where('permit_order_trafic_permit.status', 1)
                        
        //                 ->join('unities', 'unities.id', '=', 'permit_orders.unity_id')
        //                 ->where('unities.id', $value);
        //             });
        //         });
        //     }
        // );

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
            'type'  => 'date',
            'name'  => 'year',
            'label' => 'سال',
            'date_picker_options' => [
                'format'   => 'yyyy',
                'language' => 'en',
                'minViewMode' => 'years'
            ],
          ],
            false,
          function ($value) { // if the filter is active, apply these constraints
            $this->crud->addClause('whereHas', 'repository', function($repository) use( $value) {
                $repository->whereYear('year', $value);
            });
          });

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
                'label' => 'اصلاحات',
                'name' => 'exports_count',
                'type' => 'model_function',
                'function_name' => 'getExportCount',
                'escaped' => false,
                'limit' => 1000
            ]
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
        CRUD::setValidation(CorrectedExportRequest::class);

        
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
