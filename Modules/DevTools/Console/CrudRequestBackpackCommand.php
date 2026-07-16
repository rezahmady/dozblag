<?php

namespace Modules\DevTools\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class CrudRequestBackpackCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:backpack:crud-request';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:backpack:crud-request {name} {module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a Backpack CRUD request';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Request';

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = str_replace($this->laravel->getNamespace(), '', $name);

        return module_path($this->argument('module')).'/Http/Requests/'.str_replace('\\', '/', Str::studly($name)).'Request.php';
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/crud-request.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return 'Modules\\'.$this->argument('module').'\Http\Requests';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [

        ];
    }

    protected function qualifyClass($name)
    {
        $name = ltrim($name, '\\/');

        $name = str_replace('/', '\\', $name);

        return Str::studly($name);
    }

    protected function rootNamespace()
    {
        return 'Modules\\'.$this->argument('module').'\\';
    }

    protected function replaceNamespace(&$stub, $name)
    {
        $searches = [
            ['DummyNamespace', 'DummyRootNamespace', 'NamespacedDummyUserModel'],
            ['{{ namespace }}', '{{ rootNamespace }}', '{{ namespacedUserModel }}'],
            ['{{namespace}}', '{{rootNamespace}}', '{{namespacedUserModel}}'],
        ];

        foreach ($searches as $search) {
            $stub = str_replace(
                $search,
                [$this->getDefaultNamespace($name), $this->rootNamespace(), $this->userProviderModel()],
                $stub
            );
        }

        return $this;
    }
}
