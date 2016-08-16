<?php

namespace App\Listeners\Frontend\Scrum\UserStory;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class UserStoryEventListener
 * @package App\Listeners\Frontend\Scrum\UserStory
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
			'trans("history.frontend.userstories.created") <strong>'.$event->userstory->name.'</strong>',
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
			'trans("history.frontend.userstories.updated") <strong>'.$event->userstory->name.'</strong>',
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
			'trans("history.frontend.userstories.deleted") <strong>'.$event->userstory->name.'</strong>',
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
			'trans("history.frontend.userstories.restored") <strong>'.$event->userstory->name.'</strong>',
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
			\App\Events\Frontend\Scrum\UserStory\UserStoryCreated::class,
			'App\Listeners\Frontend\Scrum\UserStory\UserStoryEventListener@onCreated'
		);

		$events->listen(
			\App\Events\Frontend\Scrum\UserStory\UserStoryUpdated::class,
			'App\Listeners\Frontend\Scrum\UserStory\UserStoryEventListener@onUpdated'
		);

		$events->listen(
			\App\Events\Frontend\Scrum\UserStory\UserStoryDeleted::class,
			'App\Listeners\Frontend\Scrum\UserStory\UserStoryEventListener@onDeleted'
		);

		$events->listen(
			\App\Events\Frontend\Scrum\UserStory\UserStoryRestored::class,
			'App\Listeners\Frontend\Scrum\UserStory\UserStoryEventListener@onRestored'
		);
	}
}
