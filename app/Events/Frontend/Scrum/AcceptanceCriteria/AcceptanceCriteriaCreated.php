<?php
namespace App\Events\Frontend\Scrum\AcceptanceCriteria;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Class AcceptanceCriteriaCreated
 * 
 * @package App\Events\Frontend\Scrum\AcceptanceCriteria
 */
class AcceptanceCriteriaCreated extends Event
{
    use SerializesModels;

    /**
     *
     * @var $acceptancecriteria
     */
    public $acceptancecriteria;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($acceptancecriteria)
    {
        $this->acceptancecriteria = $acceptancecriteria;
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
