<?php

namespace App\Traits;

trait ProductTemplates
{
    /*
    |--------------------------------------------------------------------------
    | Product Templates
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

    private function commodity()
    {
        $this->crud->addFields([
            [
                'name'    => 'price',
                'type'    => 'number',
                'label'   => 'قیمت',
                'prefix'  => '<i class="la la-dollar"></i>',
                'suffix'  => 'تومان',
                'wrapper' => ['class' => 'form-group col-md-6'],
                'tab'     => 'جزئیات ساختاری محصول',
                'fake'  => true,
                'store_in' => 'extras',
            ],
            [
                'name'    => 'old_price',
                'type'    => 'number',
                'label'   => 'قیمت خط‌خورده',
                'prefix'  => '<i class="la la-dollar"></i>',
                'suffix'  => 'تومان',
                'wrapper' => ['class' => 'form-group col-md-6'],
                'tab'     => 'جزئیات ساختاری محصول',
                'fake'  => true,
                'store_in' => 'extras',
            ],
            [
                'name'    => 'stock',
                'type'    => 'number',
                'label'   => 'تعداد موجودی',
                'prefix'  => '<i class="la la-list"></i>',
                'wrapper' => ['class' => 'form-group col-md-6'],
                'tab'     => 'جزئیات ساختاری محصول',
                'fake'  => true,
                'store_in' => 'extras',
            ],
            [
                'name'    => 'sku',
                'type'    => 'text',
                'label'   => 'شناسه محصول',
                'prefix'  => '<i class="la la-barcode"></i>',
                'wrapper' => ['class' => 'form-group col-md-6'],
                'tab'     => 'جزئیات ساختاری محصول',
                'fake'  => true,
                'store_in' => 'extras',
            ],
            [   // select2_from_array
                'name'        => 'tax_mode',
                'label'       => "مالیات",
                'type'        => 'select2_from_array',
                'wrapper' => ['class' => 'form-group col-md-6'],
                'options'     => [
                    'defult' => 'بر اساس تنظیمات فروشگاه', 
                    'custom' => 'نرخ سفارشی محاسبه شود.', 
                    'nope' => 'محاسبه نشود.'],
                'allows_null' => false,
                'default'     => '',
                'tab'     => 'جزئیات ساختاری محصول',
                'fake'  => true,
                'store_in' => 'extras',
            ],
            [   // two interconnected entities
                'type'              => 'conditional_select',
                'name'              => 'tax_data',
                'select_field'       => 'tax_mode',
                'wrapper' => ['class' => 'form-group col-md-6'],
                'fake'  => true,
                'store_in' => 'extras',
                'options'           => [
                    "defult",
                    "custom",
                    "nope"
                ],
                'fields'            => [
                    'defult' => [],
                    'custom' => [
                        [
                            'name'    => 'tax',
                            'type'    => 'number',
                            'label'   => 'نرخ سفارشی مالیات',
                            'prefix'  => '<i class="la la-percent"></i>',
                            'wrapper' => ['class' => 'col-12 p-0'],
                            'suffix'  => 'درصد',
                            'tab'     => 'جزئیات ساختاری محصول',
                            'fake'  => true,
                            'store_in' => 'extras',
                        ],
                    ],
                    'nope' => []
                ],
                'tab'     => 'جزئیات ساختاری محصول',
            ],
            [
                'name'    => 'minimum',
                'type'    => 'number',
                'label'   => 'حداقل تعداد در هر سفارش',
                'prefix'  => '<i class="la la-battery-1"></i>',
                'wrapper' => ['class' => 'form-group col-md-6'],
                'tab'     => 'جزئیات ساختاری محصول',
                'fake'  => true,
                'store_in' => 'extras',
            ],
            [
                'name'    => 'maximum',
                'type'    => 'number',
                'label'   => 'حداکثر تعداد در هر سفارش',
                'prefix'  => '<i class="la la-battery-4"></i>',
                'wrapper' => ['class' => 'form-group col-md-6'],
                'tab'     => 'جزئیات ساختاری محصول',
                'fake'  => true,
                'store_in' => 'extras',
            ],
            [   // select2_from_array
                'name'        => 'shipment_mode',
                'label'       => "حمل و نقل",
                'type'        => 'select2_from_array',
                'wrapper' => ['class' => 'form-group col-md-6'],
                'options'     => [
                    'defult' => 'ارسال بر اساس تنظیمات فروشگاه انجام می‌شود.', 
                    'custom' => 'ارسال با هزینه‌ی مشخص انجام می‌شود.', 
                    'free' => 'ارسال رایگان انجام می‌شود.', 
                    'nope' => 'غیر فعال باشد.'],
                'allows_null' => false,
                'default'     => '',
                'tab'     => 'جزئیات ساختاری محصول',
                'fake'  => true,
                'store_in' => 'extras',
            ],
            [   // two interconnected entities
                'type'              => 'conditional_select2',
                'name'              => 'shipment_data',
                'select_field'       => 'shipment_mode',
                'wrapper' => ['class' => 'form-group'],
                'fake'  => true,
                'store_in' => 'extras',
                'options'           => [
                    'defult', 
                    'custom', 
                    'free', 
                    'nope'
                ],
                'fields'            => [
                    'defult' => [
                        [
                            'name'    => 'weight',
                            'type'    => 'number',
                            'label'   => 'وزن بسته',
                            'prefix'  => '<i class="la la-percent"></i>',
                            'wrapper' => ['class' => 'form-group col-md-6'],
                            'tab'     => 'جزئیات ساختاری محصول',
                        ],
                        [
                            'name'    => 'width',
                            'type'    => 'number',
                            'label'   => 'طول بسته',
                            'prefix'  => '<i class="la la-percent"></i>',
                            'wrapper' => ['class' => 'form-group col-md-6'],
                            'tab'     => 'جزئیات ساختاری محصول',
                        ],
                        [
                            'name'    => 'length',
                            'type'    => 'number',
                            'label'   => 'عرض بسته',
                            'prefix'  => '<i class="la la-percent"></i>',
                            'wrapper' => ['class' => 'form-group col-md-6'],
                            'tab'     => 'جزئیات ساختاری محصول',
                        ],
                        [
                            'name'    => 'height',
                            'type'    => 'number',
                            'label'   => 'ارتفاع بسته',
                            'prefix'  => '<i class="la la-percent"></i>',
                            'wrapper' => ['class' => 'form-group col-md-6'],
                            'tab'     => 'جزئیات ساختاری محصول',
                        ],
                    ], 
                    'custom' => [
                        [
                            'name'    => 'shipping',
                            'type'    => 'number',
                            'label'   => 'قیمت',
                            'prefix'  => '<i class="la la-dollar"></i>',
                            'suffix'  => 'تومان',
                            'wrapper' => ['class' => 'form-group col-md-6'],
                            'tab'     => 'جزئیات ساختاری محصول',
                        ],
                        [
                            'name'    => 'weight',
                            'type'    => 'number',
                            'label'   => 'وزن بسته',
                            'prefix'  => '<i class="la la-percent"></i>',
                            'wrapper' => ['class' => 'form-group col-md-6'],
                            'tab'     => 'جزئیات ساختاری محصول',
                        ],
                        [
                            'name'    => 'width',
                            'type'    => 'number',
                            'label'   => 'طول بسته',
                            'prefix'  => '<i class="la la-percent"></i>',
                            'wrapper' => ['class' => 'form-group col-md-6'],
                            'tab'     => 'جزئیات ساختاری محصول',
                        ],
                        [
                            'name'    => 'length',
                            'type'    => 'number',
                            'label'   => 'عرض بسته',
                            'prefix'  => '<i class="la la-percent"></i>',
                            'wrapper' => ['class' => 'form-group col-md-6'],
                            'tab'     => 'جزئیات ساختاری محصول',
                        ],
                        [
                            'name'    => 'height',
                            'type'    => 'number',
                            'label'   => 'ارتفاع بسته',
                            'prefix'  => '<i class="la la-percent"></i>',
                            'wrapper' => ['class' => 'form-group col-md-6'],
                            'tab'     => 'جزئیات ساختاری محصول',
                        ],

                    ],
                    'free' => [
                        [
                            'name'    => 'weight',
                            'type'    => 'number',
                            'label'   => 'وزن بسته',
                            'prefix'  => '<i class="la la-percent"></i>',
                            'wrapper' => ['class' => 'form-group col-md-6'],
                            'tab'     => 'جزئیات ساختاری محصول',
                        ],
                        [
                            'name'    => 'width',
                            'type'    => 'number',
                            'label'   => 'طول بسته',
                            'prefix'  => '<i class="la la-percent"></i>',
                            'wrapper' => ['class' => 'form-group col-md-6'],
                            'tab'     => 'جزئیات ساختاری محصول',
                        ],
                        [
                            'name'    => 'length',
                            'type'    => 'number',
                            'label'   => 'عرض بسته',
                            'prefix'  => '<i class="la la-percent"></i>',
                            'wrapper' => ['class' => 'form-group col-md-6'],
                            'tab'     => 'جزئیات ساختاری محصول',
                        ],
                        [
                            'name'    => 'height',
                            'type'    => 'number',
                            'label'   => 'ارتفاع بسته',
                            'prefix'  => '<i class="la la-percent"></i>',
                            'wrapper' => ['class' => 'form-group col-md-6'],
                            'tab'     => 'جزئیات ساختاری محصول',
                        ],
                    ], 
                    'nope' => [],
                ],
                'tab'     => 'جزئیات ساختاری محصول',
            ],
            
        ]);

        // مشخصه ها

        $this->crud->field('parameters')->type('repeatable')
        ->label('ویژگی ها  <br> <small class="help-block p-0">ویژگی‌های محصول مانند مشخصات فیزیکی، نرم‌افزاری و... را به صورت گروه بندی شده تعریف کنید.</small>')
        ->fields([
            [
                'name'    => 'group',
                'type'    => 'text',
                'label'   => 'نام گروه',
                'wrapper' => ['class' => 'form-group col-md-4'],
                'attributes' => [
                    'placeholder' => 'مانند : مشخصات فنی',
                ]
            ],
            [
                'name'  => 'param',
                'type'  => 'table',
                'label' => 'آیتم ها',
                'entity_singular' => 'ویژگی',
                'columns' => [
                    'name'  => 'عنوان <small>(مانند : پردازنده)</small>',
                    'value'  => 'مقدار <small>(مانند: Intel Core i7 Quad Core 2.8 گيگاهرتز)</small>',
                ],
                'min' => 0,
                'max' => 30
            ],
        ])
        ->new_item_label('افزودن گروه جدید')
        ->tab('مشخصه ها');

    }

    private function course()
    {

        $this->crud->addField([
            'name'    => 'courses',
            'type'    => 'repeatable',
            'label'   => '',
            'wrapper' => ['class' => 'form-group col-12'],
            'tab'     => 'ویدئو‌ها',
            'new_item_label'  => 'فایل جدید',
            'fake'  => true,
            'store_in' => 'extras',
            'attributes' => [
                'placeholder' => 'مانند : نقد و بررسی',
            ],
            'fields' => [
                [
                    'name'    => 'section',
                    'type'    => 'text',
                    'label'   => 'عنوان بخش/فصل',
                    'wrapper' => ['class' => 'form-group col-md-6'],
                    'attributes' => [
                        'placeholder' => 'مانند : فصل اول',
                    ]
                ],
                [
                    'name'    => 'title',
                    'type'    => 'text',
                    'label'   => 'عنوان فایل',
                    'wrapper' => ['class' => 'form-group col-md-6'],
                    'attributes' => [
                        'placeholder' => 'مانند : قسمت اول',
                    ]
                ],
                [
                    'name'    => 'file',
                    'type'    => 'browse',
                    'label'   => 'فایل',
                    'wrapper' => ['class' => 'form-group col-md-12'],
                ],
                
            ]
        ]);

        

        // مشخصه ها

        $this->crud->addField([   // repeatable
            'name'  => 'parameters',
            'label' => 'ویژگی ها',
            'type'  => 'repeatable',
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
                    'name'    => 'value',
                    'type'    => 'text',
                    'label'   => 'مقدار',
                    'wrapper' => ['class' => 'form-group col-md-4 col-sm-4'],
                ]
            ],
            'tab'             => 'مشخصه ها',
            // optional
            'new_item_label'  => 'افزودن مشخصه', // customize the text of the button
        ]);

    }
}