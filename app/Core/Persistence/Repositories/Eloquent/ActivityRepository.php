<?php

namespace Smile\Core\Persistence\Repositories\Eloquent;

use Smile\Core\Persistence\Models\Activity;
use Smile\Core\Persistence\Models\Post;
use Smile\Core\Persistence\Models\User;
use Smile\Core\Persistence\Repositories\ActivityContract;

class ActivityRepository extends BaseRepository implements ActivityContract
{
	/**
	 * @param Activity $model
	 */
	public function __construct(Activity $model)
	{
		$this->model = $model;
	}

    /**
     * Create a new activity
     *
     * @param User $user
     * @param Post $post
     * @param $eventName
     * @return Activity
     */
    public function create(User $user, Post $post, $eventName)
	{
		return $this->model->create([
			'user_id' => $user->id,
            'post_id' => $post->id,
            'eventName' => $eventName
		]);
	}

    /**
     * Find activities by user id
     *
     * @param User $user
     * @param null $eventName
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function findByUser(User $user, $eventName = null, $perPage = 10)
    {
        $activities = $this->model->with(['post', 'user'])
            ->whereHas('post', function ($q) {
                $q->where('accepted', true);
            })
            ->where('user_id', $user->id);

        if ( ! is_null($eventName)) {
            $eventName = $this->compileWildcard($eventName);
            $activities = $activities->where('eventName', 'like', $eventName);
        }

        $activities = $activities->orderBy('id', 'desc');

        return $activities->paginate($perPage);
    }

    /**
     * Count activities by user and event name
     *
     * @param User $user
     * @param $eventName
     * @return mixed
     */
    public function countActivities(User $user, $eventName)
    {
        $activity = $this->model->where('user_id', $user->id)
                    ->where('eventName', $eventName);

        return $activity->count();
    }

    /**
     * @param User $user
     * @param Post $post
     * @param $eventName
     * @return mixed
     */
    public function deleteByComposite(User $user, Post $post, $eventName)
    {
        $activity = $this->model->where('user_id', $user->id)
            ->where('post_id', $post->id)
            ->where('eventName', 'like', $this->compileWildcard($eventName));

        return $activity->delete();
    }

    /**
     * Compile wildcard strings
     *
     * @param $name
     * @return mixed
     */
    protected function compileWildcard($name)
    {
        return str_replace('*', '%', $name);
    }

}