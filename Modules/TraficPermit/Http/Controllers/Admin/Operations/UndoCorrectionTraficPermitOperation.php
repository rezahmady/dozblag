<?php

namespace  Modules\TraficPermit\Http\Controllers\Admin\Operations;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Modules\TraficPermit\Enums\TraficPermitStatus;

trait UndoCorrectionTraficPermitOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupUndoCorrectionTraficPermitRoutes($segment, $routeName, $controller)
    {
        Route::post($segment.'/{id}/undo-correction-trafic-permit', [
            'as'        => $routeName.'.undoCorrectionTraficPermit',
            'uses'      => $controller.'@undoCorrectionTraficPermit',
            'operation' => 'undoCorrectionTraficPermit',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupUndoCorrectionTraficPermitDefaults()
    {
        CRUD::allowAccess('undoCorrectionTraficPermit');

        CRUD::operation('undoCorrectionTraficPermit', function () {
            CRUD::loadDefaultOperationSettingsFromConfig();
        });

        CRUD::operation('list', function () {
            CRUD::addButton('line', 'undocorrectionTraficPermit', 'view', 'traficpermit::buttons.undo_correctiontraficpermit', 'beginning');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function undoCorrectionTraficPermit($id)
    {
        CRUD::hasAccessOrFail('undoCorrectionTraficPermit');
        $this->crud->setOperation('undoCorrectionTraficPermit');

        $this->crud->model->findOrFail($id)->changeStatus(TraficPermitStatus::Consumed);

        return true;
    }
}
