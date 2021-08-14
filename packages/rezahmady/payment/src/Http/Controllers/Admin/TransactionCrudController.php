<?php

namespace Rezahmady\Payment\Http\Controllers\Admin;

use Rezahmady\Payment\Http\Requests\TransactionRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TransactionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TransactionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Rezahmady\SettingOperation\SettingOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\Rezahmady\Payment\Models\Transaction::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/transaction');
        CRUD::setEntityNameStrings('تراکنش', 'تراکنش ها');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->enableExportButtons();

        CRUD::addColumns([
            [
                'name'          => 'user',
                'label'         => 'کاربر',
                'type'          => 'model_function',
                'function_name' => 'getUserBrowse',
            ],
            [
                'name'          => 'amount',
                'label'         => 'مبلغ <small>(ریال)</small>',
                'type'          => 'model_function',
                'function_name' => 'getAmountBrowse',
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
            [
                'name'          => 'transactionId',
                'label'         => 'شناسه',
                'type'          => 'model_function',
                'function_name' => 'getTransactionIdBrowse',
            ],
            [
                'name'          => 'drive',
                'label'         => 'درگاه',
                'type'          => 'model_function',
                'function_name' => 'getDriveBrowse',
            ],
        ]);

        // Filters
        $this->crud->addFilter([
            'name'  => 'status',
            'type'  => 'dropdown',
            'label' => 'وضعیت'
          ], [
            1 => 'پرداخت شده',
            0 => 'عدم پرداخت',
          ], function($value) {
            $this->crud->addClause('where', 'status', $value);
          }
        );

        $this->crud->addFilter([
            'name'  => 'driver',
            'type'  => 'dropdown',
            'label' => 'درگاه'
          ], [
            'zarinpal' => trans("rezahmady.payment::payment.drivers.zarinpal"),
            'idpay' => trans("rezahmady.payment::payment.drivers.idpay"),
            'behpardakht' => trans("rezahmady.payment::payment.drivers.behpardakht"),
            'saman' => trans("rezahmady.payment::payment.drivers.saman"),
          ], function($value) {
            $this->crud->addClause('where', 'driver', $value);
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
            'name'  => 'transactionId',
            'label' => 'شناسه'
          ], 
          false, 
          function($value) { // if the filter is active
            $this->crud->addClause('where', 'transactionId', 'LIKE', "%$value%");
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

        /**
    * Define what happens when the Setting operation is loaded.
    * 
    * @see https://github.com/rezahmady/setting-operation
    * @return void
    */
    protected function setupSettingOperation()
    {
        // backpack fields
        $this->crud->addFields([
            [
                'name'    => 'drivers',
                'type'    => 'select2_from_array',
                'label'   => 'درگاه های فعال',
                'hint' => 'درگاه هایی که کاربر می تواند پیش از پرداخت انتخاب کند. لطفا پس از فعال کردن هر درگاه تنظیمات آن را در همین صفحه وارد کنید',
                'options' => [
                    'idpay'       => 'آیدی پی',
                    'zarinpal'    => 'زرین پال',
                    'behpardakht' => 'به پرداخت ملت',
                    'saman'       => 'سامان'
                ],
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
                'allows_null' => true,
                'allows_multiple' => true
            ],
            [
                'name'    => 'default_driver',
                'type'    => 'select2_from_array',
                'label'   => 'درگاه پیش فرض',
                'options' => [
                    'idpay'       => 'آیدی پی',
                    'zarinpal'    => 'زرین پال',
                    'behpardakht' => 'به پرداخت ملت',
                    'saman'       => 'سامان'
                ],
                'allows_null' => false,
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
            ],

            // zarinpal
            [
                'name'    => 'zarinpal_merchantId',
                'type'    => 'text',
                'label'   => 'merchantId',
                'tab'     => 'زرین پال',
                'wrapper'      => [
                    'class'  => "form-group col-md-6 ltr"
                ],
            ],
            [
                'name'    => 'zarinpal_mode',
                'type'    => 'select2_from_array',
                'label'   => 'حالت درگاه',
                'options' => [
                    'normal'    => 'درگاه معمولی',
                    'zaringate' => 'زرین گیت',
                    'sandbox'   => 'حالت آزمایشی',
                ],
                'allows_null' => false,
                'tab'     => 'زرین پال',
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
            ],
            [
                'name'  => 'zarinpal_logo',
                'label' => 'تصویر لوگو',
                'type'  => 'browse',
                'tab'     => 'زرین پال',
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
            ],

            // idpay
            [
                'name'    => 'idpay_merchantId',
                'type'    => 'text',
                'label'   => 'merchantId',
                'tab'     => 'آیدی پی',
                'wrapper'      => [
                    'class'  => "form-group col-md-6 ltr"
                ],
            ],
            [
                'name' => 'idpay_sandbox',
                'label' => 'sandbox',
                'type' => 'toggle',
                'tab'     => 'آیدی پی',
                'wrapper'      => [
                    'class'  => "form-group col-md-6 ltr"
                ],
            ],
            [
                'name'  => 'idpay_logo',
                'label' => 'تصویر لوگو',
                'type'  => 'browse',
                'tab'     => 'آیدی پی',
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
            ],

            // behpardakht
            [
                'name'    => 'behpardakht_terminalId',
                'type'    => 'text',
                'label'   => 'terminalId',
                'tab'     => 'به پرداخت ملت',
                'wrapper'      => [
                    'class'  => "form-group col-md-6 ltr"
                ],
            ],
            [
                'name'    => 'behpardakht_username',
                'type'    => 'text',
                'label'   => 'نام کاربری',
                'tab'     => 'به پرداخت ملت',
                'wrapper'      => [
                    'class'  => "form-group col-md-6 ltr"
                ],
            ],
            [
                'name'    => 'behpardakht_password',
                'type'    => 'text',
                'label'   => 'رمز عبور',
                'tab'     => 'به پرداخت ملت',
                'wrapper'      => [
                    'class'  => "form-group col-md-6 ltr"
                ],
            ],
            [
                'name'  => 'behpardakht_logo',
                'label' => 'تصویر لوگو',
                'type'  => 'browse',
                'tab'     => 'به پرداخت ملت',
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
            ],

            // saman
            [
                'name'    => 'saman_merchantId',
                'type'    => 'text',
                'label'   => 'merchantId',
                'tab'     => 'سامان',
                'wrapper'      => [
                    'class'  => "form-group col-md-6 ltr"
                ],
            ],
            [
                'name'  => 'saman_logo',
                'label' => 'تصویر لوگو',
                'type'  => 'browse',
                'tab'     => 'سامان',
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
            ],

        ]);
    }
}
