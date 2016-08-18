<?php
namespace App\Console\Commands;

use Illuminate\Support\Str;
use App\Console\Commands\GeneratorCommand;

class ServiceProviderMakeCommand extends GeneratorCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:pjss-service-provider {namespace} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create / Modify a new service-provider class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'ServiceProvider';
    
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $path = $this->getPath($this->parseName($this->getNameInput()));
        if ($this->files->exists($path)){
            $lower_namespace = Str::lower($this->getNamespaceInput());
            $lower_name = Str::lower($this->getNameInput());
            $plural_lower_name = Str::plural($lower_name);
            
            // 增加本实体的绑定注册
            $contents = $this->files->get($path);
            $comment_header = '     /**' . PHP_EOL .
                    '       * ' . $this->getNameInput() .' Binding' . PHP_EOL .
                    '       */';
            $stub = '        $this->app->bind(' . PHP_EOL .
                    '           \App\Repositories\Frontend\{namespace}\{name}\{name}RepositoryContract::class,' . PHP_EOL .
                    '           \App\Repositories\Frontend\{namespace}\{name}\Eloquent{name}Repository::class' . PHP_EOL .
                    '       );' . PHP_EOL .
                    PHP_EOL .
                    '       $this->app->bind(' . PHP_EOL .
                    '           \App\Repositories\Backend\{namespace}\{name}\{name}RepositoryContract::class,' . PHP_EOL .
                    '           \App\Repositories\Backend\{namespace}\{name}\Eloquent{name}Repository::class' . PHP_EOL .
                    '       );';
            $stub = str_replace('{namespace}', $this->getNamespaceInput(), $stub);
            $stub = str_replace('{name}', $this->getNameInput(), $stub);
            $comment_footer = '	// Replacer';
            
            if (strpos($contents, $comment_header) === false) {
                $contents = str_replace($comment_footer, $comment_header . $stub . $comment_footer, $contents);
                $this->files->put($path, $contents);
            }
            $this->comment('ServiceProvider modified successfully.');
        } else {
            if (parent::fire() !== false){
                $path = $this->laravel['path'] . '/../config/app.php';
                
                // 增加本命名控件的路由
                $contents = $this->files->get($path);
                $replacer = '        // Service Provider Replacer';
                $comment = '        // ' . $this->getNamespaceInput() . ' Require';
                $sutb = '        App\Providers\\' . $this->getNamespaceInput() . 'ServiceProvider::class,';
                
                if (strpos($contents, $comment) === false) {
                    $contents = str_replace($replacer, 
                        $comment . PHP_EOL. 
                        $sutb . PHP_EOL . 
                        $replacer,
                        $contents);
                    $this->files->put($path, $contents);
                }
                $this->comment('AppConfig modified successfully.');
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
        return __DIR__ . '/stubs/service-provider.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace            
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Providers\\';
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
        
        return $this->laravel['path'] . '/' . Str::replaceLast($this->getNameInput(), $this->getNamespaceInput(), str_replace('\\', '/', $name)) . 'ServiceProvider.php';
    }
}
