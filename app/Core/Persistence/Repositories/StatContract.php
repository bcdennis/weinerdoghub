<?php

namespace Smile\Core\Persistence\Repositories;

use Smile\Core\Persistence\Models\Stat;

interface StatContract
{

    /**
     * Create stat
     *
     * @param $key
     * @param int|null $value
     * @return Stat|static
     */
    public function increment($key, $value = 1);

    /**
     * Get stat info
     *
     * @param $key
     * @param $month
     * @param $year
     * @return Stat
     */
    public function get($key, $month = null, $year = null);

    /**
     * Count the values of a stat
     *
     * @param $key
     * @return integer
     */
    public function count($key);

    /**
     * Get stats from dates range
     *
     * @param $key
     * @param int $months
     * @param int $years
     */
    public function all($key, $months = 0, $years = 0);
}