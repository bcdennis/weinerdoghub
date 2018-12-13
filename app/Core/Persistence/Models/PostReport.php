<?php

namespace Smile\Core\Persistence\Models;

use Illuminate\Database\Eloquent\Model;

class PostReport extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'post_reports';

    /**
     * Fields that can be filled during creation or update
     *
     * @var array
     */
    protected $fillable = [
        'post_id', 'user_id', 'reason',
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
        $reports = $reports->where('post_id', $this->attributes['post_id'])
                         ->where('reason', $this->attributes['reason'])
                         ->where('id', '!=', $this->attributes['id'])
                         ->count();

        $this->attributes['other'] = $reports;

        return $reports;
    }

    /**
     * Reported post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo('Smile\Core\Persistence\Models\Post');
    }

    /**
     * The report user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Smile\Core\Persistence\Models\User');
    }

}
