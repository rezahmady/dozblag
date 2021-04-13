<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CommentRequest;
use App\Traits\DefaultPermissions;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Comment;
use Alert;

/**
 * Class CommentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CommentCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Rezahmady\SettingOperation\SettingOperation;
    use DefaultPermissions;

    Const ENTITY = 'comment';
    Const MODULE = 'Article';

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Comment::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/article/comment');
        CRUD::setEntityNameStrings('نظر', 'نظرات');
        $this->crud->addClause('whereModule', self::MODULE);


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
        CRUD::addColumns([
            [
                'name'   => 'name',
                'label'  => 'کاربر'
            ],
            [
                'name'   => 'body',
                'label'  => 'نظر'
            ],
            [
                'name'  => 'status',
                'label' => 'وضعیت', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getStatusShow',
            ]
        ]);

        $this->crud->addButtonFromModelFunction('line', 'reply', 'goToComment', 'beginning');

        /*
        |--------------------------------------------------------------------------
        | FILTER
        |--------------------------------------------------------------------------
        */

        $this->crud->addFilter([
            'name'  => 'status',
            'type'  => 'dropdown',
            'label' => 'وضعیت'
        ], [
            '0' => 'بررسی نشده',
            '1' => 'تایید نمایش',
            '2' => 'رد شده'
        ], function($value) { // if the filter is active
            return$this->crud->addClause('where', 'status', $value);
        });

        // $this->crud->addButtonFromModelFunction('line', 'status', 'toggleStatus', 'beginning');
        // $this->crud->addButtonFromView('line', 'status', 'btn-toggle-3', 'beginning');

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
        CRUD::setValidation(CommentRequest::class);

        // CRUD::field('module');

        CRUD::addFields([
            [
                'name' => 'module',
                'value' => self::MODULE,
                'type'  => 'hidden'
            ],
            [
                'name' => 'module_id',
                'value' => 2,
                'type' => 'hidden',
            ],
            [
                'name' => 'parent_id',
                'type' => 'number',
            ],
            [
                'name' => 'user_id',
                'label' => 'کاربر',
            ],
            [
                'name' => 'user_id',
                'label' => 'کاربر',
            ],
            [
                'name' => 'name',
                'label' => 'نام',
            ],
            [
                'name' => 'email',
                'label' => 'ایمیل',
            ],
            [
                'name' => 'body',
                'label' => 'نظر',
                'type'  => 'textarea',
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

        CRUD::setValidation(CommentRequest::class);
        CRUD::addFields([
            [
                'name' => 'module',
                'value' => self::MODULE,
                'type'  => 'hidden'
            ],
            [
                'name' => 'module_id',
                'value' => $this->crud->getCurrentEntry()->module_id,
                'type' => 'hidden',
            ],
            [
                'name' => 'parent_id',
                'value' => $this->crud->getCurrentEntry()->parent_id,
                'type' => 'hidden',
            ],
            [
                'name' => 'user_id',
                'label' => 'کاربر',
            ],
            [
                'name' => 'user_id',
                'label' => 'کاربر',
            ],
            [
                'name' => 'name',
                'label' => 'نام',
            ],
            [
                'name' => 'email',
                'label' => 'ایمیل',
            ],
            [
                'name' => 'body',
                'label' => 'نظر',
                'type'  => 'textarea',
            ],
        ]);
    }

    protected function setupShowOperation()
    {
        // by default the Show operation will try to show all columns in the db table,
        // but we can easily take over, and have full control of what columns are shown,
        // by changing this config for the Show operation
        $this->crud->set('show.setFromDb', false);

        CRUD::addColumns([
            [
                'name' => 'name',
                'label' => ' نام'
            ],
            [
                'name' => 'email',
                'label' => ' ایمیل'
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'module_id',
                'label' => 'عنوان مقاله', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getModuleParameter', // the method in your Model
                'function_parameters' => ['title'], // pass one/more parameters to that method
                // 'limit' => 100, // Limit the number of characters shown
            ],
            [
                // any type of relationship
                'name'         => 'parent', // name of relationship method in the model
                'type'         => 'relationship',
                'label'        => 'در پاسخ به', // Table column heading
                // OPTIONAL
                // 'entity'    => 'tags', // the method that defines the relationship in your Model
                'attribute' => 'body', // foreign key attribute that is shown to user
                // 'model'     => App\Models\Category::class, // foreign key model
            ],
            [
                'name' => 'body',
                'label' => 'نظر',
            ],
            [
                'name' => 'module_id',
                'label' => 'نظر',
            ],
            [
                'name'  => 'status',
                'label' => 'وضعیت', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getStatusShow',
            ],

        ]);

        $this->crud->addButtonFromModelFunction('line', 'reject', 'rejectComment', 'beginning');
        $this->crud->addButtonFromModelFunction('line', 'approved', 'approvedComment', 'beginning');
        $this->crud->addButtonFromModelFunction('line', 'reply', 'goToComment', 'beginning');

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
        CRUD::addFields([
            [
                'name' => 'success-created',
                'label' => 'متن پیام ارسال موفق نظر',
                'type' => 'textarea',
            ],
        ]);
    }

    public function approvedComment(Comment $comment)
    {
        $comment->status = 1;
        $comment->save();
        Alert::success("وضعیت نظر تغییر کرد")->flash();
        return redirect()->to($this->crud->route);
    }

    public function rejectComment(Comment $comment)
    {
        $comment->status = 2;
        $comment->save();
        Alert::success("وضعیت نظر تغییر کرد")->flash();
        return redirect()->to($this->crud->route);
    }


}
