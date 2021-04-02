<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FilterRequest;
use App\Traits\DefaultPermissions;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class FilterCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class FilterCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;
    use DefaultPermissions;

    Const ENTITY = 'filter';

    protected function setupReorderOperation()
    {
        // define which model attribute will be shown on draggable elements
        $this->crud->set('reorder.label', 'name');
        // define how deep the admin is allowed to nest the items
        // for infinite levels, set it to 0
        $this->crud->set('reorder.max_level', 1);
    }

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Filter::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/filter');
        CRUD::setEntityNameStrings(' دسته', 'دسته بندی ها');


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
        CRUD::addColumn(['name' => 'name', 'label' => 'عنوان']);

        CRUD::addColumn([   // select_multiple: n-n relationship (with pivot table)
            'label'     => 'فیلترها', // Table column heading
            'type'      => 'relationship_count',
            'name'      => 'items', // the method that defines the relationship in your Model
            'suffix' => ' فیلتر',
            'wrapper'   => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('filteritem?filter_id='.$entry->getKey());
                },
            ],
        ]);

        CRUD::column('status')->type('model_function')
        ->label('وضعیت')
        ->function_name('getStatusBrowse');

        // CRUD::column('deleted_at');
        // CRUD::column('created_at');
        // CRUD::column('updated_at');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(FilterRequest::class);

        CRUD::addField([
            'name'       => 'name',
            'label'      => 'نام',
            'type'       => 'text'
        ]);

        CRUD::addField([ // Text
            'name'    => 'status',
            'label'   => '<i class="la la-flag-o"></i> وضعیت انتشار',
            'type'    => 'radio',
            'default' => '1',
            'options' => [
                "1" => '<span class="bg-success mb-1 d-block">
                            نمایش داده شود.
                        </span>',
                "0"     => '<span class="bg-danger mb-1 d-block">
                            منتشر نشود.
                        </span>',
            ],
            'wrapper' => [
                'class'      => 'form-group col-md-12'
             ]
        ]);

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
