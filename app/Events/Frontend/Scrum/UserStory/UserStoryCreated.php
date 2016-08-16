<?php

namespace App\Events\Frontend\Scrum\UserStory;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Class UserStoryCreated
 * @package App\Events\Frontend\Scrum\UserStory
 */
class UserStoryCreated extends Event
{
    use SerializesModels;
    
    /**
	 * @var $userstory
	 */
	public $userstory;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($userstory)
	{
		$this->userstory = $userstory;
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
