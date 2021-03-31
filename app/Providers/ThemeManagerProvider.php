<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use ThemeFolder\themes\ThemeOptions;
use ThemeFolder\themes\ThemeWidgets;

class ThemeManagerProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //       
    }


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Register Theme
        $this->register_theme(); 

        // Load helpers
        @include __DIR__.'/../Helpers/theme.php';

        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'theme');
        
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
                    $middleware_classname = 'Rezahmady\\ThemeManager\\Middleware\\' . str_replace('.php', '', $middleware);
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
        $theme_model = config('themes.models.theme');

        try{

            if (Schema::hasTable('themes')) {
                
                $themes_folder = config('themes.themes_folder', resource_path('views/themes'));
                
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
}
