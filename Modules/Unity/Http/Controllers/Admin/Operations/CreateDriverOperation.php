<?php

namespace Modules\Unity\Http\Controllers\Admin\Operations;

use Illuminate\Support\Facades\Route;

trait CreateDriverOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param  string  $segment  Name of the current entity (singular). Used as first URL segment.
     * @param  string  $routeName  Prefix of the route name.
     * @param  string  $controller  Name of the current CrudController.
     */
    protected function setupCreateDriverRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/create-driver', [
            'as'        => $routeName.'.create-driver',
            'uses'      => $controller.'@createDriver',
            'operation' => 'createDriver',
        ]);

        Route::post($segment.'/create-driver', [
            'as'        => $routeName.'.store-driver',
            'uses'      => $controller.'@storeDriver',
            'operation' => 'createDriver',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupCreateDriverDefaults()
    {
        $this->crud->allowAccess('createDriver');

        $this->crud->operation('createDriver', function () {
            $this->crud->loadDefaultOperationSettingsFromConfig();
            $this->crud->setupDefaultSaveActions();
        });

        $this->crud->operation('list', function () {
            $this->crud->addButton('top', 'createDriver', 'view', 'unity::buttons.create-driver');
        });
    }

    /**
     * Show the form for creating inserting a new row.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function createDriver()
    {
        $this->crud->hasAccessOrFail('createDriver');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->crud->getSaveAction();
        $this->data['title'] = $this->crud->getTitle() ?? trans('backpack::crud.add').' '.$this->crud->entity_name;

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view('unity::operations.create-driver', $this->data);
    }

    /**
     * Store a newly created resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeDriver()
    {
        $this->crud->hasAccessOrFail('createDriver');

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

        // register any Model Events defined on fields
        $this->crud->registerFieldEvents();

        // insert item in the db
        $item = $this->crud->create($this->crud->getStrippedSaveRequest($request));
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }
}
