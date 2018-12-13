<?php namespace Smile\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider {

	/**
	 * The event handler mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		'Smile\Events\Post\PostWasCreated' => [
			'Smile\Handlers\Events\Post\LogCreationActivity',
            'Smile\Handlers\Events\Post\TrackPost',
		],
		'Smile\Events\Post\PostWasVoted'   => [
            'Smile\Handlers\Events\Post\LogVoteActivity',
            'Smile\Handlers\Events\Post\VoteNotification',
        ],
        'Smile\Events\Post\PostWasUnvoted'  => [
            'Smile\Handlers\Events\Post\ClearVoteLogActivity',
        ],
        'Smile\Events\Post\PostWasAccepted'  => [
            'Smile\Handlers\Events\Post\UpdateLogActivity',
        ],
        'Smile\Events\Post\BeforeMediaUpload'  => [
        ],
        // Comments
		'Smile\Events\Comment\CommentWasCreated' => [
            'Smile\Handlers\Events\Comment\LogCreationActivity',
            'Smile\Handlers\Events\Comment\CreateNotification'
        ],
        'Smile\Events\Comment\CommentWasVoted'   => [
        ],
        'Smile\Events\Comment\CommentWasUnvoted'  => [
        ],
		// Users
		'Smile\Events\User\UserWasCreated' => [
            'Smile\Handlers\Events\User\SendConfirmationMail',
            'Smile\Handlers\Events\User\TrackUser',
        ],
        'Smile\Events\User\UserCreatedThroughOAuth' => [
            'Smile\Handlers\Events\User\TrackOAuthUser',
        ],
        'Smile\Events\User\UserWasDeleted' => [
            'Smile\Handlers\Events\User\SendDeletionMail'
        ],
        'Smile\Events\User\UserWasConfirmed' => [
        ]
	];

	/**
	 * Register any other events for your application.
	 *
	 * @param  \Illuminate\Contracts\Events\Dispatcher  $events
	 * @return void
	 */
	public function boot(DispatcherContract $events)
	{
		parent::boot($events);

		//
	}

}
