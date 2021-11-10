<?php

namespace Modules\User\Traits;

use Modules\Filter\Models\Filter;
use Modules\Filter\Models\FilterItem;
use Rezahmady\SettingOperation\Setting;
use Modules\Subscribtion\Models\Subscribtion;

trait UserTemplates
{
    /*
    |--------------------------------------------------------------------------
    | User Templates
    |--------------------------------------------------------------------------
    |
    | Each page template has its own method, that define what fields should show up using the Backpack\CRUD API.
    | Use snake_case for naming and PageManager will make sure it looks pretty in the create/update form
    | template dropdown.
    |
    | Any fields defined here will show up after the standard page fields:
    | - select template
    */

    private function operator()
    {
        $this->crud->addField([
            // two interconnected entities
            'label'             => trans('backpack::permissionmanager.user_role_permission'),
            'tab'               => trans('backpack::permissionmanager.user_role_permission'),
            'field_unique_name' => 'user_role_permission',
            'type'              => 'checklist_dependency',
            'name'              => ['roles', 'permissions'],
            'tab'               => 'دسترسی',
            'subfields'         => [
                'primary' => [
                    'label'            => trans('backpack::permissionmanager.roles'),
                    'name'             => 'roles', // the method that defines the relationship in your Model
                    'entity'           => 'roles', // the method that defines the relationship in your Model
                    'entity_secondary' => 'permissions', // the method that defines the relationship in your Model
                    'attribute'        => 'name', // foreign key attribute that is shown to user
                    'model'            => config('permission.models.role'), // foreign key model
                    'pivot'            => true, // on create&update, do you need to add/delete pivot table entries?]
                    'number_columns'   => 3, //can be 1,2,3,4,6
                ],
                'secondary' => [
                    'label'          => ucfirst(trans('backpack::permissionmanager.permission_singular')),
                    'name'           => 'permissions', // the method that defines the relationship in your Model
                    'entity'         => 'permissions', // the method that defines the relationship in your Model
                    'entity_primary' => 'roles', // the method that defines the relationship in your Model
                    'attribute'      => 'display_name', // foreign key attribute that is shown to user
                    'model'          => config('permission.models.permission'), // foreign key model
                    'pivot'          => true, // on create&update, do you need to add/delete pivot table entries?]
                    'number_columns' => 3, //can be 1,2,3,4,6
                ],
            ],
        ]);

    }

