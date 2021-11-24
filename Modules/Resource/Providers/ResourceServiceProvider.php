<?php

namespace Modules\Resource\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Livewire\Livewire;
use Modules\Resource\Http\Livewire\ResourceList;
use TorMorten\Eventy\Facades\Eventy as Hook;

class ResourceServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Resource';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'resource';

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

        Livewire::component('resource.http.livewire.resource-list', ResourceList::class);
        Livewire::component('modules.resource.http.livewire.resource-list', ResourceList::class);

        Hook::addAction('admin-menu-build', function($menu) {
            if(backpack_user()->can('user manage')){
                $menu->add('resources', trans('resource::resource.resource_manage') , '#' , 200 , 'stethoscope');
                $menu->add('resources.resource', trans('resource::resource.resource_plural') , backpack_url('resource') , 210, 'hospital');
                if(backpack_user()->can('resource filter')) {
                    $menu->add('resources.filter', trans('resource::resource.filtes') , backpack_url('resource/filter') , 220, 'archive');
                    $menu->add('resources.filteritem', trans('resource::resource.filterItems') , backpack_url('resource/filteritem') , 230, 'filter');
                }
            }
        }, 20, 1);
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
}
