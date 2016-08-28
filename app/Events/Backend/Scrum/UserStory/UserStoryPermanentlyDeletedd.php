<?php
namespace App\Events\Backend\Scrum\UserStory;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Class UserStoryPermanentlyDeletedd
 * 
 * @package App\Events\Backend\Scrum\UserStory
 */
class UserStoryPermanentlyDeletedd extends Event
{
    use SerializesModels;

    /**
     *
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
