<?php
namespace App\Console\Commands;

use Illuminate\Support\Str;
use App\Console\Commands\GeneratorCommand;

class ModelMakeCommand extends GeneratorCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:pjss-model {namespace} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        if (parent::fire() !== false) {
            $table = $this->getTable();
            
//             $this->call('make:migration', [
//                 'name' => "create_{$table}_table",
//                 '--create' => $table
//             ]);
            $this->call('make:pjss-repository-backend', [
                'namespace' => $this->getNamespaceInput(),
                'name' => $this->getNameInput()
            ]);
            $this->call('make:pjss-repository-frontend', [
                'namespace' => $this->getNamespaceInput(),
                'name' => $this->getNameInput()
            ]);
            $this->call('make:pjss-eloquent-repository-backend', [
                'namespace' => $this->getNamespaceInput(),
                'name' => $this->getNameInput()
            ]);
            $this->call('make:pjss-eloquent-repository-frontend', [
                'namespace' => $this->getNamespaceInput(),
                'name' => $this->getNameInput()
            ]);
            
            $this->call('make:pjss-service-provider', [
                'namespace' => $this->getNamespaceInput(),
                'name' => $this->getNameInput()
            ]);
        }
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/model.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace            
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Models' . '\\' . $this->getNamespaceInput() . '\\' . $this->getNameInput();
    }

    /**
     * Build the class with the given name.
     *
     * @param string $name            
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);
        
        $this->replaceTable($stub, $name);
        
        return $stub;
    }

    /**
     * Replace the table for the given stub.
     *
     * @param string $stub            
     * @param string $name            
     * @return $this
     */
    protected function replaceTable(&$stub, $name)
    {
        $table = $this->getTable($name);
        
        $stub = str_replace('{table}', $table, $stub);
        
        return $this;
    }

    /**
     * Get the full table name for a given class.
     *
     * @param string $name            
     * @return string
     */
    protected function getTable()
    {
        return Str::snake($this->getNamespaceInput()) . '_' . Str::plural(Str::snake($this->getNameInput()));
    }
}
