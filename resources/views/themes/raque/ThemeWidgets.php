<?php
namespace ThemeFolder\themes;

use Rezahmady\Page\Models\Page;
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

    public function widget_banner()
    {

        // 
        CRUD::addField([
            'name' => 'banner_title',
            'label' => 'عنوان بنر',
            'tab'          => 'بنر',
            'fake'  => true,
        ]);

        CRUD::addField([
            'name' => 'banner_description',
            'label' => 'توضیحات بنر',
            'tab'          => 'بنر',
            'fake'  => true,
        ]);

        // image
        CRUD::addField([
            'label'        => "تصویر بنر",
            'name'         => 'image',
            'fake'  => true,
            'type' => 'image',
            'crop' => true, // set to true to allow cropping, false to disable
            'aspect_ratio' => 1, // omit or set to 0 to allow any aspect ratio
            // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
            'prefix'    => '', // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
            'wrapper'      => [
                'class'  => "form-group col-12 ltr"
            ],
            'tab'          => 'بنر',
        ]);

        // button

        CRUD::addField([
            'name' => 'banner_button_header',
            'label' => '',
            'type'  => 'custom_html',
            'value' => '<hr><p class="text-center"><b>دکمه</b></p>',
            'tab'          => 'بنر',
            'fake'  => true,
        ]);

        CRUD::addField([
            'name'   => 'banner_button_title',
            'prefix' =>'<i class="la la-pencil la-lg"></i>',
            'label'  => '',
            'wrapper'      => ['class'  => "form-group col-md-6"],
            'attributes'   => ['placeholder' => 'عنوان'],
            'tab'          => 'بنر',
            'fake'  => true,
        ]);

        CRUD::addField([
            'name' => 'banner_button_link',
            'prefix' => '<i class="la la-link la-lg"></i>',
            'attributes'   => ['placeholder' => 'لینک'],
            'label' => '',
            'wrapper'      => ['class'  => "form-group col-md-6"],
            'tab'          => 'بنر',
            'fake'  => true,
        ]);

        CRUD::addField([
            'name' => 'banner_button_visible',
            'label' => ' نمایش',
            'wrapper'      => [
                'class'  => "form-group col-md-4"
            ],
            'type'  => 'toggle',
            'view_namespace' => 'vendor/backpack/crud/fields',
            'tab'          => 'بنر',
            'fake'  => true,
        ]);

        // link

        CRUD::addField([
            'name' => 'banner_link_header',
            'label' => '',
            'type'  => 'custom_html',
            'value' => '<hr><p class="text-center"><b>لینک متنی</b></p>',
            'tab'          => 'بنر',
            'fake'  => true,
        ]);

        CRUD::addField([
            'name'   => 'banner_link_text',
            'prefix' =>'<i class="la la-pencil la-lg"></i>',
            'label'  => '',
            'wrapper'      => ['class'  => "form-group col-md-6"],
            'attributes'   => ['placeholder' => 'متن'],
            'tab'          => 'بنر',
            'fake'  => true,
        ]);

        CRUD::addField([
            'name' => 'banner_link_link',
            'prefix' => '<i class="la la-link la-lg"></i>',
            'attributes'   => ['placeholder' => 'لینک'],
            'label' => '',
            'wrapper'      => ['class'  => "form-group col-md-6"],
            'tab'          => 'بنر',
            'fake'  => true,
        ]);

        CRUD::addField([
            'name' => 'banner_link_visible',
            'label' => ' نمایش',
            'wrapper'      => [
                'class'  => "form-group col-md-4"
            ],
            'type'  => 'toggle',
            'view_namespace' => 'vendor/backpack/crud/fields',
            'tab'          => 'بنر',
            'fake'  => true,
        ]);





        ///////////////////////////// ویجت دسته بندی ها ///////////////////////



    }

    public function widget_course_grouped()
    {
        ///////////////////////////// ویجت لیست دوره ها به صورت تب بندی شده ///////////////////////

        CRUD::addField([
            'name' => 'tabs_title',
            'label' => 'عنوان ویجت',
            'prefix' =>'<i class="la la-pencil la-lg"></i>',
            'tab'          => 'تب بندی شده',
            'fake'  => true,
        ]);

        CRUD::addField([
            'name' => 'tabs_filter',
            'label' => 'دسته برای نمایش آیتم ها',
            'type'        => 'select2_from_array',
            'options'     => [
                'shop'  => trans('backpack::pagemanager.function_name.shop'),
                'blog'  => trans('backpack::pagemanager.function_name.blog')
            ],
            'allows_null' => false,
            'default'     => 'one',
            'tab'          => 'تب بندی شده',
            'fake'  => true,
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ],);

        CRUD::addField([
            'name' => 'tabs_filter_max',
            'label' => 'حداکثر تعداد نمایش تب',
            'type'  => 'number',
            'wrapper'      => ['class'  => "form-group col-md-6"],
            'tab'          => 'تب بندی شده',
            'fake'  => true,
        ]);
        CRUD::addField([
            'name' => 'tabs_filter_item_max',
            'label' => 'حداکثر تعداد محصول',
            'type'  => 'number',
            'wrapper'      => ['class'  => "form-group col-md-6"],
            'tab'          => 'تب بندی شده',
            'fake'  => true,
        ]);

        CRUD::addField([
            'name'   => 'tabs_button_label',
            'prefix' =>'<i class="la la-pencil la-lg"></i>',
            'label'  => 'متن دکمه',
            'wrapper'      => ['class'  => "form-group col-md-6"],
            'attributes'   => ['placeholder' => 'متن'],
            'tab'          => 'تب بندی شده',
            'fake'  => true,
        ]);

        CRUD::addField([
            'name' => 'tabs_button_link',
            'prefix' => '<i class="la la-link la-lg"></i>',
            'attributes'   => ['placeholder' => 'لینک'],
            'label' => 'لینک دکمه',
            'wrapper'      => ['class'  => "form-group col-md-6"],
            'tab'          => 'تب بندی شده',
            'fake'  => true,
        ]);


    }

    public function widget_course_group()
    {
        ///////////////////////////// ویجت دسته بندی ها ///////////////////////

        CRUD::addField([
            'name' => 'category_title',
            'label' => 'عنوان ویجت',
            'prefix' =>'<i class="la la-pencil la-lg"></i>',
            'tab'          => 'دسته بندی دوره ها',
            'fake'  => true,
        ]);

        // CRUD::addField([
        //     'name' => 'category_filter',
        //     'label' => 'دسته برای نمایش ',
        //     'type'  => 'select2',
        //     'wrapper'      => ['class'  => "form-group col-md-6"],
        //     // optional
        //     'entity'    => 'relationBelongsTo', // the method that defines the relationship in your Model
        //     'model'     => "App\Models\Filter", // foreign key model
        //     'attribute' => 'name', // foreign key attribute that is shown to user
        //     'default'   => 2, // set the default value of the select2

        //         // also optional
        //     'options'   => (function ($query) {
        //             return $query->orderBy('name', 'ASC')->where('depth', 1)->get();
        //         }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select

        //     'tab'          => 'دسته بندی دوره ها',
        //     'fake'  => true,
        // ]);
        CRUD::addField([
            'name' => 'category_filter',
            'label' => 'دسته برای نمایش ',
            'type'      => 'select2_from_array',
            'wrapper'      => ['class'  => "form-group col-md-6"],
            // optional
            'allows_multiple' => true,
            'allows_null' => false,
            'options' => Page::where('template', 'shop')->get()->pluck('name','id')->toArray(),
            'tab'          => 'دسته بندی دوره ها',
            'fake'  => true,
        ]);

        CRUD::addField([
            'name' => 'category_filter_max',
            'label' => 'حداکثر تعداد آیتم',
            'default' => 4,
            'type'  => 'number',
            'wrapper'      => ['class'  => "form-group col-md-6"],
            'tab'          => 'دسته بندی دوره ها',
            'fake'  => true,
        ]);

        CRUD::addField([
            'name'   => 'category_button_label',
            'prefix' =>'<i class="la la-pencil la-lg"></i>',
            'label'  => 'متن دکمه',
            'wrapper'      => ['class'  => "form-group col-md-6"],
            'attributes'   => ['placeholder' => 'متن'],
            'tab'          => 'دسته بندی دوره ها',
            'fake'  => true,
        ]);

        CRUD::addField([
            'name' => 'category_button_link',
            'prefix' => '<i class="la la-link la-lg"></i>',
            'attributes'   => ['placeholder' => 'لینک'],
            'label' => 'لینک دکمه',
            'wrapper'      => ['class'  => "form-group col-md-6"],
            'tab'          => 'دسته بندی دوره ها',
            'fake'  => true,
        ]);
        

    }

    public function widget_kashi()
    {

        ///////////////////////////// ویجت کاشی ///////////////////////

        CRUD::addField([
            'name' => 'kashi_title',
            'label' => 'عنوان ویجت',
            'prefix' =>'<i class="la la-pencil la-lg"></i>',
            'tab'          => 'کاشی',
            'fake'  => true,
        ]);

        CRUD::addField([
            'name' => 'kashi_description',
            'type' => 'wysiwyg',
            'label' => 'توضیحات ویجت',
            'prefix' =>'<i class="la la-pencil la-lg"></i>',
            'tab'          => 'کاشی',
            'fake'  => true,
        ]);

        // image
        CRUD::addField([
            'label'        => "تصویر پس زمینه",
            'name'         => 'image_bg',
            'fake'  => true,
            'type' => 'image',
            'crop' => true, // set to true to allow cropping, false to disable
            'aspect_ratio' => 2, // omit or set to 0 to allow any aspect ratio
            // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
            'prefix'    => '', // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
            'wrapper'      => [
                'class'  => "form-group col-12 ltr"
            ],
            'tab'          => 'کاشی',
        ]);

        CRUD::addField([
            'name'   => 'kashi_button_label',
            'prefix' =>'<i class="la la-pencil la-lg"></i>',
            'label'  => 'متن دکمه',
            'wrapper'      => ['class'  => "form-group col-md-6"],
            'attributes'   => ['placeholder' => 'متن'],
            'tab'          => 'کاشی',
            'fake'  => true,
        ]);

        CRUD::addField([
            'name' => 'kashi_button_link',
            'prefix' => '<i class="la la-link la-lg"></i>',
            'attributes'   => ['placeholder' => 'لینک'],
            'label' => 'لینک دکمه',
            'wrapper'      => ['class'  => "form-group col-md-6"],
            'tab'          => 'کاشی',
            'fake'  => true,
        ]);
        
    }

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

    public function widget_top_menu()
    {
        $this->widget_main_menu();
    }


    public function widget_footer_menu2()
    {
        $this->widget_main_menu();
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
                'tab'   => 'اطلاعات تماس',
                // optional
                'new_item_label'  => 'افزودن شبکه اجتماعی جدید', // customize the text of the button
            ],
            
        ]);
    }

    public function widget_counter()
    {
        CRUD::addField([   // repeatable
            'name'  => 'items',
            'label' => 'آیتم',
            'type'  => 'repeatable',
            'fake'  => true,
            'fields' => [
                [   // icon_picker
                    'label'   => '',
                    'name'    => 'icon',
                    'type'    => 'icon_picker',
                    'iconset' => 'fontawesome', // options: fontawesome, glyphicon, ionicon, weathericon, mapicon, octicon, typicon, elusiveicon, materialdesign
                    'wrapper' => ['class' => 'form-group col-md-2 col-sm-2'],
                ],
                [
                    'name'    => 'label',
                    'type'    => 'text',
                    'label'   => 'عنوان',
                    'wrapper' => ['class' => 'form-group col-md-6 col-sm-6'],
                ],
                [
                    'name'    => 'number',
                    'type'    => 'number',
                    'label'   => 'مقدار عددی',
                    'wrapper' => ['class' => 'form-group col-md-4 col-sm-4'],
                ]
            ],
            'tab'             => 'آیتم ها',
            // optional
            'new_item_label'  => 'افزودن آیتم', // customize the text of the button
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
}