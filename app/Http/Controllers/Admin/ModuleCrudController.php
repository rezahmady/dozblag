<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ModuleRequest;
use App\Models\Module;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Artisan;
use Prologue\Alerts\Facades\Alert;
use ZipArchive;

/**
 * Class ModuleCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ModuleCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Module::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/module');
        CRUD::setEntityNameStrings('افزونه', 'افزونه‌ها');

        (backpack_user()->can('module manage')) ? $this->crud->allowAccess('list') : $this->crud->denyAccess('list'); // list
        (backpack_user()->can('module create')) ? $this->crud->allowAccess('create') : $this->crud->denyAccess('create'); // add
        (backpack_user()->can('module delete')) ? $this->crud->allowAccess('delete') : $this->crud->denyAccess('delete'); // delete
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addColumns([
            [
                'name'  => 'display_name',
                'label' => 'عنوان',
                'type'  => 'text'
            ],
            [
                'name'  => 'status',
                'label' => 'وضعیت',
                'type'     => 'closure',
                'function' => function($entry) {
                    if($entry->status) {
                        return 'فعال';
                    } 
                    return 'غیرفعال';
                }
            ],
            [
                'name'  => 'description',
                'label' => 'توضیحات',
                'type'  => 'text'
            ],
        ]);

        $this->crud->addFilter([
            'name'  => 'status',
            'type'  => 'dropdown',
            'label' => 'وضعیت'
          ], [
            0 => 'غیرفعال',
            1 => 'فعال',
          ], function($value) { // if the filter is active
            $this->crud->addClause('where', 'status', $value);
          });

          $this->crud->addButtonFromModelFunction('line', 'enable', 'enable', 'beginning');

    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ModuleRequest::class);

        CRUD::addFields([
            [   // Browse
                'name'  => 'file',
                'label' => 'فایل',
                'type'  => 'browse',
            ],
        ]);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function enable(Module $module)
    {
        $module->update(['status' => true]);
        Artisan::call('module:enable '.$module->name);
        Alert::error('افزونه '.$module->display_name.' فعال شد.')->flash();
        return redirect()->back();
    }

    public function disable(Module $module)
    {
        $module->update(['status' => false]);
        Artisan::call('module:disable '.$module->name);
        Alert::error('افزونه '.$module->display_name.' غیرفعال شد.')->flash();
        return redirect()->back();
    }


    public function store()
    {
        $path = public_path($this->crud->getRequest()->file);

        $zip = new ZipArchive;
        $res = $zip->open($path);
        if ($res === TRUE) {
            $zip->extractTo(config('modules.paths.modules'));
            $folder = $zip->statIndex(0)['name'];
            $zip->close();
            $json_file = config('modules.paths.modules').'/'.$folder. 'module.json';
            if(file_exists($json_file)) {
                $module = json_decode(file_get_contents($json_file), true);

                // add fields
                $this->crud->addField(['type' => 'hidden', 'name' => 'name']);
                $this->crud->addField(['type' => 'hidden', 'name' => 'description']);
                $this->crud->addField(['type' => 'hidden', 'name' => 'display_name']);

                // set fields value
                $this->crud->getRequest()->request->add(['name'=> $module['name']]);
                $this->crud->getRequest()->request->add(['description'=> $module['description']]);
                $this->crud->getRequest()->request->add(['display_name'=> $module['display_name']]);

                // remove temporary file field
                $this->crud->removeField('file');
                
                // save
                $response = $this->traitStore();
        
                Artisan::call('module:enable', ['module' => $module['name']]);
                Artisan::call('core:update');
                
                return $response;
            }
            echo 'ساختار پلاگین درست نیست';
        } else {
            echo 'فرمت فایل درست نیست';
        }
    }
}
