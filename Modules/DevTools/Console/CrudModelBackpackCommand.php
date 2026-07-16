<?php

namespace Modules\DevTools\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;

class CrudModelBackpackCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:backpack:crud-model';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:backpack:crud-model {name} {module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a Backpack CRUD model';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';

    /**
     * The trait that allows a model to have an admin panel.
     *
     * @var string
     */
    protected $crudTrait = 'Backpack\CRUD\app\Models\Traits\CrudTrait';

    /**
     * Execute the console command.
     *
     * @return bool|null
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        $name = $this->getNameInput();
        $module = (string) $this->argument('module');

        $module_instanc = Module::find($module);
        if(!$module_instanc) {
            $this->warn("Module `$module` note exists.");
            return true;
        }
        
        $namespaceModels = 'Modules\\'.$this->argument('module').'\\Models\\'.$this->getNameInput();

        // $existsOnModels = $this->alreadyExists($namespaceModels);
        $existsOnModels = $this->files->exists($this->getModulePath($namespaceModels));

        // If no model was found, we will generate the path to the location where this class file
        // should be written. Then, we will build the class and make the proper replacements on
        // the stub files so that it gets the correctly formatted namespace and class name.
        if (! $existsOnModels) {
            $this->makeDirectory($namespaceModels);

            $this->files->put($this->getModulePath($namespaceModels), $this->sortImports($this->buildClass($namespaceModels)));

            $this->info($this->type.' created successfully.');

            return;
        }

        $name = $namespaceModels;
        $path = $this->getModulePath($name);

        // As the class already exists, we don't want to create the class and overwrite the
        // user's code. We just make sure it uses CrudTrait. We add that one line.
        if (! $this->hasOption('force') || ! $this->option('force')) {
            $file = $this->files->get($path);
            $lines = preg_split('/(\r\n)|\r|\n/', $file);

            // check if it already uses CrudTrait
            // if it does, do nothing
            if (Str::contains($file, $this->crudTrait)) {
                $this->comment('Model already used CrudTrait.');

                return;
            }

            // if it does not have CrudTrait, add the trait on the Model
            foreach ($lines as $key => $line) {
                if (Str::contains($line, "class {$this->getNameInput()} extends")) {
                    if (Str::endsWith($line, '{')) {
                        // add the trait on the next
                        $position = $key + 1;
                    } elseif ($lines[$key + 1] == '{') {
                        // add the trait on the next next line
                        $position = $key + 2;
                    }

                    // keep in mind that the line number shown in IDEs is not
                    // the same as the array index - arrays start counting from 0,
                    // IDEs start counting from 1

                    // add CrudTrait
                    array_splice($lines, $position, 0, "    use \\{$this->crudTrait};");

                    // save the file
                    $this->files->put($path, implode(PHP_EOL, $lines));

                    // let the user know what we've done
                    $this->info('Model already existed. Added CrudTrait to it.');

                    return;
                }
            }

            // In case we couldn't add the CrudTrait
            $this->error("Model already existed on '$name' and we couldn't add CrudTrait. Please add it manually.");
        }
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/crud-model.stub';
    }

    /**
     * Replace the table name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceTable(&$stub, $name)
    {
        $name = ltrim(strtolower(preg_replace('/[A-Z]/', '_$0', str_replace($this->getNamespace($name).'\\', '', $name))), '_');

        $table = Str::snake(Str::plural($name));

        $stub = str_replace('DummyTable', $table, $stub);

        return $this;
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)->replaceTable($stub, $name)->replaceClass($stub, $name);
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

    protected function getModulePath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return base_path().'/'.str_replace('\\', '/', $name).'.php';
    }
}
