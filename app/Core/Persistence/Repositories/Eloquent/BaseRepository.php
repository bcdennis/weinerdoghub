<?php

namespace Smile\Core\Persistence\Repositories\Eloquent;

use Closure;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * Creates a new instance of the current model
     *
     * @param array $args
     * @return Model
     */
    public function getNew(array $args = [])
    {
        return $this->model->newInstance($args);
    }

    /**
     * Creates a new transaction
     *
     * @param Closure $callback
     * @return mixed
     */
    public function transaction(closure $callback)
    {
        return app('db')->transaction($callback);
    }


    /**
     * Escape raw string
     *
     * @param $str
     * @return mixed
     */
    protected function escape($str)
    {
        return trim(app('db')->getPdo()->quote($str), '\'');
    }

}
