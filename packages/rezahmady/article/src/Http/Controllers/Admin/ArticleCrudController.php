<?php

namespace Rezahmady\Article\Http\Controllers\Admin;

use App\Traits\DefaultPermissions;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Rezahmady\Article\Http\Requests\ArticleRequest;

class ArticleCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkCloneOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;
    use DefaultPermissions;
    Const ENTITY = 'post';

    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel(\Rezahmady\Article\Models\Article::class);
        $this->crud->setRoute(config('backpack.base.route_prefix', 'admin').'/article');
        $this->crud->setEntityNameStrings(trans('general.article_singular'), trans('general.article_plural'));

        /*
        |--------------------------------------------------------------------------
        | PERMISSIONS
        |--------------------------------------------------------------------------
        */
        $this->setPermissions();

        /*
        |--------------------------------------------------------------------------
        | LIST OPERATION
        |--------------------------------------------------------------------------
        */
        $this->crud->operation('list', function () {

            $this->crud->addButtonFromModelFunction('line', 'open', 'getOpenButton', 'beginning');

            $this->crud->addColumn([
                'name' => 'title',
                'label' => trans('validation.attributes.title')
            ]);

            $this->crud->addColumn([
                'name' => 'status',
                'type' => 'model_function',
                'function_name' => 'getStatusBrowse',
                'label' => trans('general.article.status')
            ]);

            $this->crud->addColumn([
                'name' => 'tags',
                'label' => trans('general.tag_plural'),
                'visibleInTable'  => false,
                'visibleInModal'  => true,
            ]);

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
                'DRAFT' => 'عدم انتشار'
            ], function($value) { // if the filter is active
                return$this->crud->addClause('where', 'status', $value);
            });

            $this->crud->addFilter([ // select2_multiple filter
                'name' => 'tags',
                'type' => 'select2_multiple',
                'label'=> trans('general.tag_plural')
            ], function () {
                return \Rezahmady\Article\Models\Tag::all()->keyBy('id')->pluck('name', 'id')->toArray();
            }, function ($values) { // if the filter is active
                $this->crud->query = $this->crud->query->whereHas('tags', function ($q) use ($values) {
                    foreach (json_decode($values) as $key => $value) {
                        if ($key == 0) {
                            $q->where('tags.id', $value);
                        } else {
                            $q->orWhere('tags.id', $value);
                        }
                    }
                });
            });
        });

        /*
        |--------------------------------------------------------------------------
        | CREATE & UPDATE OPERATIONS
        |--------------------------------------------------------------------------
        */
        $this->crud->operation(['create', 'update'], function () {
            $this->crud->setValidation(ArticleRequest::class);
            $this->crud->setOperationSetting('contentClass', 'col-md-12 bold-labels');
            $this->crud->addFields(static::getFieldsArrayForAttributes());

            $this->crud->addFields([
                [
                    'name'        => 'description',
                    'label'       => trans('validation.attributes.description'),
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
                    'placeholder' => 'خلاصه ای از مطلب',
                    'fake'        =>   true,
                    'tab'         => 'محتوا',
                ],
                // [
                //     'name' => 'content',
                //     'label' => trans('validation.attributes.content'),
                //     'type' => 'summernote',
                //     'placeholder' => 'محتوای خود را در اینجا بنویسید',
                //     'tab'   => 'محتوا',
                // ],
                [   // WYSIWYG Editor
                    'name'  => 'content',
                    'label' => trans('validation.attributes.content'),
                    'type'  => 'ckeditor',
                    'placeholder' => 'محتوای خود را در اینجا بنویسید',
                    'tab'   => 'محتوا',
                    'extra_plugins' => [
                        'autolink',
                        'colorbutton',
                        'justify',
                        'emoji',
                        'find',
                        // 'templates',
                        'divarea',
                        'div'
                    ],
                    'options' => [
                        'language' => 'fa',
                        // 'skin'     => 'office2013',
                    ]
                ],
            ]);


            $this->crud->addField([
                'name'  => 'list',
                'type'  => 'table',
                'label' => 'فهرست',
                'entity_singular' => 'فهرست',
                'columns' => [
                    'hook'  => 'لنگر (#)',
                    'label'  => 'عنوان',
                ],
                'min' => 0,
                'max' => 30,
                'fake' => true,
                'tab' => 'فهرست'
            ]);
            

            $this->crud->addField([
                'name'  => 'resources',
                'type'  => 'table',
                'label' => 'منابع',
                'entity_singular' => 'منبع',
                'columns' => [
                    'hook'  => 'لنگر',
                    'label'  => 'عنوان',
                    'link'  => 'لینک',
                ],
                'min' => 0,
                'max' => 30,
                'fake' => true,
                'tab' => 'منابع'
            ]);

            $this->crud->field('line')->type('custom_html')
            ->value('<span class="bg-warning text-warning">تیتر و شرح مختصر صفحه به صورت خودکار ایجاد می‌شود و در صورتی که تمایل دارید این مقادیر را به صورت سفارشی ایجاد کنید، از فرم زیر استفاده کنید.</span>')
            ->tab('سئو');

            $this->crud->addFields(static::getFieldsArrayForSeo());

        });
    }

    public static function getFieldsArrayForAttributes()
    {
        return [
            [
                'name' => 'title',
                'label' => trans('validation.attributes.title'),
                'type' => 'text',
                'attributes' => [
                    'placeholder' => 'عنوان پست را اینجا بنویسید',
                    'class'       => 'form-control form-control-lg'
                ],
                'wrapper'   => [
                    'class'  => "form-group col-md-6"
                ],
                'prefix' => '<i class="la la-pencil la-lg"></i>',
                'tab'   => 'مشخصات',
            ],
            [  // Select2
                'label'     => "نویسنده",
                'type'      => 'select2',
                'name'      => 'user_id', // the db column for the foreign key

                // optional
                'entity'    => 'user', // the method that defines the relationship in your Model
                'model'     => "App\Models\User", // foreign key model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'default'   => 1, // set the default value of the select2
                'wrapper'   => [
                    'class'  => "form-group col-md-6"
                ],
                'tab'   => 'مشخصات',
                //  // also optional
                // 'options'   => (function ($query) {
                //      return $query->orderBy('name', 'ASC')->where('depth', 1)->get();
                //  }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
             ],
            [
                'name' => 'image',
                'label' => trans('general.article.image'),
                'type' => 'browse',
                'wrapper'   => [
                    'class'  => "form-group col-md-6"
                ],
                'tab'   => 'مشخصات',
            ],
            [
                'label' => trans('general.tag_plural'),
                'type' => 'relationship',
                'name' => 'tags', // the method that defines the relationship in your Model
                'entity' => 'tags', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
                'inline_create' => ['entity' => 'tag'],
                'wrapper'   => [
                    'class'  => "form-group col-md-6"
                ],
                'ajax' => true,
                'tab'   => 'مشخصات',
            ],
            [   // Checklist
                'label'     => 'در کدام صفحات نمایش داده شود',
                'type'      => 'drop_down_combo_tree',
                'name'      => 'pages',
                'entity'    => 'pages',
                'scope'     => 'blogTemplate',
                'attribute' => 'title',
                'model'     => "Rezahmady\Page\Models\Page",
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
                'tab'          => 'مشخصات',
            ],
            [ // Text
                'name'  => 'status',
                'label' => '<i class="la la-flag-o"></i> وضعیت انتشار',
                'type'  => 'radio',
                'options' => [
                    "PUBLISHED" => '<span class="bg-success mb-1 d-block">
                                پست منتشر شده و نمایش داده شود.
                            </span>',
                    "DRAFT" => '<span class="bg-danger mb-1 d-block">
                                منتشر نشود.
                            </span>',
                ],
                'wrapper'   => [
                    'class'      => 'form-group col-md-6'
                ],
                'default' => 'PUBLISHED',
                'tab'   => 'مشخصات',
            ],
            [   // Checklist
                'label'     => 'در کدام صفحات نمایش داده شود',
                'type'      => 'checklist_nested',
                'name'      => 'pages',
                'entity'    => 'pages',
                'template'   => 'blog',
                'attribute' => 'title',
                'model'     => "Rezahmady\Page\Models\Page",
                'pivot'     => true,
                'tab'   => 'مشخصات',
            ],
        ];
    }

    public static function getFieldsArrayForSeo(): array
    {
        return [
            [ // Text
                'name'  => 'meta_title',
                'label' => 'تیتر صفحه',
                'prefix' => '<i class="la la-pencil la-lg"></i>',
                'hint'  => 'پیشنهاد می‌شود حداکثر 60 حرف در این فیلد بنویسید.',
                'type'  => 'text',
                'fake'  => true,
                'store_in' => 'extras',
                'tab'   => 'سئو',
            ],
            [ // textarea
                'name'  => 'meta_description',
                'label' => 'شرح مختصر',
                'hint'  => 'پیشنهاد می‌شود حداکثر 155 حرف در این فیلد بنویسید.',
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
                'fake'  => true,
                'store_in' => 'extras',
                'tab'   => 'سئو',
            ],
            [ // Text
                'name'  => 'meta_keywords',
                'label' => 'کلمات کلیدی',
                'type'  => 'text',
                'prefix' => '<i class="la la-key la-lg"></i>',
                'hint'  => 'این فیلد دیگر توسط گوگل پشتیبانی نمی‌شود و در بهینه‌سازی سایت شما تاثیری ندارد!',
                'fake'  => true,
                'store_in' => 'extras',
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
        ];
    }



    /**
     * Respond to AJAX calls from the select2 with entries from the Category model.
     * @return JSON
     */
    // public function fetchCategory()
    // {
    //     return $this->fetch(\App\Models\Category::class);
    // }

    /**
     * Respond to AJAX calls from the select2 with entries from the Tag model.
     * @return JSON
     */
    public function fetchTags()
    {
        return $this->fetch(\Rezahmady\Article\Models\Tag::class);
    }
}
