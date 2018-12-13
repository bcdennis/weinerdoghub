<?php

use Illuminate\Support\Str;

if ( ! function_exists('utf8_strrev')) {
    /**
     * Reverse a string regardless of the charset
     *
     * @param $str
     * @return string
     */
    function mb_strrev($str)
    {
        preg_match_all('/./us', $str, $ar);

        return implode(array_reverse($ar[0]));
    }
}


/**
 * Path to the theme
 *
 * @param $resource
 * @param null $theme
 * @return string
 */
function assetTheme($resource, $theme = null)
{
    $path = 'themes/' . ($theme ?: config('smile.theme'));

    return asset($path.'/'.$resource);
}

/**
 * Admin theme
 *
 * @param $resource
 * @param null $theme
 * @return string
 */
function adminTheme($resource, $theme = null)
{
    $path = 'themes/' . ($theme ?: config('smile.adminTheme'));

    return asset($path . '/' . $resource);
}


/**
 * View for the current theme
 *
 * @param $view
 * @param array $data
 * @return \Illuminate\View\View
 */
function themeView($view, array $data = [])
{
    return view(config('smile.theme').'::'.$view, $data);
}


/**
 * Format number
 *
 * @param $n
 * @return string
 */
function formatNumber($n)
{
    $value = $n;
    $unit = '';

    if($n > 1000000000000) {
        $value = $n / 1000000000000;
        $unit = 'T';
    }
    else if($n > 1000000000) {
        $value = $n / 1000000000;
        $unit = 'B';
    }
    else if($n > 1000000) {
        $value = $n / 1000000;
        $unit = 'M';
    }
    else if($n >= 10000) {
        $value = $n / 1000;
        $unit = 'K';
    }

    if (((int) $value) == $value) {
        return number_format($value).$unit;
    }

    return number_format($value, 1).$unit;
}

/**
 * Get languages
 *
 * @return array
 */
function languages()
{
    static $langs;

    if ($langs != null) {
        return $langs;
    }

    $languages = glob(base_path('themes/'.config('smile.theme').'/resources/lang/*'));

    $langs = [];

    foreach ($languages as $lang) {
        $langs[] = basename($lang);
    }

    return $langs;
}

/**
 * Validate languages
 *
 * @return string
 */
function validateLangs()
{
    return implode(',', languages());
}

/**
 * Get real media path
 *
 * @param $media
 * @return string
 */
function media($media)
{
    if (stripos($media, 'http') !== false) {
        return $media;
    }
    foreach (event('media_url', $media) as $result) {
        if ($result && $media != $result) {
            return $result;
        }
    }

    return asset($media);
}

/**
 * Get current user permission
 *
 * @param null $is
 * @return string
 */
function perm($is = null)
{
    $user = auth()->user();

    $perm = $user ? $user->permission : 'guest';

    if ( ! is_null($is)) {
        return $is == $perm;
    }

    return $perm;
}


/**
 * Translate current theme
 *
 * @param null $id
 * @param array $parameters
 * @param string $domain
 * @param null $locale
 * @return string
 */
function __($id = null, $parameters = array(), $domain = 'messages', $locale = null)
{
    $theme = config('smile.theme');

    return trans($theme.'::smile.'.$id, $parameters, $domain, $locale);
}

/**
 * Language choice
 *
 * @param $id
 * @param $number
 * @param array $parameters
 * @param string $domain
 * @param null $locale
 * @return string
 */
function __choice($id, $number, array $parameters = array(), $domain = 'messages', $locale = null)
{
    $theme = config('smile.theme');

    return trans_choice($theme.'::smile.'.$id, $number, $parameters, $domain, $locale);
}

/**
 * Title
 *
 * @param $title
 * @return string
 */
function title($title)
{
    return Str::title($title);
}

/**
 * Strtolower utf8
 *
 * @param $title
 * @return string
 */
function lower($title)
{
    return Str::lower($title);
}

/**
 * Strtoupper utf8
 *
 * @param $title
 * @return string
 */
function upper($title)
{
    return Str::upper($title);
}

if ( ! function_exists('curl_reset')) {
    /**
     * Curl reset for php 5.4
     *
     * @param $ch
     */
    function curl_reset($ch)
    {
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_POST, false);
    }
}
