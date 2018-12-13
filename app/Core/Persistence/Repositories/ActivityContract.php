<?php

namespace Smile\Core\Persistence\Repositories;

use Smile\Core\Persistence\Models\Activity;
use Smile\Core\Persistence\Models\Post;
use Smile\Core\Persistence\Models\User;

interface ActivityContract
{

    /**
     * Create a new activity
     *
     * @param User $user
     * @param Post $post
     * @param $eventName
     * @return Activity
     */
    public function create(User $user, Post $post, $eventName);

    /**
     * Find activities by user id
     *
     * @param User $user
     * @param $eventName
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function findByUser(User $user, $eventName, $perPage = 10);

    /**
     * Count activities by user and event name
     *
     * @param User $user
     * @param $eventName
     * @return mixed
     */
    public function countActivities(User $user, $eventName);

    /**
     * @param User $user
     * @param Post $post
     * @param $eventName
     * @return mixed
     */
    public function deleteByComposite(User $user, Post $post, $eventName);

}