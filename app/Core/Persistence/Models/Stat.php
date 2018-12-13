<?php

namespace Smile\Core\Persistence\Models;

use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{

    /**
     * Deactivate timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Fields that can be filled during creation or update
     *
     * @var array
     */
    protected $fillable = [
        'key', 'value', 'month', 'year',
    ];

    /**
     * Get month name from number to string
     *
     * @return bool|string
     */
    public function getMonthNameAttribute()
    {
        return date('F', mktime(0, 0, 0, $this->attributes['month'], 10));
    }

}
