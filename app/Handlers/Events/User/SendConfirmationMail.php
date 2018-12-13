<?php namespace Smile\Handlers\Events\User;

use Illuminate\Contracts\Auth\Guard;
use Smile\Events\User\UserWasCreated;

use Smile\Core\Mailers\UserMailer;
use Smile\Core\Services\UserService;

class SendConfirmationMail {
    /**
     * @var UserMailer
     */
    private $mailer;
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var Guard
     */
    private $auth;

    /**
     * Create the event handler.
     *
     * @param UserMailer $mailer
     * @param UserService $userService
     */
    public function __construct(UserMailer $mailer, UserService $userService, Guard $auth)
    {
        $this->mailer = $mailer;
        $this->userService = $userService;
        $this->auth = $auth;
    }

    /**
     * Handle the event.
     *
     * @param  UserWasCreated  $event
     * @return void
     */
    public function handle(UserWasCreated $event)
    {
        if ( ! canContact()) {
            $this->auth->login($event->user);
            return;
        }

        $user = $this->userService->generateConfirmation($event->user);
        $this->mailer->confirm($user);
    }

}
