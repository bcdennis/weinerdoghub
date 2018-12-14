<?php namespace Smile\Handlers\Events\User;

use Smile\Core\Persistence\Repositories\StatContract;
use Smile\Events\User\UserWasCreated;

class TrackUser
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
     * @param  UserWasCreated $event
     * @return void
     */
    public function handle(UserWasCreated $event)
    {
        $this->stat->increment('users');
    }

}
