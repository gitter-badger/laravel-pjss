<?php
namespace App\Listeners\Backend\File\Media;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class MediaEventListener
 * 
 * @package App\Listeners\Backend\File\Media
 */
class MediaEventListener
{

    /**
     *
     * @var string
     */
    private $history_slug = 'Media';

    /**
     *
     * @param
     *            $event
     */
    public function onCreated($event)
    {
        history()->log($this->history_slug, 'trans("history.backend.File.media.created") <strong>' . $event->media->name . '</strong>', $event->media->id, 'plus', 'bg-green');
    }

    /**
     *
     * @param
     *            $event
     */
    public function onUpdated($event)
    {
        history()->log($this->history_slug, 'trans("history.backend.File.media.updated") <strong>' . $event->media->name . '</strong>', $event->media->id, 'save', 'bg-aqua');
    }

    /**
     *
     * @param
     *            $event
     */
    public function onDeleted($event)
    {
        history()->log($this->history_slug, 'trans("history.backend.File.media.deleted") <strong>' . $event->media->name . '</strong>', $event->media->id, 'trash', 'bg-maroon');
    }

    /**
     *
     * @param
     *            $event
     */
    public function onRestored($event)
    {
        history()->log($this->history_slug, 'trans("history.backend.File.media.restored") <strong>' . $event->media->name . '</strong>', $event->media->id, 'refresh', 'bg-aqua');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events            
     */
    public function subscribe($events)
    {
        $events->listen(\App\Events\Backend\File\Media\MediaCreated::class, 'App\Listeners\Backend\File\Media\MediaEventListener@onCreated');
        
        $events->listen(\App\Events\Backend\File\Media\MediaUpdated::class, 'App\Listeners\Backend\File\Media\MediaEventListener@onUpdated');
        
        $events->listen(\App\Events\Backend\File\Media\MediaDeleted::class, 'App\Listeners\Backend\File\Media\MediaEventListener@onDeleted');
        
        $events->listen(\App\Events\Backend\File\Media\MediaRestored::class, 'App\Listeners\Backend\File\Media\MediaEventListener@onRestored');
    }
}
