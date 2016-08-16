<?php
namespace App\Console\Commands;

use Illuminate\Support\Str;
use App\Console\Commands\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

class EventBackendMakeCommand extends GeneratorCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:pjss-event-backend {namespace} {name} {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new event class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Event';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/event-backend.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace            
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Events\Backend' . '\\' . $this->getNamespaceInput() . '\\' . $this->getNameInput();
    }

    /**
     * Get the destination class path.
     *
     * @param string $name            
     * @return string
     */
    protected function getPath($name)
    {
        $name = str_replace($this->laravel->getNamespace(), '', $name);
        
        return $this->laravel['path'] . '/' . str_replace('\\', '/', $name) . $this->argument('type') . 'd.php';
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
        
        $stub = str_replace('{type}', $this->argument('type'), $stub);
    
        return $stub;
    }
    
    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            [
                'namespace',
                InputArgument::REQUIRED,
                'The name of the namespace'
            ],
            [
                'name',
                InputArgument::REQUIRED,
                'The name of the class'
            ]
            ,
            [
                'type',
                InputArgument::REQUIRED,
                'The type of the class'
            ]
        ];
    }
}
