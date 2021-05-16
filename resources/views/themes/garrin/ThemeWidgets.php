<?php
namespace ThemeFolder\themes;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class ThemeWidgets
{

    /*
    |--------------------------------------------------------------------------
    | Template options field for ThemeManager
    |--------------------------------------------------------------------------
    |
    |
    | Any fields defined here will show up after the standard page fields:
    | - select template
    | - Theme name (only seen by admins)
    */

    public function widget_main_menu()
    {
        CRUD::addFields([
            [
                'name' => 'menu_title',
                'prefix' => '<i class="la la-pencil"></i>',
                'label' => 'عنوان',
                'fake'        => true,
                'wrapper' => [
                    'class'      => 'form-group col-md-12'
                ],
                'tab'   => 'منو'
            ],
            [   // select2_from_array
                'name'        => 'type',
                'label'       => "نوع منو",
                'type'        => 'select2_from_array',
                'fake'        => true,
                'options'     => $this->getTemplatesArray(),
                'allows_null' => false,
                'tab'         => 'منو'
            ],
            [   // two interconnected entities
                'type'              => 'conditional_select2',
                'name'              => 'data',
                'select_field'       => 'type',
                'wrapper' => ['class' => 'form-group col-md-12'],
                'fake'  => true,
                'tab'         => 'منو',
                'store_in' => 'extras',
                'options'           => [
                    'all_pages',
                    'shop',
                    'blog',
                    'custom_menu'
                ],
                'fields'            => [
                    'all_pages' => [],
                    'shop' => [],
                    'blog' => [],
                    'custom_menu' => [
                        [   // Table
                            'name'            => 'items',
                            'label'           => 'آیتم های منو',
                            'type'            => 'table',
                            'entity_singular' => 'آیتم', // used on the "Add X" button
                            'columns'         => [
                                'label'  => 'عنوان',
                                'link'  => 'لینک',
                                'target' => 'تارگت'
                            ],
                            'max' => 6, // maximum rows allowed in the table
                            'min' => 0, // minimum rows allowed in the table
                        ],
                    ],
                ],
            ],
        ]);

    }

    public function widget_footer_menu1()
    {
        $this->widget_main_menu();
    }

    public function widget_footer_menu2()
    {
        $this->widget_main_menu();
    }

    public function widget_footer_menu3()
    {
        $this->widget_main_menu();
    }

