<?php

namespace Modules\TraficPermit\Http\Controllers\Admin;

use App\Traits\DefaultPermissions;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\ReviseOperation\ReviseOperation;
use Illuminate\Support\Facades\Request;
use Modules\TraficPermit\Enums\TraficPermitStatus;
use Modules\TraficPermit\Http\Requests\RepositoryCreateRequest;
use Modules\Unity\Http\Controllers\Admin\Operations\RestoreOperation;
use Modules\TraficPermit\Http\Requests\RepositoryUpdateRequest;
use Modules\TraficPermit\Models\Country;

/**
 * Class RepositoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RepositoryCrudController extends CrudController
{
    use \RedSquirrelStudio\LaravelBackpackExportOperation\ExportOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;//{ destroy as traitDestroy; }
    use ReviseOperation;
    use RestoreOperation;
    use FetchOperation;
    use DefaultPermissions;
    Const ENTITY = 'Repository';

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\Modules\TraficPermit\Models\Repository::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/repository');
        CRUD::setEntityNameStrings(trans('traficpermit::traficpermit.repository_singular'), trans('traficpermit::traficpermit.repository_plural'));

        /*
        |--------------------------------------------------------------------------
        | PERMISSIONS
        |--------------------------------------------------------------------------
        */
        $this->setPermissions();
    }

    protected function setupReviseOperation() {

        // $this->crud->set('revise.listView', 'traficpermit::operations.revisions');
        // $this->crud->set('revise.timelineView', 'traficpermit::operations.revision_timeline');
    }

    public function setupExportOperation() {
        $this->setupListOperation();
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // add button
        $this->crud->removeButton('create');
        $this->crud->addButton('top', 'traficpermit_create_grouped', 'view', 'traficpermit::buttons.traficpermit_create_grouped', 'beginning');

        // fields
        $this->crud->addColumns([
            [
                'name'  => 'country',
                'label' => 'کشور',
                'attribute' => 'fa_name',
                'type'  => 'relationship',
                'searchLogic' => function ($query, $column, $searchTerm) {
                    $query->whereHas('country', function($query) use($searchTerm) {
                        $query->where('fa_name', 'like', '%'.$searchTerm.'%')->orWhere('en_name', 'like', '%'.$searchTerm.'%');
                    });
                }
            ],
            [
                'name' => 'types',
                'attribute' => 'title',
                'label' => 'نوع',
            ],
            [
                'name' => 'qty',
                'label' => 'تعداد',
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'year',
                'label' => 'سال', // Table column heading
                'type'  => 'date',
                'format' => 'Y'
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'end_date',
                'label' => 'تاریخ اعتبار', // Table column heading
                'type'  => 'date',
                'format' => 'Y/M/D'
            ],
            [
                'name'  => 'status',
                'label' => 'وضعیت',
                'type'  => 'model_function',
                'function_name' => 'getStatusBrowse',
            ],
        ]);

        $this->crud->addFilter([
            'name'  => 'country',
            'type'  => 'select2',
            'label' => 'کشور',
        ],
          function() { // if the filter is active
            return Country::all()->pluck('fa_name', 'id')->toArray();
          } ,
          function($value) { // if the filter is active
            $this->crud->addClause('where', 'country_id', $value); // apply the "active" eloquent scope
          }
        );
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        $this->crud->setValidation(RepositoryCreateRequest::class);

        // Repository::created(function($entry) {

        //     try {

        //         DB::beginTransaction();

        //         if(!$entry->end_serial_number) $entry->end_serial_number = $entry->start_serial_number;
        //         $i = $entry->start_serial_number;

        //         $types = $entry->types->pluck('id')->toArray();

        //         while ($i <= $entry->end_serial_number) {
        //             // create trafic permit
        //             $teafic_permit = $entry->traficpermits()->create([
        //                 'serial_number' => $i,
        //                 'status' => TraficPermitStatus::Active
        //             ]);

        //             // attach types
        //             $teafic_permit->refresh()->types()->attach($types);
        //             $i++;
        //         }

        //         DB::commit();


        //     }catch (\Exception $e) {
        //         DB::rollBack();
        //         $entry->delete();
        //         \Alert::error(trans('traficpermit::traficpermit.insert_repository_failed'))->flash();
        //     }

        // });

        $this->allFields();
    }

    public function store()
    {

        $response = $this->traitStore();

        $repository = $this->crud->getCurrentEntry()->refresh();

        if(!$repository->end_serial_number) $repository->end_serial_number = $repository->start_serial_number;

        $types = $repository->types->pluck('id')->toArray();

        $i = $repository->start_serial_number;

        while ($i <= $repository->end_serial_number) {
            // create trafic permit
            $teafic_permit = $repository->traficpermits()->create([
                'serial_number' => $i,
                'status' => TraficPermitStatus::Active
            ]);

            // attach types
            $teafic_permit->types()->attach($types);
            $i++;
        }

        return $response;
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->crud->setValidation(RepositoryUpdateRequest::class);

        $this->allFields();

        $this->crud->field('start_serial_number')->attributes([
            'class'       => 'form-control ltr',
            'disabled' => true
        ]);
        $this->crud->field('end_serial_number')->attributes([
            'class'       => 'form-control ltr',
            'disabled' => true
        ]);
        $this->crud->field('qty')->attributes([
            'class'       => 'form-control ltr',
            'disabled' => true
        ]);

    }

    public function update()
    {
        $response = $this->traitUpdate();

        $repository = $this->crud->getCurrentEntry()->refresh();

        foreach($repository->traficpermits as $traficpermit) {
            // attach types
            $traficpermit->types()->sync($repository->types->pluck('id')->toArray());
        }

        return $response;
    }

    protected function allFields() {
        $country_id = Request::input('country') ?? $this->crud->getCurrentEntry()->country_id ?? false;
        $countries = Country::active()->pluck('fa_name', 'id')->toArray();

        $this->crud->addFields([
            [   // relationship
                'name' => 'country', // the method on your model that defines the relationship
                'type' => "select_from_array",
                'label' => 'کشور',
                'options' => $countries,
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
                'default' => $country_id,
                'attributes' => [
                    'disabled' => true,
                ],
                'allows_null' => false
            ],
            [
                'name' => 'country_id',
                'type' => 'hidden',
                'value' => $country_id
            ],
            [
                'name' => 'qty',
                'label' => 'تعداد',
                'wrapper' => [
                    'class' => 'form-group col-md-3'
                ]
            ],
            [
                'name' => 'status',
                'type' => 'toggle',
                'label' => 'در دسترس',
                'wrapper'      => [
                    'class'  => "form-group col-md-3"
                ],
            ],
            [
                'name' => 'start_serial_number',
                'label' => trans('traficpermit::traficpermit.start_serial_number'),
                'type' => 'number',
                'prefix' => '<i class="la la-qrcode"></i>',
                'suffix' => 'IR',
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ],
                'attributes' => [
                    'class'       => 'form-control ltr',
                ],
            ],
            [
                'name' => 'end_serial_number',
                'label' => trans('traficpermit::traficpermit.end_serial_number'),
                'prefix' => '<i class="la la-qrcode"></i>',
                'suffix' => 'IR',
                'type' => 'number',
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ],
                'attributes' => [
                    'class'       => 'form-control ltr',
                ],
            ],
            [
                'name' => 'year',
                'label' => trans('traficpermit::traficpermit.year'),
                'prefix' => '<i class="la la-calandar"></i>',
                'type' => 'date_picker',
                'date_picker_options' => [
                    // 'todayBtn' => 'linked',
                    'format'   => 'yyyy',
                    'language' => 'en',
                    'minViewMode' => 'years'
                ],
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [
                'name' => 'end_date',
                'label' => trans('traficpermit::traficpermit.end_date'),
                'prefix' => '<i class="la la-calandar"></i>',
                'type' => 'date_picker',
                'date_picker_options' => [
                    'todayBtn' => 'linked',
                    'format'   => 'yyyy/mm/dd',
                    'language' => 'en'
                ],
                'wrapper' => [
                    'class' => 'form-group col-md-6'
                ]
            ],
            [ // Text
                'name'  => 'types',
                'label' => '<i class="la la-folder"></i>  '.trans('traficpermit::traficpermit.trafic_permit_type_singular'),
                'type'  => 'checklist',
                'entity' => 'types',
                // 'options' => $country->types->pluck('title', 'id')->toArray(),
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
            ],
            [   // relationship
                'type' => "relationship",
                'name' => 'traficPermitTemplate', // the method on your model that defines the relationship
                'ajax' => true,
                // 'inline_create' => [ 'entity' => 'group' ], // specify the entity in singular
                'label' => trans('traficpermit::traficpermit.trafic_permit_template_singular'),
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
                'minimum_input_length' => 0,
                // OPTIONALS:
                // 'label' => "Category",
                'attribute' => "title", // foreign key attribute that is shown to user (identifiable attribute)
                'entity' => 'traficPermitTemplate', // the method that defines the relationship in your Model
                'model' => "Modules\TraficPermit\Models\TraficPermitTemplate", // foreign key Eloquent model
                'placeholder' => "انتخاب قالب چاپ", // placeholder for the select2 input
                'dependencies'         => ['country_id', 'types'], // when a dependency changes, this select2 is reset to null
                'include_all_form_fields'  => true,
                'data_source' => url('/api/traficpermit/trafic-permit-template'),
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
                'hint' => 'پیش از انتخاب قالب چاپ نوع مجوز را انتخاب کنید',
            ],
        ]);
    }

    // public function destroy($id)
    // {
    //     $this->crud->hasAccessOrFail('delete');

    //     $repository = $this->crud->getCurrentEntry();

    //     $repository->de

    //     return $this->crud->delete($id);
    // }

    /**
    * Define what happens when the Setting operation is loaded.
    *
    * @see https://github.com/rezahmady/setting-operation
    * @return void
    */
    protected function setupSettingOperation()
    {
        //
    }

    public function fetchCountry()
    {
        return $this->fetch(Country::class);
    }
}
