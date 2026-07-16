<?php

namespace Modules\TraficPermit\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Lightweight model used only as the SettingOperation storage key
 * (setting_operations.key = trafic_permit_general).
 */
class TraficPermitGeneral extends Model
{
    use CrudTrait;

    protected $table = 'trafic_permit_general';

    protected $guarded = ['id'];
}
