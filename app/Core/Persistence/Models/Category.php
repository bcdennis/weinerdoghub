<?php

namespace Smile\Core\Persistence\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Disable timestamps for categories
     *
     * @var bool
     */
    public $timestamps = false;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categories';
    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug',
        'template', 'icon', 'active',
        'description', 'position'
    ];

    /**
     * Many to many with posts
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany('Smile\Core\Persistence\Models\Post');
    }

}