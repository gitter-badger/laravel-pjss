<?php
namespace App\Console\Commands;

use Illuminate\Support\Str;
use App\Console\Commands\GeneratorCommand;

class ControllerFrontendMakeCommand extends GeneratorCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:pjss-controller-frontend {namespace} {name}';

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
            $this->call('make:pjss-view-frontend', [
                'namespace' => $this->getNamespaceInput(),
                'name' => $this->getNameInput(),
                'type' => 'index',
            ]);
            $this->call('make:pjss-view-frontend', [
                'namespace' => $this->getNamespaceInput(),
                'name' => $this->getNameInput(),
                'type' => 'create',
            ]);
            $this->call('make:pjss-view-frontend', [
                'namespace' => $this->getNamespaceInput(),
                'name' => $this->getNameInput(),
                'type' => 'edit',
            ]);
            $this->call('make:pjss-view-frontend', [
                'namespace' => $this->getNamespaceInput(),
                'name' => $this->getNameInput(),
                'type' => 'detail',
            ]);
            
            // 修改resources/lang/zh/alerts.php
            $path = $this->laravel['path'] . '/../resources/lang/' . env('APP_LOCALE') . '/alerts.php';
            
            $lower_namespace = Str::lower($this->getNamespaceInput());
            $lower_name = Str::lower($this->getNameInput());
            $plural_lower_name = Str::plural($lower_name);
            
            $array = $this->files->getRequire($path);
            $contents = $this->files->get($path);
            if (!array_has($array['frontend'], $lower_namespace)){
                $contents = str_replace(
                    '   \'frontend\' => [',
                    '   \'frontend\' => [' . PHP_EOL .
                    '        \'' . $lower_namespace . '\' => [/*frontend*/' . PHP_EOL .
                    '        ],'
                    , $contents);
            }
            if (!(array_has($array['frontend'], $lower_namespace) && array_has($array['frontend'][$lower_namespace], $plural_lower_name))) {
                $contents = str_replace(
                    '       \'' . $lower_namespace . '\' => [/*frontend*/',
                    '       \'' . $lower_namespace . '\' => [/*frontend*/' . PHP_EOL .
                    '            \'' . $plural_lower_name . '\' => [' . PHP_EOL .
                    '                \'created\' => \'The ' . $lower_name . ' was successfully created.\',' . PHP_EOL .
                    '                \'deleted\' => \'The ' . $lower_name . ' was successfully deleted.\',' . PHP_EOL .
                    '                \'updated\' => \'The ' . $lower_name . ' was successfully updated.\',' . PHP_EOL .
                    '            ],'
                    , $contents);
            }
            $this->files->put($path, $contents);
            $this->comment('langs.alerts modified successfully.');
        }
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/controller-frontend.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace            
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Http\Controllers\Frontend' . '\\' . $this->getNamespaceInput() . '\\' . $this->getNameInput();
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
}
