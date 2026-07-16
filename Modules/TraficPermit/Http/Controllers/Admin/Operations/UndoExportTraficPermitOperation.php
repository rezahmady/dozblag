<?php

namespace  Modules\TraficPermit\Http\Controllers\Admin\Operations;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Modules\TraficPermit\Enums\PermitOrderStatus;
use Modules\TraficPermit\Enums\TraficPermitStatus;

trait UndoExportTraficPermitOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupUndoExportTraficPermitRoutes($segment, $routeName, $controller)
    {
        Route::post($segment.'/{id}/undo-export-trafic-permit', [
            'as'        => $routeName.'.undoExportTraficPermit',
            'uses'      => $controller.'@undoExportTraficPermit',
            'operation' => 'undoExportTraficPermit',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupUndoExportTraficPermitDefaults()
    {
        CRUD::allowAccess('undoExportTraficPermit');

        CRUD::operation('undoExportTraficPermit', function () {
            CRUD::loadDefaultOperationSettingsFromConfig();
        });

        CRUD::operation('list', function () {
            CRUD::addButton('line', 'undoExportTraficPermit', 'view', 'traficpermit::buttons.undo_exporttraficpermit', 'beginning');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function undoExportTraficPermit($id)
    {
        CRUD::hasAccessOrFail('undoExportTraficPermit');
        $this->crud->setOperation('undoExportTraficPermit');

        DB::transaction(function () use ( $id) {

            $this->crud->model->findOrFail($id)->changeStatus(TraficPermitStatus::Active);
            $this->crud->model->findOrFail($id)->exports()->orderBy('id', 'DESC')->whereNull('get_carcasses_at')->first()->order->update([
                'status' => PermitOrderStatus::Issuing
            ]);
            $this->crud->model->findOrFail($id)->exports()->orderBy('id', 'DESC')->whereNull('get_carcasses_at')->first()->transactions->where('status', 1)->first()->delete();
            $this->crud->model->findOrFail($id)->exports()->orderBy('id', 'DESC')->whereNull('get_carcasses_at')->first()->delete();

        }, 3);

        return true;
    }
}
