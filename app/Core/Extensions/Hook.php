<?php

namespace Smile\Core\Extensions;

class Hook {

    /**
     * @var array $hooks
     */
    protected $hooks = [];

    /**
     * Listen to a hooks.
     *
     * @param $hook
     * @param null $closure
     * @return $this
     */
    public function listen($hook, $closure = null)
    {
        if ( ! $this->has($hook)) {
            $this->hooks[$hook] = [];
        }

        $this->hooks[$hook][] = $closure;
    }

    /**
     * Check if we have hooks
     *
     * @param $hook
     * @return bool
     */
    public function has($hook)
    {
        return isset($this->hooks[$hook]);
    }
    
    /**
     * Fire a hook.
     *
     * @param $hook
     * @param string $result
     * @return mixed|string
     */
    public function fire($hook, &$result = '')
    {
        if ( ! isset($this->hooks[$hook])) return $result;

        foreach($this->hooks[$hook] as $closure) {
            $callResult = $closure($result);

            if ($callResult !== false) {
                $result = $callResult;
            }
        }

        return $result;
    }

}
