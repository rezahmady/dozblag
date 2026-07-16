<?php

namespace Modules\TraficPermit\Http\Controllers\Admin;

use App\Traits\DefaultPermissions;
use App\Traits\DropzoneTrait;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use Modules\TraficPermit\Enums\PermitOrderStatus;
use Modules\TraficPermit\Http\Controllers\Admin\Operations\CancelOrderTraficPermitOperation;
use Modules\TraficPermit\Http\Controllers\Admin\Operations\PermitexportOperation;
use Modules\Unity\Http\Controllers\Admin\Operations\RestoreOperation;
use Modules\TraficPermit\Http\Requests\PermitOrderRequest;
use Modules\TraficPermit\Models\Country;
use Modules\TraficPermit\Models\PermitOrder;
use Modules\TraficPermit\Models\Repository;
use Modules\Unity\Models\Driver;
use Modules\Unity\Models\Truck;
use Modules\Unity\Models\Unity;
use Rezahmady\SettingOperation\Setting;

/**
 * Class PermitOrderCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PermitOrderCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { create as traitCreate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Rezahmady\SettingOperation\SettingOperation;
    use CancelOrderTraficPermitOperation;
    use PermitexportOperation;
    use DefaultPermissions;
    use RestoreOperation;
    use FetchOperation;
    use DropzoneTrait;
    Const ENTITY = 'PermitOrder';

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\Modules\TraficPermit\Models\PermitOrder::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/permit-order');
        CRUD::setEntityNameStrings(trans('traficpermit::traficpermit.permit_order_singular'), trans('traficpermit::traficpermit.permit_order_plural'));

        $this->crud->query->orderBy('status', 'DESC')->orderBy('updated_at', 'DESC');

        /*
        |--------------------------------------------------------------------------
        | PERMISSIONS
        |--------------------------------------------------------------------------
        */
        $this->setPermissions();

        (backpack_user()->can('PermitOrder special')) ? $this->crud->allowAccess('traficpermitexport') : $this->crud->denyAccess('traficpermitexport');
        (backpack_user()->can('PermitOrder special')) ? $this->crud->allowAccess('restore') : $this->crud->denyAccess('restore');
        (backpack_user()->can('PermitOrder create')) ? $this->crud->allowAccess('cancelOrderTraficPermit') : $this->crud->denyAccess('cancelOrderTraficPermit');

        if(!backpack_user()->can('truck manage all') and backpack_user()->unity) {
            $this->crud->removeButton('update');
            $this->crud->allowAccess('update-before-issuing');
        }
    }

    protected function setupShowOperation()
    {
        if(!backpack_user()->can('truck manage all') and backpack_user()->unity) {
            if($this->crud->getCurrentEntry()->unity->id !== backpack_user()->unity->id) abort(403);
        } elseif(!backpack_user()->can('truck manage all')) {
            abort(403);
        } else {
            $this->crud->addColumn([
                'name' => 'unity',
                'label'    => 'شرکت',
                'attribute' => 'fa_name',
                'type'     => 'relationship',
            ]);
        }
        $this->crud->addColumns([
            [
                'name' => 'truck',
                'label'    => 'وسیله نقلیه',
                'type'     => 'relationship',
            ],
            [
                'name' => 'driver',
                'label'    => 'راننده',
                'attribute'    => 'fa_name',
                'type'     => 'relationship',
            ],
            [
                'name' => 'status',
                'type' => 'model_function',
                'function_name' => 'getStatusBrowse',
                'label' => 'وضعیت',
            ],
            [
                'name' => 'destination',
                'label'    => 'مقصد',
                'type'     => 'relationship',
            ],
        ]);
    }

    protected function setupPermitexportOperation()
    {
       if(!backpack_user()->can('truck manage all') and backpack_user()->unity) {
            if($this->crud->getCurrentEntry()->unity->id !== backpack_user()->unity->id) abort(403);
        } elseif(!backpack_user()->can('truck manage all')) {
            abort(403);
        } else {
            $this->crud->addColumn([
                'name' => 'unity',
                'label'    => 'شرکت',
                'attribute' => 'fa_name',
                'type'     => 'relationship',
            ]);
        }
        $this->crud->addColumns([
            [
                'name' => 'truck',
                'label'    => 'وسیله نقلیه',
                'type'     => 'relationship',
            ],
            [
                'name' => 'driver',
                'label'    => 'راننده',
                'attribute'    => 'fa_name',
                'type'     => 'relationship',
            ],
            [
                'name' => 'destination',
                'label'    => 'مقصد',
                'type'     => 'relationship',
            ],

            [   // Upload
                'name'      => 'photos',
                'label'     => 'تصاویر اسناد (مانند تصویر cmr، کارنه تیر و ...)',
                'type'      => 'dropzone',
                'mimes'            => 'image/*,application/pdf',
                'max_file_size'    => 10, // MB
                'webp'             => true,
                'destination_path' => 'uploads/permit-order-attachments',
//                'view_namespace'  => 'backpack::crud.fields',
                'thumb_prefix' => '',
                'upload'    => true,
                'disk'      => 'local', // if you store files in the /public folder, please omit this; if you store them in /storage or S3, please specify it;
                // optional:
//                'temporary' => 10 // if using a service, such as S3, that requires you to make temporary URLs this will make a URL that is valid for the number of minutes specified
            ],
        ]);

       $amounts = [];

       $amounts[Setting::get('transactions.default_price', 0)] = number_format(Setting::get('transactions.default_price', 0)). ' تومان';
       $second_prices = json_decode(Setting::get('transactions.second_prices', 0), true);
       foreach ($second_prices as $price) {
           $amounts[$price['price']] = number_format($price['price']).' تومان';
       }

        $this->crud->addFields([
            [   // 1-n relationship
                'label'       => "", // Table column heading
                'type'        => "select2_from_ajax",
                'name'        => 'traficpermit', // the column that contains the ID of that connected entity
                // 'entity'      => 'traficpermit', // the method that defines the relationship in your Model
                'attribute'   => "serial_number", // foreign key attribute that is shown to user
                'data_source' => url('/api/traficpermit/for-print'), // url to controller search function (with /{id} should return model)
                'wrapper'      => [
                    'class'  => "form-group col-md-8"
                ],
                // OPTIONAL
                'delay'                   => 400, // the minimum amount of time between ajax requests when searching in the field
                'placeholder'             => "شماره سریال را انتخاب کنید", // placeholder for the select
                'minimum_input_length'    => 1, // minimum characters to type before querying results
                'model'                   => "Modules\TraficPermit\Models\TraficPermit", // foreign key model
                // 'dependencies'            => ['category'], // when a dependency changes, this select2 is reset to null
                'method'                  => 'POST', // optional - HTTP method to use for the AJAX call (GET, POST)
                'include_all_form_fields' => true, // optional - only send the current field through AJAX (for a smaller payload if you're not using multiple chained select2s)
            ],
            [   // select2_from_array
                'name'        => 'price',
                'label'       => "قیمت",
                'type'        => 'select2_from_array',
                'options'     => $amounts,
                'allows_null' => false,
                'wrapper'      => [
                    'class'  => "form-group col-md-4"
                ],
//                'default'     => 'one',
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                // 'sortable' => true, // requires the field to accept multiple values, and allow the selected options to be sorted.
            ]
        ]);
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        if ($this->userMustSettleDebt()) {
            $amount = number_format(abs(backpack_user()->unity->cashed_balance));
            Widget::add([
                'type' => 'alert',
                'class' => 'alert alert-danger mb-3',
                'heading' => 'بدهی تسویه‌نشده',
                'content' => 'موجودی حساب شما منفی است (<span dir="ltr">-'.$amount.'</span> تومان). برای ثبت درخواست جدید ابتدا بدهی را تسویه کنید.',
            ]);
        }

        $this->crud->addButton('line', 'update-order', 'view', 'traficpermit::buttons.update', 'start');
        $this->crud->addColumn([
            'name' => 'ordernumber',
            'label'    => 'شماره',
        ]);

        if(!backpack_user()->can('truck manage all') and backpack_user()->unity) {
            $this->crud->addClause('where', 'unity_id', '=', backpack_user()->unity->id);
        } elseif(!backpack_user()->can('truck manage all')) {
            abort(403);
        } else {
            $this->crud->addColumn([
                'name' => 'unity',
                'label'    => 'شرکت',
                'attribute' => 'fa_name',
                'type'     => 'relationship',
            ]);

            $this->crud->addFilter(
                [
                    'name'  => 'unity',
                    'type'  => 'select2',
                    'label' => trans('unity::unity.unity_singular'),
                ],
                Unity::pluck('fa_name', 'id')->toArray(),
                function ($value) { // if the filter is active
                    $this->crud->addClause('whereHas', 'unity' , function($query) use($value) {
                        $query->where('id', $value);
                    });
                }
            );

            $this->crud->addFilter(
                [
                    'name'  => 'truck',
                    'type'  => 'select2',
                    'label' => trans('unity::unity.truck_singular'),
                ],
                Truck::pluck('transit_number', 'id')->toArray(),
                function ($value) { // if the filter is active
                    $this->crud->addClause('whereHas', 'truck' , function($query) use($value) {
                        $query->where('id', $value);
                    });
                }
            );
        }
        $this->crud->addColumns([
            [
                'name' => 'truck',
                'label'    => 'وسیله نقلیه',
                'type'     => 'relationship',
            ],
            [
                'name' => 'driver',
                'label'    => 'راننده',
                'attribute'    => 'fa_name',
                'type'     => 'relationship',
            ],
            [
                'name' => 'status',
                'type' => 'model_function',
                'function_name' => 'getStatusBrowse',
                'label' => 'وضعیت',
            ],
            [
                'name' => 'destination',
                'label'    => 'مقصد',
                'type'     => 'relationship',
            ],
            [
                'name' => 'carnet_number',
                'label'    => 'کارنه‌تیر',
            ],
            [
                'name' => 'date',
                'label'    => 'تاریخ',
                'type' => 'model_function',
                'function_name' => 'getDateBrowse',
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
        // $this->crud->setCreateContentClass('col-md-12');
        // $this->crud->setUpdateContentClass('col-md-12');

        $this->crud->setValidation(PermitOrderRequest::class);

        PermitOrder::creating(function($entry) {

            if(!backpack_user()->can('truck manage all') and backpack_user()->unity) {
                $entry->unity_id = backpack_user()->unity->id;
            }

            $entry->ordernumber = substr(date('Y'), -2).$entry->unity_id.'/'.Unity::find($entry->unity_id)->orders()->whereYear('created_at', date('Y'))->count()+1;

        });

        if(!backpack_user()->can('truck manage all') and backpack_user()->unity) {
            $this->crud->addFields([
                [
                    'name' => 'unity_id',
                    'type' => 'hidden',
                    'value' => backpack_user()->unity->id
                ],
                [   // relationship
                    'type' => "relationship",
                    'name' => 'truck', // the method on your model that defines the relationship
                    'ajax' => true,
                    //'hint' => trans('traficpermit::traficpermit.permitorder_truck_description'),
                    // 'inline_create' => [ 'entity' => 'group' ], // specify the entity in singular
                    'label' => trans('unity::unity.truck_singular'),
                    'wrapper'      => [
                        'class'  => "form-group col-md-4"
                    ],
                    'minimum_input_length' => 0,
                    // OPTIONALS:
                    // 'label' => "Category",
                    'attribute' => "transit_number", // foreign key attribute that is shown to user (identifiable attribute)
                    'entity' => 'truck', // the method that defines the relationship in your Model
                    'model' => "Modules\Unity\Models\Truck", // foreign key Eloquent model
                    'placeholder' => "انتخاب کامیون", // placeholder for the select2 input
                    'dependencies'         => ['unity_id'], // when a dependency changes, this select2 is reset to null
                    'include_all_form_fields'  => true,
                    'data_source' => url('/api/unity/truck-order'),
                ],
                [   // relationship
                    'type' => "relationship",
                    'name' => 'trailer', // the method on your model that defines the relationship
                    'ajax' => true,
                    //'hint' => trans('traficpermit::traficpermit.permitorder_truck_description'),
                    // 'inline_create' => [ 'entity' => 'group' ], // specify the entity in singular
                    'label' => trans('unity::unity.trailer_singular'),
                    'wrapper'      => [
                        'class'  => "form-group col-md-4"
                    ],
                    'minimum_input_length' => 0,
                    // OPTIONALS:
                    // 'label' => "Category",
                    'attribute' => "transit_number", // foreign key attribute that is shown to user (identifiable attribute)
                    'entity' => 'trailer', // the method that defines the relationship in your Model
                    'model' => "Modules\Unity\Models\Trailer", // foreign key Eloquent model
                    'placeholder' => "انتخاب یدک", // placeholder for the select2 input
                    'dependencies'         => ['unity_id'], // when a dependency changes, this select2 is reset to null
                    'include_all_form_fields'  => true,
                    'data_source' => url('/api/unity/trailer-sysadminii'),
                ],
                [   // relationship
                    'type' => "relationship",
                    'name' => 'driver', // the method on your model that defines the relationship
                    'ajax' => true,
                    // 'inline_create' => [ 'entity' => 'group' ], // specify the entity in singular
                    'label' => trans('unity::unity.driver_singular'),
                    'wrapper'      => [
                        'class'  => "form-group col-md-4"
                    ],
                    'minimum_input_length' => 0,
                    // OPTIONALS:
                    // 'label' => "Category",
                    'attribute' => "fa_name", // foreign key attribute that is shown to user (identifiable attribute)
                    'entity' => 'driver', // the method that defines the relationship in your Model
                    'model' => "Modules\Unity\Models\Driver", // foreign key Eloquent model
                    'placeholder' => "انتخاب راننده", // placeholder for the select2 input
                    'include_all_form_fields'  => true,
                    'dependencies'         => ['unity_id'], // when a dependency changes, this select2 is reset to null
                    'data_source' => url('/api/unity/driver-order'),
                ],
            ]);
        } elseif(!backpack_user()->can('truck manage all')) {
            abort(403);
        } else {
            $this->crud->addFields([
                [   // relationship
                    'type' => "relationship",
                    'name' => 'unity_id', // the method on your model that defines the relationship
                    'ajax' => true,
                    // 'inline_create' => [ 'entity' => 'group' ], // specify the entity in singular
                    'label' => trans('unity::unity.unity_singular'),
                    'wrapper'      => [
                        'class'  => "form-group col-md-4"
                    ],
                    'minimum_input_length' => 0,
                    // OPTIONALS:
                    // 'label' => "Category",
                    'attribute' => "fa_name", // foreign key attribute that is shown to user (identifiable attribute)
                    'entity' => 'unity', // the method that defines the relationship in your Model
                    'model' => "Modules\Unity\Models\Unity", // foreign key Eloquent model
                    'placeholder' => "انتخاب شرکت", // placeholder for the select2 input
                ],
                [   // relationship
                    'type' => "relationship",
                    'name' => 'truck', // the method on your model that defines the relationship
                    //'hint' => trans('traficpermit::traficpermit.permitorder_truck_description'),
                    'ajax' => true,
                    // 'inline_create' => [ 'entity' => 'group' ], // specify the entity in singular
                    'label' => trans('unity::unity.truck_singular'),
                    'wrapper'      => [
                        'class'  => "form-group col-md-4"
                    ],
                    'minimum_input_length' => 0,
                    // OPTIONALS:
                    // 'label' => "Category",
                    'attribute' => "transit_number", // foreign key attribute that is shown to user (identifiable attribute)
                    'entity' => 'truck', // the method that defines the relationship in your Model
                    'model' => "Modules\Unity\Models\Truck", // foreign key Eloquent model
                    'placeholder' => "انتخاب کامیون", // placeholder for the select2 input
                    'dependencies'         => ['unity_id'], // when a dependency changes, this select2 is reset to null
                    'include_all_form_fields'  => true,
                    'data_source' => url('/api/unity/truck-sysadminii'),
                ],
                [   // relationship
                    'type' => "relationship",
                    'name' => 'trailer', // the method on your model that defines the relationship
                    //'hint' => trans('traficpermit::traficpermit.permitorder_truck_description'),
                    'ajax' => true,
                    // 'inline_create' => [ 'entity' => 'group' ], // specify the entity in singular
                    'label' => trans('unity::unity.trailer_singular'),
                    'wrapper'      => [
                        'class'  => "form-group col-md-4"
                    ],
                    'minimum_input_length' => 0,
                    // OPTIONALS:
                    // 'label' => "Category",
                    'attribute' => "transit_number", // foreign key attribute that is shown to user (identifiable attribute)
                    'entity' => 'trailer', // the method that defines the relationship in your Model
                    'model' => "Modules\Unity\Models\Trailer", // foreign key Eloquent model
                    'placeholder' => "انتخاب یدک", // placeholder for the select2 input
                    'dependencies'         => ['unity_id'], // when a dependency changes, this select2 is reset to null
                    'include_all_form_fields'  => true,
                    'data_source' => url('/api/unity/trailer-sysadminii'),
                ],
                [   // relationship
                    'type' => "relationship",
                    'name' => 'driver', // the method on your model that defines the relationship
                    'ajax' => true,
                    // 'inline_create' => [ 'entity' => 'group' ], // specify the entity in singular
                    'label' => trans('unity::unity.driver_singular'),
                    'wrapper'      => [
                        'class'  => "form-group col-md-4"
                    ],
                    'minimum_input_length' => 0,
                    // OPTIONALS:
                    // 'label' => "Category",
                    'attribute' => "fa_name", // foreign key attribute that is shown to user (identifiable attribute)
                    'entity' => 'driver', // the method that defines the relationship in your Model
                    'model' => "Modules\Unity\Models\Driver", // foreign key Eloquent model
                    'placeholder' => "انتخاب راننده", // placeholder for the select2 input
                    'dependencies'         => ['unity_id'], // when a dependency changes, this select2 is reset to null
                    'include_all_form_fields'  => true,
                    'data_source' => url('/api/unity/driver-order'),
                ],
            ]);
        }



        $this->crud->addFields([
            [   // relationship
                'type' => "relationship",
                'name' => 'destination', // the method on your model that defines the relationship
                'ajax' => true,
                // 'inline_create' => [ 'entity' => 'group' ], // specify the entity in singular
                'label' => trans('traficpermit::traficpermit.destination'),
                'wrapper'      => [
                    'class'  => "form-group col-md-4"
                ],
                'minimum_input_length' => 0,
                // OPTIONALS:
                // 'label' => "Category",
                'attribute' => "fa_name", // foreign key attribute that is shown to user (identifiable attribute)
                'entity' => 'destination', // the method that defines the relationship in your Model
                'model' => "Modules\TraficPermit\Models\Country", // foreign key Eloquent model
                'placeholder' => "انتخاب کشور", // placeholder for the select2 input
            ],
            [
                'name'  => 'carnet_number',
                'label' => 'شماره کارنه',
                'prefix' => '<i class="la la-file-alt"></i>',
                'attributes' => [
                    // 'placeholder' => '',
                    'class'       => 'form-control ltr',
                    // 'disabled' => true
                ],
                'wrapper'      => [
                    'class'  => "form-group col-md-4"
                ],
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'carnet_date',
                'label' => 'تاریخ صدور کارنه', // Table column heading
                'type'  => 'date_picker',
                'wrapper'      => [
                    'class'  => "form-group col-md-4"
                ],
            ],
            [   // Upload
                'name'      => 'photos',
                'label'     => 'تصاویر اسناد (مانند تصویر cmr، کارنه تیر و ...)',
                'type'      => 'dropzone',
                'mimes'            => 'image/*,application/pdf',
                'max_file_size'    => 10, // MB
                'webp'             => true,
                'destination_path' => 'uploads/permit-order-attachments',
//                'view_namespace'  => 'backpack::crud.fields',
                'thumb_prefix' => '',
                'upload'    => true,
                'disk'      => 'local', // if you store files in the /public folder, please omit this; if you store them in /storage or S3, please specify it;
                // optional:
//                'temporary' => 10 // if using a service, such as S3, that requires you to make temporary URLs this will make a URL that is valid for the number of minutes specified
            ],
        ]);

        $options = Repository::active()
        ->with('types')
        // 1.country must be active
        ->whereHas('country',  function($q)  {
            $q->where('status', 1);
        })
        // 2.check validity date
        ->whereDate('end_date', '>=', Carbon::now())
        // 3. check stock
        ->whereHas('availableTraficpermitsForRequest')
        // get and convert to array
        ->select(['id', 'country_id'])
        ->get()
        ->append([ 'unique_key','types_array'])
        ->makeHidden(['country', 'types'])
        ->toArray();

        $options = $this->unique_array($options, 'unique_key');

        $exports = [];

        if($this->crud->getCurrentEntry())
        $exports = $this->crud->getCurrentEntry()->traficPermits()->wherePivot('status', 1)->get() ?? [];

        $keys = [];
        foreach($exports as $export) {
            $keys[] = $export->repository->unique_key;
        }

        foreach($options as $key => $option) {
            $options[$key]['disabled'] = false;
            foreach($exports as $export) {
                if(in_array($option['unique_key'], $keys)) {
                    $options[$key]['disabled'] = true;
                }
            }
        }

        if(sizeof($options)) {
            $this->crud->addField([
                'type'      => 'view',
                'view'      => 'traficpermit::fields.checklist_image',
                'name'      => 'orders',
                'attribute' => 'fa_name',
                'wrapper'      => [
                    'class'  => "form-group p-0 w-100 mb-0 mobile-overflow-x"
                ],
                'options' => $options,
                'fake' => true,
                'number_of_columns' => 4,
                // 'label' => 'مجوز های مورد درخواست',
                'label' => '',
            ],
        );
        }

    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        if(!backpack_user()->can('truck manage all') and backpack_user()->unity) {
            if($this->crud->getCurrentEntry()->status === 'pending') {
                $this->crud->allowAccess('update');
            }
        }
        $this->setupCreateOperation();
    }

    public function update() {
        $response = $this->traitUpdate();

        $orders = json_decode($this->crud->getRequest()->orders, false);
        $orders_count = sizeof($orders);

        $exported_trafic_permit_count = $this->crud->getCurrentEntry()->traficPermits()->wherePivot('status', 1)->count();

        if($exported_trafic_permit_count === 0 || $orders_count === 0){
            $status = PermitOrderStatus::Pending->value;
        } elseif($orders_count === $exported_trafic_permit_count) {
            $status = PermitOrderStatus::Completed->value;
        } elseif($orders_count > $exported_trafic_permit_count ) {
            $status = PermitOrderStatus::Issuing->value;
        } else {
            $status = PermitOrderStatus::Completed->value;
        }

        if($this->crud->getCurrentEntry()->status !== $status) {
            $this->crud->getCurrentEntry()->update(['status' => $status]);
        }

        return $response;
    }

    /**
    * Define what happens when the Setting operation is loaded.
    *
    * @see https://github.com/rezahmady/setting-operation
    * @return void
    */
    protected function setupSettingOperation()
    {
        $this->crud->addFields([
            [
                'name'    => 'info_text',
                'type'    => 'summernote',
                'options' => [
                    'toolbar' => []
                ],
                'label'   => 'متن تذکر در صفحه ایجاد درخواست',
                // 'tab' => 'مشخصات',
            ],
            [
                'name' => 'max_permit_in_one_request',
                'type' => 'number',
                'label' => 'حداکثر تعداد مجوز در یک درخواست',
                'wrapper' => [
                    'class' => 'form-group col-md-3',
                ],
            ]
        ]);
    }

    /**
     * Show the form for creating a new permit order, or a debt settlement notice.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $this->crud->hasAccessOrFail('create');

        if ($this->userMustSettleDebt()) {
            $this->data['crud'] = $this->crud;
            $this->data['title'] = $this->crud->getTitle() ?? trans('backpack::crud.add').' '.$this->crud->entity_name;
            $this->data['debt_amount'] = abs(backpack_user()->unity->cashed_balance);
            $this->data['debt_formatted'] = number_format(abs(backpack_user()->unity->cashed_balance));

            return view('traficpermit::operations.debt_blocked', $this->data);
        }

        return $this->traitCreate();
    }

    /**
     * Whether blocking new orders for indebted companies is enabled in general settings.
     */
    protected function isDebtBlockEnabled(): bool
    {
        return (string) Setting::get('trafic_permit_general.block_order_on_debt', '1') === '1';
    }

    /**
     * Users with expert/admin permissions may create orders despite company debt.
     */
    protected function userCanBypassDebtCheck(): bool
    {
        return backpack_user()->can('PermitOrder special')
            || backpack_user()->can('truck manage all');
    }

    /**
     * Company users with a negative wallet balance must settle before creating orders.
     */
    protected function userMustSettleDebt(): bool
    {
        if (! $this->isDebtBlockEnabled()) {
            return false;
        }

        if ($this->userCanBypassDebtCheck()) {
            return false;
        }

        $unity = backpack_user()->unity;

        return $unity && $unity->cashed_balance < 0;
    }

    public function fetchUnity()
    {
        return $this->fetch([
            'model' => Unity::class,
            'searchable_attributes' => ['fa_name', 'en_name']
        ]);
    }

    public function fetchDestination()
    {
        return $this->fetch(Country::class);
    }

    public function fetchTruck()
    {
        return $this->fetch(Truck::class);
    }

    public function fetchDriver()
    {
        return $this->fetch(Driver::class);
    }

    public function unique_array($my_array, $key) {
        $result = array();
        $i = 0;
        $key_array = array();

        foreach($my_array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $result[$i] = $val;
            }
            $i++;
        }
        return $result;
    }
}
