<?php

namespace Themes\Installer;

use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['router']->group(['namespace' => 'Themes\Installer\Http\Controllers'], function ($router) {
            require __DIR__.'/Http/routes.php';
        });
        require __DIR__.'/helpers.php';
    }

    public function boot()
    {
        //
    }

}
