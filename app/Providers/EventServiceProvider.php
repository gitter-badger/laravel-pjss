<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        //
    ];

	/**
     * Class event subscribers
     * @var array
     */
    protected $subscribe = [
		/**
		 * Frontend Subscribers
		 */

		/**
		 * Auth Subscribers
		 */
		\App\Listeners\Frontend\Auth\UserEventListener::class,
        
        // FrontendReplacer

        /**
    	 * File Subscribers
    	 */        \App\Listeners\Frontend\File\Media\MediaEventListener::class,
        // FileFrontendReplacer
    
        /**
    	 * Scrum Subscribers
    	 */
        \App\Listeners\Frontend\Scrum\UserStory\UserStoryEventListener::class,
        \App\Listeners\Frontend\Scrum\AcceptanceCriteria\AcceptanceCriteriaEventListener::class,
        // ScrumFrontendReplacer

		/**
		 * Backend Subscribers
		 */

		/**
		 * Access Subscribers
		 */
        \App\Listeners\Backend\Access\User\UserEventListener::class,
		\App\Listeners\Backend\Access\Role\RoleEventListener::class,
        
        // BackendReplacer

        /**
    	 * File Subscribers
    	 */        \App\Listeners\Backend\File\Media\MediaEventListener::class,
        // FileBackendReplacer
        
        /**
    	 * Scrum Subscribers
    	 */
        \App\Listeners\Backend\Scrum\UserStory\UserStoryEventListener::class,
        \App\Listeners\Backend\Scrum\AcceptanceCriteria\AcceptanceCriteriaEventListener::class,
        // ScrumBackendReplacer
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
