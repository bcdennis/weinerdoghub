<?php

function userStatus($user)
{
    $label = 'label-primary';
    $labelText = 'Active';

    if ($user->status == 0) {
        $label = 'label-default';
        $labelText = 'Inactive';
    }

    if ($user->blocked) {
        $label = 'label-warning';
        $labelText = 'blocked';
    }

    return sprintf('<span class="label %s">%s</span>', $label, $labelText);

}

/**
 * Admin paginator
 *
 * @param $paginator
 * @return \Themes\Admin\Presenters\PaginationPresenter
 */
function paginator($paginator)
{
    return (new \Themes\Admin\Presenters\PaginationPresenter($paginator))->render();
}

/**
 * Calculate growth rate
 *
 * @param $val1
 * @param $val2
 * @return float
 */
function growthRate($val1, $val2)
{
    if ($val1 == 0 && $val2 == 0) return 0;

    if ($val1 > $val2) {
        if ($val2 == 0) return 100.00;
        return number_format((($val1 - $val2) / $val2) * 100, 2);
    }

    if ($val1 == 0) return -100.00;

    return number_format(-(($val2 - $val1) / $val1) * 100, 2);
}

function chartMonths($data)
{
    $months = [];

    foreach ($data as $item) {
        $months[] = '"'.$item->monthName.'"';
    }

    return '['.implode(',', $months).']';
}

/**
 * Chart data
 *
 * @param $data
 * @return string
 */
function chartData($data)
{
    $dataset = [];

    foreach ($data as $item) {
        $dataset[] = $item->value;
    }

    return '['.implode(',', $dataset).']';
}

/**
 * Set admin link to active or not
 *
 * @param $name
 * @param string $extra
 * @return string
 */
function adminSetActive($name, $extra = '')
{
    $names = explode('|', $name);
    $routeName = Route::currentRouteName();

    foreach ($names as $name) {
        if (stripos($name, '*') !== false) {
            $nameParts = explode('*', $name);

            if (starts_with($routeName, 'admin.'.$nameParts[0])) {
                return 'class="active '.$extra.'"';
            }
        }
        if ($routeName == 'admin.'.$name) {
            return 'class="active '.$extra.'"';
        }
    }

    return $extra !== '' ? 'class="'.$extra.'"' : '';
}

/**
 * Display avatar
 *
 * @param $url
 * @return string
 */
function categoryIcon($url)
{
    return $url ? media($url) : assetTheme('assets/img/categories/default.png');
}
