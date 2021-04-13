<?php
namespace ThemeFolder\themes;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class ThemeOptions
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

    public function fields()
    {

        CRUD::addFields([
            [ // Text
                'name'  => 'meta_title',
                'label' => 'عنوان سایت',
                'prefix' => '<i class="la la-pencil la-lg"></i>',
                'hint'  => 'پیشنهاد می‌شود حداکثر 60 حرف در این فیلد بنویسید.',
                'type'  => 'text',
                'fake'  => true,
                'tab'   => 'اصلی',
            ],
            [ // textarea
                'name'  => 'meta_description',
                'label' => 'شرح مختصر',
                'hint'  => 'پیشنهاد می‌شود حداکثر 155 حرف در این فیلد بنویسید.',
                'type'  => 'textarea',
                'fake'  => true,
                'tab'   => 'اصلی',
            ],
            [ // Text
                'name'  => 'meta_keywords',
                'label' => 'کلمات کلیدی',
                'type'  => 'text',
                'prefix' => '<i class="la la-key la-lg"></i>',
                'hint'  => 'این فیلد دیگر توسط گوگل پشتیبانی نمی‌شود و در بهینه‌سازی سایت شما تاثیری ندارد!',
                'fake'  => true,
                'tab'   => 'اصلی',
            ],
        ]);

        // image
        CRUD::addField([
            'label'        => "تصویر لوگو",
            'name'         => 'logo',
            'fake'  => true,
            'type' => 'image',
            'crop' => true, // set to true to allow cropping, false to disable
            'aspect_ratio' => 0, // omit or set to 0 to allow any aspect ratio
            // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
            'prefix'    => '', // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
            'wrapper'      => [
                'class'  => "form-group col-12 ltr"
            ],
            'tab'          => 'هدر',
        ]);

        CRUD::addFields([
            [   
                'name'  => 'copyright',
                'label' => 'متن کپی رایت',
                'type'  => 'summernote',
                'fake'  => true,
                'options' => [ 
                    'toolbar' => [
                        ['font', ['bold', 'underline']],
                        ['link'],
                        ['color', ['color']],
                        ['fontsize', ['fontsize']],
                        ['codeview'],
                    ]
                ],
                'tab'          => 'فوتر',
            ],
        ]);


    }

    public function page_default($template)
    {

    }

    public function page_blog()
    {
        CRUD::addFields([
            [
                'name' => 'description',
                'label' => 'توضیحات',
                'fake'   => true,
                'type' => 'summernote',
                'placeholder' => 'محتوای خود را در اینجا بنویسید',
                'tab'   => 'محتوا',
            ],
        ]);
    }

    public function page_shop()
    {
        CRUD::addFields([
            [   // color_picker
                'label'                => 'رنگ پس زمینه',
                'name'                 => 'color',
                'type'                 => 'color_picker',
                'default'              => '#0eb582',
                'fake'                 => true,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
                'tab' => 'ظاهر',
                // optional
                'color_picker_options' => ['customClass' => 'custom-class']
                ],
            [   // icon_picker
                'label'   => "آیکن",
                'name'    => 'icon',
                'type'    => 'icon_picker',
                'fake'    => true,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-2',
                ],
                'iconset' => 'fontawesome', // options: fontawesome, glyphicon, ionicon, weathericon, mapicon, octicon, typicon, elusiveicon, materialdesign
                'tab' => 'ظاهر',
            ]
        ]);
        CRUD::addField([
            'label'        => "تصویر پس زمینه هدر",
            'name'         => 'header_bg',
            'tab'          => 'ظاهر',
            'fake'  => true,
            'type' => 'image',
            'crop' => true, // set to true to allow cropping, false to disable
            'aspect_ratio' => 3, // omit or set to 0 to allow any aspect ratio
            // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
            'prefix'    => '', // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
            'wrapper'      => [
                'class'  => "form-group col-12 ltr"
            ],
        ]);
    }

}