    private function doctor()
    {
        $this->crud->addFields([
            // [   // select2_from_array
            //     'name'        => 'specialty_id',
            //     'label'       => "تخصص اصلی",
            //     'type'        => 'select2_from_array',
            //     'options'     => FilterItem::where('filter_id', 6)->get()->pluck('name','id')->toArray(),
            //     'fake'  => true,
            //     'store_in' => 'extras',
            //     'tab'     => 'تخصصی',
            //     'wrapper'   => [
            //         'class'      => 'form-group col-md-6'
            //      ],
            //     'allows_null' => true,
            //     // 'default'     => 'one',
            //     // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
            // ],
            // [   // select2_from_array
            //     'name'        => 'extra_specialty',
            //     'label'       => "سایر تخصص ها",
            //     'type'        => 'select2_from_array',
            //     'options'     => FilterItem::where('filter_id', 6)->get()->pluck('name','id')->toArray(),
            //     'fake'  => true,
            //     'store_in' => 'extras',
            //     'tab'     => 'تخصصی',
            //     'wrapper'   => [
            //         'class'      => 'form-group col-md-6'
            //      ],
            //     'allows_null' => true,
            //     // 'default'     => 'one',
            //     'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
            // ],
            [
                'name'    => 'medical_code',
                'type'    => 'text',
                'prefix' => '<li class="la la-stethoscope"></i>',
                'label'   => 'نظام پزشکی',
                'tab'     => 'تخصصی',
                'wrapper'   => [
                    'class'      => 'form-group col-md-3'
                 ],
                'fake'  => true,
                'store_in' => 'extras',
            ],
            [
                'name'    => 'experience',
                'type'    => 'text',
                'label'   => 'تجربه',
                'suffix'     => 'سال',
                'wrapper'   => [
                    'class'      => 'form-group col-md-3'
                 ],
                'tab'     => 'تخصصی',
                'fake'  => true,
                'store_in' => 'extras',
            ],
            [
                'name'    => "doctor_subscribtion",
                'label'   => "اشتراک ها",
                'type'        => 'select2_from_array',
                'fake'    => true,
                'options' => Subscribtion::active()->get()->pluck('name','id')->toArray(),
                'wrapper'   => [
                    'class'      => 'form-group col-md-6'
                 ],
                'tab'     => 'تخصصی',
                'allows_multiple' => true,
                'allows_null' => true,
            ],
            [
                'name'    => 'bio',
                'type'    => 'summernote',
                'label'   => 'درباره من',
                'tab'     => 'تخصصی',
                'fake'  => true,
                'store_in' => 'extras',
            ],
            [ // Text
                'name'  => 'slug',
                'label' => 'آدرس صفحه',
                'type'  => 'text',
                'prefix' => '<i class="la la-link la-lg"></i>',
                'hint'  => 'درصورت خالی گذاشتن به طور خودکار از روی نام و تخصص پزشک ساخته می شود',
                'tab'   => 'سئو',
            ],
            // [   // Table
            //     'name'            => 'services',
            //     'label'           => 'خدمات در مطب',
            //     'type'            => 'table',
            //     'fake'  => true,
            //     'tab'             => 'تخصصی',
            //     'entity_singular' => 'خدمت', // used on the "Add X" button
            //     'columns'         => [
            //         'text'  => 'عنوان',
            //     ],
            //     'max' => 30, // maximum rows allowed in the table
            //     'min' => 0, // minimum rows allowed in the table
            // ],
        ]);

        $this->crud->addField([
            // two interconnected entities
            'label'             => trans('backpack::permissionmanager.user_role_permission'),
            'tab'               => trans('backpack::permissionmanager.user_role_permission'),
            'field_unique_name' => 'user_role_permission',
            'type'              => 'checklist_dependency',
            'name'              => ['roles', 'permissions'],
            'tab'               => 'دسترسی',
            'subfields'         => [
                'primary' => [
                    'label'            => trans('backpack::permissionmanager.roles'),
                    'name'             => 'roles', // the method that defines the relationship in your Model
                    'entity'           => 'roles', // the method that defines the relationship in your Model
                    'entity_secondary' => 'permissions', // the method that defines the relationship in your Model
                    'attribute'        => 'name', // foreign key attribute that is shown to user
                    'model'            => config('permission.models.role'), // foreign key model
                    'pivot'            => true, // on create&update, do you need to add/delete pivot table entries?]
                    'number_columns'   => 3, //can be 1,2,3,4,6
                ],
                'secondary' => [
                    'label'          => ucfirst(trans('backpack::permissionmanager.permission_singular')),
                    'name'           => 'permissions', // the method that defines the relationship in your Model
                    'entity'         => 'permissions', // the method that defines the relationship in your Model
                    'entity_primary' => 'roles', // the method that defines the relationship in your Model
                    'attribute'      => 'display_name', // foreign key attribute that is shown to user
                    'model'          => config('permission.models.permission'), // foreign key model
                    'pivot'          => true, // on create&update, do you need to add/delete pivot table entries?]
                    'number_columns' => 3, //can be 1,2,3,4,6
                ],
            ],
        ]);

        $this->crud->addFields([
            [
                'type' => "relationship",
                'label' => 'مراکز فعالیت',
                'name' => 'resource', // the method on your model that defines the relationship
                'ajax' => true,
                'tab'   => 'محل ها',
                'placeholder' => "انتخاب کنید ...", // placeholder for the select2 input
                'minimum_input_length' => 0, // minimum characters to type before querying results
                // 'inline_create' => true, // assumes the URL will be "/admin/category/inline/create"
                // 'inline_create' => [ // specify the entity in singular
                //     'entity' => 'resource', // the entity in singular
                //     // OPTIONALS
                //     'force_select' => true, // should the inline-created entry be immediately selected?
                //     'modal_class' => 'modal-dialog modal-xl', // use modal-sm, modal-lg to change width
                //     'modal_route' => route('resource-inline-create'), // InlineCreate::getInlineCreateModal()
                //     'create_route' =>  route('resource-inline-create-save'), // InlineCreate::storeInlineCreate()
                //     'include_main_form_fields' => ['resource_template_h'], // pass certain fields from the main form to the modal
                // ]
            ],

            [   // relationship
                'type' => "relationship",
                'name' => 'ostan_id', // the method on your model that defines the relationship
                'ajax' => false,
                'fake' => true,
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
                'tab'   => 'محل ها',
                // OPTIONALS:
                 'label' => "استان",
                 'attribute' => "name", // foreign key attribute that is shown to user (identifiable attribute)
                 'entity' => 'ostan', // the method that defines the relationship in your Model
                 'model' => "App\Models\Ostan", // foreign key Eloquent model
                 'placeholder' => "انتخاب کنید...", // placeholder for the select2 input
            ],
            [   // relationship
                'type' => "relationship",
                'name' => 'shahrestan_id', // the method on your model that defines the relationship
                'ajax' => true,
                'fake' => true,
                // OPTIONALS:
                'label' => "شهرستان",
                'attribute' => "name", // foreign key attribute that is shown to user (identifiable attribute)
                'entity' => 'shahrestan', // the method that defines the relationship in your Model
                'model' => "App\Models\Shahrestan", // foreign key Eloquent model
                'placeholder' => "انتخاب کنید ...", // placeholder for the select2 input
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
                'tab'   => 'محل ها',
                // AJAX OPTIONALS:
                // 'delay' => 500, // the minimum amount of time between ajax requests when searching in the field
                 'data_source' => url("api/shahrestan"), // url to controller search function (with /{id} should return model)
                 'minimum_input_length' => 0, // minimum characters to type before querying results
                 'dependencies'         => ['ostan_id'], // when a dependency changes, this select2 is reset to null
                 'include_all_form_fields'  => true, // optional - only send the current field through AJAX (for a smaller payload if you're not using multiple chained select2s)
            ],
            [
                'name'    => 'address',
                'type'    => 'summernote',
                'options' => [
                    'toolbar' => []
                ],
                'label'   => 'آدرس مطب',
                'tab'     => 'محل ها',
                'fake'  => true,
                'store_in' => 'extras',
            ],
            // [
            //     'type' => 'hidden',
            //     'name' => 'resource_template_c',
            //     'value' => 'clinic',
            // ],
            // [
            //     'type' => "relationship",
            //     'label' => 'مراکز فعالیت',
            //     'name' => 'resource', // the method on your model that defines the relationship
            //     'ajax' => true,
            //     'fake'  => true,
            //     'tab'   => 'محل ها',
            //     // 'inline_create' => true, // assumes the URL will be "/admin/category/inline/create"
            //     'inline_create' => [ // specify the entity in singular
            //         'entity' => 'resource', // the entity in singular
            //         // OPTIONALS
            //         'force_select' => true, // should the inline-created entry be immediately selected?
            //         'modal_class' => 'modal-dialog modal-xl', // use modal-sm, modal-lg to change width
            //         'modal_route' => route('resource-inline-create'), // InlineCreate::getInlineCreateModal()
            //         'create_route' =>  route('resource-inline-create-save'), // InlineCreate::storeInlineCreate()
            //         'include_main_form_fields' => ['resource_template'], // pass certain fields from the main form to the modal
            //     ]
            // ],
            // [   // repeatable
            //     'name'  => 'clinics',
            //     'label' => 'مراکز فعالیت',
            //     'type'  => 'repeatable',
            //     'fake'  => true,
            //     'tab'   => 'محل ها',
            //     'fields' => [
            //         [
            //             'name' => 'top-hint',
            //             'type' => 'custom_html',
            //             'value' => '<span class="bg-warning text-warning">کلینیک مورد نظر را از لیست زیر انتخاب کنید و یا اطلاعات آن را در ادامه وارد کنید</span>',
            //         ],
            //         // [   // relationship
            //         //     'type' => "relationship",
            //         //     'name' => 'clinic_id', // the method on your model that defines the relationship
            //         //     // OPTIONALS:
            //         //     'label' => "مرکز درمانی",
            //         //     // 'attribute' => "name", // foreign key attribute that is shown to user (identifiable attribute)
            //         //     'entity' => 'resource', // the method that defines the relationship in your Model
            //         //     'model' => "Modules\Resource\Models\Resource", // foreign key Eloquent model
            //         //     // 'placeholder' => "Select a category", // placeholder for the select2 input
            //         // ],
            //         [
            //             'type' => "relationship",
            //             'name' => 'clinic', // the method on your model that defines the relationship
            //             'ajax' => true,
            //             'inline_create' => true, // assumes the URL will be "/admin/category/inline/create"
            //         ],
            //         [
            //             'name'    => 'name',
            //             'type'    => 'text',
            //             'label'   => 'عنوان',
            //         ],

            //         [
            //             'name'    => 'caption',
            //             'type'    => 'text',
            //             'label'   => 'عنوان دوم <small>(تخصص مرکز)</small>',
            //         ],
            //         [
            //             'name'    => 'address',
            //             'type'    => 'textarea',
            //             'label'   => 'آدرس',
            //         ],
            //         [   // Table
            //             'name'            => 'options',
            //             'label'           => 'روزهای کاری',
            //             'type'            => 'table',
            //             'entity_singular' => 'روز', // used on the "Add X" button
            //             'columns'         => [
            //                 'day'  => 'عنوان روز',
            //                 'start'  => 'ساعت ورود',
            //                 'end' => 'ساعت خروج'
            //             ],
            //             'max' => 7, // maximum rows allowed in the table
            //             'min' => 0, // minimum rows allowed in the table
            //         ],
            //     ],

            //     // optional
            //     'new_item_label'  => 'افزودن', // customize the text of the button
            //     'init_rows' => 1 ,// number of empty rows to be initialized, by default 1
            //     // 'min_rows' => 2, // minimum rows allowed, when reached the "delete" buttons will be hidden
            //     'max_rows' => 5, // maximum rows allowed, when reached the "new item" button will be hidden

            // ],
        ]);

        $this->crud->addFields([
            [   // repeatable
                'name'  => 'edu_bg',
                'label' => 'سوابق تحصیلی',
                'type'  => 'repeatable',
                'fake'  => true,
                'tab'   => 'سوابق',
                'fields' => [
                    [
                        'name'    => 'name',
                        'type'    => 'text',
                        'label'   => 'عنوان مدرک',
                        'wrapper' => ['class' => 'form-group col-md-4'],
                    ],
                    [
                        'name'    => 'place',
                        'type'    => 'text',
                        'label'   => 'محل تحصیل',
                        'wrapper' => ['class' => 'form-group col-md-4'],
                    ],
                    [
                        'name'    => 'date',
                        'type'    => 'text',
                        'label'   => 'سال اخذ',
                        'wrapper' => ['class' => 'form-group col-md-4'],
                    ],
                ],

                // optional
                'new_item_label'  => 'افزودن', // customize the text of the button
                'init_rows' => 0 ,// number of empty rows to be initialized, by default 1
                // 'min_rows' => 2, // minimum rows allowed, when reached the "delete" buttons will be hidden
                'max_rows' => 5, // maximum rows allowed, when reached the "new item" button will be hidden

            ],
            [   // repeatable
                'name'  => 'job_bg',
                'label' => 'سوابق کاری',
                'type'  => 'repeatable',
                'fake'  => true,
                'tab'   => 'سوابق',
                'fields' => [
                    [
                        'name'    => 'name',
                        'type'    => 'text',
                        'label'   => 'محل کار',
                        'wrapper' => ['class' => 'form-group col-md-6'],
                    ],
                    [
                        'name'    => 'duration',
                        'type'    => 'text',
                        'label'   => 'زمان فعالیت',
                        'wrapper' => ['class' => 'form-group col-md-6'],
                    ],
                ],

                // optional
                'new_item_label'  => 'افزودن', // customize the text of the button
                'init_rows' => 0 ,// number of empty rows to be initialized, by default 1
                // 'min_rows' => 2, // minimum rows allowed, when reached the "delete" buttons will be hidden
                'max_rows' => 5, // maximum rows allowed, when reached the "new item" button will be hidden

            ],
            [   // repeatable
                'name'  => 'gif_bg',
                'label' => 'موفقیت ها',
                'type'  => 'repeatable',
                'fake'  => true,
                'tab'   => 'سوابق',
                'fields' => [
                    [
                        'name'    => 'date',
                        'type'    => 'text',
                        'label'   => 'تاریخ',
                        'wrapper' => ['class' => 'form-group col-md-6'],
                    ],
                    [
                        'name'    => 'name',
                        'type'    => 'text',
                        'label'   => 'عنوان',
                        'wrapper' => ['class' => 'form-group col-md-6'],
                    ],
                    [
                        'name'    => 'description',
                        'type'    => 'textarea',
                        'label'   => 'توضیحات',
                    ],
                ],

                // optional
                'new_item_label'  => 'افزودن', // customize the text of the button
                'init_rows' => 0 ,// number of empty rows to be initialized, by default 1
                // 'min_rows' => 2, // minimum rows allowed, when reached the "delete" buttons will be hidden
                'max_rows' => 5, // maximum rows allowed, when reached the "new item" button will be hidden

            ],
        ]);

        $this->crud->addFields([
            [
                'name' => 'instagram',
                'label' => 'اینستاگرام',
                'tab' => 'شبکه های اجتماعی',
                'fake'  => true,
                'prefix' => '<i class="la la-instagram"></i>',
            ],
            [
                'name' => 'telegram',
                'label' => 'تلگرام',
                'tab' => 'شبکه های اجتماعی',
                'fake'  => true,
                'prefix' => '<i class="la la-telegram"></i>',
            ],
        ]);

        $this->getFilters('doctor');

    }

