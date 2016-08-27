<?php
namespace App\Providers;

use App\Services\File\File;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

/**
 * Class FileServiceProvider
 * 
 * @package App\Providers
 */
class FileServiceProvider extends ServiceProvider
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
     * Register the vault facade without the media having to add it to the app.php file.
     *
     * @return void
     */
    public function registerFacade()
    {}

    /**
     * Register service provider bindings
     */
    public function registerBindings()
    {
        /**
         * Media Binding
         */
        $this->app->bind(\App\Repositories\Frontend\File\Media\MediaRepositoryContract::class, \App\Repositories\Frontend\File\Media\EloquentMediaRepository::class);
        
        $this->app->bind(\App\Repositories\Backend\File\Media\MediaRepositoryContract::class, \App\Repositories\Backend\File\Media\EloquentMediaRepository::class);
        
        /**
         * Media Binding
         */
        $this->app->bind(\App\Repositories\Frontend\File\Media\MediaRepositoryContract::class, \App\Repositories\Frontend\File\Media\EloquentMediaRepository::class);
        
        $this->app->bind(\App\Repositories\Backend\File\Media\MediaRepositoryContract::class, \App\Repositories\Backend\File\Media\EloquentMediaRepository::class);
        // Replacer
    }

    /**
     * Register the blade extender to use new blade sections
     */
    protected function registerBladeExtensions()
    {}
}