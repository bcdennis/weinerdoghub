<?php

namespace Smile\Core\Persistence\Repositories\Eloquent;

use Smile\Core\Persistence\Models\Notification;
use Smile\Core\Persistence\Models\User;
use Smile\Core\Persistence\Repositories\NotificationContract;

class NotificationRepository extends BaseRepository implements NotificationContract
{
    /**
     * @param Notification $model
     */
    public function __construct(Notification $model)
    {
        $this->model = $model;
    }

    /**
     * Create a new notification
     *
     * @param array $data
     * @return Notification
     */
    public function create(array $data)
    {
        $notification = $this->getNew();
        $notification->fill($data);
        $notification->save();

        return $notification;
    }

    /**
     * Update notification
     *
     * @param Notification $notification
     * @param array $data
     * @return Notification
     */
    public function update(Notification $notification, array $data)
    {
        $notification->fill($data);
        $notification->save();

        return $notification;
    }

    /**
     * Delete notification
     *
     * @param Notification $notification
     * @return bool|null
     * @throws \Exception
     */
    public function delete(Notification $notification)
    {
        return $notification->delete();
    }

    /**
     * Delete all the notifications
     *
     * @param User $user
     * @return mixed|void
     */
    public function deleteAll(User $user)
    {
        return $this->model->where('user_id', $user->id)->delete();
    }

    /**
     * Find notification by id
     *
     * @param $id
     * @return null|Notification
     */
    public function findById($id)
    {
        return $this->model->where('id', $id)->first();
    }

    /**
     * Get notifications
     *
     * @param User|null $user
     * @param int $perPage
     * @return mixed
     */
    public function search(User $user = null, $perPage = 5)
    {
        return $this->model->with('from')
            ->where('user_id', $user ? $user->id : null)
            ->where('opened', 0)
            ->orderBy('id', 'desc')
            ->paginate($perPage);
    }

    /**
     * Count unread notifications
     *
     * @param User $user
     * @return int
     */
    public function countUnOpened(User $user = null)
    {
        return $this->model->where('user_id', $user ? $user->id : null)
            ->where('opened', 0)
            ->count();
    }

}
