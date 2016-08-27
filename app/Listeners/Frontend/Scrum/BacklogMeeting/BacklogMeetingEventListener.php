<?php

namespace App\Listeners\Frontend\Scrum\BacklogMeeting;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class BacklogMeetingEventListener
 * @package App\Listeners\Frontend\Scrum\BacklogMeeting
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
			'trans("history.frontend.Scrum.backlogmeetings.created") <strong>'.$event->backlogmeeting->name.'</strong>',
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
			'trans("history.frontend.Scrum.backlogmeetings.updated") <strong>'.$event->backlogmeeting->name.'</strong>',
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
			'trans("history.frontend.Scrum.backlogmeetings.deleted") <strong>'.$event->backlogmeeting->name.'</strong>',
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
			'trans("history.frontend.Scrum.backlogmeetings.restored") <strong>'.$event->backlogmeeting->name.'</strong>',
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
			\App\Events\Frontend\Scrum\BacklogMeeting\BacklogMeetingCreated::class,
			'App\Listeners\Frontend\Scrum\BacklogMeeting\BacklogMeetingEventListener@onCreated'
		);

		$events->listen(
			\App\Events\Frontend\Scrum\BacklogMeeting\BacklogMeetingUpdated::class,
			'App\Listeners\Frontend\Scrum\BacklogMeeting\BacklogMeetingEventListener@onUpdated'
		);

		$events->listen(
			\App\Events\Frontend\Scrum\BacklogMeeting\BacklogMeetingDeleted::class,
			'App\Listeners\Frontend\Scrum\BacklogMeeting\BacklogMeetingEventListener@onDeleted'
		);

		$events->listen(
			\App\Events\Frontend\Scrum\BacklogMeeting\BacklogMeetingRestored::class,
			'App\Listeners\Frontend\Scrum\BacklogMeeting\BacklogMeetingEventListener@onRestored'
		);
	}
}
