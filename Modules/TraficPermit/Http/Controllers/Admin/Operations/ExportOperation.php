<?php

namespace Modules\TraficPermit\Http\Controllers\Admin\Operations;

use Maatwebsite\Excel\Facades\Excel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Route;
use Modules\TraficPermit\Exports\GenericExport;

trait ExportOperation
{
    /**
     * Define the ExportOperation operation.
     *
     * @return void
     */
    protected function setupExportRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/export', [
            'as'        => $routeName.'.export',
            'uses'      => $controller.'@export',
            'operation' => 'export',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     *
     * @return void
     */
    protected function setupExportDefaults()
    {
        CRUD::allowAccess('export');

        CRUD::operation('list', function () {
            CRUD::addButton('top', 'export', 'view', 'traficpermit::buttons.export', 'end');
        });
    }

    public function export()
    {
        $this->crud->applyUnappliedFilters();
        $search = request()->input('search');
        // if a search term was present
        if ($search && $search['value'] ?? false) {
            // filter the results accordingly
            $this->crud->applySearchTerm($search['value']);
        }
        $this->crud->applyDatatableOrder();
        (new GenericExport($this->crud))->store('exports/export.xlsx', 'local');
        $url = url('exports/export.xlsx');
        Alert::success(trans("فرایند استخراج شروع شد . لینک فایل {$url}"))->flash();
        return redirect()->back();
//        return Excel::download(new GenericExport($this->crud), $this->crud->entity_name.'_export.xlsx');
    }
}
