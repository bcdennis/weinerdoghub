<?php

/**
 * Check if requirement passes
 *
 * @param $requirement
 * @return string
 */
function passes($requirement)
{
    $class = $requirement['ok'] ? 'alert-success' : 'alert-danger';

    return sprintf(' class="%s"', $class);
}

/**
 * Set active acording to the route
 *
 * @param $name
 * @return string
 */
function setStepActive($name)
{
    if (\Route::currentRouteName() == $name) {
        return 'class="active"';
    }
    return '';
}
