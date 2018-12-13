<?php

namespace Smile\Core\Themes;

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
        $this->app->singleton('themes.manager', function ($app) {
            return $app->make('Smile\Core\Themes\ThemeManager');
        });

        if (INSTALLED) {
            $this->app['themes.manager']->activate('admin');
            $this->app['themes.manager']->activate('site');
        } else {
            $this->app['config']->set('app.debug', true);
            $this->app['themes.manager']->activate('installer');
        }
    }

    public function boot()
    {
        $manager = $this->app['themes.manager'];

        foreach ($manager->getActiveThemes() as $theme) {
            $this->registerResources($theme);
        }
    }

    /**
     * Register resources for a specific theme
     *
     * @param Theme $theme
     */
    public function registerResources(Theme $theme)
    {
        $this->loadViewsFrom($theme->getPath().'/resources/views/', $theme->getName());
        $this->loadTranslationsFrom($theme->getPath().'/resources/lang/', $theme->getName());
    }
}
