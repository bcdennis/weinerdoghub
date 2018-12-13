<?php namespace Smile\Handlers\Events\Post;

use Smile\Events\Post\PostWasCreated;
use Smile\Core\Persistence\Repositories\StatContract;

class TrackPost {
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
	 * @param  PostWasCreated  $event
	 * @return void
	 */
	public function handle(PostWasCreated $event)
	{
		$this->stat->increment('posts');
	}

}
