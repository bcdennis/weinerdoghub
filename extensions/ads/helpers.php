<?php

/**
 * Generate rectangle ad
 *
 * @return \Illuminate\Foundation\Application|mixed|string
 */
function generateRectangleAd()
{
    if (setting('rectangle-ad-image', false)) {
        return '<img src="'.media(setting('rectangle-ad-image')).'" alt="."/>';
    }

    if (setting('rectangle-ad-code', false)) {
        return setting('rectangle-ad-code');
    }

    return '<img src="'.assetTheme('assets/img/ad-rect.png').'" alt=".">';
}

/**
 * Generate square ad
 *
 * @return \Illuminate\Foundation\Application|mixed|string
 */
function generateSquareAd()
{
    if (setting('square-ad-image', false)) {
        return '<img src="'.media(setting('square-ad-image')).'" alt="."/>';
    }

    if (setting('square-ad-code', false)) {
        return setting('square-ad-code');
    }

    return '<img src="'.assetTheme('assets/img/ad-square.png').'" alt=".">';
}