<?php
namespace App\Console\Commands;

use Illuminate\Support\Str;
use App\Console\Commands\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

class ViewBackendMakeCommand extends GeneratorCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:pjss-view-backend {namespace} {name} {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new view file';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'View';
    
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        if (parent::fire() !== false) {
            // 修改resources/lang/zh/labels.php
            $path = $this->laravel['path'] . '/../resources/lang/' . env('APP_LOCALE') . '/labels.php';
    
            $lower_namespace = Str::lower($this->getNamespaceInput());
            $lower_name = Str::lower($this->getNameInput());
            $plural_lower_name = Str::plural($lower_name);
    
            $array = $this->files->getRequire($path);
            $contents = $this->files->get($path);
            if (!array_has($array['backend'], $lower_namespace)){
                $contents = str_replace(
                    '   \'backend\' => [',
                    '   \'backend\' => [' . PHP_EOL .
                    '        \'' . $lower_namespace . '\' => [/*backend*/' . PHP_EOL .
                    '        ],'
                    , $contents);
            }
            if (!(array_has($array['backend'], $lower_namespace) && array_has($array['backend'][$lower_namespace], $plural_lower_name))) {
                $contents = str_replace(
                    '       \'' . $lower_namespace . '\' => [/*backend*/',
                    '       \'' . $lower_namespace . '\' => [/*backend*/' . PHP_EOL .
                    '            \'' . $plural_lower_name . '\' => [' . PHP_EOL .
                    '                \'management\' => \'' . $lower_name . '\',' . PHP_EOL .
                    '            ],'
                    , $contents);
            }
            $this->files->put($path, $contents);
            $this->comment('langs.labels modified successfully.');
        }
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/view-backend-' . $this->argument('type') . '.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace            
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\..\resources\views\backend' . '\\' . Str::lower($this->getNamespaceInput()) . '\\' . Str::lower($this->getNameInput());
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
        
        return $this->laravel['path'] . '/' . str_replace('\\', '/', $name) . $this->argument('type') . '.blade.php';
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
