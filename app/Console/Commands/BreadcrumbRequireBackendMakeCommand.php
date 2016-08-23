<?php
namespace App\Console\Commands;

use Illuminate\Support\Str;
use App\Console\Commands\GeneratorCommand;

class BreadcrumbRequireBackendMakeCommand extends GeneratorCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:pjss-breadcrumb-require-backend {namespace} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create / Modify a new breadcrumb require class';

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
        $path = $this->getPath($this->parseName($this->getNameInput()));
        if ($this->files->exists($path)) {
            $lower_namespace = Str::lower($this->getNamespaceInput());
            $lower_name = Str::lower($this->getNameInput());
            $plural_lower_name = Str::plural($lower_name);
            
            // 增加本实体的面包屑
            $contents = $this->files->get($path);
            $comment = '// ' . $this->getNameInput() . ' Require';
            
            if (strpos($contents, $comment) === false) {
                $sutb = $this->buildClass($this->parseName($this->getNameInput()));
                
                $sutbStartIndex = strpos($sutb, $comment);
                $sutb = Str::substr($sutb, $sutbStartIndex);
                $this->files->put($path, $contents . PHP_EOL . $sutb);
            }
            $this->comment('Breadcrumbs modified successfully.');
        }
        else {
            if (parent::fire() !== false) {
                $path = $this->laravel['path'] . '/Http/Breadcrumbs/Backend/Backend.php';
                
                // 增加本命名控件的面包屑
                $contents = $this->files->get($path);
                $comment = '// ' . $this->getNamespaceInput() . ' Require';
                $sutb = 'require __DIR__ . \'/' . $this->getNamespaceInput() . '.php\';';
                
                if (strpos($contents, $comment) === false) {
                    $this->files->put($path, $contents . PHP_EOL . $comment . PHP_EOL. $sutb);
                }
                $this->comment('Breadcrumbs modified successfully.');
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
        return __DIR__ . '/stubs/breadcrumb-require-backend.stub';
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
        $name = str_replace_last('\\' . $this->getNameInput(), '', $name);
        
        return $this->laravel['path'] . '/' . str_replace('\\', '/', $name) . '.php';
    }
}
