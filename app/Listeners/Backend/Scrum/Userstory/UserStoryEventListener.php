<?php

namespace App\Listeners\Backend\Scrum\UserStory;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class UserStoryEventListener
 * @package App\Listeners\Backend\Scrum\UserStory
 */
class UserStoryEventListener
{
	/**
	 * @var string
	 */
	private $history_slug = 'UserStory';

	/**
	 * @param $event
	 */
	public function onCreated($event) {
		history()->log(
			$this->history_slug,
			'trans("history.backend.Scrum.userstories.created") <strong>'.$event->userstory->name.'</strong>',
			$event->userstory->id,
			'plus',
			'bg-green'
		);
	}

	/**
	 * @param $event
	 */
	public function onUpdated($event) {
		history()->log(
			$this->history_slug,
			'trans("history.backend.Scrum.userstories.updated") <strong>'.$event->userstory->name.'</strong>',
			$event->userstory->id,
			'save',
			'bg-aqua'
		);
	}

	/**
	 * @param $event
	 */
	public function onDeleted($event) {
		history()->log(
			$this->history_slug,
			'trans("history.backend.Scrum.userstories.deleted") <strong>'.$event->userstory->name.'</strong>',
			$event->userstory->id,
			'trash',
			'bg-maroon'
		);
	}

	/**
	 * @param $event
	 */
	public function onRestored($event) {
		history()->log(
			$this->history_slug,
			'trans("history.backend.Scrum.userstories.restored") <strong>'.$event->userstory->name.'</strong>',
			$event->userstory->id,
			'refresh',
			'bg-aqua'
		);
	}

	/**
	 * Register the listeners for the subscriber.
	 *
	 * @param  \Illuminate\Events\Dispatcher  $events
	 */
	public function subscribe($events)
	{
		$events->listen(
			\App\Events\Backend\Scrum\UserStory\UserStoryCreated::class,
			'App\Listeners\Backend\Scrum\UserStory\UserStoryEventListener@onCreated'
		);

		$events->listen(
			\App\Events\Backend\Scrum\UserStory\UserStoryUpdated::class,
			'App\Listeners\Backend\Scrum\UserStory\UserStoryEventListener@onUpdated'
		);

		$events->listen(
			\App\Events\Backend\Scrum\UserStory\UserStoryDeleted::class,
			'App\Listeners\Backend\Scrum\UserStory\UserStoryEventListener@onDeleted'
		);

		$events->listen(
			\App\Events\Backend\Scrum\UserStory\UserStoryRestored::class,
			'App\Listeners\Backend\Scrum\UserStory\UserStoryEventListener@onRestored'
		);
	}
}
