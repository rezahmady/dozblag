<?php

namespace App\Traits;

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
            'type'  => 'wysiwyg',
            'fake'  => true,
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