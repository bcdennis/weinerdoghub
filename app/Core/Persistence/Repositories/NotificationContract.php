<?php

namespace Smile\Core\Persistence\Repositories;

use Smile\Core\Persistence\Models\Notification;
use Smile\Core\Persistence\Models\User;

interface NotificationContract
{

    /**
     * Find notification by id
     *
     * @param $id
     * @return Notification|null
     */
    public function findById($id);

    /**
     * Create notification
     *
     * @param array $data
     * @return Notification
     */
    public function create(array $data);

    /**
     * Update notification
     *
     * @param Notification $notification
     * @param array $data
     * @return Notification
     */
    public function update(Notification $notification, array $data);

    /**
     * Count unread notifications
     *
     * @param User $user
     * @return int
     */
    public function countUnOpened(User $user);

    /**
     * Get notifications
     *
     * @param User|null $user
     * @param int $perPage
     * @return mixed
     */
    public function search(User $user = null, $perPage = 5);

    /**
     * Delete notification
     *
     * @param $notification
     * @return mixed
     */
    public function delete(Notification $notification);

    /**
     * Delete all the notifications
     *
     * @param User $currentUser
     * @return mixed
     */
    public function deleteAll(User $currentUser);

}
