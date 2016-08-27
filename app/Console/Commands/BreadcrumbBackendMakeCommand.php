<?php
namespace App\Console\Commands;

use Illuminate\Support\Str;
use App\Console\Commands\GeneratorCommand;

class BreadcrumbBackendMakeCommand extends GeneratorCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:pjss-breadcrumb-backend {namespace} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create / Modify a new breadcrumb class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Breadcrumb';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        if (parent::fire() !== false) {
            $this->call('make:pjss-breadcrumb-require-backend', [
                'namespace' => $this->getNamespaceInput(),
                'name' => $this->getNameInput()
            ]);
            
            // 修改resources/lang/zh/menus.php
            $path = $this->laravel['path'] . '/../resources/lang/' . env('APP_LOCALE') . '/menus.php';
            
            $lower_namespace = Str::lower($this->getNamespaceInput());
            $lower_name = Str::lower($this->getNameInput());
            $plural_lower_name = Str::plural($lower_name);
            
            $array = $this->files->getRequire($path);
            $contents = $this->files->get($path);
            if (! array_has($array['backend'], $lower_namespace)) {
                $contents = str_replace('   \'backend\' => [', '   \'backend\' => [' . PHP_EOL . '        \'' . $lower_namespace . '\' => [/*backend*/' . PHP_EOL . '        ],', $contents);
            }
            if (! (array_has($array['backend'], $lower_namespace) && array_has($array['backend'][$lower_namespace], $plural_lower_name))) {
                $contents = str_replace('       \'' . $lower_namespace . '\' => [/*backend*/', '       \'' . $lower_namespace . '\' => [/*backend*/' . PHP_EOL . '            \'' . $plural_lower_name . '\' => [' . PHP_EOL . '                \'create\' => \'Create ' . $this->getNameInput() . '\',' . PHP_EOL . '                \'detail\' => \'Information ' . $this->getNameInput() . '\',' . PHP_EOL . '                \'edit\' => \'Edit ' . $this->getNameInput() . '\',' . PHP_EOL . '            ],', $contents);
            }
            $this->files->put($path, $contents);
            $this->comment('langs.menus modified successfully.');
        }
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/breadcrumb-backend.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace            
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Http\Breadcrumbs\Backend' . '\\' . $this->getNamespaceInput();
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
        
        return $this->laravel['path'] . '/' . str_replace('\\', '/', $name) . '.php';
    }
}
