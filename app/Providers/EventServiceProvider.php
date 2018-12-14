<?php

namespace Smile\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \Smile\Events\Post\PostWasCreated::class => [
            \Smile\Handlers\Events\Post\LogCreationActivity::class,
            \Smile\Handlers\Events\Post\TrackPost::class,
        ],
        \Smile\Events\Post\PostWasVoted::class => [
            \Smile\Handlers\Events\Post\LogVoteActivity::class,
            \Smile\Handlers\Events\Post\VoteNotification::class,
        ],
        \Smile\Events\Post\PostWasUnvoted::class => [
            \Smile\Handlers\Events\Post\ClearVoteLogActivity::class,
        ],
        \Smile\Events\Post\PostWasAccepted::class => [
            \Smile\Handlers\Events\Post\UpdateLogActivity::class,
        ],
        \Smile\Events\Post\BeforeMediaUpload::class => [
        ],
        // Comments
        \Smile\Events\Comment\CommentWasCreated::class => [
            \Smile\Handlers\Events\Comment\LogCreationActivity::class,
            \Smile\Handlers\Events\Comment\CreateNotification::class,
        ],
        \Smile\Events\Comment\CommentWasVoted::class => [
        ],
        \Smile\Events\Comment\CommentWasUnvoted::class => [
        ],
        // Users
        \Smile\Events\User\UserWasCreated::class => [
            \Smile\Handlers\Events\User\SendConfirmationMail::class,
            \Smile\Handlers\Events\User\TrackUser::class,
        ],
        \Smile\Events\User\UserCreatedThroughOAuth::class => [
            \Smile\Handlers\Events\User\TrackOAuthUser::class,
        ],
        \Smile\Events\User\UserWasDeleted::class => [
            \Smile\Handlers\Events\User\SendDeletionMail::class,
        ],
        \Smile\Events\User\UserWasConfirmed::class => [
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }

}
