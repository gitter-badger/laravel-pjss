<?php
namespace App\Console\Commands;

use Illuminate\Support\Str;
use App\Console\Commands\GeneratorCommand;

class RepositoryBackendMakeCommand extends GeneratorCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:pjss-repository-backend {namespace} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';
    
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        if (parent::fire() !== false) {
            $this->call('make:pjss-event-backend', [
                'namespace' => $this->getNamespaceInput(),
                'name' => $this->getNameInput(),
                'type' => 'Create',
            ]);
            $this->call('make:pjss-event-backend', [
                'namespace' => $this->getNamespaceInput(),
                'name' => $this->getNameInput(),
                'type' => 'Delete',
            ]);
            $this->call('make:pjss-event-backend', [
                'namespace' => $this->getNamespaceInput(),
                'name' => $this->getNameInput(),
                'type' => 'Restore',
            ]);
            $this->call('make:pjss-event-backend', [
                'namespace' => $this->getNamespaceInput(),
                'name' => $this->getNameInput(),
                'type' => 'Update',
            ]);
            
            $this->call('make:pjss-listener-backend', [
                'namespace' => $this->getNamespaceInput(),
                'name' => $this->getNameInput(),
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
        return __DIR__ . '/stubs/repository-contract-backend.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace            
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Repositories\Backend' . '\\' . $this->getNamespaceInput() . '\\' . $this->getNameInput();
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
        
        return $this->laravel['path'] . '/' . str_replace('\\', '/', $name) . 'RepositoryContract.php';
    }
}
