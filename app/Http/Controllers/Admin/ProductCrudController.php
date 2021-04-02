<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use App\Models\Filter;
use App\Traits\DefaultPermissions;
use App\Traits\ProductTemplates;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation;
    // use \App\Http\Controllers\Admin\Operations\SettingOperation;
    use \Rezahmady\SettingOperation\SettingOperation;
    use \Backpack\ReviseOperation\ReviseOperation;
    use ProductTemplates;
    use DefaultPermissions;
    
    Const ENTITY = 'product';
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Product::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product');
        CRUD::setEntityNameStrings('محصول', 'محصولات');

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

        /*
        |--------------------------------------------------------------------------
        | COLUMN
        |--------------------------------------------------------------------------
        */

        // Custom Query
        // $this->crud->addClause('where', 'settings->status', '=', 'PUBLISHED');

        // Responsive Table
        // $this->crud->disableResponsiveTable();

        // Persistent Table
        // $this->crud->enablePersistentTable();
        // $this->crud->disablePersistentTable();

        // $this->crud->enableExportButtons();

        CRUD::column('slug')->type('model_function')
        ->label('تصویر')
        ->orderable(false)
        ->searchLogic(false)
        ->function_name('getImageThumb');

        $this->crud->addColumn([
            'name'      => 'row_number',
            'type'      => 'row_number',
            'label'     => '#',
            'orderable' => false,
        ])->makeFirstColumn();

        CRUD::column('name')->type('model_function')
        ->label('نام محصول')
        ->function_name('getNameWithCaption');

        CRUD::column('status')->type('model_function')
        ->label('وضعیت')
        ->function_name('getStatusBrowse');



        /*
        |--------------------------------------------------------------------------
        | FILTER
        |--------------------------------------------------------------------------
        */

        $this->crud->addFilter([
            'name'  => 'status',
            'type'  => 'dropdown',
            'label' => 'وضعیت انتشار'
        ], [
            'PUBLISHED' => 'منتشر شده',
            'PENDING' => 'در وضعیت بررسی',
            'DRAFT' => 'عدم انتشار'
        ], function($value) { // if the filter is active
            return$this->crud->addClause('where', 'settings->status', $value);
        });


    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ProductRequest::class);

        $this->addDefaultProductFields(\Request::input('template'));

        CRUD::setOperationSetting('contentClass', 'col-md-12');
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        CRUD::setValidation(ProductRequest::class);
        $template = \Request::input('template') ?? $this->crud->getCurrentEntry()->template;

        $this->addDefaultProductFields($template);

        CRUD::setOperationSetting('contentClass', 'col-md-12');
    }

    /**
     * Define what happens when the Setting operation is loaded.
     *
     * @see https://github.com/rezahmady/setting-operation
     * @return void
     */
    protected function setupSettingOperation()
    {
        CRUD::addFields([
            [ // Text
                'name'  => 'meta_title',
                'label' => 'تیتر صفحه',
                'prefix' => '<i class="la la-pencil la-lg"></i>',
                'hint'  => 'پیشنهاد می‌شود حداکثر 60 حرف در این فیلد بنویسید.',
                'type'  => 'text',
                'fake'  => true,
                'store_in' => 'metas',
                'tab'   => 'سئو',
            ],
            [ // textarea
                'name'  => 'meta_description',
                'label' => 'شرح مختصر',
                'hint'  => 'پیشنهاد می‌شود حداکثر 155 حرف در این فیلد بنویسید.',
                'type'  => 'textarea',
                'fake'  => true,
                'store_in' => 'metas',
                'tab'   => 'سئو',
            ],
            [ // Text
                'name'  => 'meta_keywords',
                'label' => 'کلمات کلیدی',
                'type'  => 'text',
                'prefix' => '<i class="la la-key la-lg"></i>',
                'hint'  => 'این فیلد دیگر توسط گوگل پشتیبانی نمی‌شود و در بهینه‌سازی سایت شما تاثیری ندارد!',
                'fake'  => true,
                'store_in' => 'metas',
                'tab'   => 'سئو',
            ],
            [ // Text
                'name'  => 'slug',
                'label' => 'آدرس صفحه',
                'type'  => 'text',
                'prefix' => '<i class="la la-link la-lg"></i>',
                'hint'  => 'درصورت خالی گذاشتن به طور خودکار از روی عنوان پست ساخته می شود',
                'tab'   => 'سئو',
            ],
        ]);

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


    // -----------------------------------------------
    // Methods that are particular to the ProductTemplate.
    // -----------------------------------------------

    /**
     * Populate the create/update forms with basic fields, that all pages need.
     *
     * @param string $template The name of the template that should be used in the current form.
     */
    public function addDefaultProductFields($template = false)
    {

        $this->crud->addField([
            'name' => 'template',
            'label' => trans('backpack::productmanager.template'),
            'hint' => 'نوع محصولی که می خواهید ایجاد کنید را در ابتدا مشخص کنید و سپس سایر اطلاعات محصول را در زیر تکمیل کنید',
            'type' => 'select_page_template',
            'view_namespace'  => 'pagemanager::fields',
            'options' => $this->getTemplatesArray(),
            'value' => $template,
            'allows_null' => false,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ],
        ]);

        // محتوا

        CRUD::field('name')->type('text')
            ->label('نام')
            ->attributes([
                'placeholder' => 'عنوان محصول را اینجا بنویسید',
                'class'       => 'form-control form-control-lg'
            ])
            ->prefix('<i class="la la-pencil la-lg"></i>')
            ->tab('محتوا');

        CRUD::field('caption')->type('text')
            ->label('عنوان ثانویه محصول')
            ->attributes([
                'placeholder' => 'عنوان ثانویه محصول ...',
            ])
            ->tab('محتوا');


        if(backpack_user()->can('filter list')) {

            $filters = Filter::where('status', 1)->get();

            foreach($filters as $filter) {
                CRUD::addField([
                    'label'        => $filter->name,
                    'name'      => 'filter_'.$filter->id,
                    'type'      => 'select2_nested_scope',
                    'entity'    => 'filter', // the method that defines the relationship in your Model
                    'attribute' => 'name', // foreign key attribute that is shown to user
                    'scope'     => 'field',
                    'scope_param' => $filter->id,
                    // optional
                    'model'     => "App\Models\FilterItem", // force foreign key model
                    'fake'      => true,
                    'store_in'  => 'filters',
                    'wrapper'      => [
                        'class'  => "form-group col-md-6"
                    ],
                    'tab'          => 'محتوا'
                ]);
            }
        }

        CRUD::addField(
            [   // Checklist
                'label'     => 'در کدام صفحات نمایش داده شود',
                'type'      => 'drop_down_combo_tree',
                'name'      => 'pages',
                'entity'    => 'pages',
                'scope'     => 'shopTemplate',
                'attribute' => 'title',
                'model'     => "App\Models\Page",
                'wrapper'   => [
                    'class'  => "form-group col-md-6"
                ],
                'attributes' => [
                    'placeholder' => 'انتخاب کنید',
                    'autocomplete' => 'off'
                ],
                'combo' => [
                    'isMultiple'         => true,
                    'cascadeSelect'      => true,
                    'collapse'           => false,
                    'selectableLastNode' => true,
                ],
                'pivot'     => true,
                'tab'          => 'محتوا',
            ],
        );

        CRUD::field('description')->type('summernote')
        ->label('توضیحات')
        ->hint('شرح مختصری کم‌تر از 1000 حرف در مورد محصول بنویسید.')
        ->tab('محتوا');

        CRUD::field('content')->type('ckeditor')
        ->label('توضیحات کامل')
        ->tab('محتوا');

        // image
        $this->crud->addField([
            'label'        => "تصویر شاخص",
            'name'         => 'image',
            'type' => 'image',
            'crop' => true, // set to true to allow cropping, false to disable
            'aspect_ratio' => 1, // omit or set to 0 to allow any aspect ratio
            // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
            'prefix'    => '', // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
            'wrapper'      => [
                'class'  => "form-group col-12 ltr"
            ],
            'tab'          => 'محتوا'
        ]);

        $this->useTemplate($template);




        // سئو

        CRUD::field('line')->type('custom_html')
            ->value('<span class="bg-warning text-warning">تیتر و شرح مختصر صفحه به صورت خودکار ایجاد می‌شود و در صورتی که تمایل دارید این مقادیر را به صورت سفارشی ایجاد کنید، از فرم زیر استفاده کنید.</span>')
            ->tab('سئو');

        CRUD::addFields([
            [ // Text
                'name'  => 'meta_title',
                'label' => 'تیتر صفحه',
                'prefix' => '<i class="la la-pencil la-lg"></i>',
                'hint'  => 'پیشنهاد می‌شود حداکثر 60 حرف در این فیلد بنویسید.',
                'type'  => 'text',
                'fake'  => true,
                'store_in' => 'metas',
                'tab'   => 'سئو',
            ],
            [ // textarea
                'name'  => 'meta_description',
                'label' => 'شرح مختصر',
                'hint'  => 'پیشنهاد می‌شود حداکثر 155 حرف در این فیلد بنویسید.',
                'type'  => 'textarea',
                'fake'  => true,
                'store_in' => 'metas',
                'tab'   => 'سئو',
            ],
            [ // Text
                'name'  => 'meta_keywords',
                'label' => 'کلمات کلیدی',
                'type'  => 'text',
                'prefix' => '<i class="la la-key la-lg"></i>',
                'hint'  => 'این فیلد دیگر توسط گوگل پشتیبانی نمی‌شود و در بهینه‌سازی سایت شما تاثیری ندارد!',
                'fake'  => true,
                'store_in' => 'metas',
                'tab'   => 'سئو',
            ],
            [ // Text
                'name'  => 'slug',
                'label' => 'آدرس صفحه',
                'type'  => 'text',
                'prefix' => '<i class="la la-link la-lg"></i>',
                'hint'  => 'درصورت خالی گذاشتن به طور خودکار از روی عنوان پست ساخته می شود',
                'tab'   => 'سئو',
            ],
        ]);


        // تنظیمات

        CRUD::addFields([
            [ // Text
                'name'  => 'status',
                'label' => '<i class="la la-flag-o"></i> وضعیت انتشار',
                'type'  => 'radio',
                'options' => [
                    "PUBLISHED" => '<span class="bg-success mb-1 d-block">
                                محصول منتشر شده و نمایش داده شود.
                            </span>',
                    "PENDING" => '<span class="bg-warning mb-1 d-block">
                                منتظر بررسی و تایید باشد.
                            </span>',
                    "DRAFT" => '<span class="bg-danger mb-1 d-block">
                                منتشر نشود.
                            </span>',
                ],
                'wrapper'   => [
                    'class'      => 'form-group col-md-6'
                ],
                'default' => 'PUBLISHED',
                'fake'  => true,
                'store_in' => 'settings',
                'tab'   => 'تنظیمات',
            ],
            [
                'name'  => 'password',
                'label' => 'رمزعبور',
                'type'  => 'text',
                'wrapper'   => [
                    'class'      => 'form-group col-md-6'
                 ],
                'prefix' => '<i class="la la-key la-lg"></i>',
                'hint'   => 'در صورتی که می‌خواهید صفحه برای بازدیدکنندگانی خاص قابل مشاهده باشد، رمز عبوری در این فیلد بنویسید.',
                'fake'  => true,
                'store_in' => 'settings',
                'tab'    => 'تنظیمات'
            ]
        ]);

    }

    /**
     * Add the fields defined for a specific template.
     *
     * @param  string $template_name The name of the template that should be used in the current form.
     */
    public function useTemplate($template_name = false)
    {
        $templates = $this->getTemplates();

        // set the default template
        if ($template_name == false) {
            $template_name = $templates[0]->name;
        }

        // actually use the template
        if ($template_name) {
            $this->{$template_name}();
        }
    }

    /**
     * Get all defined templates.
     */
    public function getTemplates($template_name = false)
    {
        $templates_array = [];

        $templates_trait = new \ReflectionClass('App\Traits\ProductTemplates');
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
    public function getTemplatesArray()
    {
        $templates = $this->getTemplates();

        foreach ($templates as $template) {
            $templates_array[$template->name] = trans('backpack::productmanager.function_name.'.$template->name);
        }

        return $templates_array;
    }

}
