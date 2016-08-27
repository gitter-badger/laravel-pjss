<?php

namespace App\Events\Frontend\Scrum\BacklogMeeting;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Class BacklogMeetingRestored
 * @package App\Events\Frontend\Scrum\BacklogMeeting
 */
class BacklogMeetingRestored extends Event
{
    use SerializesModels;
    
    /**
	 * @var $backlogmeeting
	 */
	public $backlogmeeting;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($backlogmeeting)
	{
		$this->backlogmeeting = $backlogmeeting;
	}

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
