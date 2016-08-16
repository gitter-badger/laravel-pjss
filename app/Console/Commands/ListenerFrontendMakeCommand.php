<?php
namespace App\Console\Commands;

use Illuminate\Support\Str;
use App\Console\Commands\GeneratorCommand;

class ListenerFrontendMakeCommand extends GeneratorCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:pjss-listener-frontend {namespace} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new listener class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Listener';
    
    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        if (parent::fire() !== false) {
            // 修改Providers/EventServiceProvider.php
            $replace_comment_header = str_replace('{namespace}', $this->getNamespaceInput(),'// FrontendReplacer
    
        /**
    	 * {namespace} Subscribers
    	 */');
    
            $replace = '
        \App\Listeners\Frontend\{namespace}\{name}\{name}EventListener::class,
        ';
            $replace = str_replace('{namespace}', $this->getNamespaceInput(),$replace);
            $replace = str_replace('{name}', $this->getNameInput(),$replace);
    
            $replace_comment_footer = str_replace('{namespace}', $this->getNamespaceInput(),'// {namespace}FrontendReplacer');
    
            $path = $this->laravel['path'] . '/Providers/EventServiceProvider.php';
            $contents = $this->files->get($path);
            $index = strpos($contents, $replace);
            if ($index === false){
                $index = strpos($contents, $replace_comment_footer);
                if ($index === false) {
                    $contents = str_replace('// FrontendReplacer', $replace_comment_header . $replace . $replace_comment_footer, $contents);
                } else {
                    $contents = str_replace($replace_comment_footer, $replace . $replace_comment_footer, $contents);
                }
                $this->files->put($path, $contents);
                $this->comment('EventServiceProvider modified successfully.');
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
        return __DIR__ . '/stubs/listener-frontend.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace            
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Listeners\Frontend' . '\\' . $this->getNamespaceInput() . '\\' . $this->getNameInput();
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
        
        return $this->laravel['path'] . '/' . str_replace('\\', '/', $name) . 'EventListener.php';
    }
}
