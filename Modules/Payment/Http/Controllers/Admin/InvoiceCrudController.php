<?php

namespace Modules\Payment\Http\Controllers\Admin;

use Modules\Payment\Http\Requests\InvoiceRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class InvoiceCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class InvoiceCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\Modules\Payment\Models\Invoice::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/invoice');
        CRUD::setEntityNameStrings('صورت حساب', 'صورت حساب ها');
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
                'name'          => 'user',
                'label'         => 'کاربر',
                'type'          => 'model_function',
                'function_name' => 'getUserBrowse',
            ],
            [
                // any type of relationship
                'name'         => 'invoiceable', // name of relationship method in the model
                'type'         => 'relationship',
                'label'        => 'اشتراک', // Table column heading
                // OPTIONAL
                // 'entity'    => 'tags', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                // 'model'     => App\Models\Category::class, // foreign key model
            ],
            [
                'name'          => 'amount',
                'label'         => 'مبلغ <small>(ریال)</small>',
                'type'          => 'model_function',
                'function_name' => 'getAmountBrowse',
            ],
            [
                // any type of relationship
                'name'         => 'discount', // name of relationship method in the model
                'type'         => 'relationship',
                'label'        => 'تخفیف', // Table column heading
                // OPTIONAL
                // 'entity'    => 'tags', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                // 'model'     => App\Models\Category::class, // foreign key model
            ],
            [
                'name'          => 'date',
                'label'         => 'تاریخ',
                'type'          => 'model_function',
                'function_name' => 'getDateBrowse',
            ],
            [
                'name' => 'status',
                'type' => 'model_function',
                'function_name' => 'getStatusBrowse',
                'label' => 'وضعیت'
            ],
        ]);

        // Filter

        $this->crud->addFilter([
            'name'  => 'status',
            'type'  => 'dropdown',
            'label' => 'وضعیت'
          ], [
            1 => 'پرداخت شده',
            0 => 'عدم پرداخت',
          ], function($value) {
            $this->crud->addClause('whereHas', 'transactions', function($q) use ($value) {
                if($value) {
                    $q->where('status',1);
                } else {
                    $q->where('status',0);
                }

            });
          }
        );


        $this->crud->addFilter([
            'type'  => 'text',
            'name'  => 'amount',
            'label' => 'مبلغ'
          ],
          false,
          function($value) { // if the filter is active
            $this->crud->addClause('where', 'amount', $value);
          }
        );

        $this->crud->addFilter([
            'type'  => 'text',
            'name'  => 'discount',
            'label' => 'کد تخفیف'
          ],
          false,
          function($value) { // if the filter is active
            $this->crud->addClause('whereHas', 'discount', function($q) use ($value) {
                $q->where('name',$value);
            });
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
        CRUD::setValidation(InvoiceRequest::class);



        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
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
}
