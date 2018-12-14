<?php namespace Smile\Handlers\Events\User;

use Illuminate\Contracts\Queue\ShouldBeQueued;
use Smile\Events\User\UserWasDeleted;

class SendDeletionMail
{

    /**
     * Create the event handler.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserWasDeleted $event
     * @return void
     */
    public function handle(UserWasDeleted $event)
    {
        //
    }

}
