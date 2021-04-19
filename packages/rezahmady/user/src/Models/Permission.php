<?php

namespace Rezahmady\User\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Spatie\Permission\Models\Permission as OriginalPermission;

class Permission extends OriginalPermission
{
    use CrudTrait;

    protected $fillable = ['name', 'display_name', 'guard_name', 'updated_at', 'created_at'];
}
