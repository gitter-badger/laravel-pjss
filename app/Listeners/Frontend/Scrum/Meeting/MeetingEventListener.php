<?php

namespace App\Listeners\Frontend\Scrum\Meeting;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class MeetingEventListener
 * @package App\Listeners\Frontend\Scrum\Meeting
 */
class MeetingEventListener
{
	/**
	 * @var string
	 */
	private $history_slug = 'Meeting';

	/**
	 * @param $event
	 */
	public function onCreated($event) {
		history()->log(
			$this->history_slug,
			'trans("history.frontend.Scrum.meetings.created") <strong>'.$event->meeting->name.'</strong>',
			$event->meeting->id,
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
			'trans("history.frontend.Scrum.meetings.updated") <strong>'.$event->meeting->name.'</strong>',
			$event->meeting->id,
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
			'trans("history.frontend.Scrum.meetings.deleted") <strong>'.$event->meeting->name.'</strong>',
			$event->meeting->id,
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
			'trans("history.frontend.Scrum.meetings.restored") <strong>'.$event->meeting->name.'</strong>',
			$event->meeting->id,
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
			\App\Events\Frontend\Scrum\Meeting\MeetingCreated::class,
			'App\Listeners\Frontend\Scrum\Meeting\MeetingEventListener@onCreated'
		);

		$events->listen(
			\App\Events\Frontend\Scrum\Meeting\MeetingUpdated::class,
			'App\Listeners\Frontend\Scrum\Meeting\MeetingEventListener@onUpdated'
		);

		$events->listen(
			\App\Events\Frontend\Scrum\Meeting\MeetingDeleted::class,
			'App\Listeners\Frontend\Scrum\Meeting\MeetingEventListener@onDeleted'
		);

		$events->listen(
			\App\Events\Frontend\Scrum\Meeting\MeetingRestored::class,
			'App\Listeners\Frontend\Scrum\Meeting\MeetingEventListener@onRestored'
		);
	}
}
