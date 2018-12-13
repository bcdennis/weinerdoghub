<?php

namespace Smile\Core\Persistence\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Smile\Core\Persistence\Models\Vote;

trait VoteableTrait
{

    /**
     * Vote post
     *
     * @param Model $model
     * @param Vote $user
     * @param $value
     * @return mixed|void
     */
    public function vote(Model $model, $user, $value)
    {
        $vote = new Vote();
        $vote->user_id = $user;
        $vote->value = $value;

        $model->votes()->save($vote);
    }

    /**
     * Get vote
     *
     * @param Model $model
     * @param int $user
     * @return null|Vote
     */
    public function getVote(Model $model, $user)
    {
        return $model->votes()->where('user_id', $user)->first();
    }

    /**
     * Update votes
     *
     * @param $model
     * @return mixed
     */
    public function updateVotes(Model $model)
    {
        $likes = $model->votes()->where('value', 1)->count('id');
        $dislikes = $model->votes()->where('value', -1)->count('id');

        return $this->update($model, [
            'likes' => $likes,
            'dislikes' => $dislikes,
            'points' => $likes - $dislikes
        ]);
    }

}
