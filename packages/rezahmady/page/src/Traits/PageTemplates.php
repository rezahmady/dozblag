<?php

namespace Rezahmady\Page\Traits;

trait PageTemplates
{
    /*
    |--------------------------------------------------------------------------
    | Page Templates for Backpack\PageManager
    |--------------------------------------------------------------------------
    |
    | Each page template has its own method, that define what fields should show up using the Backpack\CRUD API.
    | Use snake_case for naming and PageManager will make sure it looks pretty in the create/update form
    | template dropdown.
    |
    | Any fields defined here will show up after the standard page fields:
    | - select template
    | - page name (only seen by admins)
    | - page title
    | - page slug
    */

    private function text()
    {
        $this->crud->addField([   // WYSIWYG Editor
            'name'  => 'content',
            'label' => 'محتوا صفحه',
            'type'  => 'ckeditor',
            'fake'  => true,
            'options' => [
                'language' => 'fa',
                "stylesSet" => [
                    [ "name" => "پس زمینه آبی", "element" => "div", "attributes" => ["class" => "bg-blue", "style" => "background: aliceblue;padding: 15px;font-size: 17px;border-radius: 20px;"]],
                    [ "name" => "پس زمینه زرد", "element" => "div", "attributes" => ["class" => "bg-blue", "style" => "background: #feffaf;padding: 15px;font-size: 17px;border-radius: 20px;"]],
                    [ "name" => "پس زمینه قرمز", "element" => "div", "attributes" => ["class" => "bg-blue", "style" => "background: #fff0f0;padding: 15px;font-size: 17px;border-radius: 20px;"]],
                    [ "name" => "پس زمینه سبز", "element" => "div", "attributes" => ["class" => "bg-blue", "style" => "background: #dfffd7;padding: 15px;font-size: 17px;border-radius: 20px;"]],
                    [ "name" => "پس زمینه سبز", "element" => "div", "attributes" => ["class" => "bg-blue", "style" => "background: #dfffd7;padding: 15px;font-size: 17px;border-radius: 20px;"]],
                    [ "name" => "حاشیه نقطه ای آبی", "element" => "div", "attributes" => ["class" => "bg-blue", "style" => "border: 2px dotted #20c0f3;padding: 15px;font-size: 17px;border-radius: 20px;"]],
                    [ "name" => "حاشیه نقطه ای قرمز", "element" => "div", "attributes" => ["class" => "bg-blue", "style" => "border: 2px dotted red;padding: 15px;font-size: 17px;border-radius: 20px;"]],
                    [ "name" => "حاشیه نقطه ای سبز", "element" => "div", "attributes" => ["class" => "bg-blue", "style" => "border: 2px dotted #1bbf19;padding: 15px;font-size: 17px;border-radius: 20px;"]],
                    [ "name" => " لیست استایل قرمز", "element" => "span", "attributes" => ["class" => "list-style-red", "style" => "padding: 0 13px;color: #fff;display: inline-block;text-align: center;border-radius: 20px;background: #fb2941;box-shadow: 4px 5px 0 0 rgb(0 0 0 / 9%);width:max-content"]],
                    [ "name" => " لیست استایل آبی", "element" => "span", "attributes" => ["class" => "list-style-blue", "style" => "padding: 0 13px;color: #fff;display: inline-block;text-align: center;border-radius: 20px;background: #00bfd6;box-shadow: 4px 5px 0 0 rgb(0 0 0 / 9%);width:max-content"]],
                    [ "name" => " لیست استایل سبز", "element" => "span", "attributes" => ["class" => "list-style-green", "style" => "padding: 0 13px;color: #fff;display: inline-block;text-align: center;border-radius: 20px;background: #14ce2b;box-shadow: 4px 5px 0 0 rgb(0 0 0 / 9%);width:max-content"]],
                    [ "name" => " لیست استایل خاکستری تیره", "element" => "span", "attributes" => ["class" => "list-style-gray", "style" => "padding: 0 13px;color: #fff;display: inline-block;text-align: center;border-radius: 20px;background: #797878;box-shadow: 4px 5px 0 0 rgb(0 0 0 / 9%);width:max-content"]],
                    [ "name" => " دکمه", "element" => "div", "attributes" => ["class" => "btn-consultation", "style" => "padding: 5px 10px;color: #fff;margin: auto;display: block;text-align: center;border-radius: 20px;background: #fb2941;box-shadow: 4px 5px 0 0 rgb(0 0 0 / 9%);width:max-content"]],
                ],
                // "disallowedContent" => false,
                "allowedContent" => true
                // 'skin'     => 'office2013',
            ]
        ]);
    }

    private function shop()
    {

        $this->crud->addField([
            'label'        => "تصویر شاخص",
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
        ]);
        $this->crud->addField([
            'name' => 'max_item',
            'label' => 'حداکثر تعداد آیتم در صفحه',
            'type' => 'number',
            'fake'    => true,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4',
            ],
            'tab' => 'تنظیمات',
        ]);

    }

    private function blog()
    {
        $this->crud->addField([
            'label'        => "تصویر شاخص",
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
        ]);
        $this->crud->addField([
            'name' => 'max_item',
            'label' => 'حداکثر تعداد آیتم در صفحه',
            'type' => 'number',
            'fake'    => true,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4',
            ],
            'tab' => 'تنظیمات',
        ]);
    }

    private function form()
    {
        $this->crud->addField([   // WYSIWYG Editor
            'name'  => 'description',
            'label' => 'توضیحات',
            'type'  => 'wysiwyg',
            'fake'  => true,
        ]);
        $this->crud->setOperationSetting('contentClass', 'col-md-12');
        $this->crud->addField([
            'name' => 'form',
            'label' => '',
            'type' => 'form_builder',
            'fake'    => true,
            'tab' => 'فرم ساز',
        ]);
    }

    private function gallery()
    {

    }

    private function link()
    {
        //
    }

}