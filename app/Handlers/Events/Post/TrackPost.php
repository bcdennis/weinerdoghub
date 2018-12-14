<?php namespace Smile\Handlers\Events\Post;

use Smile\Core\Persistence\Repositories\StatContract;
use Smile\Events\Post\PostWasCreated;

class TrackPost
{
    /**
     * @var StatContract
     */
    private $stat;

    /**
     * Create the event handler.
     *
     * @param StatContract $stat
     */
    public function __construct(StatContract $stat)
    {
        $this->stat = $stat;
    }

    /**
     * Handle the event.
     *
     * @param  PostWasCreated $event
     * @return void
     */
    public function handle(PostWasCreated $event)
    {
        $this->stat->increment('posts');
    }

}
