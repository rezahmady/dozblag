<?php

namespace  Modules\TraficPermit\Http\Controllers\Admin\Operations;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Route;

trait CancelOrderTraficPermitOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupCancelOrderTraficPermitRoutes($segment, $routeName, $controller)
    {
        Route::post($segment.'/{id}/cancel-order-trafic-permit', [
            'as'        => $routeName.'.cancelOrderTraficPermit',
            'uses'      => $controller.'@cancelOrderTraficPermit',
            'operation' => 'cancelOrderTraficPermit',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupCancelOrderTraficPermitDefaults()
    {
        CRUD::allowAccess('cancelOrderTraficPermit');

        CRUD::operation('cancelOrderTraficPermit', function () {
            CRUD::loadDefaultOperationSettingsFromConfig();
        });

        CRUD::operation('list', function () {
            CRUD::addButton('line', 'cancelOrderTraficPermit', 'view', 'traficpermit::buttons.cancel_order_traficpermit', 'befor');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function cancelOrderTraficPermit($id)
    {
        CRUD::hasAccessOrFail('cancelOrderTraficPermit');
        $this->crud->setOperation('cancelOrderTraficPermit');

        if(!$this->crud->model->findOrFail($id)->exports()->exists()) {
            $this->crud->model->findOrFail($id)->delete();
        }

        return true;
    }
}
