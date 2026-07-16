<?php

namespace Modules\Unity\Http\Controllers\Admin\Operations;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Modules\Unity\Enums\DriverContractStatus;
use Modules\Unity\Models\DriverContract;

trait DriverContractTerminateOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupDriverContractTerminateRoutes($segment, $routeName, $controller)
    {

        Route::get($segment.'/{id}/driver-contract-terminate', [
            'as'        => $routeName.'.driverContractTerminate',
            'uses'      => $controller.'@driverContractTerminate',
            'operation' => 'driverContractTerminate',
        ]);

        Route::put($segment.'/{id}/driver-contract-terminate', [
            'as'        => $routeName.'.driverContractTerminateAction',
            'uses'      => $controller.'@driverContractTerminateAction',
            'operation' => 'driverContractTerminate',
        ]);

        Route::get($segment.'/{id}/driver-contract-accept', [
            'as'        => $routeName.'.driverContractTerminateAccept',
            'uses'      => $controller.'@driverContractTerminateAccept',
            'operation' => 'driverContractTerminate',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupDriverContractTerminateDefaults()
    {
        CRUD::allowAccess('driverContractTerminate');

        CRUD::operation('driverContractTerminate', function () {
            CRUD::loadDefaultOperationSettingsFromConfig();
        });

        $this->crud->operation('update', function () {
            $this->crud->loadDefaultOperationSettingsFromConfig();

            if ($this->crud->getModel()->translationEnabled()) {
                $this->crud->addField([
                    'name' => '_locale',
                    'type' => 'hidden',
                    'value' => request()->input('_locale') ?? app()->getLocale(),
                ]);
            }

            $this->crud->setupDefaultSaveActions();
        });


        CRUD::operation('list', function () {
            CRUD::addButton('line', 'driverContractTerminate', 'view', 'unity::buttons.driverContractTerminate');
            CRUD::addButton('line', 'driverContractAccept', 'view', 'unity::buttons.driverContractAccept');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function driverContractTerminate($id)
    {
        CRUD::hasAccessOrFail('driverContractTerminate');

        if((!backpack_user()->can('drivercontract manage all') and !backpack_user()->unity) or (!backpack_user()->can('drivercontract manage all') and $this->crud->getCurrentEntry()->unity_id != backpack_user()->unity->id)) {
            abort(403);
        }

        $id = $this->crud->getCurrentEntryId() ?? $id;

        // prepare the fields you need to show
        $this->data['entry'] = $this->crud->getEntryWithLocale($id);
        $this->crud->setOperationSetting('fields', $this->crud->getUpdateFields());

        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = [
            "active" => [
              "value" => "save_and_back",
              "label" => "ذخیره و بازگشت"
            ],
            "options" => []
          ];
        $this->data['title'] = $this->crud->getTitle() ?? trans('backpack::crud.edit').' '.$this->crud->entity_name;
        $this->data['id'] = $id;

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view('unity::operations.terminate', $this->data);
    }

        /**
     * Update the specified resource in the database.
     *
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function driverContractTerminateAction()
    {

        $this->crud->hasAccessOrFail('driverContractTerminate');

        if((!backpack_user()->can('drivercontract manage all') and !backpack_user()->unity) or (!backpack_user()->can('drivercontract manage all') and $this->crud->getCurrentEntry()->unity_id != backpack_user()->unity->id)) {
            abort(403);
        }

        // execute the FormRequest authorization and validation, if one is required
        $request = $this->crud->validateRequest();

        // register any Model Events defined on fields
        $this->crud->registerFieldEvents();


        DB::transaction(function () use($request) {
            $array = array_merge($this->crud->getStrippedSaveRequest($request),['contract_status' => DriverContractStatus::Expired]);

            $item = $this->crud->update(
                $request->get($this->crud->model->getKeyName()),
                $array
            );

            $this->crud->getCurrentEntry()->driver->update([
                'unity_id' => null,
            ]);

            $this->data['entry'] = $this->crud->entry = $item;
        }, 3);

        // show a success message
        \Alert::success('فسخ قرارداد با موفقیت انجام شد.')->flash();

        // save the redirect choice for next time
        $this->crud->addSaveAction([
            'name' => 'save_and_back',
            'redirect' => function($crud, $request, $itemId) {
                return $crud->route;
            }, // what's the redirect URL, where the user will be taken after saving?

            // OPTIONAL:
            'button_text' => 'Custom save message', // override text appearing on the button
            // You can also provide translatable texts, for example:
            // 'button_text' => trans('backpack::crud.save_action_one'),
            'visible' => function($crud) {
                return true;
            }, // customize when this save action is visible for the current operation
            'referrer_url' => function($crud, $request, $itemId) {
                return $crud->route;
            }, // override http_referrer_url
            'order' => 1, // change the order save actions are in
        ]);

        return $this->crud->performSaveAction($this->crud->getCurrentEntry()->getKey());
    }


    public function driverContractTerminateAccept()
    {

        $this->crud->hasAccessOrFail('driverContractTerminate');

        if(!backpack_user()->can('drivercontract manage all')) {
            abort(403);
        }


        DB::transaction(function () {
            $this->crud->getCurrentEntry()->update([
                'contract_status' => DriverContractStatus::Active,
            ]);

            $this->crud->getCurrentEntry()->driver->update([
                'unity_id' => $this->crud->getCurrentEntry()->unity_id,
            ]);

            DriverContract::where([
                'driver_id' => $this->crud->getCurrentEntry()->driver->id,
                'contract_status' => DriverContractStatus::Pending,
            ])->delete();
        }, 3);


        // show a success message
        \Alert::success('تایید قرارداد با موفقیت انجام شد.')->flash();

        return back();
    }
}
