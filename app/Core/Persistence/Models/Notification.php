<?php

namespace Smile\Core\Persistence\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    /**
     * Fields that can be filled during creation or update
     *
     * @var array
     */
    protected $fillable = [
        'from_id', 'user_id', 'type', 'url', 'opened',
    ];

    /**
     * Get from user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function from()
    {
        return $this->belongsTo('Smile\Core\Persistence\Models\User', 'from_id');
    }
}
