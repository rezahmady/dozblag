<?php

namespace Modules\TraficPermit\Http\Controllers\Admin\Operations;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Modules\TraficPermit\Enums\TraficPermitStatus;

trait CarcassDeliveryOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupCarcassDeliveryRoutes($segment, $routeName, $controller)
    {
        Route::post($segment.'/{id}/carcass-delivery', [
            'as'        => $routeName.'.carcassDelivery',
            'uses'      => $controller.'@carcassDelivery',
            'operation' => 'carcassDelivery',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupCarcassDeliveryDefaults()
    {
        CRUD::allowAccess('carcassDelivery');

        CRUD::operation('carcassDelivery', function () {
            CRUD::loadDefaultOperationSettingsFromConfig();
        });

        CRUD::operation('list', function () {
            CRUD::addButton('line', 'carcassdelivery', 'view', 'traficpermit::buttons.carcassdelivery', 'beginning');
        });
    }

    public function carcassDelivery($id) {
        $this->crud->hasAccessOrFail('carcassDelivery');
        $this->crud->setOperation('carcassDelivery');

        DB::transaction(function () use ($id) {

            $this->crud->model->findOrFail($id)->changeStatus(TraficPermitStatus::Consumed);
            $this->crud->model->findOrFail($id)->exports()->where('status', 1)->where('get_carcasses_at', null)->orderBy('id', 'DESC')->first()->update([
                'get_carcasses_at' => Carbon::now()
            ]);

        }, 3);

        return true;
    }


}
