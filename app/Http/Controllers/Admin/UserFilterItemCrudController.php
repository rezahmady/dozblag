<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FilterItemRequest;
use App\Models\FilterItem;
use App\Traits\DefaultPermissions;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class FilterItemCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserFilterItemCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
    use DefaultPermissions;
    Const ENTITY = 'resource filter';
    Const MODULE = 'User';

    protected function setupReorderOperation()
    {
        // define which model attribute will be shown on draggable elements
        $this->crud->set('reorder.label', 'name');
        // define how deep the admin is allowed to nest the items
        // for infinite levels, set it to 0
        $this->crud->set('reorder.max_level', 2);
    }


    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(FilterItem::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/resource/filteritem');
        CRUD::setEntityNameStrings('فیلتر', 'فیلترها');

        $this->crud->addClause('whereHas', 'filter', function($query) {
            $query->where('module', self::MODULE);
        });

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
        CRUD::addColumn([
            // any type of relationship
            'name'         => 'filter', // name of relationship method in the model
            'type'         => 'relationship',
            'label'        => 'دسته', // Table column heading
            // OPTIONAL
            // 'entity'    => 'tags', // the method that defines the relationship in your Model
            // 'attribute' => 'name', // foreign key attribute that is shown to user
            // 'model'     => App\Models\Category::class, // foreign key model
         ]);

         $this->crud->addFilter([ // select2 filter
            'name' => 'filter_id',
            'type' => 'select2',
            'label'=>  'دسته فیلترها',
        ], function () {
            return \App\Models\Filter::all()->keyBy('id')->pluck('name', 'id')->toArray();
        }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'filter_id', $value);
        });
        // CRUD::column('filter_id');


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
        CRUD::setValidation(FilterItemRequest::class);

        CRUD::addFields([
            [
                'name'       => 'name',
                'label'      => 'نام',
                'type'       => 'text'
            ],
            [
                'label' => 'دسته',
                'type' => 'relationship',
                'name' => 'filter_id',
                'entity' => 'filter',
                'attribute' => 'name',
                'inline_create' => true,
                'ajax' => false,
            ],
            [   // Browse
                'name'  => 'image',
                'label' => 'تصویر',
                'type'  => 'browse',
                'tab'   => 'تصویر شاخص'
            ],
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


    /**
     * Respond to AJAX calls from the select2 with entries from the Category model.
     * @return JSON
     */
    public function fetchFilter()
    {
        return $this->fetch(\App\Models\Filter::class);
    }

}
