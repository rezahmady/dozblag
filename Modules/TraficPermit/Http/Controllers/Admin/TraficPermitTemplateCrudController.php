<?php

namespace Modules\TraficPermit\Http\Controllers\Admin;

use App\Traits\DefaultPermissions;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use Modules\TraficPermit\Http\Requests\TraficPermitTemplateRequest;
use Modules\TraficPermit\Models\Country;
use Illuminate\Support\Facades\Request;
use Modules\TraficPermit\Enums\PaperSize;

/**
 * Class TraficPermitTemplateCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TraficPermitTemplateCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation;
    // use \Rezahmady\SettingOperation\SettingOperation;
    use DefaultPermissions;
    Const ENTITY = 'TraficPermitType';

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\Modules\TraficPermit\Models\TraficPermitTemplate::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/trafic-permit-template');
        CRUD::setEntityNameStrings(trans('traficpermit::traficpermit.trafic_permit_template_singular'), trans('traficpermit::traficpermit.trafic_permit_template_plural'));

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
        // add button
        $this->crud->removeButton('create');
        $this->crud->addButton('top', 'traficpermit_create_grouped', 'view', 'traficpermit::buttons.traficpermit_create_grouped', 'beginning');

        $this->crud->addColumns([
            [
                'name' => 'title',
                'label' => 'عنوان',
            ],
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
                'name'  => 'status',
                'label' => 'وضعیت',
                'type'  => 'model_function',
                'function_name' => 'getStatusBrowse',
            ],
        ]);

        // $this->crud->addFilter([
        //     'name'  => 'country',
        //     'type'  => 'select2',
        //     'label' => 'کشور',
        // ],
        //   function() { // if the filter is active
        //     return Country::all()->pluck('fa_name', 'id')->toArray();
        //   } ,
        //   function($value) { // if the filter is active
        //     $this->crud->addClause('where', 'country_id', $value); // apply the "active" eloquent scope
        //   } 
        // );
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(TraficPermitTemplateRequest::class);

        $country_id = Request::input('country') ?? $this->crud->getCurrentEntry()->country_id ?? false;
        if(!$country_id){
            $country = Country::active()->first();
            $country_id =$country_id;
        }  else {
            $country = Country::find($country_id);
        }
        $countries = Country::active()->pluck('fa_name', 'id')->toArray();
        
        $this->crud->setCreateContentClass('col-md-12');
        $this->crud->setUpdateContentClass('col-md-12');

        Widget::add()->type('script')->content('/modules/traficpermit/trafic_permit_tmplate.js');


        $this->crud->addFields([
            [
                'name' => 'title',
                'attributes' => [
                    'placeholder' => 'عنوان قالب را اینجا بنویسید',
                ],
                'label' => 'عنوان',
                'wrapper' => [
                    'class'  => "form-group col-md-6"
                ],
            ],
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
            // [ // Text
            //     'name'  => 'types',
            //     'label' => '<i class="la la-folder"></i>  '.trans('traficpermit::traficpermit.trafic_permit_type_singular'),
            //     'type'  => 'checklist',
            //     'entity' => 'types',
            //     // 'options' => $country->types->pluck('title', 'id')->toArray(),
            //     'wrapper'      => [
            //         'class'  => "form-group col-md-4"
            //     ],
            // ],
            [
                'name'        => 'paper_size',
                'fake'        => true,
                'label'       => "اندازه صفحه",
                'type'        => 'select2_from_array',
                'options'     => PaperSize::get_translated_array(),
                'allows_null' => false,
                'wrapper' => ['class' => 'form-group col-md-4'],
            ],
            [
                'name' => 'status',
                'type' => 'toggle',
                'label' => 'در دسترس',
                'wrapper'      => [
                    'class'  => "form-group col-md-4"
                ],
            ],
        ]);

        $fields = [
            'unity.en_name' => 'شرکت : نام انگلیسی',
            'unity.en_address' => 'شرکت : آدرس انگلیسی',
            'driver.en_name' => 'راننده : نام انگلیسی',
            'truck.transit' => 'کشنده : شماره ترانزیت',
            'trailer.transit' => 'یدک : شماره ترانزیت',
            'string' => 'عبارت دلخواه',
            'date' => 'تاریخ صدور',
        ];

        $this->crud->addFields([
            [   // repeatable
                'name'  => 'front_fields',
                'label' => 'فیلدها',
                'type'  => 'repeatable',
                'tab' => 'روی برگه',
                'fake' => true,
                'subfields' => [
                    [
                        'name'        => 'type',
                        'label'       => "نوع فیلد",
                        'type'        => 'select2_from_array',
                        'options'     => $fields,
                        'allows_null' => false,
                        'wrapper' => ['class' => 'form-group col-md-4'],
                    ],
                    [
                        'name'    => 'x_mm',
                        'type'    => 'number',
                        'label'   => ' (mm) <i class="las la-arrow-left"></i>',
                        'wrapper' => ['class' => 'form-group col-md-2 text-left'],
                        'attributes' => [
                            'class'       => 'form-control ltr text-left',
                        ],
                    ],
                    [
                        'name'    => 'y_mm',
                        'type'    => 'number',
                        'label'   => ' (mm) <i class="las la-arrow-down"></i>',
                        'wrapper' => ['class' => 'form-group col-md-2 text-left'],
                        'attributes' => [
                            'class'       => 'form-control ltr text-left',
                        ],
                    ],
                    [
                        'name'    => 'width',
                        'type'    => 'number',
                        'label'   => ' (mm) عرض',
                        'wrapper' => ['class' => 'form-group col-md-2 text-left'],
                        'attributes' => [
                            'class'       => 'form-control ltr text-left',
                        ],
                    ],
                    [
                        'name'    => 'font_size',
                        'label'    => 'سایز فونت (px)',
                        'type'   => 'number',
                        'wrapper' => ['class' => 'form-group col-md-2 text-left'],
                        'attributes' => [
                            'class'       => 'form-control ltr text-left',
                        ],
                    ],
                    [
                        'name' => 'bold',
                        'type' => 'checkbox',
                        //'default' => false,
                        'label' => 'پررنگ',
                        'wrapper' => ['class' => 'form-group col-md-2'],
                    ],
                    [
                        'name'    => 'value',
                        'type'    => 'text',
                        'label'   => 'مقدار عبارت دلخواه',
                        'wrapper' => ['class' => 'form-group col-md-6'],
                    ],
                ],
            
                // optional
                'new_item_label'  => 'افزودن فیلد', // customize the text of the button
                'init_rows' => 0, // number of empty rows to be initialized, by default 1
                'min_rows' => 0, // minimum rows allowed, when reached the "delete" buttons will be hidden
                'max_rows' => 20, // maximum rows allowed, when reached the "new item" button will be hidden
                // allow reordering?
                'reorder' => false, // hide up&down arrows next to each row (no reordering)
                'reorder' => true, // show up&down arrows next to each row
                'reorder' => 'order', // show arrows AND add a hidden subfield with that name (value gets updated when rows move)
                'reorder' => ['name' => 'order', 'type' => 'number', 'attributes' => ['data-reorder-input' => true]], // show arrows AND add a visible number subfield
            ],
            [   // repeatable
                'name'  => 'back_fields',
                'label' => 'فیلدها',
                'type'  => 'repeatable',
                'tab' => 'پشت برگه',
                'fake' => true,
                'subfields' => [
                    [
                        'name'        => 'type',
                        'label'       => "نوع فیلد",
                        'type'        => 'select2_from_array',
                        'options'     => $fields,
                        'allows_null' => false,
                        'wrapper' => ['class' => 'form-group col-md-4'],
                    ],
                    [
                        'name'    => 'x_mm',
                        'type'    => 'number',
                        'label'   => '<i class="las la-arrow-left"></i> (mm)',
                        'wrapper' => ['class' => 'form-group col-md-2'],
                    ],
                    [
                        'name'    => 'y_mm',
                        'type'    => 'number',
                        'label'   => '<i class="las la-arrow-down"></i> (mm)',
                        'wrapper' => ['class' => 'form-group col-md-2'],
                    ],
                    [
                        'name'    => 'width',
                        'type'    => 'number',
                        'label'   => ' (mm) عرض',
                        'wrapper' => ['class' => 'form-group col-md-2 text-left'],
                        'attributes' => [
                            'class'       => 'form-control ltr text-left',
                        ],
                    ],
                    [
                        'name'    => 'font_size',
                        'label'    => 'سایز فونت (px)',
                        'type'   => 'number',
                        'wrapper' => ['class' => 'form-group col-md-2'],
                    ],
                    [
                        'name' => 'bold',
                        'type' => 'checkbox',
                        //'default' => false,
                        'label' => 'پررنگ',
                        'wrapper' => ['class' => 'form-group col-md-2'],
                    ],
                    [
                        'name'    => 'value',
                        'type'    => 'text',
                        'label'   => 'مقدار عبارت دلخواه',
                        'wrapper' => ['class' => 'form-group col-md-6'],
                    ],
                ],
            
                // optional
                'new_item_label'  => 'افزودن فیلد', // customize the text of the button
                'init_rows' => 0, // number of empty rows to be initialized, by default 1
                'min_rows' => 0, // minimum rows allowed, when reached the "delete" buttons will be hidden
                'max_rows' => 20, // maximum rows allowed, when reached the "new item" button will be hidden
                // allow reordering?
                'reorder' => false, // hide up&down arrows next to each row (no reordering)
                'reorder' => true, // show up&down arrows next to each row
                'reorder' => 'order', // show arrows AND add a hidden subfield with that name (value gets updated when rows move)
                'reorder' => ['name' => 'order', 'type' => 'number', 'attributes' => ['data-reorder-input' => true]], // show arrows AND add a visible number subfield
            ]
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
}
