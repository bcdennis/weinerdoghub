<?php

namespace Smile\Core\Persistence\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{

    /**
     * Fields that can be filled during creation or update
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'title', 'slug',
        'media', 'thumbnail', 'featured', 'safe',
        'source', 'type', 'resized', 'comments',
        'likes', 'dislikes', 'points', 'pinned', 'description',
        'accepted', 'views', 'parent_id', 'position'
    ];

    /**
     * One to one relation with post
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function post()
    {
        return $this->hasOne('Smile\Core\Persistence\Models\Post');
    }

    /**
     * List items
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany('Smile\Core\Persistence\Models\Post', 'parent_id');
    }

    /**
     * Relationship with user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Smile\Core\Persistence\Models\User');
    }

    /**
     * Post categories
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany('Smile\Core\Persistence\Models\Category');
    }

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
     * Order by random scope
     *
     * @param $query
     * @return mixed
     */
    public function scopeRandom($query)
    {
        return $query->orderBy(DB::raw('RAND()'));
    }

}
