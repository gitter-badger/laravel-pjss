<?php
namespace App\Console\Commands;

use Illuminate\Support\Str;
use App\Console\Commands\GeneratorCommand;

class RouteFrontendMakeCommand extends GeneratorCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:pjss-route-frontend {namespace} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create / Modify a new route class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Route';

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
            $comment_header = '	/**' . PHP_EOL . '	 * ' . $this->getNameInput() . ' Management' . PHP_EOL . '	 */';
            $stub = '	Route::group([\'namespace\' => \'' . $this->getNameInput() . '\'], function() {' . PHP_EOL . '		Route::resource(\'' . $lower_name . '\', \'' . $this->getNameInput() . 'Controller\');' . PHP_EOL . '	});';
            $comment_footer = '	// Replacer';
            
            if (strpos($contents, $comment_header) === false) {
                $contents = str_replace($comment_footer, $comment_header . PHP_EOL . $stub . PHP_EOL . PHP_EOL . $comment_footer, $contents);
                $this->files->put($path, $contents);
            }
            $this->comment('Routes modified successfully.');
        } else {
            if (parent::fire() !== false) {
                $path = $this->laravel['path'] . '/Http/routes.php';
                
                // 增加本命名控件的路由
                $contents = $this->files->get($path);
                $replacer = '        // Frontend Replacer';
                $comment = '        // ' . $this->getNamespaceInput() . ' Require';
                $sutb = '        require __DIR__ . \'/Routes/Frontend/' . $this->getNamespaceInput() . '.php\';';
                
                if (strpos($contents, $comment) === false) {
                    $contents = str_replace($replacer, $comment . PHP_EOL . $sutb . PHP_EOL . $replacer, $contents);
                    $this->files->put($path, $contents);
                }
                $this->comment('Routes modified successfully.');
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
        return __DIR__ . '/stubs/route-frontend.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace            
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Http\Routes\Frontend\\';
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
        
        return $this->laravel['path'] . '/' . Str::replaceLast($this->getNameInput(), $this->getNamespaceInput(), str_replace('\\', '/', $name)) . '.php';
    }
}
