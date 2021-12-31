<?php

namespace Modules\User\Http\Controllers\Admin;

use App\Traits\DefaultPermissions;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Modules\User\Http\Requests\UserStoreCrudRequest as StoreRequest;
use Modules\User\Http\Requests\UserUpdateCrudRequest as UpdateRequest;
use Modules\User\Traits\UserTemplates;
use Modules\Resource\Models\Resource;
use Illuminate\Support\Facades\Hash;
use TorMorten\Eventy\Facades\Events as Hook;
use Modules\Filter\Models\Filter;
use App\Models\User;
use Rezahmady\SettingOperation\Setting;

class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Rezahmady\SettingOperation\SettingOperation;
    use \App\Traits\ReviseOperation;
    use \App\Traits\DropzoneTrait;
    use DefaultPermissions;
    use UserTemplates;

    Const ENTITY = 'user';

    public function setup()
    {
        $this->crud->setModel(User::class);
        $this->crud->setEntityNameStrings(trans('user::permissionmanager.user'), trans('user::permissionmanager.users'));
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
        Hook::action('user-crud-setting-operation', $this->crud);
    }

    public function setupListOperation()
    {
        if(backpack_user()->can('user export'))
            $this->crud->enableExportButtons();

        $this->crud->addColumns([
            [
                'name'  => 'name',
                'label' => trans('user::permissionmanager.name'),
                'type'  => 'text',
            ],
            [
                'name'  => 'mobile',
                'label' => trans('user::permissionmanager.mobile'),
                'type'  => 'text',
            ],
            [ // n-n relationship (with pivot table)
                'label'     => trans('user::permissionmanager.roles'), // Table column heading
                'type'      => 'select_multiple',
                'name'      => 'roles', // the method that defines the relationship in your Model
                'entity'    => 'roles', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model'     => config('permission.models.role'), // foreign key model
            ],
            [
                'name'  => 'email',
                'label' => trans('user::permissionmanager.email'),
                'type'  => 'email',
            ],
            [ // n-n relationship (with pivot table)
                'label'     => trans('user::permissionmanager.extra_permissions'), // Table column heading
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
                'label' => trans('user::permissionmanager.role'),
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
                'label' => trans('user::permissionmanager.extra_permissions'),
            ],
            config('permission.models.permission')::all()->pluck('display_name', 'id')->toArray(),
            function ($value) { // if the filter is active
                $this->crud->addClause('whereHas', 'permissions', function ($query) use ($value) {
                    $query->where('permission_id', '=', $value);
                });
            }
        );

        Hook::action('user-crud-list-operation-after-columns', $this->crud);
    }

    public function setupCreateOperation()
    {
        Hook::action('user-crud-create-operation-before-fields', $this->crud, \Request::input('template'));
        $this->addUserFields(\Request::input('template'));
        Hook::action('user-crud-create-operation-after-fields', $this->crud, \Request::input('template'));
        $this->crud->setValidation(StoreRequest::class);
    }

    public function setupUpdateOperation()
    {
        $template = \Request::input('template') ?? $this->crud->getCurrentEntry()->template;
        Hook::action('user-crud-update-operation-before-fields', $this->crud, $template);
        $this->addUserFields($template);
        Hook::action('user-crud-update-operation-after-fields', $this->crud, $template);
        $this->crud->setValidation(UpdateRequest::class);
    }

    public function setupShowOperation() {
        Hook::action('user-crud-show-operation', $this->crud);
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
//        $this->crud->addField([
//            'name' => 'template',
//            'label' => trans('user::permissionmanager.template'),
//            'hint' => 'نوع کاربری را که می خواهید ایجاد کنید را در ابتدا مشخص کنید و سپس سایر اطلاعات کاربر را در زیر تکمیل کنید',
//            'type' => 'select_crud_template',
//            'options' => $this->getTemplatesArray(),
//            'value' => $template,
//            'allows_null' => false,
//        ]);

        $this->crud->addFields([
            [
                'name' => 'template',
                'type' => 'hidden',
                'value' => 'user',
            ],
            [
                'name'  => 'name',
                'prefix'  => '<i class="la la-user"></i>',
                'label' => trans('user::permissionmanager.name'),
                'type'  => 'text',
                'wrapper'   => [
                    'class'  => "form-group col-md-6"
                ],
            ],
            [
                'name'  => 'mobile',
                'prefix'  => '<i class="la la-mobile"></i>',
                'label' => trans('user::permissionmanager.mobile'),
                'type'  => 'text',
                'wrapper'   => [
                    'class'  => "form-group col-md-6"
                ],
            ],
            [
                'name'  => 'email',
                'label' => trans('user::permissionmanager.email'),
                'type'  => 'email',
                'attributes' => [
                    'autocomplete' => 'new-password',
                ],
                'wrapper'   => [
                    'class'  => "form-group col-md-6"
                ],
            ],
        ]);
        if(backpack_user()->can('admin create')) {
            $this->crud->addFields([
                [
                    'name'  => 'password',
                    'label' => trans('user::permissionmanager.password'),
                    'type'  => 'password',
                    'attributes' => [
                        'autocomplete' => 'new-password',
                    ],
                    'wrapper'   => [
                        'class'  => "form-group col-md-6"
                    ],
                    'tab' => 'دسترسی',
                ],
                [
                    'name'  => 'password_confirmation',
                    'label' => trans('user::permissionmanager.password_confirmation'),
                    'type'  => 'password',
                    'wrapper'   => [
                        'class'  => "form-group col-md-6"
                    ],
                    'tab' => 'دسترسی',
                ]
            ]);
        }

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

        $templates_trait = new \ReflectionClass('Modules\User\Traits\UserTemplates');
        $templates = $templates_trait->getMethods(\ReflectionMethod::IS_PRIVATE);

        if (! count($templates)) {
            abort(503, trans('user::permissionmanager.template_not_found'));
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
            $templates_array[$template->name] = trans('user::permissionmanager.function_name.'.$template->name);
        }

        return $templates_array;
    }

    protected function fetchResource()
    {
        return $this->fetch([
            'model' => Resource::class, // required
            'searchable_attributes' => ['name', 'caption'],
            'paginate' => 10, // items to show per page
        ]);
    }
}
