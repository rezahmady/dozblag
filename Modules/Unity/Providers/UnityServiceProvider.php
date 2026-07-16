<?php

namespace Modules\Unity\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Modules\Unity\Models\Unity;
use Modules\Unity\View\Widgets\DriverCount;
use Modules\Unity\View\Widgets\TruckCount;
use Modules\Unity\View\Widgets\UnityTitle;
use TorMorten\Eventy\Facades\Eventy as Hook;

class UnityServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Unity';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'unity';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        // ModelsUser::belongsTo(Unity::class, 'extras->unity_id');

        $this->commands([
            \Modules\Unity\Console\FixDateColumns::class,
        ]);

        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
        Blade::component('unity-widget-unity-title', UnityTitle::class);
        Blade::component('unity-widget-driver-count', DriverCount::class);
        Blade::component('unity-widget-truck-count', TruckCount::class);
        
        /**
         *  Admin menu
         */
        Hook::addAction('admin-menu-build', function($menu) {
            if(backpack_user()->can('Unity list')){
                $menu->add('unity', trans('unity::unity.unity_plural') , backpack_url('unity') , 200, 'database');
            }
            
            if(
                backpack_user()->can('truck list')
                or backpack_user()->can('Trailer list')
                or backpack_user()->can('truckcontract list')
                or backpack_user()->can('vehicletype list') ) {
                $menu->add('trucks', trans('unity::unity.truck_plural'), '#' , 220 , 'truck');
            }

            if(backpack_user()->can('truck list'))
            $menu->add('trucks.truck', trans('unity::unity.list_truck_plural') , backpack_url('truck') , 225, 'list');

            if(backpack_user()->can('Trailer list'))
            $menu->add('trucks.trailer', trans('unity::unity.trailer_plural') , backpack_url('trailer') , 235, 'truck');
            
            if(backpack_user()->can('truckcontract list'))
            $menu->add('trucks.contract', trans('unity::unity.truck_contract_plural') , backpack_url('truckcontract') , 228, 'file-alt');
            if(backpack_user()->can('vehicletype list'))
            $menu->add('trucks.vehicletype', trans('unity::unity.vehicletype.plural') , backpack_url('vehicletype') , 230, 'truck');

            if(backpack_user()->can('driver list')) {
                $menu->add('drivers', trans('unity::unity.driver_plural'), '#' , 240 , 'id-card-alt');
                $menu->add('drivers.driver', trans('unity::unity.list_driver_plural') , backpack_url('driver') , 242, 'list');
            }
            
            if(backpack_user()->can('drivercontract list'))
            $menu->add('drivers.contract', trans('unity::unity.list_driver_contract_plural') , backpack_url('drivercontract') , 250, 'file-alt');

        }, 5, 1);

        Hook::addAction('user-crud-update-operation-after-fields', function ($crud) {
            $crud->addFields([
                [   // relationship
                    'type' => "select2",
                    'name' => 'unity_id', // the method on your model that defines the relationship
                    // 'ajax' => true,
                    'fake' => true,
                    // 'inline_create' => [ 'entity' => 'group' ], // specify the entity in singular
                    'label' => 'شرکت',
                    'wrapper'      => [
                        'class'  => "form-group col-md-6"
                    ],
                    'minimum_input_length' => 0,
                    'attribute' => "fa_name", // foreign key attribute that is shown to user (identifiable attribute)
                    //'entity' => 'unity', // the method that defines the relationship in your Model
                    'model' => "Modules\Unity\Models\Unity", // foreign key Eloquent model
                    'placeholder' => "انتخاب شرکت", // placeholder for the select2 input
                ],
            ]);
        }, 20, 2);

        Hook::addAction('user-crud-create-operation-after-fields', function ($crud) {
            $crud->addFields([
                [   // relationship
                    'type' => "select2",
                    'name' => 'unity_id', // the method on your model that defines the relationship
                    // 'ajax' => true,
                    'fake' => true,
                    // 'inline_create' => [ 'entity' => 'group' ], // specify the entity in singular
                    'label' => 'شرکت',
                    'wrapper'      => [
                        'class'  => "form-group col-md-6"
                    ],
                    'minimum_input_length' => 0,
                    'attribute' => "fa_name", // foreign key attribute that is shown to user (identifiable attribute)
                    //'entity' => 'unity', // the method that defines the relationship in your Model
                    'model' => "Modules\Unity\Models\Unity", // foreign key Eloquent model
                    'placeholder' => "انتخاب شرکت", // placeholder for the select2 input
                ],
            ]);
        }, 20, 2);

        Hook::addAction('user-crud-list-operation-after-columns', function ($crud) {
            $crud->addColumn([   // relationship
                'type' => "select_from_array",
                'options' => Unity::pluck('fa_name', 'id')->toArray(),
                'name' => 'unity_id', // the method on your model that defines the relationship
                'label' => 'شرکت',
                // 'visibleInTable' => true,
                'attribute' => "fa_name", // foreign key attribute that is shown to user (identifiable attribute)
            ])->makeFirstColumn();

            $crud->addFilter(
                [
                    'name'  => 'unity',
                    'type'  => 'select2',
                    'label' => trans('unity::unity.unity_plural'),
                ],
                Unity::pluck('fa_name', 'id')->toArray(),
                function ($value) use ($crud) { // if the filter is active
                    $crud->addClause('where', 'extras->unity_id', $value);
                }
            );
        }, 20, 2);

        Hook::addFilter('core-auth-registeration-url', function($url) {
            return route('unity.auth.register');
        }, 5, 1);

        /**
         *  Admin widget
         */
         Hook::addFilter('admin-dashboard-widget::filter', function($widgets) {
            if(backpack_user()->unity) {
                $widget = [
                    'id'  => 'unity-title-widget',
                    'lg'  => 'col-lg-12',
                    'md'  => 'col-md-12',
                    'sm'  => 'col-sm-12',
                    'xsm' => 'col-12',
                    'view' => 'unity-widget-unity-title',
                    'active' => true,
                ];
    
                array_push($widgets, $widget);
            }

            if(backpack_user()->unity) {
                $widget = [
                    'id'  => 'unity-driver-count-widget',
                    'lg'  => 'col-lg-3',
                    'md'  => 'col-md-3',
                    'sm'  => 'col-sm-12',
                    'xsm' => 'col-12',
                    'view' => 'unity-widget-driver-count',
                    'active' => true,
                ];
    
                array_push($widgets, $widget);
            }

            if(backpack_user()->unity) {
                $widget = [
                    'id'  => 'unity-truck-count-widget',
                    'lg'  => 'col-lg-3',
                    'md'  => 'col-md-3',
                    'sm'  => 'col-sm-12',
                    'xsm' => 'col-12',
                    'view' => 'unity-widget-truck-count',
                    'active' => true,
                ];
    
                array_push($widgets, $widget);
            }
            return $widgets;
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
        User::resolveRelationUsing('unity', function ($model) {
            return $model->belongsTo(Unity::class, 'extras->unity_id', 'id');
        });
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
