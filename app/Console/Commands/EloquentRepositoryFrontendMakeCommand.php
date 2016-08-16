<?php
namespace App\Console\Commands;

use Illuminate\Support\Str;
use App\Console\Commands\GeneratorCommand;

class EloquentRepositoryFrontendMakeCommand extends GeneratorCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:pjss-eloquent-repository-frontend {namespace} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new eloquent repository class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'EloquentRepository';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/eloquent-repository-frontend.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace            
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Repositories\Frontend' . '\\' . $this->getNamespaceInput() . '\\' . $this->getNameInput();
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
        
        return $this->laravel['path'] . '/' . Str::replaceLast($this->getNameInput(), 'Eloquent' . $this->getNameInput(), str_replace('\\', '/', $name)) . 'Repository.php';
    }
}
