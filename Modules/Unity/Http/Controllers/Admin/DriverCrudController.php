<?php

namespace Modules\Unity\Http\Controllers\Admin;

use App\Traits\DefaultPermissions;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Modules\Unity\Enums\DriverContractStatus;
use Modules\Unity\Http\Controllers\Admin\Operations\CreateDriverOperation;
use Modules\Unity\Http\Requests\DriverRequest;
use Modules\Unity\Models\Driver;
use Modules\Unity\Models\DriverContract;
use Modules\Unity\Models\Unity;

/**
 * Class DriverCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DriverCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    //use CreateDriverOperation;
    //use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
    use \Rezahmady\SettingOperation\SettingOperation;
    use DefaultPermissions;
    Const ENTITY = 'driver';

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\Modules\Unity\Models\Driver::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/driver');
        CRUD::setEntityNameStrings(trans('unity::unity.driver_singular'), trans('unity::unity.driver_plural'));

        /*
        |--------------------------------------------------------------------------
        | PERMISSIONS
        |--------------------------------------------------------------------------
        */
        $this->setPermissions();
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // check permissions
        if(!backpack_user()->can('driver manage all') and backpack_user()->unity) {
            $this->crud->addClause('where', 'unity_id', '=', backpack_user()->unity->id);
        } elseif(!backpack_user()->can('driver manage all')) {
            abort(403);
        } else {
            $this->crud->addColumn([
                'name' => 'unity',
                'attribute' => 'fa_name',
                'label' => trans('unity::unity.unity_singular')
            ]);

            $this->crud->addFilter(
                [
                    'name'  => 'unity',
                    'type'  => 'select2',
                    'label' => trans('unity::unity.unity_plural'),
                ],
                Unity::pluck('fa_name', 'id')->toArray(),
                function ($value) { // if the filter is active
                    $this->crud->addClause('whereHas', 'unity' , function($query) use($value) {
                        $query->where('id', $value);
                    });
                }
            );
        }
        $this->crud->addColumns([
            [
                'name' => 'fa_name',
                'label' => 'نام',
            ],
            [
                'name' => 'en_name',
                'label' => 'نام انگلیسی',
            ],
        ]);
    }

    protected function setupShowOperation()
    {
        // check permissions
        if(!backpack_user()->can('driver manage all') and backpack_user()->unity) {
            if($this->crud->getCurrentEntry()->unity->id !== backpack_user()->unity->id) abort(403);
        } elseif(!backpack_user()->can('driver manage all')) {
            abort(403);
        } else {
            $this->crud->addColumn([
                'name' => 'unity',
                'label'    => 'شرکت',
                'attribute' => 'fa_name'
            ]);
        }
        $this->crud->addColumns([
            [
                'name' => 'fa_name',
                'label' => 'نام',
            ],
            [
                'name' => 'en_name',
                'label' => 'نام انگلیسی',
            ],
            [
                'name' => 'national_id',
                'label' => 'کدملی',
            ],
            [
                'name' => 'mobile',
                'label' => 'شماره همراه',
            ],
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        $this->crud->setValidation(DriverRequest::class);

        Driver::created(function($entry) {

            if($entry->unity) {
                DriverContract::create([
                    'user_id' => backpack_user()->id,
                    'driver_id' => $entry->id,
                    'unity_id' => $entry->unity->id,
                    'contract_status' => DriverContractStatus::Active->value,
                    'start_date' => Carbon::now()->format('Y/m/d'),
                ]);
            }
        });

        Driver::creating(function($entry) {

            if(!backpack_user()->can('driver manage all') and backpack_user()->unity) {
                $entry->unity_id = backpack_user()->unity->id;
            }

        });

        if(backpack_user()->can('driver manage all')) {
            $this->crud->addField([   // relationship
                'type' => "relationship",
                'name' => 'unity', // the method on your model that defines the relationship
                'ajax' => true,
                // 'inline_create' => [ 'entity' => 'group' ], // specify the entity in singular
                'label' => 'شرکت',
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
                'tab' => 'مشخصات',
                'minimum_input_length' => 0,
                'attribute' => "fa_name", // foreign key attribute that is shown to user (identifiable attribute)
                'entity' => 'unity', // the method that defines the relationship in your Model
                'model' => "Modules\Unity\Models\Unity", // foreign key Eloquent model
                'placeholder' => "انتخاب شرکت", // placeholder for the select2 input
            ]);
        }

        $this->crud->addFields([
            [
                'name'  => 'fa_name',
                'label' => 'نام و نام خانوادگی فارسی',
                'prefix' => '<i class="la la-pencil-square la-lg"></i>',
                'attributes' => [
                    'placeholder' => 'عنوان واحد را اینجا بنویسید',
                    'class'       => 'form-control form-control-lg'
                ],
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
                'tab' => 'مشخصات',
            ],
            [
                'name'  => 'en_name',
                'label' => 'English firstname and lastname',
                'suffix' => '<i class="la la-pencil-square la-lg"></i>',
                'attributes' => [
                    'placeholder' => 'Full Name',
                    'class'       => 'form-control form-control-lg text-left'
                ],
                'wrapper'      => [
                    'class'  => "form-group col-md-6 text-left"
                ],
                'tab' => 'مشخصات',
            ],
            [
                'name' => 'national_id',
                'label' => 'کدملی',
                'suffix' => '<i class="la la-id-card-alt"></i>',
                'attributes' => [
                    'dir' => 'ltr',
                ],
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
                'tab' => 'مشخصات',
            ],
            [
                'name' => 'mobile',
                'label' => 'شماره همراه',
                'suffix' => '<i class="la la-mobile"></i>',
                'attributes' => [
                    'placeholder' => 'مانند: 09120000000',
                    'dir' => 'ltr',
                ],
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
                'tab' => 'مشخصات',
            ],
        ]);


    }


    protected function setupCreateDriverOperation()
    {
        $this->crud->setValidation(DriverRequest::class);

        $this->crud->addFields([
            [
                'name' => 'national_id',
                'label' => 'کدملی',
                'suffix' => '<i class="la la-id-card-alt"></i>',
                'attributes' => [
                    'dir' => 'ltr',
                ],
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
                'tab' => 'مشخصات',
            ],
        ]);


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

    public function fetchUnity()
    {
        return $this->fetch([
            'model' => Unity::class,
            'searchable_attributes' => ['fa_name', 'en_name']
        ]);
    }
}