    public function widget_footer_about_us()
    {
        CRUD::addFields([
            [
                'name'   => 'about_img',
                'prefix' =>'<i class="la la-image la-lg"></i>',
                'type'   => 'browse',
                'label'  => 'تصویر',
                'tab'          => 'محتوا',
                'fake'  => true,
            ],
            [
                'name'        => 'about_description',
                'label'       => 'توضیحات',
                'type'    => 'summernote',
                'options' => [
                    'toolbar' => [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ]
                ],
                'fake'        =>   true,
                'tab'         => 'محتوا',
            ],
            [   // repeatable
                'name'  => 'social_list',
                'label' => 'آیکن شبکه های اجتماعی',
                'type'  => 'repeatable',
                'fake'        => true,
                'fields' => [
                    [
                        'name'    => 'icon',
                        'type'    => 'icon_picker',
                        'iconset' => 'fontawesome',
                        'label'   => 'آیکن',
                        'wrapper' => ['class' => 'form-group col-md-2 col-sm-2'],
                    ],
                    [
                        'name'    => 'link',
                        'type'    => 'text',
                        'prefix'  => '<i class="la la-link"></i>',
                        'label'   => 'لینک',
                        'wrapper' => ['class' => 'form-group col-md-7 col-sm-7'],
                    ],
                    [   // select2_from_array
                        'name'        => 'target',
                        'label'   => 'تارگت',
                        'type'        => 'select2_from_array',
                        'options'     => ['_blank' => 'در تب جدید باز شود', '_self' => 'در همان تب باز شود'],
                        'allows_null' => false,
                        'default'     => '_self',
                        'wrapper' => ['class' => 'form-group col-md-3 col-sm-3'],
                        // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                    ],
                ],
                'tab'   => 'شبکه های اجتماعی',
                // optional
                'new_item_label'  => 'افزودن شبکه اجتماعی جدید', // customize the text of the button
            ],
           
        ]);
    }

    public function widget_footer_contact_us()
    {
        CRUD::addFields([
            [
                'name' => 'widget_title',
                'prefix' => '<i class="la la-pencil"></i>',
                'label' => 'عنوان',
                'fake'        => true,
                'wrapper' => [
                    'class'      => 'form-group col-md-12'
                ],
                'tab'   => 'اطلاعات تماس'
            ],
            [   // repeatable
                'name'  => 'contact_list',
                'label' => 'لیست اطلاعات تماس',
                'type'  => 'repeatable',
                'fake'        => true,
                'fields' => [
                    [
                        'name'    => 'icon',
                        'type'    => 'icon_picker',
                        'iconset' => 'fontawesome',
                        'label'   => 'آیکن',
                        'wrapper' => ['class' => 'form-group col-md-2 col-sm-2'],
                    ],
                    [
                        'name'    => 'text',
                        'type'    => 'text',
                        'label'   => 'متن',
                        'wrapper' => ['class' => 'form-group col-md-10 col-sm-10'],
                    ],
                    [
                        'name'    => 'link',
                        'type'    => 'text',
                        'prefix'  => '<i class="la la-link"></i>',
                        'label'   => 'لینک',
                        'wrapper' => ['class' => 'form-group col-md-9 col-sm-9'],
                    ],
                    [   // select2_from_array
                        'name'        => 'target',
                        'label'   => 'تارگت',
                        'type'        => 'select2_from_array',
                        'options'     => ['_blank' => 'در تب جدید باز شود', '_self' => 'در همان تب باز شود'],
                        'allows_null' => false,
                        'default'     => '_self',
                        'wrapper' => ['class' => 'form-group col-md-3 col-sm-3'],
                        // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                    ],
                ],
                'tab'   => 'اطلاعات تماس',
                // optional
                'new_item_label'  => 'افزودن تماس جدید', // customize the text of the button
            ],

        ]);
    }

    

    public function widget_home_search()
    {
        CRUD::addFields([
            [
                'name' => 'search_title',
                'label' => 'عنوان',
                'prefix' =>'<i class="la la-pencil la-lg"></i>',
                'tab'          => 'جستو جو',
                'fake'  => true,
            ],
            [
                'name'        => 'search_description',
                'label'       => 'توضیحات',
                'type'    => 'summernote',
                'options' => [
                    'toolbar' => [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ]
                ],
                'fake'        =>   true,
                'tab'         => 'جستو جو',
            ],
            [
                'name'   => 'input_placeholder',
                'prefix' =>'<i class="la la-i-cursor la-lg"></i>',
                'label'  => 'متن پیشفرض جستجو',
                'tab'          => 'جستو جو',
                'fake'  => true,
            ],
            [
                'name'   => 'input_hint',
                'prefix' =>'<i class="la la-info-circle la-lg"></i>',
                'label'  => 'متن راهنمای جستجو',
                'tab'          => 'جستو جو',
                'fake'  => true,
            ],
            [
                'name'   => 'header_img',
                'prefix' =>'<i class="la la-image la-lg"></i>',
                'type'   => 'browse',
                'label'  => 'تصویر بنر',
                'tab'          => 'جستو جو',
                'fake'  => true,
            ],
        ]);
    }

    public function widget_service1()
    {
        CRUD::addFields([
            [
                'name' => 'service_title',
                'label' => 'عنوان',
                'prefix' =>'<i class="la la-pencil la-lg"></i>',
                'tab'          => 'محتوا',
                'fake'  => true,
            ],
            [
                'name'        => 'service_description',
                'label'       => 'توضیحات',
                'type'    => 'summernote',
                'options' => [
                    'toolbar' => [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ]
                ],
                'fake'        =>   true,
                'tab'         => 'محتوا',
            ],
            [
                'name'   => 'service_img',
                'prefix' =>'<i class="la la-image la-lg"></i>',
                'type'   => 'browse',
                'label'  => 'تصویر شاخص',
                'tab'          => 'محتوا',
                'fake'  => true,
            ],
        ]);
    }

    public function widget_service2()
    {
        $this->widget_service1();
    }

    public function widget_service3()
    {
        $this->widget_service1();
    }

    public function widget_filter_slide()
    {
        CRUD::addFields([
            [
                'name' => 'filter_title',
                'label' => 'عنوان',
                'prefix' =>'<i class="la la-pencil la-lg"></i>',
                'tab'          => 'محتوا',
                'fake'  => true,
            ],
            [   // relationship
                'type' => "relationship",
                'name' => 'filter', // the method on your model that defines the relationship
                'ajax' => false,
                'fake' => true,
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
                'tab'   => 'محتوا',
                // OPTIONALS:
                 'label' => "دسته فیلتر",
                 'attribute' => "name", // foreign key attribute that is shown to user (identifiable attribute)
                 'entity' => 'relationBelongsTo', // the method that defines the relationship in your Model
                 'model' => "Rezahmady\Filter\Models\Filter", // foreign key Eloquent model
                 'placeholder' => "انتخاب کنید...", // placeholder for the select2 input
            ],
            [   // relationship
                'type' => "relationship",
                'name' => 'filterItem', // the method on your model that defines the relationship
                'ajax' => true,
                'fake' => true,
                // OPTIONALS:
                'label' => "فیلترها",
                'attribute' => "name", // foreign key attribute that is shown to user (identifiable attribute)
                'entity' => 'relationHasMany', // the method that defines the relationship in your Model
                'model' => "Rezahmady\Filter\Models\FilterItem", // foreign key Eloquent model
                'placeholder' => "انتخاب کنید ...", // placeholder for the select2 input
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
                'tab'   => 'محتوا',
                // AJAX OPTIONALS:
                // 'delay' => 500, // the minimum amount of time between ajax requests when searching in the field
                 'data_source' => url("api/filter-item"), // url to controller search function (with /{id} should return model)
                 'minimum_input_length' => 0, // minimum characters to type before querying results
                 'dependencies'         => ['filter'], // when a dependency changes, this select2 is reset to null
                 'include_all_form_fields'  => true, // optional - only send the current field through AJAX (for a smaller payload if you're not using multiple chained select2s)
            ],
            
        ]);
    }

    public function widget_doctor_slide()
    {
        CRUD::addFields([
            [   // icon_picker
                'label'   => "Icon",
                'name'    => 'doctor_icon',
                'type'    => 'icon_picker',
                'tab'          => 'محتوا',
                'wrapper' => ['class' => 'form-group col-md-2 col-sm-2'],
                'fake'  => true,
                'iconset' => 'fontawesome' // options: fontawesome, glyphicon, ionicon, weathericon, mapicon, octicon, typicon, elusiveicon, materialdesign
            ],
            [
                'name' => 'doctor_title',
                'label' => 'عنوان',
                'prefix' =>'<i class="la la-pencil la-lg"></i>',
                'wrapper' => ['class' => 'form-group col-md-10 col-sm-10'],
                'tab'          => 'محتوا',
                'fake'  => true,
            ],
            [
                'name'        => 'doctor_description',
                'label'       => 'توضیحات',
                'type'    => 'summernote',
                'options' => [
                    'toolbar' => [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ]
                ],
                'fake'        =>   true,
                'tab'         => 'محتوا',
            ],
            [
                'name' => 'template',
                'label' => 'نوع کاربر',
                'type'      => 'select2_from_array',
                'wrapper'      => ['class'  => "form-group col-md-6"],
                // optional
                // 'allows_multiple' => true,
                'allows_null' => false,
                'options' => $this->getUserTemplatesArray(),
                'tab'          => 'محتوا',
                'fake'  => true,
            ],
            [   // relationship
                'type' => "relationship",
                'name' => 'users', // the method on your model that defines the relationship
                'ajax' => true,
                'fake' => true,
                // OPTIONALS:
                'label' => "انتخاب از کاربران",
                'attribute' => "name", // foreign key attribute that is shown to user (identifiable attribute)
                'entity' => 'relationHasMany', // the method that defines the relationship in your Model
                'model' => "Rrzahmady\User\Models\User", // foreign key Eloquent model
                'placeholder' => "انتخاب کنید ...", // placeholder for the select2 input
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
                'tab'   => 'محتوا',
                // AJAX OPTIONALS:
                // 'delay' => 500, // the minimum amount of time between ajax requests when searching in the field
                 'data_source' => url("api/doctor"), // url to controller search function (with /{id} should return model)
                 'minimum_input_length' => 0, // minimum characters to type before querying results
                 'dependencies'         => ['template'], // when a dependency changes, this select2 is reset to null
                 'include_all_form_fields'  => true, // optional - only send the current field through AJAX (for a smaller payload if you're not using multiple chained select2s)
            ],
        ]);
    }

    public function widget_consultation_banner()
    {
        CRUD::addFields([
            [
                'name' => 'banner_title',
                'label' => 'عنوان',
                'prefix' =>'<i class="la la-pencil la-lg"></i>',
                'tab'          => 'محتوا',
                'fake'  => true,
            ],
            [
                'name'        => 'banner_description',
                'label'       => 'توضیحات',
                'type'    => 'summernote',
                'options' => [
                    'toolbar' => [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ]
                ],
                'fake'        =>   true,
                'tab'         => 'محتوا',
            ],
            [
                'name'   => 'banner_css',
                'prefix' =>'<i class="la la-css3 la-lg"></i>',
                'wrapper'      => ['class'  => "form-group col-md-12 dir-left"],
                'label'  => 'css اختصاصی',
                'tab'          => 'محتوا',
                'fake'  => true,
            ],
            [
                'name'   => 'button_label',
                'prefix' =>'<i class="la la-pencil la-lg"></i>',
                'label'  => 'متن دکمه',
                'wrapper'      => ['class'  => "form-group col-md-6"],
                'attributes'   => ['placeholder' => 'متن'],
                'tab'          => 'محتوا',
                'fake'  => true,
            ],
            [
                'name' => 'button_link',
                'prefix' => '<i class="la la-link la-lg"></i>',
                'attributes'   => ['placeholder' => 'لینک'],
                'label' => 'لینک دکمه',
                'wrapper'      => ['class'  => "form-group col-md-6"],
                'tab'          => 'محتوا',
                'fake'  => true,
            ],
            [
                'name'   => 'banner_img',
                'prefix' =>'<i class="la la-image la-lg"></i>',
                'type'   => 'browse',
                'label'  => 'تصویر شاخص',
                'tab'          => 'محتوا',
                'fake'  => true,
            ],
        ]);
    }

    public function widget_mag_grider()
    {
        CRUD::addFields([
            [   // icon_picker
                'label'   => "Icon",
                'name'    => 'mag_icon',
                'type'    => 'icon_picker',
                'tab'          => 'محتوا',
                'fake'  => true,
                'iconset' => 'fontawesome' // options: fontawesome, glyphicon, ionicon, weathericon, mapicon, octicon, typicon, elusiveicon, materialdesign
            ],
            [
                'name' => 'mag_title',
                'label' => 'عنوان',
                'prefix' =>'<i class="la la-pencil la-lg"></i>',
                'tab'          => 'محتوا',
                'fake'  => true,
            ],
            [
                'name'   => 'button_label',
                'prefix' =>'<i class="la la-pencil la-lg"></i>',
                'label'  => 'متن دکمه',
                'wrapper'      => ['class'  => "form-group col-md-6"],
                'attributes'   => ['placeholder' => 'متن'],
                'tab'          => 'محتوا',
                'fake'  => true,
            ],
            [
                'name' => 'button_link',
                'prefix' => '<i class="la la-link la-lg"></i>',
                'attributes'   => ['placeholder' => 'لینک'],
                'label' => 'لینک دکمه',
                'wrapper'      => ['class'  => "form-group col-md-6"],
                'tab'          => 'محتوا',
                'fake'  => true,
            ],
        ]);
    }

    public function widget_comment_slide()
    {
        CRUD::addFields([
            [
                'name' => 'comment_title',
                'label' => 'عنوان',
                'prefix' =>'<i class="la la-pencil la-lg"></i>',
                'tab'          => 'محتوا',
                'fake'  => true,
            ],
            [   // repeatable
                'name'  => 'items',
                'label' => 'نظرات',
                'type'  => 'repeatable',
                'fake'  => true,
                'fields' => [
                    [
                        'name'    => 'name',
                        'type'    => 'text',
                        'label'   => 'نام کاربر',
                        'wrapper' => ['class' => 'form-group col-md-6 col-sm-6'],
                    ],
                    [
                        'name'    => 'filter',
                        'type'    => 'text',
                        'label'   => 'زمینه تخصص',
                        'wrapper' => ['class' => 'form-group col-md-6 col-sm-6'],
                    ],
                    [
                        'name'        => 'content',
                        'label'       => 'نظر',
                        'type'    => 'summernote',
                        'options' => [
                            'toolbar' => [
                                ['style', ['style']],
                                ['font', ['bold', 'underline', 'clear']],
                                ['color', ['color']],
                                ['para', ['ul', 'ol', 'paragraph']],
                                ['table', ['table']],
                                ['insert', ['link', 'video']],
                                ['view', ['fullscreen', 'codeview', 'help']]
                            ]
                        ],
                        'fake'        =>   true,
                        'tab'         => 'محتوا',
                    ],
                ],
                'tab'             => 'محتوا',
                // optional
                'new_item_label'  => 'افزودن نظر', // customize the text of the button
            ]

        ]);
    }



            /**
     * Get all defined templates.
     */
    private function getTemplates($template_name = false)
    {
        $templates_array = [];

        $templates_trait = new \ReflectionClass('App\Traits\PageTemplates');
        $templates = $templates_trait->getMethods(\ReflectionMethod::IS_PRIVATE);

        if (! count($templates)) {
            abort(503, trans('backpack::pagemanager.template_not_found'));
        }

        return $templates;
    }

    /**
     * Get all defined template as an array.
     *
     * Used to populate the template dropdown in the create/update forms.
     */
    private function getTemplatesArray()
    {
        // $templates = $this->getTemplates();
        $templates_array['all_pages'] = 'لیست همه صفحات';
        $templates_array['shop'] = 'لیست همه صفحات فروشگاهی';
        $templates_array['blog'] = 'لیست همه صفحات وبلاگی';
        $templates_array['custom_menu'] = 'منو سفارشی';
        // foreach ($templates as $template) {
        //     $templates_array[$template->name] = 'لیست صفحات '.trans('backpack::pagemanager.function_name.'.$template->name);
        // }


        return $templates_array;
    }

    /**
     * Get all defined template as an array.
     *
     * Used to populate the template dropdown in the create/update forms.
     */
    public function getUserTemplatesArray()
    {
        $templates = $this->getUserTemplates();

        foreach ($templates as $template) {
            $templates_array[$template->name] = trans('backpack::permissionmanager.function_name.'.$template->name);
        }

        return $templates_array;
    }

        /**
     * Get all defined templates.
     */
    public function getUserTemplates($template_name = false)
    {
        $templates_array = [];

        $templates_trait = new \ReflectionClass('Rezahmady\User\Traits\UserTemplates');
        $templates = $templates_trait->getMethods(\ReflectionMethod::IS_PRIVATE);

        if (! count($templates)) {
            abort(503, trans('backpack::permissionmanager.template_not_found'));
        }

        return $templates;
    }
}
