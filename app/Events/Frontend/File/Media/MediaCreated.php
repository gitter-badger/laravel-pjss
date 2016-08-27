<?php

namespace App\Events\Frontend\File\Media;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Class MediaCreated
 * @package App\Events\Frontend\File\Media
 */
class MediaCreated extends Event
{
    use SerializesModels;
    
    /**
	 * @var $media
	 */
	public $media;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($media)
	{
		$this->media = $media;
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
