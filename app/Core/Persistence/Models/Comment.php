<?php

namespace Smile\Core\Persistence\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'comments';

    /**
     * Fields that can be filled with data
     *
     * @var array
     */
    protected $fillable = [
        'post_id',
        'user_id',
        'parent_id',
        'message',
        'comments',
        'points',
        'likes',
        'dislikes'
    ];

    /**
     * Retrieve votes for post
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function votes()
    {
        return $this->morphMany('Smile\Core\Persistence\Models\Vote', 'voteable');
    }

    /**
     * Many to many relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function post()
    {
        return $this->belongsTo('Smile\Core\Persistence\Models\Post');
    }

    /**
     * User for the comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Smile\Core\Persistence\Models\User');
    }

    /**
     * Parent comments
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo('Smile\Core\Persistence\Models\Comment', 'parent_id');
    }
    /**
     * Children comments
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany('Smile\Core\Persistence\Models\Comment', 'parent_id')
                    ->orderBy('id', 'desc');
    }

}
