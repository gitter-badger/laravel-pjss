<?php

namespace App\Listeners\Backend\Scrum\BacklogMeeting;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class BacklogMeetingEventListener
 * @package App\Listeners\Backend\Scrum\BacklogMeeting
 */
class BacklogMeetingEventListener
{
	/**
	 * @var string
	 */
	private $history_slug = 'BacklogMeeting';

	/**
	 * @param $event
	 */
	public function onCreated($event) {
		history()->log(
			$this->history_slug,
			'trans("history.backend.Scrum.backlogmeetings.created") <strong>'.$event->backlogmeeting->name.'</strong>',
			$event->backlogmeeting->id,
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
			'trans("history.backend.Scrum.backlogmeetings.updated") <strong>'.$event->backlogmeeting->name.'</strong>',
			$event->backlogmeeting->id,
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
			'trans("history.backend.Scrum.backlogmeetings.deleted") <strong>'.$event->backlogmeeting->name.'</strong>',
			$event->backlogmeeting->id,
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
			'trans("history.backend.Scrum.backlogmeetings.restored") <strong>'.$event->backlogmeeting->name.'</strong>',
			$event->backlogmeeting->id,
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
			\App\Events\Backend\Scrum\BacklogMeeting\BacklogMeetingCreated::class,
			'App\Listeners\Backend\Scrum\BacklogMeeting\BacklogMeetingEventListener@onCreated'
		);

		$events->listen(
			\App\Events\Backend\Scrum\BacklogMeeting\BacklogMeetingUpdated::class,
			'App\Listeners\Backend\Scrum\BacklogMeeting\BacklogMeetingEventListener@onUpdated'
		);

		$events->listen(
			\App\Events\Backend\Scrum\BacklogMeeting\BacklogMeetingDeleted::class,
			'App\Listeners\Backend\Scrum\BacklogMeeting\BacklogMeetingEventListener@onDeleted'
		);

		$events->listen(
			\App\Events\Backend\Scrum\BacklogMeeting\BacklogMeetingRestored::class,
			'App\Listeners\Backend\Scrum\BacklogMeeting\BacklogMeetingEventListener@onRestored'
		);
	}
}
