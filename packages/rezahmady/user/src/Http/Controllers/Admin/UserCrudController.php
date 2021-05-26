<?php

namespace Rezahmady\User\Http\Controllers\Admin;

use App\Traits\DefaultPermissions;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Rezahmady\User\Http\Requests\UserStoreCrudRequest as StoreRequest;
use Rezahmady\User\Http\Requests\UserUpdateCrudRequest as UpdateRequest;
use Rezahmady\User\Traits\UserTemplates;
use Rezahmady\Resource\Models\Resource;
use Illuminate\Support\Facades\Hash;
use Rezahmady\Filter\Models\Filter;
use App\Models\User;

class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
    use \Rezahmady\SettingOperation\SettingOperation;
    use DefaultPermissions;
    use UserTemplates;

    Const ENTITY = 'user';

    public function setup()
    {
        $this->crud->setModel(User::class);
        $this->crud->setEntityNameStrings(trans('rezahmady.user::permissionmanager.user'), trans('rezahmady.user::permissionmanager.users'));
        $this->crud->setRoute(backpack_url('user'));

        /*
        |--------------------------------------------------------------------------
        | PERMISSIONS
        |--------------------------------------------------------------------------
        */
        $this->setPermissions();
    }

    /**
    * Define what happens when the Setting operation is loaded.
    * 
    * @see https://github.com/rezahmady/setting-operation
    * @return void
    */
    protected function setupSettingOperation()
    {
        // backpack fields
        $templates = $this->getTemplatesArray();
        $filters = Filter::active()->pluck('name','id');
        foreach($templates as $key => $item) {
            $this->crud->addField([   // select2_from_array
                'name'        => "template_{$key}_filters",
                'label'       => $item,
                'type'        => 'select2_from_array',
                'options'     => $filters,
                'allows_null' => false,
                'default'     => 'one',
                'wrapper'   => [
                    'class'  => "form-group col-md-6"
                ],
                'tab'   => 'فیلتر ها',
                'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
            ]);
        }
    }

    public function setupListOperation()
    {
        $this->crud->enableExportButtons();
        $this->crud->addButtonFromModelFunction('line', 'open', 'getOpenButton', 'ending');
        $this->crud->addColumns([
            [
                'name'  => 'name',
                'label' => trans('rezahmady.user::permissionmanager.name'),
                'type'  => 'text',
            ],
            [
                'name'  => 'mobile',
                'label' => trans('rezahmady.user::permissionmanager.mobile'),
                'type'  => 'text',
            ],
            [
                // run a function on the CRUD model and show its return value
                'name'  => 'subscribtion',
                'label' => 'اشتراک', // Table column heading
                'type'  => 'model_function',
                'function_name' => 'getSubscribtionBrowse', // the method in your Model
                // 'function_parameters' => [$one, $two], // pass one/more parameters to that method
                // 'limit' => 100, // Limit the number of characters shown
            ],
            [ // n-n relationship (with pivot table)
                'label'     => trans('rezahmady.user::permissionmanager.roles'), // Table column heading
                'type'      => 'select_multiple',
                'name'      => 'roles', // the method that defines the relationship in your Model
                'entity'    => 'roles', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model'     => config('permission.models.role'), // foreign key model
            ],
            [
                'name'  => 'email',
                'label' => trans('rezahmady.user::permissionmanager.email'),
                'type'  => 'email',
            ],
            [ // n-n relationship (with pivot table)
                'label'     => trans('rezahmady.user::permissionmanager.extra_permissions'), // Table column heading
                'type'      => 'select_multiple',
                'name'      => 'permissions', // the method that defines the relationship in your Model
                'entity'    => 'permissions', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model'     => config('permission.models.permission'), // foreign key model
            ],
        ]);

        // Role Filter
        $this->crud->addFilter(
            [
                'name'  => 'role',
                'type'  => 'dropdown',
                'label' => trans('rezahmady.user::permissionmanager.role'),
            ],
            config('permission.models.role')::all()->pluck('name', 'id')->toArray(),
            function ($value) { // if the filter is active
                $this->crud->addClause('whereHas', 'roles', function ($query) use ($value) {
                    $query->where('role_id', '=', $value);
                });
            }
        );

        // Extra Permission Filter
        $this->crud->addFilter(
            [
                'name'  => 'permissions',
                'type'  => 'select2',
                'label' => trans('rezahmady.user::permissionmanager.extra_permissions'),
            ],
            config('permission.models.permission')::all()->pluck('display_name', 'id')->toArray(),
            function ($value) { // if the filter is active
                $this->crud->addClause('whereHas', 'permissions', function ($query) use ($value) {
                    $query->where('permission_id', '=', $value);
                });
            }
        );

        $this->crud->addFilter([
            'type'  => 'simple',
            'name'  => 'doctor',
            'label' => 'پزشک'
        ], 
        false, 
        function() { // if the filter is active
            $this->crud->addClause('where','template', 'doctor'); // apply the "active" eloquent scope 
        } );

        $this->crud->addFilter([
            'type'  => 'simple',
            'name'  => 'customer',
            'label' => 'مشتری'
        ], 
        false, 
        function() { // if the filter is active
            $this->crud->addClause('where','template', 'customer'); // apply the "active" eloquent scope 
        } );

        $this->crud->addFilter([
            'type'  => 'simple',
            'name'  => 'operator',
            'label' => 'اپراتور'
        ], 
        false, 
        function() { // if the filter is active
            $this->crud->addClause('where','template', 'operator'); // apply the "active" eloquent scope 
        } );
    }

    public function setupCreateOperation()
    {
        $this->addUserFields(\Request::input('template'));
        $this->crud->setValidation(StoreRequest::class);
    }

    public function setupUpdateOperation()
    {
        $template = \Request::input('template') ?? $this->crud->getCurrentEntry()->template;
        $this->addUserFields($template);
        $this->crud->setValidation(UpdateRequest::class);
    }

    /**
     * Store a newly created resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        $this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        return $this->traitStore();
    }

    /**
     * Update the specified resource in the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        $this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        return $this->traitUpdate();
    }

    /**
     * Handle password input fields.
     */
    protected function handlePasswordInput($request)
    {
        // Remove fields not present on the user.
        $request->request->remove('password_confirmation');
        $request->request->remove('roles_show');
        $request->request->remove('permissions_show');

        // Encrypt password if specified.
        if ($request->input('password')) {
            $request->request->set('password', Hash::make($request->input('password')));
        } else {
            $request->request->remove('password');
        }

        return $request;
    }

    protected function addUserFields($template = '')
    {
        $this->crud->addField([
            'name' => 'template',
            'label' => trans('rezahmady.user::permissionmanager.template'),
            'hint' => 'نوع کاربری را که می خواهید ایجاد کنید را در ابتدا مشخص کنید و سپس سایر اطلاعات کاربر را در زیر تکمیل کنید',
            'type' => 'select_crud_template',
            'options' => $this->getTemplatesArray(),
            'value' => $template,
            'allows_null' => false,
        ]);

        $this->crud->addFields([
            [
                'name'  => 'name',
                'prefix'  => '<i class="la la-user"></i>',
                'label' => trans('rezahmady.user::permissionmanager.name'),
                'type'  => 'text',
                'wrapper'   => [
                    'class'  => "form-group col-md-6"
                ],
                'tab'   => 'مشخصات فردی',
            ],
            [
                'name'  => 'gender',
                'label' => 'جنسیت',
                'type'        => 'select2_from_array',
                'options' => [
                    'mail'  => 'آقا',
                    'fmail' => 'خانم'
                ],
                'allows_null' => true,
                'fake' => true,
                'wrapper'   => [
                    'class'  => "form-group col-md-6"
                ],
                'tab'   => 'مشخصات فردی',
            ],
            [
                'name'  => 'mobile',
                'prefix'  => '<i class="la la-mobile"></i>',
                'label' => trans('rezahmady.user::permissionmanager.mobile'),
                'type'  => 'text',
                'wrapper'   => [
                    'class'  => "form-group col-md-6"
                ],
                'tab'   => 'مشخصات فردی',
            ],
            [
                'name'  => 'email',
                'label' => trans('rezahmady.user::permissionmanager.email'),
                'type'  => 'email',
                'wrapper'   => [
                    'class'  => "form-group col-md-6"
                ],
                'tab'   => 'مشخصات فردی',
            ],
            [
                'name'  => 'password',
                'label' => trans('rezahmady.user::permissionmanager.password'),
                'type'  => 'password',
                'wrapper'   => [
                    'class'  => "form-group col-md-6"
                ],
                'tab'   => 'مشخصات فردی',
            ],
            [
                'name'  => 'password_confirmation',
                'label' => trans('rezahmady.user::permissionmanager.password_confirmation'),
                'type'  => 'password',
                'wrapper'   => [
                    'class'  => "form-group col-md-6"
                ],
                'tab'   => 'مشخصات فردی',
            ],
            [
                'label'        => "تصویر پروفایل",
                'name'         => 'profile',
                'fake'  => true,
                'type' => 'browse',
                // 'crop' => true, // set to true to allow cropping, false to disable
                // 'aspect_ratio' => 1, // omit or set to 0 to allow any aspect ratio
                // 'disk'      => 's3_bucket', // in case you need to show images from a different disk
                'prefix'    => '', // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
                'wrapper'      => [
                    'class'  => "form-group col-12 ltr"
                ],
                'tab'   => 'مشخصات فردی',
            ]
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
    public function getTemplates($template_name = false)
    {
        $templates_array = [];

        $templates_trait = new \ReflectionClass('Rezahmady\User\Traits\UserTemplates');
        $templates = $templates_trait->getMethods(\ReflectionMethod::IS_PRIVATE);

        if (! count($templates)) {
            abort(503, trans('rezahmady.user::permissionmanager.template_not_found'));
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
            $templates_array[$template->name] = trans('rezahmady.user::permissionmanager.function_name.'.$template->name);
        }

        return $templates_array;
    }

    protected function fetchResources()
    {
        return $this->fetch([
            'model' => Resource::class, // required
            'searchable_attributes' => ['name', 'caption'],
            'paginate' => 10, // items to show per page
        ]);
    }
}
