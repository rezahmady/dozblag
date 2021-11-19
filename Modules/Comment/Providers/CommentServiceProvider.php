<?php

namespace Modules\Comment\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Livewire\Livewire;
use Modules\Comment\Http\Livewire\Comment;
use Modules\Comment\Http\Livewire\CommentHolder;
use Modules\Comment\Http\Livewire\CreateComment;
use Modules\Comment\View\Widgets\CommentsNumber;
use TorMorten\Eventy\Facades\Eventy as Hook;

class CommentServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Comment';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'comment';

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

        Livewire::component('comment.comment', Comment::class);
        Livewire::component('comment.comment-holder', CommentHolder::class);
        Livewire::component('comment.create-comment', CreateComment::class);

        Blade::component('comment-widget-comments-number', CommentsNumber::class);


        Hook::addAction('admin-menu-build', function($menu) {
            if(backpack_user()->can('post manage') and backpack_user()->can('comment list')) {
                $menu->add('articles.comments', trans('comment::comment.article_comments') , backpack_url('article/comment') , 430, 'comments');
            }

            if(backpack_user()->can('user manage') and backpack_user()->can('comment list')) {
                $menu->add('users', ' مدیریت کاربران', '#' , 100 , 'users');
                $menu->add('users.comments', trans('comment::comment.doctor_comment') , backpack_url('user/doctor/comment') , 140, 'comments');
            }
        }, 21, 1);

        /**
         *  Admin widgets
         *
         */

        Hook::addFilter('admin-dashboard-widget::filter', function($widgets) {
            $widget = [
                'id'  => 'comment-comments-number',
                'lg'  => 'col-lg-3',
                'md'  => 'col-md-3',
                'sm'  => 'col-sm-6',
                'xsm' => 'col-12',
                'view' => 'comment-widget-comments-number',
                'active' => false,
            ];
            array_push($widgets, $widget);
            return $widgets;
        }, 20, 1);

        /**
         *  Core Widget
         *  monthly chart
         */
        Hook::addAction('widget-core-monthly-chart::action', function($chart) {
            $v = Verta();
            $data = [];
            for ($key=0 ; $key<12; $key++) {
                $v = Verta();
                $startMonth = (array) $v->month($key)->startMonth();
                $endMonth = (array) $v->month($key)->endMonth();

                $data['comments'][$key] = (int) \Modules\Comment\Models\Comment::where('module', 'Article')
                    ->whereBetween('created_at', [$startMonth['date'] , $endMonth['date']])->count();
            }
            $chart->dataset('نظرات', $data['comments']);
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
