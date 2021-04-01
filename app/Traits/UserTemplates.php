<?php

namespace App\Traits;

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
            [
                'name'    => 'medical_code',
                'type'    => 'text',
                'prefix' => '<li class="la la-stethoscope"></i>',
                'label'   => 'نظام پزشکی',
                'tab'     => 'تخصصی',
                'wrapper'   => [ 
                    'class'      => 'form-group col-md-6'
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
                    'class'      => 'form-group col-md-6'
                 ], 
                'tab'     => 'تخصصی',
                'fake'  => true,
                'store_in' => 'extras',
            ],
            [
                'name'    => 'bio',
                'type'    => 'summernote',
                'label'   => 'درباره من',
                'tab'     => 'تخصصی',
                'fake'  => true,
                'store_in' => 'extras',
            ],
            [   // Table
                'name'            => 'services',
                'label'           => 'خدمات در مطب',
                'type'            => 'table',
                'fake'  => true,
                'tab'             => 'تخصصی',
                'entity_singular' => 'خدمت', // used on the "Add X" button
                'columns'         => [
                    'name'  => 'عنوان',
                ],
                'max' => 30, // maximum rows allowed in the table
                'min' => 0, // minimum rows allowed in the table
            ],
        ]);
        
        $this->crud->addFields([
            [   // repeatable
                'name'  => 'clinics',
                'label' => 'مراکز فعالیت',
                'type'  => 'repeatable',
                'fake'  => true,
                'tab'   => 'محل ها',
                'fields' => [
                    [
                        'name' => 'top-hint',
                        'type' => 'custom_html',
                        'value' => '<span class="bg-warning text-warning">کلینیک مورد نظر را از لیست زیر انتخاب کنید و یا اطلاعات آن را در ادامه وارد کنید</span>',
                    ],
                    [   // relationship
                        'type' => "relationship",
                        'name' => 'clinic_id', // the method on your model that defines the relationship
                        // OPTIONALS:
                        'label' => "مرکز درمانی",
                        // 'attribute' => "name", // foreign key attribute that is shown to user (identifiable attribute)
                        'entity' => 'parent', // the method that defines the relationship in your Model
                        // 'model' => "App\Models\Category", // foreign key Eloquent model
                        // 'placeholder' => "Select a category", // placeholder for the select2 input
                    ],
                    [
                        'name'    => 'name',
                        'type'    => 'text',
                        'label'   => 'عنوان',
                    ],
                    
                    [
                        'name'    => 'caption',
                        'type'    => 'text',
                        'label'   => 'عنوان دوم <small>(تخصص مرکز)</small>',
                    ],
                    [
                        'name'    => 'address',
                        'type'    => 'textarea',
                        'label'   => 'آدرس',
                    ],
                    [   // Table
                        'name'            => 'options',
                        'label'           => 'روزهای کاری',
                        'type'            => 'table',
                        'entity_singular' => 'روز', // used on the "Add X" button
                        'columns'         => [
                            'day'  => 'عنوان روز',
                            'start'  => 'ساعت ورود',
                            'end' => 'ساعت خروج'
                        ],
                        'max' => 7, // maximum rows allowed in the table
                        'min' => 0, // minimum rows allowed in the table
                    ],
                ],
            
                // optional
                'new_item_label'  => 'افزودن', // customize the text of the button
                'init_rows' => 1 ,// number of empty rows to be initialized, by default 1
                // 'min_rows' => 2, // minimum rows allowed, when reached the "delete" buttons will be hidden
                'max_rows' => 5, // maximum rows allowed, when reached the "new item" button will be hidden
            
            ],
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

        
    }

    private function clinic()
    {

    }

    private function customer()
    {

    }
}