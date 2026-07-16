<?php

namespace Modules\TraficPermit\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Rezahmady\SettingOperation\SettingOperation;

/**
 * General TraficPermit settings page for system admins.
 *
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TraficPermitGeneralCrudController extends CrudController
{
    use SettingOperation;

    public const ENTITY = 'TraficPermitGeneral';

    public function setup()
    {
        CRUD::setModel(\Modules\TraficPermit\Models\TraficPermitGeneral::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/trafic-permit-general');
        CRUD::setEntityNameStrings('تنظیمات کلی', 'تنظیمات کلی');

        (backpack_user()->can(self::ENTITY.' setting'))
            ? $this->crud->allowAccess('setting')
            : $this->crud->denyAccess('setting');
    }

    /**
     * @see https://github.com/rezahmady/setting-operation
     */
    protected function setupSettingOperation()
    {
        $this->crud->addFields([
            [
                'name'  => 'block_order_on_debt',
                'label' => 'مسدودسازی ثبت درخواست در صورت بدهی شرکت',
                'type'  => 'toggle',
                'hint'  => 'اگر فعال باشد، کاربران شرکت با موجودی منفی نمی‌توانند درخواست جدید ثبت کنند. دارندگان دسترسی کارشناس از این محدودیت معاف‌اند.',
                'default' => '1',
                'wrapper' => [
                    'class' => 'form-group col-md-8',
                ],
            ],
        ]);
    }
}
