<?php

namespace Modules\Filter\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Javoscript\MacroableModels\Facades\MacroableModels;
use Livewire\Livewire;
use Modules\Resource\Models\Resource;
use Modules\Filter\Http\Livewire\FilterItemPage;
use Modules\Filter\Http\Livewire\FilterItemService;
use Modules\Filter\Http\Livewire\Widgets\FilterItem;
use Modules\Filter\Models\Filter;
use Modules\Filter\Models\FilterItem as ModelsFilterItem;

class FilterServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Filter';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'filter';

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

        Livewire::component('widgets.filter-item', FilterItem::class);
        Livewire::component('filter.http.livewire.filter-item-page', FilterItemPage::class);
        Livewire::component('filter.http.livewire.filter-item-service', FilterItemService::class);
        $this->resolveModelsEloquent();
    }

    public function resolveModelsEloquent()
    {

        User::resolveRelationUsing('speciltyFilter', function ($Model) {
            return $Model->belongsTo(ModelsFilterItem::class, 'extras->filter_specilty');
        });


        MacroableModels::addMacro(User::class, 'servicesFilter', function() {
            $user = $this;
            return Filter::findBySlug('services')->items->filter(function($filteritem) use ($user) {
                if(isset($user->extras->filter_services))
                    return in_array($filteritem->id, $user->extras->filter_services) ;
                return false;
            });
        });


        MacroableModels::addMacro(Resource::class, 'servicesFilter', function() {
            $user = $this;
            return Filter::findBySlug('services')->items->filter(function($filteritem) use ($user) {
                if(isset($user->extras->filter_services))
                    return in_array($filteritem->id, $user->extras->filter_services) ;
                return false;
            });
        });

        MacroableModels::addMacro(User::class, 'getSpecilty', function() {
            return ($this->speciltyFilter) ? $this->speciltyFilter->name : '';
        });
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
