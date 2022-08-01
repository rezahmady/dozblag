<?php

namespace Modules\ThemeManager\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use TorMorten\Eventy\Facades\Events as Hook;

class ThemeManagerServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'ThemeManager';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'thememanager';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
        $this->registerBladeDirectives();
        // Register Theme
        $this->register_theme();

        // Load helpers
        @include module_path($this->moduleName, '/Helpers/theme.php');

        // Load helpers
        $this->loadViewsFrom(base_path('Themes'), 'theme');

        Hook::addAction('admin-menu-build', function($menu) {
            $menu->add('index', 'نمایش وب سایت' , url('/') , 5, 'external-link');
            if(backpack_user()->can('theme manage')){
                $menu->add('themes', 'پوسته' ,'#' , 1000, 'paint-brush');
                if (backpack_user()->can('theme update')) {
                    $menu->add('themes.theme', 'انتخاب پوسته' , backpack_url('theme') , 1020, 'television');
                }
                if (backpack_user()->can('widget manage')) {
                    $menu->add('themes.widget', 'ابزارک ها', backpack_url('widget'), 1030, 'puzzle-piece');
                    $menu->add('themes.menu', 'منو‌ها', backpack_url('menu'), 1050, 'reorder');
                }
            }
        }, 20, 1);
    }

    private function loadDynamicMiddleware($themes_folder, $theme){
        if (empty($theme)) {
            return;
        }
        $middleware_folder = $themes_folder . '/' . $theme->folder . '/middleware';
        if(file_exists( $middleware_folder )){
            $middleware_files = scandir($middleware_folder);
            foreach($middleware_files as $middleware){
                if($middleware != '.' && $middleware != '..'){
                    include($middleware_folder . '/' . $middleware);
                    $middleware_classname = 'Modules\\ThemeManager\\Middleware\\' . str_replace('.php', '', $middleware);
                    if(class_exists($middleware_classname)){
                        // Dynamically Load The Middleware
                        $this->app->make('Illuminate\Contracts\Http\Kernel')->prependMiddleware($middleware_classname);
                    }
                }
            }
        }
    }

    // Duplicating the rescue function that's available in 5.5, just in case

    public function rescue(callable $callback, $rescue = null)
    {
        try {
            return $callback();
        } catch (\Throwable $e) {
            report($e);
            return value($rescue);
        }
    }

    public function register_theme()
    {
        $theme_model = config('thememanager.models.theme');

        try{

            if (Schema::hasTable('themes')) {

                $themes_folder = config('thememanager.themes_folder', resource_path('views/themes'));

                $theme = $this->rescue(function () use ($theme_model) {
                    return $theme_model::where('active', '=', 1)->first();
                });

                // share active theme name
                $name = ($theme) ? $theme->folder : 'default';
                define('THEME_FOLDER', $name);
                if($theme->id) define('THEME_ID', $theme->id);

                // register ThemeOption class
                include("$themes_folder/$name/ThemeOptions.php");
                $this->app->bind('ThemeOptions', ThemeOptions::class);

                // register ThemeWidget class
                include("$themes_folder/$name/ThemeWidgets.php");
                $this->app->bind('ThemeWidgets', ThemeWidgets::class);

                // Share views
                view()->share('theme', $theme);

                $this->loadDynamicMiddleware($themes_folder, $theme);

                // Make sure we have an active theme
                if (isset($theme)) {
                    $this->loadViewsFrom($themes_folder.'/'.@$theme->folder, 'theme');
                }
                $this->loadViewsFrom($themes_folder, 'themes_folder');
            }

        } catch(\Exception $e){
            return $e->getMessage();
        }

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }

    private function registerBladeDirectives()
    {
        Blade::directive('themeOption', function ($options) {
            $style = 'top:0;right:0';
            $css = '';
            $bottom = 'auto';
            $label = 'ویرایش';
            $icon = 'pencil-alt';

            //dd($fields);
            eval("\$options = [$options];");

            switch (sizeof($options)) {
                case 1:
                    $fields = $options;
                    break;
                case 2:
                    $fields = $options[0];
                    $style = $options[1];
                    break;
                case 3:
                    $fields = $options[0];
                    $style = $options[1];
                    $css = $options[2];
                    break;
                case 4:
                    $fields = $options[0];
                    $style = $options[1];
                    $css = $options[2];
                    $label = $options[3];
                    break;
                case 5:
                    $fields = $options[0];
                    $style = $options[1];
                    $css = $options[2];
                    $label = $options[3];
                    $icon = $options[4];
                    break;
                default:
                    # code...
                    break;
            }

            if(is_array($fields)) {
                $fields = implode(",", $fields);
            }

            if($fields === null) {
                $url = backpack_url("theme/".THEME_ID."/edit?iframe=true");
            } else {
                $url = backpack_url("theme/".THEME_ID."/edit?iframe=true&fields=$fields");
            }

            // dd($fields, $top, $rgt);
            return <<<EOT
                <?php
                    if(!Auth::guest() and auth()->user()->can('page update')) {
                        echo "<a class=\"btn btn-setting is-clickable {$css}\" x-show=\""."\$"."store.theme.editable\" x-on:click.prevent=\""."\$"."store.theme.openModal('{$url}')\"  style=\"{$style}\"><i class=\"fa fa-{$icon}\" wire:loading.class=\"loading\"></i>
                        <span>{$label}</span>
                        </a>";
                    }
                ?>
            EOT;
        });

        Blade::directive('widgetOption', function ($options) {
            
            return <<<EOT
                <?php
                \$style = 'top:0;right:0';
                \$css = '';
                \$label = 'ویرایش';
                \$icon = 'pencil-alt';
                \$fields = null;

                \$options = [$options];

                switch (sizeof(\$options)) {
                    case 1:
                        \$widget = \$options[0];
                        break;
                    case 2:
                        \$widget = \$options[0];
                        \$fields = \$options[1];
                        break;
                    case 3:
                        \$widget = \$options[0];
                        \$fields = \$options[1];
                        \$style = \$options[2];
                        break;
                    case 4:
                        \$widget = \$options[0];
                        \$fields = \$options[1];
                        \$style = \$options[2];
                        \$css = \$options[3];
                        break;
                    case 5:
                        \$widget = \$options[0];
                        \$fields = \$options[1];
                        \$style = \$options[2];
                        \$css = \$options[3];
                        \$label = \$options[4];
                        break;
                    case 6:
                        \$widget = \$options[0];
                        \$fields = \$options[1];
                        \$style = \$options[2];
                        \$css = \$options[3];
                        \$label = \$options[4];
                        \$icon = \$options[5];
                        break;
                    default:
                        # code...
                        break;
                }

    
                if(is_array(\$fields)) {
                    \$fields = implode(",", \$fields);
                }
    
                if(\$fields === null) {
                    \$url = backpack_url("widget/".\$widget->id."/edit?iframe=true");
                } else {
                    \$url = backpack_url("widget/".\$widget->id."/edit?iframe=true&fields=\$fields");
                }
                    if(!Auth::guest() and auth()->user()->can('page update')) {
                        echo "<a class=\"btn btn-setting is-clickable ".\$css."\" x-on:click.prevent=\"setwidget('".\$widget->name."')\" x-show=\"editable\"  style=\"".\$style."\" href=\"".\$url."\"><i class=\"fa fa-".\$icon."\" wire:loading.class=\"loading\"></i>
                        <span>".\$label."</span>
                        </a>";
                    }
                ?>
            EOT;
        });
    }
}
