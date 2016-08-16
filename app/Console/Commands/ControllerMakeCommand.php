<?php
namespace App\Console\Commands;

use Illuminate\Support\Str;
use App\Console\Commands\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class ControllerMakeCommand extends GeneratorCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:pjss-controller {namespace} {name} {--frontend}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new controller class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        if (parent::fire() !== false) {
            if (! $this->option('frontend')) {
                $this->call('make:pjss-controller', [
                    'namespace' => $this->getNamespaceInput(),
                    'name' => $this->getNameInput(),
                    '--frontend' => '--frontend'
                ]);
            }
        }
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/controller.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace            
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Http\Controllers' . ($this->option('frontend') ? '\Frontend' : '\Backend') . '\\' . $this->getNamespaceInput() . '\\' . $this->getNameInput();
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
        
        return $this->laravel['path'] . '/' . str_replace('\\', '/', $name) . 'Controller.php';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            [
                'frontend',
                null,
                InputOption::VALUE_NONE,
                'Generate a frontend controller class.'
            ]
        ];
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
        
        $this->replaceName($stub, $name);
        
        return $stub;
    }

    /**
     * Replace the table for the given stub.
     *
     * @param string $stub            
     * @param string $name            
     * @return $this
     */
    protected function replaceName(&$stub, $name)
    {
        $names = Str::plural($this->getNameInput());
        
        $stub = str_replace('DummyName', $this->getNameInput(), $stub);
        $stub = str_replace('dummyNames', Str::camel($names), $stub);
        
        return $this;
    }
}
