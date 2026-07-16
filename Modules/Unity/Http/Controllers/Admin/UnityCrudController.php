<?php

namespace Modules\Unity\Http\Controllers\Admin;

use App\Traits\DropzoneTrait;
use Modules\Unity\Http\Requests\UnityRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Modules\Unity\Enums\UnityStatus;

/**
 * Class UnityCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UnityCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
    use \App\Traits\DefaultPermissions;
    use DropzoneTrait;

    Const ENTITY = 'Unity';

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\Modules\Unity\Models\Unity::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/unity');
        CRUD::setEntityNameStrings(trans('unity::unity.unity_singular'), trans('unity::unity.unity_plural'));
        /*
        |--------------------------------------------------------------------------
        | PERMISSIONS
        |--------------------------------------------------------------------------
        */
        $this->setPermissions();

        // Route::post($this->crud->route.'/{id}/toggle', [$this->crud->model, 'toggle']);
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
                'name' => 'image',
                'label' => 'تصویر',
                'type'  => 'model_function',
                'function_name' => 'getLogo',
            ],
            [
                'name' => 'fa_name',
                'label' => 'نام',
            ],
            [
                'name' => 'en_name',
                'label' => 'نام انگلیسی',
            ],
            [
                'name' => 'cashed_balance_column',
                'label' => 'اعتبار',
                'escaped' => false,
                'limit' => 400
            ],
            [
                'name' => 'status',
                'type' => 'model_function',
                'function_name' => 'getStatusBrowse',
                'label' => 'وضعیت',
            ],
        ]);

        // $this->crud->addColumn([
        //     'name' => 'active', // name of db column
        //     'label' => 'Active', // label for table header
        //     'type' => 'toggle', // name of custom column type blade file
        // ]);

        $this->crud->addFilter([
            'name'  => 'status',
            'type'  => 'dropdown',
            'label' => 'وضعیت'
          ], UnityStatus::get_translated_array(), function($value) { // if the filter is active
            $this->crud->addClause('where', 'status', $value);
        });
    }

    protected function setupShowOperation()
    {
        $this->crud->addColumns([
            [
                'name' => 'image',
                'label' => 'تصویر',
                'type'  => 'model_function',
                'function_name' => 'getLogo',
            ],
            [
                'name' => 'fa_name',
                'label' => 'نام',
                'limit' => 500
            ],
            [
                'name' => 'en_name',
                'label' => 'نام انگلیسی',
                'limit' => 500
            ],
            [
                'name' => 'national_id',
                'label' => 'شناسه ملی',
            ],
            [
                'name' => 'tell',
                'label' => 'تلفن',
            ],
            [
                'name' => 'fa_address',
                'label' => 'آدرس',
                'limit' => 500,
                'escaped' => false
            ],
            [
                'name' => 'en_address',
                'label' => 'Address',
                'limit' => 500,
                'escaped' => false
            ],
            [
                'name' => 'description',
                'label' => 'توضیحات',
                'escaped' => false
            ],
            [
                'name' => 'status',
                'type' => 'model_function',
                'function_name' => 'getStatusBrowse',
                'label' => 'وضعیت',
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
        $this->crud->setValidation(UnityRequest::class);
        

        $this->crud->addFields([
            [
                'name'  => 'fa_name',
                'label' => 'عنوان شرکت',
                'prefix' => '<i class="la la-pencil-square la-lg"></i>',
                'attributes' => [
                    'placeholder' => 'عنوان واحد را اینجا بنویسید',
                    'class'       => 'form-control form-control-lg'
                ],
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
                'tab' => 'مشخصات',
            ],
            [
                'name'  => 'en_name',
                'label' => 'English Name',
                'suffix' => '<i class="la la-pencil-square la-lg"></i>',
                'prefix' => 'INTL.TRP.CO',
                'attributes' => [
                    'placeholder' => 'Unity title',
                    'class'       => 'form-control form-control-lg text-left'
                ],
                'wrapper'      => [
                    'class'  => "form-group col-md-6 text-left"
                ],
                'tab' => 'مشخصات',
            ],
            [
                'name' => 'national_id',
                'label' => 'شناسه ملی',
                'attributes' => [
                    'dir' => 'ltr',
                ],
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
                'tab' => 'مشخصات',
            ],
            [
                'name' => 'tell',
                'label' => 'تلفن',
                'suffix' => '<i class="la la-phone"></i>',
                'attributes' => [
                    'dir' => 'ltr',
                ],
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
                'tab' => 'مشخصات',
            ],
            [   // relationship
                'type' => "relationship",
                'name' => 'ostan_id', // the method on your model that defines the relationship
                'ajax' => false,
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
                'tab'   => 'مشخصات',
                // OPTIONALS:
                 'label' => "استان",
                 'attribute' => "name", // foreign key attribute that is shown to user (identifiable attribute)
                 'entity' => 'ostan', // the method that defines the relationship in your Model
                 'model' => "App\Models\Ostan", // foreign key Eloquent model
                 'placeholder' => "انتخاب کنید...", // placeholder for the select2 input
            ],
            [   // relationship
                'type' => "relationship",
                'name' => 'shahrestan_id', // the method on your model that defines the relationship
                'ajax' => true,
                // OPTIONALS:
                'label' => "شهر",
                'attribute' => "name", // foreign key attribute that is shown to user (identifiable attribute)
                'entity' => 'shahrestan', // the method that defines the relationship in your Model
                'model' => "App\Models\Shahrestan", // foreign key Eloquent model
                'placeholder' => "انتخاب کنید ...", // placeholder for the select2 input
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
                'tab'   => 'مشخصات',
                // AJAX OPTIONALS:
                // 'delay' => 500, // the minimum amount of time between ajax requests when searching in the field
                 'data_source' => url("api/shahrestan"), // url to controller search function (with /{id} should return model)
                 'minimum_input_length' => 0, // minimum characters to type before querying results
                 'dependencies'         => ['ostan_id'], // when a dependency changes, this select2 is reset to null
                 'include_all_form_fields'  => true, // optional - only send the current field through AJAX (for a smaller payload if you're not using multiple chained select2s)
            ],
            [
                'name'    => 'fa_address',
                'type'    => 'summernote',
                'options' => [
                    'toolbar' => [],
                ],
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
                'label'   => 'آدرس',
                'hint' => 'آدرس فارسی شرکت',
                'tab' => 'مشخصات',
            ],
            [
                'name'    => 'en_address',
                'type'    => 'summernote',
                'options' => [
                    'toolbar' => [],
                ],
                'label'   => 'Address',
                'wrapper'      => [
                    'class'  => "form-group col-md-6 text-left ltr"
                ],
                'hint' => 'English address',
                'tab' => 'مشخصات',
            ],
            [
                'name' => 'zip_code',
                'label' => 'کدپستی',
                'suffix' => '<i class="la la-envelope-open-text"></i>',
                'attributes' => [
                    'dir' => 'ltr',
                ],
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
                'tab' => 'مشخصات',
            ],
            [ // Text
                'name'  => 'status',
                'label' => '<i class="la la-flag-o"></i> وضعیت',
                'type'  => 'radio',
                'options' => [
                    UnityStatus::Active->value => '<span class="bg-success mb-1 d-block">
                    '.trans('unity::unity.status.'.UnityStatus::Active->value).'
                            </span>',
                    UnityStatus::Inactive->value => '<span class="bg-danger mb-1 d-block">
                    '.trans('unity::unity.status.'.UnityStatus::Inactive->value).'
                            </span>',
                ],
                'default' => UnityStatus::Active->value,
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
                'tab' => 'مشخصات',
            ],
            [
                'name' => 'image',
                'label' => 'تصویر لوگو',
                'type' => 'dropzone',
                'disk' => 'local',
                'destination_path' => 'uploads/images/unities',
                'mimes' => 'image/*',
                'thumb_prefix' => '/',
                'image_width'      => 200,
                'image_height'     => 200,
                'max_file_size'    => 1,
                'max_file' => 1,
                'tab' => 'مشخصات',
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
}
