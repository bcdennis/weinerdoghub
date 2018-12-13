<?php

namespace Smile\Core\Persistence\Repositories\Eloquent;

use Smile\Core\Persistence\Models\Vote;
use Smile\Core\Persistence\Repositories\VoteContract;

class VoteRepository extends BaseRepository implements VoteContract
{
	/**
	 * @param Vote $model
	 */
	public function __construct(Vote $model)
	{
		$this->model = $model;
	}

	/**
	 * Get new vote object
	 *
	 * @param $user
	 * @param $value
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function newObject($user, $value)
	{
		$vote = $this->getNew();
		$vote->user_id = $user;
		$vote->value = $value;

		return $vote;
	}

	/**
	 * Delete vote model
	 *
	 * @param $vote
	 * @return mixed
	 */
	public function delete(Vote $vote)
	{
		return $vote->delete();
	}

	/**
	 * Update vote value
	 *
	 * @param Vote $vote
	 * @param $value
	 * @return Vote
	 */
	public function update(Vote $vote, $value)
	{
		$vote->fill(['value' => $value]);
		$vote->save();

		return $vote;
	}
}