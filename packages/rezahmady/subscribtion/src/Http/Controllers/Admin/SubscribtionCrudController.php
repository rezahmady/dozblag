<?php

namespace Rezahmady\Subscribtion\Http\Controllers\Admin;

use Rezahmady\Subscribtion\Http\Requests\SubscribtionRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SubscribtionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SubscribtionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Rezahmady\SettingOperation\SettingOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\Rezahmady\Subscribtion\Models\Subscribtion::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/subscribtion');
        CRUD::setEntityNameStrings('اشتراک', 'اشتراک ها');
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
                'name'      => 'name',
                'label'     => 'عنوان',
            ],
            [
                'name'  => 'description',
                'label'     => 'توضیحات',
                'escaped' => false,
                'limit'  => 120, // character limit; default is 50;
            ],
            [
                'name'  => 'amount',
                'label'     => 'قیمت <small>(تومان)</small>',
                'type'  => 'model_function',
                'function_name' => 'getAmount'
            ],
            [
                'name' => 'status',
                'type' => 'model_function',
                'function_name' => 'getStatusBrowse',
                'label' => 'وضعیت'
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | FILTER
        |--------------------------------------------------------------------------
        */

        $this->crud->addFilter([
            'name'  => 'status',
            'type'  => 'dropdown',
            'label' => 'وضعیت انتشار'
        ], [
            1 => 'منتشر شده',
            0 => 'عدم انتشار'
        ], function($value) { // if the filter is active
            return$this->crud->addClause('where', 'extras->status', $value);
        });
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(SubscribtionRequest::class);
        $this->addFields();
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
                'name'  => 'title',
                'label' => 'عنوان',
                'type'  => 'text',
                'attributes' => [
                    'class'       => 'form-control form-control-lg'
                ],
                'tab'     => 'قالب',
            ],
            [
                'name'    => 'description',
                'label'   => 'توضیحات',
                'type'    => 'summernote',
                'options' => [
                    'toolbar' => [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ]
                ],
                'tab'     => 'قالب',
            ],
            [
                'name'    => 'col_class',
                'type'    => 'text',
                'label'   => 'استایل هر باکس اشتراک',
                'tab'     => 'قالب',
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
            ],
            [
                'name'    => 'button_label',
                'type'    => 'text',
                'label'   => 'متن دکمه',
                'tab'     => 'قالب',
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
            ],
        ]);
    }

    public function addFields()
    {
        $this->crud->addFields([
            [
                'name'  => 'name',
                'label' => 'عنوان',
                'type'  => 'text',
                'attributes' => [
                    'class'       => 'form-control form-control-lg'
                ],
            ],
            [
                'name'    => 'description',
                'type'    => 'summernote',
                'options' => [
                    'toolbar' => [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ]
                ],
                'label'   => 'توضیحات',
            ],
            [
                'name'    => 'amount_before_discount',
                'prefix'  => '<i class="la la-dollar"></i>',
                'suffix'  => 'تومان',
                'type'    => 'text',
                'label'   => 'قیمت پیش از تخفیف',
                'fake'    => true,
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
            ],
            [
                'name'    => 'amount',
                'prefix'  => '<i class="la la-dollar"></i>',
                'suffix'  => 'تومان',
                'type'    => 'text',
                'label'   => 'قیمت',
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
            ],
            [
                'name'    => 'limit_capacity',
                'type'    => 'text',
                'label'   => 'محدودیت گفت و گو',
                'prefix'  => 'تعداد',
                'fake'    => true,
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
            ],
            [
                'name'    => 'limit_duration',
                'prefix'  => '<i class="la la-calendar"></i>',
                'suffix'  => 'دقیقه',
                'type'    => 'text',
                'label'   => 'محدودیت زمان',
                'fake'    => true,
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
            ],
            [ // Text
                'name'  => 'status',
                'label' => '<i class="la la-flag-o"></i> وضعیت انتشار',
                'type'  => 'radio',
                'fake'    => true,
                'options' => [
                    1 => '<span class="bg-success mb-1 d-block">
                                انتشار.
                            </span>',
                    0 => '<span class="bg-danger mb-1 d-block">
                    عدم انتشار.
                            </span>',
                ],
                'wrapper'   => [
                    'class'      => 'form-group col-md-6'
                ],
                'default' => 1,
            ],
        ]);
    }
}
