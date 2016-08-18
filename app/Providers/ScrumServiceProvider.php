<?php

namespace App\Providers;

use App\Services\Scrum\Scrum;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

/**
 * Class ScrumServiceProvider
 * @package App\Providers
 */
class ScrumServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Package boot method
     */
    public function boot()
    {
        $this->registerBladeExtensions();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerFacade();
        $this->registerBindings();
    }

    /**
     * Register the vault facade without the userstory having to add it to the app.php file.
     *
     * @return void
     */
    public function registerFacade()
    {
        
    }

    /**
     * Register service provider bindings
     */
    public function registerBindings()
    {
    	/**
    	 * UserStory Binding
    	 */
        $this->app->bind(
            \App\Repositories\Frontend\Scrum\UserStory\UserStoryRepositoryContract::class,
            \App\Repositories\Frontend\Scrum\UserStory\EloquentUserStoryRepository::class
        );

        $this->app->bind(
            \App\Repositories\Backend\Scrum\UserStory\UserStoryRepositoryContract::class,
            \App\Repositories\Backend\Scrum\UserStory\EloquentUserStoryRepository::class
        );
        
        // Replacer
    }

    /**
     * Register the blade extender to use new blade sections
     */
    protected function registerBladeExtensions()
    {
        
    }
}