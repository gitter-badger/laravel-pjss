<?php

namespace App\Listeners\Frontend\Scrum\AcceptanceCriteria;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class AcceptanceCriteriaEventListener
 * @package App\Listeners\Frontend\Scrum\AcceptanceCriteria
 */
class AcceptanceCriteriaEventListener
{
	/**
	 * @var string
	 */
	private $history_slug = 'AcceptanceCriteria';

	/**
	 * @param $event
	 */
	public function onCreated($event) {
		history()->log(
			$this->history_slug,
			'trans("history.frontend.Scrum.acceptancecriterias.created") <strong>'.$event->acceptancecriteria->name.'</strong>',
			$event->acceptancecriteria->id,
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
			'trans("history.frontend.Scrum.acceptancecriterias.updated") <strong>'.$event->acceptancecriteria->name.'</strong>',
			$event->acceptancecriteria->id,
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
			'trans("history.frontend.Scrum.acceptancecriterias.deleted") <strong>'.$event->acceptancecriteria->name.'</strong>',
			$event->acceptancecriteria->id,
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
			'trans("history.frontend.Scrum.acceptancecriterias.restored") <strong>'.$event->acceptancecriteria->name.'</strong>',
			$event->acceptancecriteria->id,
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
			\App\Events\Frontend\Scrum\AcceptanceCriteria\AcceptanceCriteriaCreated::class,
			'App\Listeners\Frontend\Scrum\AcceptanceCriteria\AcceptanceCriteriaEventListener@onCreated'
		);

		$events->listen(
			\App\Events\Frontend\Scrum\AcceptanceCriteria\AcceptanceCriteriaUpdated::class,
			'App\Listeners\Frontend\Scrum\AcceptanceCriteria\AcceptanceCriteriaEventListener@onUpdated'
		);

		$events->listen(
			\App\Events\Frontend\Scrum\AcceptanceCriteria\AcceptanceCriteriaDeleted::class,
			'App\Listeners\Frontend\Scrum\AcceptanceCriteria\AcceptanceCriteriaEventListener@onDeleted'
		);

		$events->listen(
			\App\Events\Frontend\Scrum\AcceptanceCriteria\AcceptanceCriteriaRestored::class,
			'App\Listeners\Frontend\Scrum\AcceptanceCriteria\AcceptanceCriteriaEventListener@onRestored'
		);
	}
}
