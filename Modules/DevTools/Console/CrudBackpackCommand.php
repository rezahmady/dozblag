<?php

namespace Modules\DevTools\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CrudBackpackCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:backpack:crud {name} {module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a CRUD interface: Controller, Model, Request';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $module = (string) $this->argument('module');
        $name = (string) $this->argument('name');
        $nameTitle = ucfirst(Str::camel($name));
        $nameKebab = Str::kebab($nameTitle);
        $name_snak = Str::snake($name);

        $module_snak = Str::snake($this->argument('module'));

        // Create the CRUD Model and show output
        $this->call('module:backpack:crud-model', ['name' => $nameTitle, 'module' => $module]);

        // Create the CRUD Controller and show output
        $this->call('module:backpack:crud-controller', ['name' => $nameTitle, 'module' => $module]);

        // Create the CRUD Request and show output
        $this->call('module:backpack:crud-request', ['name' => $nameTitle, 'module' => $module]);

        // Create the CRUD route
        $this->call('module:backpack:add-custom-route', [
            'module' => $module,
            'code' => "Route::crud('$nameKebab', '{$nameTitle}CrudController');"
        ]);

        // // Create the sidebar item
        $this->call('module:backpack:add-admin-menu', [
            'module' => $module,
            'code' => '$menu->add("'.$name_snak.'", trans("'.$module_snak.'::lang.'.$name_snak.'_plural") , backpack_url("'.$name_snak.'") , 700, "question");',
        ]);

        // if the application uses cached routes, we should rebuild the cache so the previous added route will
        // be acessible without manually clearing the route cache.
        if (app()->routesAreCached()) {
            $this->call('route:cache');
        }
    }
}
