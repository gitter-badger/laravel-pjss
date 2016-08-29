<?php

namespace App\Events\Backend\Scrum\Meeting;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Class MeetingCreated
 * @package App\Events\Backend\Scrum\Meeting
 */
class MeetingCreated extends Event
{
    use SerializesModels;
    
    /**
	 * @var $meeting
	 */
	public $meeting;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($meeting)
	{
		$this->meeting = $meeting;
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
