<?php

namespace Modules\Payment\Http\Controllers\Admin;

use Modules\Payment\Http\Requests\DiscountRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class DiscountCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DiscountCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\Modules\Payment\Models\Discount::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/discount');
        CRUD::setEntityNameStrings('کد تخفیف', 'تخفیف ها');
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
                'label'     => 'کد',
                'type' => 'model_function',
                'function_name' => 'getNameWithCaptionBrowse',
            ],
            [
                'name'      => 'value',
                'label'     => 'مقدار',
                'type' => 'model_function',
                'function_name' => 'getValueBrowse',
            ],
            [
                'name'      => 'use',
                'label'     => 'تعداد استفاده',
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
            return$this->crud->addClause('where', 'status', $value);
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
        CRUD::setValidation(DiscountRequest::class);
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

    public function addFields()
    {
        $this->crud->addFields([
            [
                'name'  => 'name',
                'label' => 'کد',
                'prefix' => '<i class="la la-ticket-alt"></i>',
                'type'  => 'text',
                'attributes' => [
                    'class'       => 'form-control form-control-lg'
                ],
            ],
            [
                'name'  => 'caption',
                'label' => 'شرح مختصر برای مدیر',
                'type'  => 'text',
                'attributes' => [
                    'class'       => 'form-control '
                ],
            ],
            [
                'name'    => 'value',
                'prefix'  => '<i class="la la-dollar"></i>',
                'type'    => 'text',
                'label'   => 'مقدار تخفیف',
                'wrapper'      => [
                    'class'  => "form-group col-md-4"
                ],
            ],
            [
                'name'    => 'type',
                'type'    => 'select2_from_array',
                'label'   => 'به',
                'options' => [
                    'PERCENT' => 'درصد',
                    'EQUAL' => 'ریال',
                ],
                'wrapper'      => [
                    'class'  => "form-group col-md-2"
                ],
            ],
            [
                'name'    => 'limit',
                'prefix'  => '<i class="la la-dollar"></i>',
                'suffix'   => 'ریال',
                'type'    => 'text',
                'label'   => 'تا سقف',
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
                                فعال
                            </span>',
                    0 => '<span class="bg-danger mb-1 d-block">
                    غیر فعال
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
