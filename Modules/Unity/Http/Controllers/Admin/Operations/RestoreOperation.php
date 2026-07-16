<?php

namespace Modules\Unity\Http\Controllers\Admin\Operations;

use Illuminate\Support\Facades\Route;

trait RestoreOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupRestoreRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/{id}/restore', [
            'as'        => $routeName.'.restore',
            'uses'      => $controller.'@restore',
            'operation' => 'restore',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupRestoreDefaults()
    {
        $this->crud->allowAccess('restore');

        $this->crud->operation('restore', function () {
            $this->crud->loadDefaultOperationSettingsFromConfig();
        });

        $this->crud->operation('list', function () {
            // $this->crud->addButton('top', 'restore', 'view', 'crud::buttons.restore');
            if(backpack_user()->can('restore')) {
                $this->crud->addButton('line', 'trash', 'view', 'traficpermit::operations.restore');
                $this->crud->addFilter([
                    'type'  => 'simple',
                    'name'  => 'trash',
                    'prefix' => '<i class="la la-trash"></i>',
                    'label' => 'زباله'
                  ],
                  false,
                  function() { // if the filter is active
                    $this->crud->query->withTrashed()->whereNotNull('deleted_at'); // apply the "active" eloquent scope
                  }
                );
    
                $trash = $_GET['trash'] ?? false;
                if($trash == true) $this->crud->removeButtons(['delete', 'update'], 'line');
                // $this->crud->addButton('line', 'restore', 'view', 'crud::buttons.restore');
                }
            });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function restore($id)
    {
        $this->crud->hasAccessOrFail('restore');
        $this->crud->model->withTrashed()->findOrFail($id)->restore();

        \Alert::success('آیتم مورد نظر برگردانده شد.')->flash();
        return \Redirect::to($this->crud->route);
    }
}
