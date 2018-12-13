<?php

use Smile\Core\Extensions\Hook;

/**
 * Get extension object
 *
 * @param null $name
 * @return \Illuminate\Foundation\Application|mixed
 */
function extensions($name = null)
{
    if (is_null($name)) {
        return app('extensions.manager');
    }

    return app('extensions.manager')->get($name);
}

/**
 * Asset
 *
 * @param $asset
 * @param $extension
 * @return string
 */
function assetExtension($asset, $extension)
{
    return asset('extensions/'.$extension.'/'.$asset);
}

/**
 *
 *
 * @param null $name
 * @param null $result
 * @return Hook
 */
function hook($name = null, &$result = null)
{
    if ($name == null) {
        return app('extensions.hook');
    }

    return app('extensions.hook')->fire($name, $result);
}

/**
 * Render widget
 *
 * @param $section
 * @param array $data
 */
function render_widget($section, array $data = [])
{
    return app('extensions.widgets')->render($section, $data);
}

/**
 * Register widget
 *
 * @param $section
 * @param $view
 * @param int $priority
 * @return \Illuminate\Support\ServiceProvider
 */
function register_widget($section, $view, $priority = 0)
{
    return app('extensions.widgets')->register($section, $view, $priority);
}
