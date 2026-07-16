<?php

namespace Modules\UserCustomField\Providers;

use Illuminate\Support\ServiceProvider;
use Rezahmady\SettingOperation\Setting;
use Verta;
use TorMorten\Eventy\Facades\Eventy as Hook;

class CustomFieldServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'UserCustomField';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'user_custom_field';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        Hook::addAction('core-operation-revise', function($image) {
            $text  = \PersianRender\PersianRender::render(Setting::get('users.image_text'), true);
            $image->text($text, Setting::get('users.image_text_left'), Setting::get('users.image_text_top'), function($font) {
                $font->file(public_path('/packages/iransans/dist/fonts/ttf/IRANSansWeb(FaNum)_Bold.ttf'));
                $font->size(Setting::get('users.image_text_size'));
                $font->color(Setting::get('users.image_text_color'));
                $font->align('right');
            });
        }, 20, 1);
        /**
         *  Custom fields
         */
        $fields = Setting::get('users.custom_fields');
        $fields = json_decode($fields, true);

        // crud setting operation
        Hook::addAction('user-crud-setting-operation', function ($crud) {
            self::add_settings_fields($crud);
        }, 20);

        // crud Create/Update operation
        Hook::addAction('user-crud-update-operation-after-fields', function ($crud, $template) use ($fields) {
            self::normalize_fields($crud, $fields);
        }, 20, 2);
        Hook::addAction('user-crud-create-operation-after-fields', function ($crud, $template) use ($fields) {
            self::normalize_fields($crud, $fields);
        }, 20, 2);

        // validation rules
        Hook::addFilter('user-validate-update-rules', function($rules) use ($fields) {
            if(sizeof($fields)) {
                foreach ($fields as $key => $field) {
                    if($field['required'] === '1') {
                        $rules[$field['name']] = 'required';
                    }
                }
            }
            return $rules;
        }, 20, 1);
        Hook::addFilter('user-validate-store-rules', function($rules) use ($fields) {
            if(sizeof($fields)) {
                foreach ($fields as $key => $field) {
                    if($field['required'] === '1') {
                        $rules[$field['name']] = 'required';
                    }
                }
            }
            $rules['password'] = str_replace('required|', '', $rules['password']);
            return $rules;
        }, 20, 1);

        // validation attributes
        Hook::addFilter('user-validate-store-attributes', function($attributes) use ($fields) {
            if(sizeof($fields)) {
                foreach ($fields as $key => $field) {
                    if($field['required'] === '1') {
                        $attributes[$field['name']] = $field['label'];
                    }
                }
            }
            return $attributes;
        }, 20, 1);
        Hook::addFilter('user-validate-update-attributes', function($attributes) use ($fields) {
            if(sizeof($fields)) {
                foreach ($fields as $key => $field) {
                    if($field['required'] === '1') {
                        $attributes[$field['name']] = $field['label'];
                    }
                }
            }
            return $attributes;
        }, 20, 1);

        // crud list operation
        Hook::addAction('user-crud-list-operation-after-columns', function ($crud) use ($fields) {
            self::add_list_columns($crud, $fields);
        }, 20, 2);

        // crud show operation
        Hook::addAction('user-crud-show-operation', function ($crud) use ($fields) {
            self::add_show_columns($crud, $fields);
        }, 20, 2);

        Hook::addFilter('core-revision-timeline-fields', function($values) use ($fields) {
            if(sizeof($fields) and sizeof($values)) {
                foreach ($values as $key => $value) {
                    $new = self::search($fields, 'name', $key);
                    if (sizeof($new)) {
                        $new = $new[0];
                        switch ($new['type']) {
                            case "select2_from_array":
                                $options = [];
                                $opt = json_decode($new['options'], true);
                                foreach ($opt as $item) {
                                    $options[$item['name']] = $item['label'];
                                }
                                $value['new'] = $options[$value['new']];
                                $value['old'] = $options[$value['old']] ?? '';
                                break;
                            case "jdate_picker":
                                $value['new'] = (new Verta($value['new']))->format('Y/n/j');
                                $value['old'] = (new Verta($value['old']))->format('Y/n/j');
                                break;
                            case "table":
                                $columns = [];
                                $col = json_decode($new['columns'], true);
                                foreach ($col as $item) {
                                    $columns[$item['name']] = $item['label'];
                                }
                                $value['old'] = self::table($columns, json_decode($value['old'], true));
                                $value['new'] = self::table($columns, json_decode($value['new'], true));

                                break;
                            case "dropzone":
                                $value['old'] = self::gallery($value['old']);
                                $value['new'] = self::gallery($value['new']);
                                break;
                            default:
                                break;
                        }
                        $values[$new['label']] = $value;
                        unset($values[$key]);
                    }
                }
            }
            return $values;
        }, 20, 2);

        Hook::addFilter('core-revision-timeline-fields-new', function($new_value) {
            return $new_value;
        }, 20, 2);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public static function add_list_columns($crud, $fields) {
        $crud->removeColumn('permissions');
        $crud->addColumns([
            [
                'name'  => 'created_at',
                'label' => 'تاریخ ایجاد',
                'type'     => 'closure',
                'function' => function($entry) {
                    $date = new Verta($entry->created_at);
                    return $date->format('Y/m/d H:i:s');
                }
            ],
            [
                'name'  => 'update_at',
                'label' => 'آخرین ویرایش',
                'type'     => 'closure',
                'function' => function($entry) {
                    $date = new Verta($entry->updated_at);
                    return $date->format('Y/m/d H:i:s');
                }
            ]
        ]);
        if(is_array($fields) and sizeof($fields)) {
            foreach ($fields as $key => $field) {
                if($field['filter'] === '1') {
                    switch ($field['type']) {
                        case "text":
                            // add filter
                            $crud->addFilter([
                                'type'  => 'text',
                                'name'  => $field['name'],
                                'label' => $field['label']
                            ],
                                false,
                                function($value) use ($crud, $field) {
                                    $crud->addClause('where', 'extras->'.$field['name'], 'LIKE', "%$value%");
                                });
                            break;
                        case "summernote":
                            // add filter
                            $crud->addFilter([
                                'type'  => 'text',
                                'name'  => $field['name'],
                                'label' => $field['label']
                            ],
                                false,
                                function($value) use ($crud, $field) {
                                    $crud->addClause('where', 'extras->'.$field['name'], 'LIKE', "%$value%");
                                });
                            break;
                        case "number":
                            // add filter
                            $crud->addFilter([
                                'type'  => 'text',
                                'name'  => $field['name'],
                                'label' => $field['label']
                            ],
                                false,
                                function($value) use ($crud, $field) {
                                    $crud->addClause('where', 'extras->'.$field['name'], $value);
                                });
                            break;
                        case "select2_from_array":
                            $options = [];
                            $opt = json_decode($field['options'], true);
                            foreach ($opt as $item) {
                                $options[$item['name']] = $item['label'];
                            }
                            // add filter
                            $crud->addFilter([
                                'type'  => 'select2_multiple',
                                'name'  => $field['name'],
                                'label' => $field['label']
                            ], function() use ($options) {
                                return $options;
                            }, function($values) use ($crud, $field){
                                $array = json_decode($values);
                                if(is_array($array)) {
                                    foreach ($array as $value) {
                                        $crud->query = $crud->query->where(function ($q) use ($field, $value) {
                                            $q->orWhereJsonContains('extras->'.$field['name'], $value);
                                        });
                                    }
                                } else {
                                    $crud->addClause('whereIn', 'extras->'.$field['name'], json_decode($values));
                                }
                            });
                            break;
                        case "checkbox":
                            // add filter
                            $crud->addFilter([
                                'type'  => 'simple',
                                'name'  => $field['name'],
                                'label' => $field['label']
                            ],
                                false,
                                function() use ($crud, $field) {
                                    $crud->addClause('where', 'extras->'.$field['name'],  "1");
                                });
                            break;
                        case "jdate_picker":
                            // add filter
                            $crud->addFilter([
                                'type'  => 'jdate',
                                'name'  => $field['name'],
                                'label' => $field['label']
                            ],
                                false,
                                function ($value) use ($crud, $field) { // if the filter is active, apply these constraints
                                    $crud->addClause('whereDate', 'extras->'.$field['name'], $value);
                                });
                            break;
                        default:
                            break;
                    }
                }
                switch ($field['type']) {
                    case "text":
                        // add column
                        $crud->addColumn([
                            'name'  => $field['name'],
                            'label' => $field['label'],
                        ]);
                        break;
                    case "summernote":
                        // add column
                        $crud->addColumn([
                            'name'  => $field['name'],
                            'label' => $field['label'],
                            'escaped' => false
                        ]);
                        break;
                    case "select2_from_array":
                        $options = [];
                        $opt = json_decode($field['options'], true);
                        foreach ($opt as $item) {
                            $options[$item['name']] = $item['label'];
                        }
                        // add column
                        $crud->addColumn([
                            'name'  => $field['name'],
                            'label' => $field['label'],
                            'type'    => 'select_from_array',
                            'options' => $options,
                        ]);
                        break;
                    case "checkbox":
                        // add column
                        $crud->addColumn([
                            'name'  => $field['name'],
                            'label' => $field['label'],
                            'type'  => 'check',
                        ]);
                        break;
                    case "jdate_picker":
                        // add column
                        $crud->addColumn([
                            'name'  => $field['name'],
                            'label' => $field['label'],
                            'type'     => 'closure',
                            'function' => function($entry) use($field) {
                                $date = new Verta($entry->{$field['name']});
                                return $date->format('Y/m/d');
                            }
                        ]);
                        break;
                    case "table":
                        $columns = [];
                        $col = json_decode($field['columns'], true);
                        foreach ($col as $item) {
                            $columns[$item['name']] = $item['label'];
                        }
                        // add column
                        $crud->addColumn([
                            'name'  => $field['name'],
                            'label' => $field['label'],
                            'type'  => 'table',
                            'columns' => $columns,
                        ]);
                        break;
                    case "number":
                        $crud->addColumn([
                            'name'  => $field['name'],
                            'label' => $field['label'],
                        ]);
                        break;
                    default:
                        break;
                }
            }
            $crud->addFields($fields);
        }
    }

    public static function add_settings_fields($crud) {
        $options = [
            'text' => 'متن ساده',
            'summernote' => 'متن چندخطی',
            'number'     => 'عدد',
            'table' => 'جدول',
            'select2_from_array' => 'انتخابی',
            'jdate_picker' => 'تاریخ',
            'dropzone' => 'مدیا',
            'checkbox' => 'چک باکس',
        ];

        $crud->addField([   // repeatable
            'name'  => 'custom_fields',
            'label' => 'فیلدهای سفارشی',
            'type'  => 'repeatable',
            'fields' => [
                [
                    'name'    => 'type',
                    'type'    => 'select2_from_array',
                    'label'   => 'نوع',
                    'options' => $options,
                    'wrapper' => ['class' => 'form-group col-md-3'],
                    'show_when' => [
                        'table' => ['columns', 'min', 'max'],
                        'select2_from_array' => ['allows_multiple', 'options'],
                        'dropzone' => ['max_file', 'max_file_size', 'image_height', 'image_width'],
                    ],
                    'hide_when' => [
                        'dropzone' => ['filter'],
                        'table' => ['filter'],
                    ],
                ],
                [
                    'name'    => 'name',
                    'type'    => 'text',
                    'label'   => 'نام انگلیسی',
                    'wrapper' => ['class' => 'form-group col-md-3'],
                ],
                [
                    'name'    => 'label',
                    'type'    => 'text',
                    'label'   => 'عنوان فیلد',
                    'wrapper' => ['class' => 'form-group col-md-3'],
                ],
                [
                    'name'    => 'fake',
                    'type'    => 'hidden',
                    'value'   => true,
                ],
                [
                    'name'    => 'tab',
                    'type'    => 'text',
                    'label'   => 'عنوان تب',
                    'wrapper' => ['class' => 'form-group col-md-3'],
                ],
                [   // Checkbox
                    'name'  => 'required',
                    'label' => 'الزامی باشد',
                    'type'  => 'checkbox',
                    'wrapper' => ['class' => 'form-group col-md-3'],
                ],
                [   // Checkbox
                    'name'  => 'col-md-12',
                    'label' => 'استایل تمام عرض',
                    'type'  => 'checkbox',
                    'wrapper' => ['class' => 'form-group col-md-3'],
                ],
                [   // Checkbox
                    'name'  => 'filter',
                    'label' => 'فیلتر',
                    'type'  => 'checkbox',
                    'wrapper' => ['class' => 'form-group col-md-3'],
                ],
                [   // Checkbox
                    'name'  => 'min',
                    'label' => 'حداقل تعداد ردیف',
                    'type'  => 'number',
                    'wrapper' => ['class' => 'form-group col-md-3'],
                ],
                [   // Checkbox
                    'name'  => 'max',
                    'label' => 'حداکثر تعداد ردیف',
                    'type'  => 'number',
                    'wrapper' => ['class' => 'form-group col-md-3'],
                ],
                [   // Checkbox
                    'name'  => 'max_file',
                    'label' => 'حداکثر تعداد تصویر',
                    'type'  => 'number',
                    'wrapper' => ['class' => 'form-group col-md-3'],
                ],
                [   // Checkbox
                    'name'  => 'max_file_size',
                    'label' => 'حداکثر حجم تصویر',
                    'type'  => 'number',
                    'wrapper' => ['class' => 'form-group col-md-3'],
                ],
                [   // Checkbox
                    'name'  => 'image_width',
                    'label' => 'پهنا',
                    'type'  => 'number',
                    'wrapper' => ['class' => 'form-group col-md-3'],
                ],
                [   // Checkbox
                    'name'  => 'image_height',
                    'label' => 'ارتفاع',
                    'type'  => 'number',
                    'wrapper' => ['class' => 'form-group col-md-3'],
                ],
                [   // Checkbox
                    'name'  => 'columns',
                    'label' => 'ستون ها',
                    'type'  => 'table',
                    'columns'         => [
                        'name'  => 'نام (انگلیسی)',
                        'label'  => 'عنوان فارسی',
                    ],
                    'max' => 10, // maximum rows allowed in the table
                    'min' => 1,
                    'wrapper' => ['class' => 'form-group col-md-12'],
                ],
                [   // Checkbox
                    'name'  => 'allows_multiple',
                    'label' => 'چندانتخابی',
                    'type'  => 'checkbox',
                    'wrapper' => ['class' => 'form-group col-md-3'],
                ],
                [   // Checkbox
                    'name'  => 'options',
                    'label' => 'گزینه ها',
                    'type'  => 'table',
                    'columns'         => [
                        'name'  => ' نام (انگلیسی)',
                        'label'  => 'عنوان فارسی',
                    ],
                    'max' => 100, // maximum rows allowed in the table
                    'min' => 1,
                    'wrapper' => ['class' => 'form-group col-md-12'],
                ],

            ],
            'tab'   => 'مدیریت فیلدها',
            // optional
            'new_item_label'  => 'افزودن فیلد جدید', // customize the text of the button
            'init_rows' => 0, // number of empty rows to be initialized, by default 1
            'min_rows' => 0, // minimum rows allowed, when reached the "delete" buttons will be hidden
            'max_rows' => 100, // maximum rows allowed, when reached the "new item" button will be hidden

        ]);

        // print
        $crud->addFields([
            [
                'name'    => 'print_text',
                'type'    => 'text',
                'label'   => 'متن واترمارک',
                'wrapper' => ['class' => 'form-group col-md-6'],
                'tab'     => 'پرینت',
            ],
            [
                'name'    => 'print_text_bottom',
                'type'    => 'number',
                'label'   => 'فاصله از پایین',
                'wrapper' => ['class' => 'form-group col-md-6'],
                'tab'     => 'پرینت',
            ],
            [
                'name'    => 'print_text_left',
                'type'    => 'number',
                'label'   => 'فاصله از چپ',
                'wrapper' => ['class' => 'form-group col-md-6'],
                'tab'     => 'پرینت',
            ],
            [
                'name'    => 'print_text_size',
                'type'    => 'number',
                'label'   => 'اندازه متن',
                'wrapper' => ['class' => 'form-group col-md-6'],
                'tab'     => 'پرینت',
            ],
        ]);

        // image
        $crud->addFields([
            [
                'name'    => 'image_text',
                'type'    => 'text',
                'label'   => 'متن تصویر',
                'wrapper' => ['class' => 'form-group col-md-6'],
                'tab'     => 'تصاویر',
            ],
            [
                'name'    => 'image_text_top',
                'type'    => 'number',
                'label'   => 'فاصله از بالا',
                'wrapper' => ['class' => 'form-group col-md-6'],
                'tab'     => 'تصاویر',
            ],
            [
                'name'    => 'image_text_left',
                'type'    => 'number',
                'label'   => 'فاصله از چپ',
                'wrapper' => ['class' => 'form-group col-md-6'],
                'tab'     => 'تصاویر',
            ],
            [
                'name'    => 'image_text_size',
                'type'    => 'number',
                'label'   => 'اندازه متن',
                'wrapper' => ['class' => 'form-group col-md-6'],
                'tab'     => 'تصاویر',
            ],
            [
                'name'    => 'image_text_color',
                'label'   => 'رنگ متن',
                'wrapper' => ['class' => 'form-group col-md-6'],
                'tab'     => 'تصاویر',
                'type'                 => 'color_picker',
                'default'              => '#000000',

                // optional
                // Anything your define inside `color_picker_options` will be passed as JS
                // to the JavaScript plugin. For more information about the options available
                // please see the plugin docs at:
                //  ### https://itsjavi.com/bootstrap-colorpicker/module-options.html
                'color_picker_options' => [
                    'customClass' => 'custom-class',
                    'horizontal' => true,
                    'extensions' => [
                        [
                            'name' => 'swatches', // extension name to load
                            'options' => [ // extension options
                                'colors' => [
                                    'primary' => '#337ab7',
                                    'success' => '#5cb85c',
                                    'info' => '#5bc0de',
                                    'warning' => '#f0ad4e',
                                    'danger' => '#d9534f'
                                ],
                                'namesAsValues' => false
                            ]
                        ]
                    ]
                ]
            ],
        ]);
    }

    public static function add_show_columns($crud, $fields) {
        $crud->set('show.setFromDb', false);
        $crud->setShowContentClass('col-md-12');
        $crud->addColumns([
            [
                'name'  => 'name',
                'label' => 'نام',
            ],
            [
                'name'  => 'mobile',
                'label' => 'موبایل',
                'type'     => 'phone',
            ],
            [
                'name'  => 'email',
                'label' => 'ایمیل',
                'type'  => 'email',
            ],
        ]);

        if(sizeof($fields)) {
            foreach ($fields as $key => $field) {
                switch ($field['type']) {
                    case "text":
                        // add column
                        $crud->addColumn([
                            'name'  => $field['name'],
                            'label' => $field['label'],
                        ]);
                        break;
                    case "summernote":
                        // add column
                        $crud->addColumn([
                            'name'  => $field['name'],
                            'label' => $field['label'],
                            'escaped' => false
                        ]);
                        break;
                    case "select2_from_array":
                        $options = [];
                        $opt = json_decode($field['options'], true);
                        foreach ($opt as $item) {
                            $options[$item['name']] = $item['label'];
                        }
                        // add column
                        $crud->addColumn([
                            'name'  => $field['name'],
                            'label' => $field['label'],
                            'type'    => 'select_from_array',
                            'options' => $options,
                        ]);
                        break;
                    case "checkbox":
                        // add column
                        $crud->addColumn([
                            'name'  => $field['name'],
                            'label' => $field['label'],
                            'type'  => 'check',
                        ]);
                        break;
                    case "jdate_picker":
                        // add column
                        $crud->addColumn([
                            'name'  => $field['name'],
                            'label' => $field['label'],
                            'type'     => 'closure',
                            'function' => function($entry) use($field) {
                                $date = new Verta($entry->{$field['name']});
                                return $date->format('Y/m/d');
                            }
                        ]);
                        break;
                    case "table":
                        $columns = [];
                        $col = json_decode($field['columns'], true);
                        foreach ($col as $item) {
                            $columns[$item['name']] = $item['label'];
                        }
                        // add column
                        $crud->addColumn([
                            'name'  => $field['name'],
                            'label' => $field['label'],
                            'type'  => 'table',
                            'columns' => $columns,
                        ]);

                        break;
                    case "number":
                        $crud->addColumn([
                            'name'  => $field['name'],
                            'label' => $field['label'],
                        ]);
                        break;
                    case "dropzone":
                        $crud->addColumn([
                            'name'  => $field['name'],
                            'label' => $field['label'],
                            'type'  => 'view',
                            'view'  => 'user::admin.columns.multi_image',
                        ]);
                        break;
                    default:
                        break;
                }
            }
            $crud->addFields($fields);
        }
    }

    public static function normalize_fields($crud, $fields) {
        $crud->setEditContentClass('col-md-12');
        if(sizeof($fields)) {
            foreach ($fields as $key => $field) {
                if($field['type'] === 'summernote') {
                    $fields[$key]['options'] = [
                        'toolbar' => [
                            ['style', ['style']],
                            ['font', ['bold', 'underline', 'clear']],
                            ['color', ['color']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['table', ['table']],
                            ['insert', ['link', 'video']],
                            ['view', ['fullscreen', 'codeview', 'help']]
                        ]
                    ];

                } elseif($field['type'] === 'table') {
                    $columns = [];
                    $col = json_decode($field['columns'], true);
                    foreach ($col as $item) {
                        $columns[$item['name']] = $item['label'];
                    }
                    $fields[$key]['columns'] = $columns;
                } elseif($field['type'] === 'select2_from_array') {
                    $options = [];
                    $opt = json_decode($field['options'], true);
                    foreach ($opt as $item) {
                        $options[$item['name']] = $item['label'];
                    }
                    $fields[$key]['options'] = $options;
                } elseif ($field['type'] === 'dropzone') {
                    $fields[$key]['disk'] = 'local';
                    $fields[$key]['destination_path'] = 'uploads/images/user';
                    $fields[$key]['mimes'] = 'image/*';
                    $fields[$key]['thumb_prefix'] = '/';
                }
                if($field['tab'] == '') unset($fields[$key]['tab']);
                if($field['col-md-12'] == '1') {
                    $fields[$key]['wrapper'] = [
                        'class'  => "form-group col-12"
                    ];
                } else {
                    $fields[$key]['wrapper'] = [
                        'class'  => "form-group col-md-6 col-12"
                    ];
                }
            }
            $crud->addFields($fields);
        }
    }

    public static function search($array, $key, $value): array
    {
        $results = array();

        if (is_array($array)) {
            if (isset($array[$key]) && $array[$key] == $value) {
                $results[] = $array;
            }

            foreach ($array as $subarray) {
                $results = array_merge($results, self::search($subarray, $key, $value));
            }
        }

        return $results;
    }

    public static function gallery($images): string
    {
        $gallery = '<div class="d-flex justify-content-center flex-wrap">';
        foreach ($images as $image) {
            $gallery .= '<img width="100px" class="m-2" src="/'.$image.'" />';
        }
        $gallery .= '</div>';

        return $gallery;
    }

    public static function table($head, $rows): string
    {
        if (is_array($rows)) {
            $table = '<table class="table bg-white table-bordered table-condensed table-striped m-b-0"><thead><tr>';
            foreach ($head as $th) {
                $table .= '<th>'.$th.'</th>';
            }
            $table .= '</thead><tbody>';
            foreach ($rows as $key => $row) {
                $table .= '<tr>';
                foreach ($row as $index => $value) {
                    $table .= '<td>'.$value.'</td>';
                }
                $table .= '</tr>';
            }
            $table .= '</tbody></table>';
        } else {
            $table = '';
        }
        return $table;
    }
}
