<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\WidgetRequest;
use App\Models\Theme;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class MenuCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MenuCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

    private $themes_folder = '';

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Widget::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/menu');
        CRUD::setEntityNameStrings('منو', 'منو ها');
        $this->themes_folder = config('themes.themes_folder', resource_path('views/themes'));
        // $this->crud->setListView('vendor/backpack/crud/widget-list');
        $theme = Theme::active()->first();
        if(isset($theme->id)) {
            $this->crud->addClause('where', 'theme_id', '=', $theme->id);
            $this->crud->addClause('where', 'type', '=', 'menu');
        } else {
            $this->crud->addClause('where', 'theme_id', '=', null);
        }
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addColumn([
            'name' => 'label',
            'label' => 'نام'
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
        CRUD::setValidation(WidgetRequest::class);

        CRUD::field('name');
        CRUD::field('prefix');
        CRUD::field('label');
        CRUD::field('type');
        CRUD::field('cat');
        CRUD::field('description');
        CRUD::field('theme_id');
        CRUD::field('status');
        CRUD::field('extras');

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
        $theme = Theme::find($this->crud->getCurrentEntry()->theme_id);
        $this->themeWidgets($this->crud->getCurrentEntry()->name );
        $this->addDefaultWidgetFields();
    }

    /**
     * Add the widget defined for a specific theme.
     *
     * @param  string $theme_folder The name of the template folder that should be used in the current form.
     */
    public function themeWidgets($widget)
    {

        $widgets = resolve('ThemeWidgets');
        $widget_name = "widget_$widget";
        if(method_exists($widgets,$widget_name)) {
            return $widgets->{$widget_name}();
        }
    }

    public function addDefaultWidgetFields()
    {
        CRUD::addField([
            'name' => 'name',
            // 'prefix' => '<i class="la la-pencil"></i>',
            'label' => 'name',
            'readOnly' => true,
            'wrapper' => [ 
                'class'      => 'form-group col-md-12 ltr'
            ],
            'attributes' => [
                // 'placeholder' => 'Some text when empty',
                // 'class'       => 'form-control some-class',
                'readonly'    => 'readonly',
                'disabled'    => 'disabled',
              ],
            'tab'   => 'تنظیمات'
        ]);
        CRUD::addField([
            'name' => 'label',
            'prefix' => '<i class="la la-pencil"></i>',
            'label' => 'نام ابزارک',
            'wrapper' => [ 
                'class'      => 'form-group col-md-12'
            ],
            'tab'   => 'تنظیمات'
        ]);
        CRUD::addField([
            'name' => 'description',
            'label' => 'توضیحات',
            'type'  => 'textarea',
            'tab'   => 'تنظیمات'
        ]);
        // CRUD::field('theme_id')->tab('تنظیمات');
        CRUD::addField([ // Text
            'name'    => 'status',
            'label'   => '<i class="la la-flag-o"></i> وضعیت انتشار',
            'type'    => 'radio',
            'default' => '1',
            'options' => [
                "1" => '<span class="bg-success mb-1 d-block">
                ابزارک فعال باشد و نمایش داده شود.
                        </span>',
                "0"     => '<span class="bg-danger mb-1 d-block">
                غیرفعال باشد.
                        </span>',
            ],
            'wrapper' => [ 
                'class'      => 'form-group col-md-12'
            ],
            'tab' => 'تنظیمات'
        ]);
    }
}
