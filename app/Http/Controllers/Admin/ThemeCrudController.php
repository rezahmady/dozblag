<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ThemeRequest;
use App\Models\Theme;
use App\Models\Widget;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\File;
use Alert;

/**
 * Class ThemeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ThemeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

    private $themes_folder = '';
    public $theme_model = '';

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        $this->theme_model = config('themes.models.theme');
        CRUD::setModel($this->theme_model);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/theme');
        CRUD::setEntityNameStrings('قالب', 'قالب ها');
        $this->crud->allowAccess('list');
        $this->themes_folder = config('themes.themes_folder', resource_path('views/themes'));
        $this->crud->addButtonFromView('line', 'install', 'install', 'end');
        $this->crud->setListView('vendor/backpack/crud/theme-list');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->installThemes();
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ThemeRequest::class);

        CRUD::field('name');
        CRUD::field('folder');
        CRUD::field('active');
        CRUD::field('version');
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
        $this->themeOptions($this->crud->getCurrentEntry()->folder);
    }

    private function getThemesFromFolder(){
        $themes = array();

        if(!file_exists($this->themes_folder)){
            mkdir($this->themes_folder);
        }

        $scandirectory = scandir($this->themes_folder);

        if(isset($scandirectory)){

            foreach($scandirectory as $folder){
                $json_file = $this->themes_folder . '/' . $folder . '/' . $folder . '.json';
                if(file_exists($json_file)){
                    $themes[$folder] = json_decode(file_get_contents($json_file), true);
                    $themes[$folder]['folder'] = $folder;
                    $themes[$folder] = (object)$themes[$folder];
                }
            }

        }

        return (object)$themes;
    }

    private function installThemes() {

        $themes = $this->getThemesFromFolder();

        foreach($themes as $theme){
            $widgets = $theme->widgets ?? false;
            // $json_file_path = $this->themes_folder . '/' . $theme->folder . '/' . $theme->folder . '.json';
            if(isset($theme->folder)){
                $theme_exists = $this->theme_model::where('folder', '=', $theme->folder)->first();
                // If the theme does not exist in the database, then update it.
                if(!isset($theme_exists->id)){
                    $version = isset($theme->version) ? $theme->version : '';
                    $theme = $this->theme_model::create(['name' => $theme->name, 'folder' => $theme->folder, 'version' => $version]);
                    if(config('themes.publish_assets', true)){
                        $this->publishAssets($theme->folder);
                    }
                    if(isset($widgets)){
                        // $jsonString = file_get_contents($json_file_path);
                        // $data = json_decode($jsonString, true);
                        foreach($widgets as $key => $widget) {
                            $widget_exists = Widget::where('name', '=', $widget['name'])->where('theme_id', $theme->id)->first();
                            if(!isset($widget_exists->id)){
                                Widget::create([
                                    'name' => $widget['name'], 
                                    'prefix' => $widget['prefix'] ?? '',
                                    'label' => $widget['label'] ?? '',
                                    'description' => $widget['description'] ?? '',
                                    'type' => $widget['type'] ?? '',
                                    'cat' => $widget['cat'] ?? '',
                                    'theme_id' => $theme->id
                                ]);
                                // $widgets[$key]['id'] = $newWidget->id;
                            }
                        }
                        // $data['widgets'] = $widgets;
                        // file_put_contents($json_file_path, json_encode($data, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
                    }
                } else {
                    // If it does exist, let's make sure it's been updated
                    if(isset($theme->version) and $theme->version != $theme_exists->version) {
                        $theme_exists->update = $theme->version;
                        $theme_exists->save();
                    }
                    if(config('themes.publish_assets', true)){
                        $this->publishAssets($theme->folder);
                    }
                }

            }
        }
    }

    public function activate($theme_folder){

        $theme = $this->theme_model::where('folder', '=', $theme_folder)->first();

        if(isset($theme->id)){
            $this->deactivateThemes();
            $theme->active = 1;
            $theme->save();
            return redirect()
                ->back()
                ->with([
                        'message'    => "Successfully activated " . $theme->name . " theme.",
                        'alert-type' => 'success',
                    ]);
        } else {
            return redirect()
                ->back()
                ->with([
                        'message'    => "Could not find theme " . $theme_folder . ".",
                        'alert-type' => 'error',
                    ]);
        }

    }

    public function rebuild(Theme $theme)
    {
        if(!$theme->update) {
            Alert::error("بروزرسانی ای برای قالب $theme->name دردسترس نیست")->flash();
            return redirect()->back();
        }

        try {
            $json_file = $this->themes_folder . '/' . $theme->folder . '/' . $theme->folder . '.json';
            if(file_exists($json_file)){
                $json = json_decode(file_get_contents($json_file), true);
    
                foreach($json['widgets'] as $jsonWidget)
                {
                    $widget = Widget::where('theme_id', $theme->id)->where('name', $jsonWidget['name'])->first();
    
                    if(isset($widget->id)) {
                        $widget->prefix = $jsonWidget['prefix'];
                        $widget->label = $jsonWidget['label'];
                        $widget->type = $jsonWidget['type'];
                        $widget->cat = $jsonWidget['cat'];
                        $widget->description = $jsonWidget['description'];
                        $widget->save();
                    } else {
                        Widget::create([
                            'name' => $jsonWidget['name'], 
                            'prefix' => $jsonWidget['prefix'] ?? '',
                            'label' => $jsonWidget['label'] ?? '',
                            'description' => $jsonWidget['description'] ?? '',
                            'type' => $jsonWidget['type'] ?? '',
                            'cat' => $jsonWidget['cat'] ?? '',
                            'theme_id' => $theme->id
                        ]);
                    }
                }
            }
            $theme->name = $json['name'];
            $theme->version = $json['version'];
            $theme->update = '';
            $theme->save();
            Alert::success("قالب $theme->name به نسخه $theme->version باموفقیت بروز شد")->flash();
        } catch (\Throwable $th) {
            // Alert::error('بروزرسانی قالب با مشکل مواجه شده هست')->flash();
            Alert::error('بروزرسانی قالب با مشکل مواجه شده هست')->flash();
        }

        return redirect()->back();
    }


    private function deactivateThemes(){
        $this->theme_model::query()->update(['active' => 0]);
    }

    private function publishAssets($theme) {
        $theme_path = public_path('themes/'.$theme);

        if(!file_exists($theme_path)){
            if(!file_exists(public_path('themes'))){
                mkdir(public_path('themes'));
            }
            mkdir($theme_path);
        }

        File::copyDirectory($this->themes_folder.'/'.$theme.'/assets', public_path('themes/'.$theme));
        File::copy($this->themes_folder.'/'.$theme.'/'.$theme.'.jpg', public_path('themes/'.$theme.'/'.$theme.'.jpg'));
    }

    /**
     * Add the fields defined for a specific theme.
     *
     */
    public function themeOptions()
    {
        $options = resolve('ThemeOptions');
        return $options->fields();
    }
}
