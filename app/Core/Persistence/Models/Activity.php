<?php

namespace Smile\Core\Persistence\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'activities';

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = ['post_id', 'user_id', 'eventName'];

    /**
     * Get user that made the activity
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Smile\Core\Persistence\Models\User');
    }

    /**
     * Get the post data for the activity
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo('Smile\Core\Persistence\Models\Post');
    }

}