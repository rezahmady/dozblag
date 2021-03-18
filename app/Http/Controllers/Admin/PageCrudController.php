<?php

namespace App\Http\Controllers\Admin;

use App\Traits\PageTemplates;
// VALIDATION: change the requests to match your own file names if you need form validation
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\PageManager\app\Http\Requests\PageRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;

class PageCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { create as traitCreate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { edit as traitEdit; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\BulkDeleteOperation;

    use PageTemplates;
    private $themes_folder = '';
    Const ENTITY = 'page';

    protected function setupReorderOperation()
    {
        // define which model attribute will be shown on draggable elements 
        $this->crud->set('reorder.label', 'name');
        // define how deep the admin is allowed to nest the items
        // for infinite levels, set it to 0
        $this->crud->set('reorder.max_level', 5);
    }

    public function setup()
    {
        $this->crud->setModel(config('backpack.pagemanager.page_model_class', 'Backpack\PageManager\app\Models\Page'));
        $this->crud->setRoute(config('backpack.base.route_prefix').'/page');
        $this->crud->setEntityNameStrings(trans('backpack::pagemanager.page'), trans('backpack::pagemanager.pages'));
        $this->themes_folder = config('themes.themes_folder', resource_path('views/themes'));

        // Permission Manager
        (backpack_user()->can(self::ENTITY.' list')) ? $this->crud->allowAccess('list') : $this->crud->denyAccess('list'); // list
        (backpack_user()->can(self::ENTITY.' create')) ? $this->crud->allowAccess('create') : $this->crud->denyAccess('create'); // add
        (backpack_user()->can(self::ENTITY.' update')) ? $this->crud->allowAccess('update') : $this->crud->denyAccess('update'); // update
        (backpack_user()->can(self::ENTITY.' delete')) ? $this->crud->allowAccess('delete') : $this->crud->denyAccess('delete'); // delete
        (backpack_user()->can(self::ENTITY.' clone')) ? $this->crud->allowAccess('clone') : $this->crud->denyAccess('clone'); // clone
    }

    protected function setupListOperation()
    {
        $this->crud->addColumn([
            'name' => 'name',
            'label' => trans('backpack::pagemanager.name'),
        ]);
        $this->crud->addColumn([
            'name' => 'template',
            'label' => trans('backpack::pagemanager.template'),
            'type' => 'model_function',
            'function_name' => 'getTemplateName',
        ]);
        $this->crud->addColumn([
            'name' => 'slug',
            'label' => trans('backpack::pagemanager.slug'),
        ]);
        $this->crud->addButtonFromModelFunction('line', 'open', 'getOpenButton', 'beginning');
    }

    // -----------------------------------------------
    // Overwrites of CrudController
    // -----------------------------------------------

    protected function setupCreateOperation()
    {
        // Note:
        // - default fields, that all templates are using, are set using $this->addDefaultPageFields();
        // - template-specific fields are set per-template, in the PageTemplates trait;
        $defaultTemplates = $this->getTemplates();
        $defaultTemplates = $defaultTemplates[0]->name;
        $template = Request::input('template') ?? $defaultTemplates;
        
        $this->crud->addField([
            'name' => 'name',
            'label' => trans('backpack::pagemanager.page_name'),
            'type' => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ],
            // 'disabled' => 'disabled'
        ]);
        $this->crud->addField([
            'name' => 'title',
            'label' => trans('backpack::pagemanager.page_title'),
            'type' => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ],
            // 'disabled' => 'disabled'
        ]);

        // Add theme page fields
        $this->themeOptions($template);
        
        // Add page template fields
        $this->useTemplate($template);

        // Add default fields
        $this->addDefaultPageFields($template);

        // valdation
        $this->crud->setValidation(PageRequest::class);
    }

    protected function setupUpdateOperation()
    {
        // if the template in the GET parameter is missing, figure it out from the db
        $template = Request::input('template') ?? $this->crud->getCurrentEntry()->template;

        $this->crud->addField([
            'name' => 'name',
            'label' => trans('backpack::pagemanager.page_name'),
            'type' => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ],
            // 'disabled' => 'disabled'
        ]);
        $this->crud->addField([
            'name' => 'title',
            'label' => trans('backpack::pagemanager.page_title'),
            'type' => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ],
            // 'disabled' => 'disabled'
        ]);

        // Add theme page fields
        $this->themeOptions($template);

        // Add page template fields
        $this->useTemplate($template);
        
        // Add default fields
        $this->addDefaultPageFields($template);
        
        // valdation
        $this->crud->setValidation(PageRequest::class);
    }

    // -----------------------------------------------
    // Methods that are particular to the PageManager.
    // -----------------------------------------------

    /**
     * Populate the create/update forms with basic fields, that all pages need.
     *
     * @param string $template The name of the template that should be used in the current form.
     */
    public function addDefaultPageFields($template = false)
    {
        $this->crud->addField([
            'name' => 'template',
            'label' => trans('backpack::pagemanager.template'),
            'type' => 'select_page_template',
            'view_namespace'  => 'pagemanager::fields',
            'options' => $this->getTemplatesArray(),
            'value' => $template,
            'allows_null' => false,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ],
            'tab' => 'تنظیمات'
        ]);
        
        $this->crud->addField([
            'name' => 'slug',
            'label' => trans('backpack::pagemanager.page_slug'),
            'type' => 'text',
            'hint' => trans('backpack::pagemanager.page_slug_hint'),
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ],
            'tab' => 'تنظیمات',
            // 'disabled' => 'disabled'
        ]);

        // filename
        $path = theme_path("/modules/pages/$template");
        if(!File::isDirectory($path)) File::makeDirectory($path, 0777, true, true);
        $files = array_diff(scandir($path), array('.', '..')); 

        if($files) {
            $options = [];
            foreach($files as $item) {
                $filename = str_replace('.blade.php','',$item);
                $label = str_replace("$template-",'',$filename);
                $options[$filename] = [
                    "label" => "قالب $label",
                    "image" => asset(config('themes.assets_folder')."/admin/images/pages/$filename.svg"),
                ];
            }
 
            $this->crud->addField([   // radio
                'name'        => 'filename', // the name of the db column
                'label'       => 'قالب صفحه', // the input label
                'type'        => 'radio_image',
                'options'     => $options,
                'default'     => 'default',
                'fake'        => true,
                'tab' => 'تنظیمات',
            ]);
        }


        $this->crud->field('line')->type('custom_html')
        ->value('<span class="bg-warning text-warning">تیتر و شرح مختصر صفحه به صورت خودکار ایجاد می‌شود و در صورتی که تمایل دارید این مقادیر را به صورت سفارشی ایجاد کنید، از فرم زیر استفاده کنید.</span>')
        ->tab('سئو');

        $this->crud->addFields(static::getFieldsArrayForSeo());

        // Add default theme page fields
        $this->themeOptions('default');

    }

    public static function getFieldsArrayForSeo()
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
                'type'  => 'textarea',
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
    public function getTemplatesArray()
    {
        $templates = $this->getTemplates();

        foreach ($templates as $template) {
            $templates_array[$template->name] = trans('backpack::pagemanager.function_name.'.$template->name);
        }

        return $templates_array;
    }

    /**
     * Add the fields defined for a specific theme.
     *
     * @param  string $theme_folder The name of the template folder that should be used in the current form.
     */
    public function themeOptions($template)
    {
        if(defined('THEME_ID')) {
            $options = resolve('ThemeOptions');
            $method_name = "page_$template";
            if(method_exists($options,$method_name)) {
                return $options->{$method_name}($template);
            }
        }
    }
}
