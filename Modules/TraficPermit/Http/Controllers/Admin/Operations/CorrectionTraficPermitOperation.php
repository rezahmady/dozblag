<?php

namespace Modules\TraficPermit\Http\Controllers\Admin\Operations;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Modules\TraficPermit\Enums\TraficPermitStatus;

trait CorrectionTraficPermitOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupCorrectionTraficPermitRoutes($segment, $routeName, $controller)
    {
        Route::post($segment.'/{id}/correction-trafic-permit', [
            'as'        => $routeName.'.correctionTraficPermit',
            'uses'      => $controller.'@correctionTraficPermit',
            'operation' => 'correctionTraficPermit',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupCorrectionTraficPermitDefaults()
    {
        CRUD::allowAccess('correctionTraficPermit');

        CRUD::operation('correctionTraficPermit', function () {
            CRUD::loadDefaultOperationSettingsFromConfig();
        });

        CRUD::operation('list', function () {
            // CRUD::addButton('top', 'correction_trafic_permit', 'view', 'crud::buttons.correction_trafic_permit');
            // CRUD::addButton('line', 'correction_trafic_permit', 'view', 'crud::buttons.correction_trafic_permit');
            CRUD::addButton('line', 'correctionTraficPermit', 'view', 'traficpermit::buttons.correctiontraficpermit', 'beginning');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function correctionTraficPermit($id)
    {
        CRUD::hasAccessOrFail('correctionTraficPermit');
        $this->crud->setOperation('correctionTraficPermit');

        DB::transaction(function () use ( $id) {

            $this->crud->model->findOrFail($id)->changeStatus(TraficPermitStatus::Active);

            $this->crud->model->findOrFail($id)->exports()->orderBy('id', 'DESC')->first()->update([
                'get_carcasses_at' => Carbon::now(),
                'is_recursive' => 1
            ]);

        }, 3);


        return true;
    }
}
