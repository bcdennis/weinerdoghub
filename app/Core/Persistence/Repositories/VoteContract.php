<?php

namespace Smile\Core\Persistence\Repositories;

use Smile\Core\Persistence\Models\User;
use Smile\Core\Persistence\Models\Vote;

interface VoteContract
{

	/**
	 * Creates a new vote object
	 *
	 * @param $user
	 * @param $value
	 * @return mixed
	 */
	public function newObject($user, $value);

	/**
	 * Delete vote model
	 *
	 * @param $vote
	 * @return mixed
	 */
	public function delete(Vote $vote);

	/**
	 * Update vote value
	 *
	 * @param Vote $vote
	 * @param $value
	 * @return mixed
	 */
	public function update(Vote $vote, $value);
}