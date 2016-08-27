<?php
namespace App\Console\Commands;

use Illuminate\Support\Str;
use App\Console\Commands\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

class RequestBackendMakeCommand extends GeneratorCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:pjss-request-backend {namespace} {name} {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new request class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Request';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/request-backend.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace            
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Http\Requests\Backend' . '\\' . $this->getNamespaceInput() . '\\' . $this->getNameInput();
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
        
        return $this->laravel['path'] . '/' . Str::replaceLast($this->getNameInput(), $this->argument('type') . $this->getNameInput(), str_replace('\\', '/', $name)) . 'Request.php';
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
            ],
            [
                'type',
                InputArgument::REQUIRED,
                'The type of the class'
            ]
        ];
    }
}