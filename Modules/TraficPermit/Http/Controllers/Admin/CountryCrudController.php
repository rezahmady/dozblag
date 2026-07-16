<?php

namespace Modules\TraficPermit\Http\Controllers\Admin;

use App\Traits\DefaultPermissions;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Modules\TraficPermit\Http\Requests\CountryRequest;
use App\Traits\DropzoneTrait;

/**
 * Class CountryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CountryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    // use \Rezahmady\SettingOperation\SettingOperation;
    use DefaultPermissions;
    use DropzoneTrait;
    Const ENTITY = 'Country';

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\Modules\TraficPermit\Models\Country::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/country');
        CRUD::setEntityNameStrings(trans('traficpermit::traficpermit.country_singular'), trans('traficpermit::traficpermit.country_plural'));

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
        $this->crud->addColumns([
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'name',
                'label' => 'نام', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'fullname', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                // 'limit' => 100, // Limit the number of characters shown
                'escaped' => false, // echo using {!! !!} instead of {{ }}, in order to render HTML
                'searchLogic' => function ($query, $column, $searchTerm) {
                    $query->where('fa_name', 'like', '%'.$searchTerm.'%')->orWhere('en_name', 'like', '%'.$searchTerm.'%');
                }
            ],
            [
                'name' => 'amount',
                'label' => 'قیمت',
                'type' => 'model_function',
                'function_name' => 'getAmountBrows',
            ],
            [
                'name'  => 'can_duplicate',
                'label' => 'سفارش مجدد',
                'type'  => 'check',
            ],
            [
                'name'  => 'status',
                'label' => 'وضعیت',
                'type'  => 'model_function',
                'function_name' => 'getStatusBrowse',
            ],
        ]);

        $this->crud->addFilter([
            'name'  => 'status',
            'type'  => 'select2',
            'label' => 'وضعیت',
        ],
          function() { // if the filter is active
            return [
                1 => 'فعال',
                0 => 'غیرفعال'
            ];
          } ,
          function($value) { // if the filter is active
            $this->crud->addClause('where', 'status', $value); // apply the "active" eloquent scope
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
        CRUD::setValidation(CountryRequest::class);

        $this->crud->addFields([
            [
                'name'  => 'fa_name',
                'label' => 'عنوان فارسی',
                'prefix' => '<i class="la la-pencil-square"></i>',
                'attributes' => [
                    // 'placeholder' => '',
                    'class'       => 'form-control',
                    // 'disabled' => true
                ],
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
            ],
            [
                'name'  => 'en_name',
                'label' => 'عنوان انگلیسی',
                'prefix' => '<i class="la la-language"></i>',
                'attributes' => [
                    // 'placeholder' => '',
                    'class'       => 'form-control ltr',
                    // 'disabled' => true
                ],
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
            ],
            [
                'name'  => 'iso',
                'label' => 'سرنام',
                'prefix' => '<i class="la la-flag"></i>',
                'attributes' => [
                    'placeholder' => 'USA,IT,...',
                    'class'       => 'form-control ltr',
                    // 'disabled' => true
                ],
                'wrapper'      => [
                    'class'  => "form-group col-md-4"
                ],
            ],
            [
                'name'  => 'amount',
                'label' => 'قیمت',
                'prefix' => '<i class="la la-dollar"></i>',
                'attributes' => [
                    'placeholder' => 'به ریال',
                    'class'       => 'form-control ltr'
                ],
                'wrapper'      => [
                    'class'  => "form-group col-md-4"
                ],
            ],
            [
                'name' => 'can_duplicate',
                'type' => 'toggle',
                'label' => 'قابلیت سفارش دوباره',
                'wrapper'      => [
                    'class'  => "form-group col-md-4"
                ],
            ],
            [
                'name' => 'status',
                'type' => 'toggle',
                'label' => 'وضعیت',
                'wrapper'      => [
                    'class'  => "form-group col-md-4"
                ],
            ],
            [
                'name' => 'image',
                'label' => 'تصویر',
                'type' => 'dropzone',
                'disk' => 'local',
                'destination_path' => 'uploads/images/countries',
                'mimes' => 'image/*',
                'thumb_prefix' => '/',
                'image_width'      => 200,
                'image_height'     => 200,
                'max_file_size'    => 1,
                'max_file' => 1,
            ],
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
}
