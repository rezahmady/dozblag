<?php

namespace Modules\User\Http\Controllers\Admin;

use App\Traits\DefaultPermissions;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Modules\User\Http\Requests\UserStoreCrudRequest as StoreRequest;
use Modules\User\Http\Requests\UserUpdateCrudRequest as UpdateRequest;
use Illuminate\Support\Facades\Hash;
use TorMorten\Eventy\Facades\Events as Hook;
use App\Models\User;

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
        Hook::action('user-crud-create-operation-before-fields', $this->crud);
        $this->addUserFields();
        Hook::action('user-crud-create-operation-after-fields', $this->crud);
        $this->crud->setValidation(StoreRequest::class);
    }

    public function setupUpdateOperation()
    {
        Hook::action('user-crud-update-operation-before-fields', $this->crud);
        $this->addUserFields();
        Hook::action('user-crud-update-operation-after-fields', $this->crud);
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

    protected function addUserFields()
    {
        $this->crud->addFields([
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

        if(backpack_user()->can('user assign role')) {
            $this->crud->addField([
                // two interconnected entities
                'label'             => trans('user::permissionmanager.user_role_permission'),
                'field_unique_name' => 'user_role_permission',
                'type'              => 'checklist_dependency',
                'name'              => ['roles', 'permissions'],
                'tab'               => 'دسترسی',
                'subfields'         => [
                    'primary' => [
                        'label'            => trans('user::permissionmanager.roles'),
                        'name'             => 'roles', // the method that defines the relationship in your Model
                        'entity'           => 'roles', // the method that defines the relationship in your Model
                        'entity_secondary' => 'permissions', // the method that defines the relationship in your Model
                        'attribute'        => 'name', // foreign key attribute that is shown to user
                        'model'            => config('permission.models.role'), // foreign key model
                        'pivot'            => true, // on create&update, do you need to add/delete pivot table entries?]
                        'number_columns'   => 3, //can be 1,2,3,4,6
                    ],
                    'secondary' => [
                        'label'          => ucfirst(trans('user::permissionmanager.permission_singular')),
                        'name'           => 'permissions', // the method that defines the relationship in your Model
                        'entity'         => 'permissions', // the method that defines the relationship in your Model
                        'entity_primary' => 'roles', // the method that defines the relationship in your Model
                        'attribute'      => 'display_name', // foreign key attribute that is shown to user
                        'model'          => config('permission.models.permission'), // foreign key model
                        'pivot'          => true, // on create&update, do you need to add/delete pivot table entries?]
                        'number_columns' => 3, //can be 1,2,3,4,6
                    ],
                ],
            ]);
        }

    }
}
