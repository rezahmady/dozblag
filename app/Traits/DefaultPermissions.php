<?php

namespace App\Traits;

trait DefaultPermissions
{

    public function setPermissions()
    {
        (backpack_user()->can(self::ENTITY.' list')) ? $this->crud->allowAccess('list') : $this->crud->denyAccess('list'); // list
        (backpack_user()->can(self::ENTITY.' create')) ? $this->crud->allowAccess('create') : $this->crud->denyAccess('create'); // add
        (backpack_user()->can(self::ENTITY.' update')) ? $this->crud->allowAccess('update') : $this->crud->denyAccess('update'); // update
        (backpack_user()->can(self::ENTITY.' delete')) ? $this->crud->allowAccess('delete') : $this->crud->denyAccess('delete'); // delete
        (backpack_user()->can(self::ENTITY.' clone')) ? $this->crud->allowAccess('delete') : $this->crud->denyAccess('clone'); // delete
    }
}
