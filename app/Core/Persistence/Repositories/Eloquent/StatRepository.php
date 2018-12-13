<?php

namespace Smile\Core\Persistence\Repositories\Eloquent;

use Carbon\Carbon;
use Smile\Core\Persistence\Models\Stat;
use Smile\Core\Persistence\Repositories\StatContract;

class StatRepository extends BaseRepository implements StatContract
{
    /**
     * @param Stat $model
     */
    public function __construct(Stat $model)
    {
        $this->model = $model;
    }

    /**
     * @param $key
     * @param $value
     * @param $month
     * @param $year
     * @return Stat
     */
    public function create($key, $value, $month, $year)
    {
        return $this->model->create([
            'key' => $key,
            'value' => $value,
            'month' => $month,
            'year' => $year,
        ]);
    }

    /**
     * Create stat
     *
     * @param $key
     * @param int|null $value
     * @return Stat|static
     */
    public function increment($key, $value = 1)
    {
        $carbon = Carbon::now();

        $stat = $this->model->firstOrCreate([
            'key' => $key,
            'month' => $carbon->month,
            'year' => $carbon->year,
        ]);
        $stat->value += $value;
        $stat->save();

        return $stat;
    }

    /**
     * Get stat info
     *
     * @param $key
     * @param $month
     * @param $year
     * @return Stat
     */
    public function get($key, $month = null, $year = null)
    {
        $carbon = Carbon::now();

        if ($month < 0) {
            $carbon = $carbon->subMonthNoOverflow(-1 * $month);
            $month = $carbon->month;
            $year = $carbon->year;
        }

        if ( ! $month || ! $year) {
            $month = $carbon->month;
            $year = $carbon->year;
        }

        $stat = $this->model->where('key', $key)
                            ->where('month', $month)
                            ->where('year', $year);

        $stat = $stat->first();

        if ( ! $stat) {
            $stat = $this->create($key, 0, $month, $year);
        }

        return $stat;
    }


    /**
     * Count the values of a stat
     *
     * @param $key
     * @return integer
     */
    public function count($key)
    {
        return $this->model->where('key', $key)->sum('value');
    }

    /**
     * Get stats from dates range
     *
     * @param $key
     * @param int $months
     * @param int $years
     */
    public function all($key, $months = 0, $years = 0)
    {
        $carbon = Carbon::now()->subMonthNoOverflow($months)->subYears($years);
        $stats = $this->model->where('key', $key);

        if ($months > 0 && $years > 0) {
            $stats->where(function ($query) use ($carbon) {
                $query->where(function ($query) use ($carbon) {
                    $query->where('year', $carbon->year);
                    $query->where('month', '>=', $carbon->month);
                });
                $query->orWhere('year', '>', $carbon->year);
            });

        }

        return $stats->orderBy('year', 'asc')->orderBy('month', 'asc')->get();
    }

}

