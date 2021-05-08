<?php

namespace Rezahmady\Resource\Http\Controllers\Admin;

use Rezahmady\Resource\Http\Requests\ResourceRequest;
use App\Traits\DefaultPermissions;
use Rezahmady\Resource\Traits\ResourceTemplates;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;
use Rezahmady\Resource\Models\Resource;

/**
 * Class ResourceCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ResourceCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;
    use ResourceTemplates;
    use DefaultPermissions;
    Const ENTITY = 'resource';
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Resource::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/resource');
        CRUD::setEntityNameStrings('مرکز', 'مراکز درمانی');

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

        CRUD::addColumns([
            [
                'name'  => 'name',
                'label' => trans('backpack::permissionmanager.name'),
                'type'  => 'model_function',
                'function_name' => 'getNameWithCaption'
            ],
            [
                'name' => 'template',
                'label' => 'نوع',
                'type' => 'model_function',
                'function_name' => 'getTemplateName',
            ],
        ]);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        // dd('dd');
        $this->addResourceFields(\Request::input('template'));
        CRUD::setValidation(ResourceRequest::class);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    // notice InlineCreateOperation is used AFTER CreateOperation
    // that's required in order for InlineCreate to re-use whatever
    // CreateOperation has already setup

    // OPTIONAL
    // only if you want to make the InlineCreateOperation behave differently 
    // from the CreateOperation, otherwise you can just skip the setup method entirely
    
    protected function setupInlineCreateOperation()
    {
        // $template = \Request::input('resource_template_h') ?? \Request::input('resource_template_c');
        // $request2 = \Request::input('main_form_fields');
        // $template = $request2[0]['value'];
        // dd($template);
        $this->addResourceFields('');
        CRUD::setValidation(ResourceRequest::class);
    }

    protected function addResourceFields($template = '')
    {
        $this->crud->addField([
            'name' => 'template',
            'label' => trans('backpack::permissionmanager.template'),
            'hint' => 'نوع مرکزی را که می خواهید ایجاد کنید را در ابتدا مشخص کنید و سپس سایر اطلاعات آن را در زیر تکمیل کنید',
            'type' => 'select_crud_template',
            'options' => $this->getTemplatesArray(),
            'value' => $template,
            'allows_null' => false,
        ]);

        // $this->crud->addFields([
            
        // ]);

        $this->crud->addFields([
            [
                'name'  => 'name',
                'prefix'  => '<i class="la la-hospital-symbol"></i>',
                'label' => trans('backpack::permissionmanager.name'),
                'type'  => 'text',
                'attributes' => [
                    'placeholder' => 'عنوان مرکز را اینجا بنویسید',
                    'class'       => 'form-control form-control-lg'
                ],
                'tab'   => 'مشخصات',
            ],
            [
                'name'  => 'caption',
                'prefix'  => '<i class="la la-briefcase-medical"></i>',
                'label' => 'عنوان ثانویه مرکز',
                'type'  => 'text',
                'tab'   => 'مشخصات',
            ],
            [
                'name'    => 'bio',
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
                'label'   => 'درباره',
                'tab'     => 'مشخصات',
                'fake'  => true,
                'store_in' => 'extras',
            ],
            [
                'label'        => "تصویر پروفایل",
                'name'         => 'profile',
                'fake'  => true,
                'type' => 'image',
                'crop' => true, // set to true to allow cropping, false to disable
                'aspect_ratio' => 1, // omit or set to 0 to allow any aspect ratio
                // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
                'prefix'    => '', // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
                'wrapper'      => [
                    'class'  => "form-group col-12 ltr"
                ],
                'tab'   => 'مشخصات',
            ],
            [   // relationship
                'type' => "relationship",
                'name' => 'ostan', // the method on your model that defines the relationship
                'ajax' => false,
                'fake' => true,
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
                'tab'   => 'اطلاعات تماس',
                // OPTIONALS:
                 'label' => "استان",
                 'attribute' => "name", // foreign key attribute that is shown to user (identifiable attribute)
                 'entity' => 'ostan', // the method that defines the relationship in your Model
                 'model' => "App\Models\Ostan", // foreign key Eloquent model
                 'placeholder' => "انتخاب کنید...", // placeholder for the select2 input
            ],
            [   // relationship
                'type' => "relationship",
                'name' => 'shahrestan', // the method on your model that defines the relationship
                'ajax' => true,
                'fake' => true,
                // OPTIONALS:
                'label' => "شهرستان",
                'attribute' => "name", // foreign key attribute that is shown to user (identifiable attribute)
                'entity' => 'shahrestan', // the method that defines the relationship in your Model
                'model' => "App\Models\Shahrestan", // foreign key Eloquent model
                'placeholder' => "انتخاب کنید ...", // placeholder for the select2 input
                'wrapper'      => [
                    'class'  => "form-group col-md-6"
                ],
                'tab'   => 'اطلاعات تماس',
                // AJAX OPTIONALS:
                // 'delay' => 500, // the minimum amount of time between ajax requests when searching in the field
                 'data_source' => url("api/shahrestan"), // url to controller search function (with /{id} should return model)
                 'minimum_input_length' => 0, // minimum characters to type before querying results
                 'dependencies'         => ['ostan'], // when a dependency changes, this select2 is reset to null
                 'include_all_form_fields'  => true, // optional - only send the current field through AJAX (for a smaller payload if you're not using multiple chained select2s)
            ],
            [
                'name'    => 'address',
                'type'    => 'summernote',
                'options' => [
                    'toolbar' => []
                ],
                'label'   => 'آدرس',
                'tab'     => 'اطلاعات تماس',
                'fake'  => true,
                'store_in' => 'extras',
            ],
            [
                'name'    => 'phone',
                'prefix'  => '<i class="la la-phone"></i>',
                'type'    => 'text',
                'label'   => 'تلفن تماس',
                'tab'     => 'اطلاعات تماس',
                'fake'  => true,
                'store_in' => 'extras',
                'attributes' => [
                    'class'       => 'form-control col-md-6'
                ],
            ],
        ]);

        $this->useTemplate($template);
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
    public function getTemplates(): array
    {
        $templates_trait = new \ReflectionClass(ResourceTemplates::class);
        $templates = $templates_trait->getMethods(\ReflectionMethod::IS_PRIVATE);

        if (! count($templates)) {
            abort(503, trans('backpack::permissionmanager.template_not_found'));
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
            $templates_array[$template->name] = trans('backpack::permissionmanager.function_name.'.$template->name);
        }

        return $templates_array;
    }

}
