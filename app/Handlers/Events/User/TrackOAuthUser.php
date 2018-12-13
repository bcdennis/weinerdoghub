<?php namespace Smile\Handlers\Events\User;

use Smile\Events\User\UserCreatedThroughOAuth;

use Smile\Core\Persistence\Repositories\StatContract;

class TrackOAuthUser {

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
     * @param UserCreatedThroughOAuth $event
     */
    public function handle(UserCreatedThroughOAuth $event)
    {
        $this->stat->increment('users');
    }

}
