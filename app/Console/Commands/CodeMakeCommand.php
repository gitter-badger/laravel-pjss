<?php
namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CodeMakeCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:pjss-code {namespace} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create projectsaas code';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = '';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        // 实体
        $this->call('make:pjss-model', [
            'namespace' => $this->getNamespaceInput(),
            'name' => $this->getNameInput()
        ]);
        
        // 后台控制器
        $this->call('make:pjss-controller', [
            'namespace' => $this->getNamespaceInput(),
            'name' => $this->getNameInput()
        ]);
        // 前台控制器
        $this->call('make:pjss-controller', [
            'namespace' => $this->getNamespaceInput(),
            'name' => $this->getNameInput(),
            '--frontend' => '--frontend'
        ]);
    }

    /**
     * Get the desired namespace name from the input.
     *
     * @return string
     */
    protected function getNamespaceInput()
    {
        return trim($this->argument('namespace'));
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return trim($this->argument('name'));
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
        ];
    }
}
