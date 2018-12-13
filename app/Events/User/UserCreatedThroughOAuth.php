<?php

namespace Smile\Events\User;

use Smile\Events\Event;
use Illuminate\Queue\SerializesModels;
use Smile\Core\Persistence\Models\User;

class UserCreatedThroughOAuth extends Event {

    use SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * Create a new event instance.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

}
