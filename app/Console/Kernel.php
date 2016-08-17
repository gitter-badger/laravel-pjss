<?php
namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * Class Kernel
 * 
 * @package App\Console
 */
class Kernel extends ConsoleKernel
{

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
        Commands\CodeMakeCommand::class,
        
        Commands\ModelMakeCommand::class,
        Commands\RepositoryBackendMakeCommand::class,
        Commands\RepositoryFrontendMakeCommand::class,
        Commands\EloquentRepositoryBackendMakeCommand::class,
        Commands\EloquentRepositoryFrontendMakeCommand::class,
        Commands\EventBackendMakeCommand::class,
        Commands\EventFrontendMakeCommand::class,
        Commands\ListenerBackendMakeCommand::class,
        Commands\ListenerFrontendMakeCommand::class,
        Commands\ServiceProviderMakeCommand::class,
        
        Commands\ControllerBackendMakeCommand::class,
        Commands\ControllerFrontendMakeCommand::class,
        Commands\ViewBackendMakeCommand::class,
        Commands\ViewFrontendMakeCommand::class,
        Commands\BreadcrumbBackendMakeCommand::class,
        Commands\BreadcrumbRequireBackendMakeCommand::class,
        Commands\RequestBackendMakeCommand::class,
        Commands\RequestFrontendMakeCommand::class,
        Commands\RouteBackendMakeCommand::class,
        Commands\RouteFrontendMakeCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule            
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
    
    /**
     * Laravel Backup Commands
     */
        // $schedule->command('backup:clean')->daily()->at('01:00');
        // $schedule->command('backup:run')->daily()->at('02:00');
    }
}
