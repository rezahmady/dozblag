<?php

namespace  Modules\TraficPermit\Http\Controllers\Admin\Operations;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Modules\TraficPermit\Models\TraficPermitExport;

trait PermitexportOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupPermitexportRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/{id}/permitexport', [
            'as'        => $routeName.'.permitexport',
            'uses'      => $controller.'@permitexport',
            'operation' => 'permitexport',
        ]);

        Route::get($segment.'/{id}/permitexport/{export}/print', [
            'as'        => $routeName.'.permitexport.print',
            'uses'      => $controller.'@print',
            'operation' => 'permitexport',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupPermitexportDefaults()
    {
        CRUD::allowAccess('traficpermitexport');

        CRUD::operation('permitexport', function () {
            CRUD::loadDefaultOperationSettingsFromConfig();
        });

        CRUD::operation('list', function () {
            CRUD::addButton('line', 'permitexport', 'view', 'traficpermit::buttons.permitexport');
        });

    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function permitexport($id)
    {
        CRUD::hasAccessOrFail('traficpermitexport');

        $id = $this->crud->getCurrentEntryId() ?? $id;

        // get the info for that entry (include softDeleted items if the trait is used)
        if ($this->crud->get('show.softDeletes') && in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($this->crud->model))) {
            $this->data['entry'] = $this->crud->getModel()->withTrashed()->findOrFail($id);
        } else {
            $this->data['entry'] = $this->crud->getEntryWithLocale($id);
        }

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['title'] = CRUD::getTitle() ?? 'صدور '.$this->crud->entity_name;

        // load the view
        return view('traficpermit::operations.permitexport', $this->data);
    }

    public function print($id, $export) {

        CRUD::hasAccessOrFail('traficpermitexport');

        $export = TraficPermitExport::find($export);
        if(!$export) abort(404);

        $traficpermit = $export->traficpermit;
        $repository = $traficpermit->repository;
        $country = $repository->country;
        $order = $export->order;
        $unity = $order->unity;
        $truck = $order->truck;
        $driver = $order->driver;

        $values = [
            'unity.en_name' => $unity->en_name.' INTL TRP CO',
            'unity.en_address' => $unity->en_address,
            'driver.en_name' => $driver->en_name,
            'truck.transit' => $truck->transit_number,
            'trailer.transit' => $order->trailer->transit_number,
            'date' => date_format(new Carbon($export->date), 'd/m/Y'),
        ];

        $template = $repository->traficPermitTemplate->extras;

        $front_fields = json_decode($template->front_fields, true);
        if(sizeof($front_fields)) foreach($front_fields as $key => $field) {
            if($field['type'] != 'string') $front_fields[$key]['value'] = $values[$field['type']];
            $front_fields[$key]['width'] = $front_fields[$key]['width'] ?? 'auto';
            if($front_fields[$key]['width'] != 'auto') $front_fields[$key]['width'].= 'mm';
        }

        $back_fields = json_decode($template->back_fields, true);
        if(sizeof($back_fields)) foreach($back_fields as $key => $field) {
            if($field['type'] != 'string') $back_fields[$key]['value'] = $values[$field['type']];
            $back_fields[$key]['width'] = $back_fields[$key]['width'] ?? 'auto';
            if($back_fields[$key]['width'] != 'auto') $back_fields[$key]['width'].= 'mm';
        }

        $paper_size = $template->paper_size;

        $page_width = ($paper_size == 'A5') ? '148' : '210';
        $page_height = ($paper_size == 'A5') ? '220' : '297';

        return view('traficpermit::operations.print', [
            'paper_size' => $paper_size,
            'front_fields' => $front_fields,
            'back_fields' => $back_fields,
            'page_width' => $page_width,
            'page_height' => $page_height,
        ]);
    }
}
