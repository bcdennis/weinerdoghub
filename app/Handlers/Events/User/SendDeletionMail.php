<?php namespace Smile\Handlers\Events\User;

use Smile\Events\User\UserWasDeleted;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class SendDeletionMail {

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
	 * @param  UserWasDeleted  $event
	 * @return void
	 */
	public function handle(UserWasDeleted $event)
	{
		//
	}

}
