<?php

namespace Modules\TraficPermit\Http\Controllers\Admin;

use App\Traits\DefaultPermissions;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Modules\TraficPermit\Http\Requests\TotalTraficPermitReportRequest;
use Modules\TraficPermit\Models\Country;

/**
 * Class TotalTraficPermitReportCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TotalTraficPermitReportCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    // use \Rezahmady\SettingOperation\SettingOperation;
    use DefaultPermissions;
    Const ENTITY = 'TotalTraficPermitReport';

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\Modules\TraficPermit\Models\Repository::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/total-trafic-permit-report');
        CRUD::setEntityNameStrings(trans('traficpermit::traficpermit.total_trafic_permit_report_singular'), trans('traficpermit::traficpermit.total_trafic_permit_report_plural'));

        $this->crud->query->distinct('country_id')->pluck('country_id');

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
        // fields
        $this->crud->addColumns([
            [
                'name'  => 'country',
                'label' => 'کشور',
                'attribute' => 'fa_name', 
                'type'  => 'relationship',
                'searchLogic' => function ($query, $column, $searchTerm) {
                    $query->whereHas('country', function($query) use($searchTerm) {
                        $query->where('fa_name', 'like', '%'.$searchTerm.'%')->orWhere('en_name', 'like', '%'.$searchTerm.'%');
                    });
                }
            ],
            [
                'name' => 'types',
                'attribute' => 'title',
                'label' => 'نوع',
            ],
            [
                'name' => 'qty',
                'label' => 'تعداد',
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'year',
                'label' => 'سال', // Table column heading
                'type'  => 'date',
                'format' => 'Y'
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'end_date',
                'label' => 'تاریخ اعتبار', // Table column heading
                'type'  => 'date',
                'format' => 'Y/M/D'
            ],
            [
                'name'  => 'status',
                'label' => 'وضعیت',
                'type'  => 'model_function',
                'function_name' => 'getStatusBrowse',
            ],
        ]);

        $this->crud->addFilter([
            'name'  => 'country',
            'type'  => 'select2',
            'label' => 'کشور',
        ],
          function() { // if the filter is active
            return Country::all()->pluck('fa_name', 'id')->toArray();
          } ,
          function($value) { // if the filter is active
            $this->crud->addClause('where', 'country_id', $value); // apply the "active" eloquent scope
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
        // CRUD::setValidation(TotalTraficPermitReportRequest::class);

        
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
