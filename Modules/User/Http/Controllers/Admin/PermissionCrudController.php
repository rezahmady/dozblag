<?php

namespace Modules\User\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Modules\User\Http\Requests\PermissionStoreCrudRequest as StoreRequest;
use Modules\User\Http\Requests\PermissionUpdateCrudRequest as UpdateRequest;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;

// VALIDATION

class PermissionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    Const ENTITY = 'permission';

    public function setup()
    {
        $this->role_model = Role::class;
        $this->permission_model = Permission::class;

        $this->crud->setModel($this->permission_model);
        $this->crud->setEntityNameStrings(trans('user::permissionmanager.permission_singular'), trans('user::permissionmanager.permission_plural'));
        $this->crud->setRoute(backpack_url('permission'));

        // deny access according to configuration file
        if (config('backpack.permissionmanager.allow_permission_create') == false) {
            $this->crud->denyAccess('create');
        } else {(backpack_user()->can(self::ENTITY.' create')) ? $this->crud->allowAccess('create') : $this->crud->denyAccess('create');}

        if (config('backpack.permissionmanager.allow_permission_update') == false) {
            $this->crud->denyAccess('update');
        } else {(backpack_user()->can(self::ENTITY.' update')) ? $this->crud->allowAccess('update') : $this->crud->denyAccess('update');}

        if (config('backpack.permissionmanager.allow_permission_delete') == false) {
            $this->crud->denyAccess('delete');
        } else {(backpack_user()->can(self::ENTITY.' delete')) ? $this->crud->allowAccess('delete') : $this->crud->denyAccess('delete');}

    }

    public function setupListOperation()
    {
        $this->crud->addColumn([
            'name'  => 'display_name',
            'label' => trans('user::permissionmanager.display_name'),
            'type'  => 'text',
        ]);

        $this->crud->addColumn([
            'name'  => 'name',
            'label' => trans('user::permissionmanager.name'),
            'type'  => 'text',
        ]);

        if (config('backpack.permissionmanager.multiple_guards')) {
            $this->crud->addColumn([
                'name'  => 'guard_name',
                'label' => trans('user::permissionmanager.guard_type'),
                'type'  => 'text',
            ]);
        }
    }

    public function setupCreateOperation()
    {
        $this->addFields();
        $this->crud->setValidation(StoreRequest::class);

        //otherwise, changes won't have effect
        \Cache::forget('spatie.permission.cache');
    }

    public function setupUpdateOperation()
    {
        $this->addFields();
        $this->crud->setValidation(UpdateRequest::class);

        //otherwise, changes won't have effect
        \Cache::forget('spatie.permission.cache');
    }

    private function addFields()
    {
        $this->crud->addField([
            'name'  => 'display_name',
            'label' => trans('user::permissionmanager.display_name'),
            'type'  => 'text',
        ]);

        $this->crud->addField([
            'name'  => 'name',
            'label' => trans('user::permissionmanager.name'),
            'type'  => 'text',
        ]);

        if (config('backpack.permissionmanager.multiple_guards')) {
            $this->crud->addField([
                'name'    => 'guard_name',
                'label'   => trans('user::permissionmanager.guard_type'),
                'type'    => 'select_from_array',
                'options' => $this->getGuardTypes(),
            ]);
        }
    }

    /*
     * Get an array list of all available guard types
     * that have been defined in app/config/auth.php
     *
     * @return array
     **/
    private function getGuardTypes()
    {
        $guards = config('auth.guards');

        $returnable = [];
        foreach ($guards as $key => $details) {
            $returnable[$key] = $key;
        }

        return $returnable;
    }
}
