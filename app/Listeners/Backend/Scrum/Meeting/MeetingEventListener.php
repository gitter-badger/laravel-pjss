<?php

namespace App\Listeners\Backend\Scrum\Meeting;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class MeetingEventListener
 * @package App\Listeners\Backend\Scrum\Meeting
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
			'trans("history.backend.Scrum.meetings.created") <strong>'.$event->meeting->name.'</strong>',
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
			'trans("history.backend.Scrum.meetings.updated") <strong>'.$event->meeting->name.'</strong>',
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
			'trans("history.backend.Scrum.meetings.deleted") <strong>'.$event->meeting->name.'</strong>',
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
			'trans("history.backend.Scrum.meetings.restored") <strong>'.$event->meeting->name.'</strong>',
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
			\App\Events\Backend\Scrum\Meeting\MeetingCreated::class,
			'App\Listeners\Backend\Scrum\Meeting\MeetingEventListener@onCreated'
		);

		$events->listen(
			\App\Events\Backend\Scrum\Meeting\MeetingUpdated::class,
			'App\Listeners\Backend\Scrum\Meeting\MeetingEventListener@onUpdated'
		);

		$events->listen(
			\App\Events\Backend\Scrum\Meeting\MeetingDeleted::class,
			'App\Listeners\Backend\Scrum\Meeting\MeetingEventListener@onDeleted'
		);

		$events->listen(
			\App\Events\Backend\Scrum\Meeting\MeetingRestored::class,
			'App\Listeners\Backend\Scrum\Meeting\MeetingEventListener@onRestored'
		);
	}
}
