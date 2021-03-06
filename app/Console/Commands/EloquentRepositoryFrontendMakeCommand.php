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
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        if (parent::fire() !== false) {
            // 修改resources/lang/zh/exceptions.php
            $path = $this->laravel['path'] . '/../resources/lang/' . env('APP_LOCALE') . '/exceptions.php';
            
            $lower_namespace = Str::lower($this->getNamespaceInput());
            $lower_name = Str::lower($this->getNameInput());
            $plural_lower_name = Str::plural($lower_name);
            
            $array = $this->files->getRequire($path);
            $contents = $this->files->get($path);
            if (! array_has($array['frontend'], $lower_namespace)) {
                $contents = str_replace('   \'frontend\' => [', '   \'frontend\' => [' . PHP_EOL . '        \'' . $lower_namespace . '\' => [/*frontend*/' . PHP_EOL . '        ],', $contents);
            }
            if (! (array_has($array['frontend'], $lower_namespace) && array_has($array['frontend'][$lower_namespace], $plural_lower_name))) {
                $contents = str_replace('       \'' . $lower_namespace . '\' => [/*frontend*/', '       \'' . $lower_namespace . '\' => [/*frontend*/' . PHP_EOL . '            \'' . $plural_lower_name . '\' => [' . PHP_EOL . '                \'create_error\' => \'There was a problem creating this ' . $lower_name . '. Please try again.\',' . PHP_EOL . '                \'delete_error\' => \'There was a problem deleting this ' . $lower_name . '. Please try again.\',' . PHP_EOL . '                \'restore_error\' => \'There was a problem restoring this ' . $lower_name . '. Please try again.\',' . PHP_EOL . '                \'update_error\' => \'There was a problem updating this ' . $lower_name . '. Please try again.\',' . PHP_EOL . '            ],', $contents);
            }
            $this->files->put($path, $contents);
            $this->comment('langs.exceptions modified successfully.');
        }
    }

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