    private function clinic()
    {

    }

    private function customer()
    {
        $this->crud->addFields([
            [   // repeatable
                'name'  => 'medical_folder',
                'label' => '',
                'type'  => 'repeatable',
                'fields' => [
                    [   // Browse
                        'name'  => 'photo',
                        'label' => 'تصویرمدرک',
                        'type'  => 'browse',
                    ],
                    [
                        'name'    => 'title',
                        'type'    => 'text',
                        'label'   => 'عنوان مدرک',
                    ],
                    [
                        'name'    => 'description',
                        'type'    => 'summernote',
                        'options' => [
                            'toolbar' => []
                        ],
                        'label'   => 'توضیحات',
                    ],
                ],
                'tab' => 'پرونده پزشکی',
                'fake'  => true,
                // optional
                'new_item_label'  => 'افزودن مدرک', // customize the text of the button
                'init_rows' => 1, // number of empty rows to be initialized, by default 1
                'min_rows' => 0, // minimum rows allowed, when reached the "delete" buttons will be hidden
                // 'max_rows' => 2 // maximum rows allowed, when reached the "new item" button will be hidden

            ],
        ]);
    }

    protected function getFilters($template) {
        $filters = Setting::get("users.template_{$template}_filters");

        if($filters) foreach($filters as $key => $item) {
            $item = Filter::findOrFail($item);
            $multiple = ($item->type == 'hasMany') ? true : false;
            switch ($item->field) {
                case 'select2_from_array':
                    $this->crud->addField([
                        'name'    => "filter_{$item->slug}",
                        'label'   => $item->name,
                        'type'        => 'select2_from_array',
                        'fake'    => true,
                        'options' => FilterItem::where('filter_id', $item->id)->get()->pluck('name','id')->toArray(),
                        'tab' => 'فیلترها',
                        'wrapper'   => [
                            'class'      => 'form-group col-md-6'
                        ],
                        'allows_multiple' => $multiple,
                        'allows_null' => true,
                    ]);
                    break;
                case 'select_and_order':
                    $this->crud->addField([
                        'name'    => "filter_{$item->slug}",
                        'label'   => $item->name,
                        'type'    => 'select_and_order',
                        'fake'    => true,
                        'options' => FilterItem::where('filter_id', $item->id)->get()->pluck('name','id')->toArray(),
                        'tab' => 'فیلترها',
                    ]);
                    break;
                default:
                    # code...
                    break;
            }
        }
    }
}
