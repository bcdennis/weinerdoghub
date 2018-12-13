<?php

namespace Smile\Core\Persistence\Models;

use Illuminate\Database\Eloquent\Model;

class CommentReport extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'comment_reports';

    /**
     * Fields that can be filled during creation or update
     *
     * @var array
     */
    protected $fillable = [
        'comment_id', 'user_id',
    ];

    /**
     * Count other reports for the same reason and post
     *
     * @return static
     */
    public function getOtherAttribute()
    {
        if (isset($this->attributes['other'])) {
            return $this->attributes['other'];
        }

        $reports = $this->newInstance();
        $reports = $reports->where('comment_id', $this->attributes['comment_id'])
            ->where('id', '!=', $this->attributes['id'])
            ->count();

        $this->attributes['other'] = $reports;

        return $reports;
    }


    /**
     * The reported comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comment()
    {
        return $this->belongsTo('Smile\Core\Persistence\Models\Comment');
    }

    /**
     * The user who report
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Smile\Core\Persistence\Models\User');
    }

}
