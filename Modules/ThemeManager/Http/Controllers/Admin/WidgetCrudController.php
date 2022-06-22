<?php

namespace Modules\ThemeManager\Http\Controllers\Admin;

use App\Traits\DefaultPermissions;
use Modules\ThemeManager\Http\Requests\WidgetRequest;
use Modules\ThemeManager\Models\Theme;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class WidgetCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class WidgetCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation { destroy as traitDestroy; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use DefaultPermissions;

    Const ENTITY = 'widget';
    private $themes_folder = '';
    public $theme_model = '';

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        $this->theme_model = config('thememanager.models.theme');
        CRUD::setModel(\App\Models\Widget::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/widget');
        CRUD::setEntityNameStrings('ابزارک', 'ابزارک ها');
        $this->themes_folder = config('thememanager.themes_folder', resource_path('views/themes'));
        $this->crud->setListView('thememanager::widget-list');

        $theme = Theme::active()->first();
        
        if($theme) {
            $this->crud->addClause('where', 'theme_id', '=', $theme->id);
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

        $this->crud->addButton('line', 'update', 'view', 'crud::buttons.btn-update');
        $this->crud->addButton('line', 'delete', 'view', 'crud::buttons.btn-delete');
        CRUD::column('name');
        CRUD::column('prefix');
        CRUD::column('label');
        CRUD::column('type');
        CRUD::column('cat');
        CRUD::column('description');
        CRUD::column('theme_id');
        CRUD::column('status');

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

        CRUD::addField([
            'name' => 'name',
            'prefix' => '<i class="la la-terminal"></i>',
            'label' => 'نام',
        ]);
        CRUD::addField([
            'name' => 'label',
            'label' => 'عنوان نمایشی',
            'prefix' => '<i class="la la-pencil"></i>'
        ]);
        CRUD::addField([   // icon_picker
            'label'   => "آیکن",
            'name'    => 'icon',
            'type'    => 'icon_picker',
            'iconset' => 'octicon' // options: fontawesome, glyphicon, ionicon, weathericon, mapicon, octicon, typicon, elusiveicon, materialdesign
        ]);
        CRUD::field('type');
        CRUD::field('cat');
        CRUD::field('description');
        CRUD::field('theme_id');

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
        $this->themeWidgets($this->crud->getCurrentEntry()->name );
        $this->addDefaultWidgetFields();
    }

    public function destroy($id)
    {
        $this->crud->hasAccessOrFail('delete');
        // delete from json file
        $widget = $this->crud->getEntry($id);;
        $theme = $this->theme_model::find($widget->theme_id);
        $json_file_path = $this->themes_folder . '/' . $theme->folder . '/' . $theme->folder . '.json';
        $jsonString = file_get_contents($json_file_path);
        $data = json_decode($jsonString, true);

        $found_key = array_search($widget->name, array_column($data['widgets'], 'name'));
        unset($data['widgets'][$found_key]);
        file_put_contents($json_file_path, json_encode($data, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));

        return $this->crud->delete($id);
    }

    public function store()
    {    
        $response = $this->traitStore();
        // 
        $request = $this->crud->getRequest();
        $theme = $this->theme_model::find($request->theme_id);
        $json_file_path = $this->themes_folder . '/' . $theme->folder . '/' . $theme->folder . '.json';
        $jsonString = file_get_contents($json_file_path);
        $data = json_decode($jsonString, true);

        $data['widgets'][] = $request->except(['_token', 'http_referrer', 'save_action', 'extras', 'status']);
        file_put_contents($json_file_path, json_encode($data, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));

        return $response;
    }

    /**
     * Add the widget defined for a specific theme.
     *
     * @param  string $theme_folder The name of the template folder that should be used in the current form.
     */
    public function themeWidgets($widget)
    {
        $widgets = resolve("Themes\\".THEME_FOLDER."\\ThemeWidgets");
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
