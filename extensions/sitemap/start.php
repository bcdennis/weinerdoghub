<?php

use Illuminate\Routing\Router;
use Smile\Core\Extensions\Extension;

class SitemapExtension extends Extension {

    public $settingsRoute = 'admin.extensions.sitemap.settings';

    public function register()
    {
        $this->app->register(new Roumen\Sitemap\SitemapServiceProvider($this->app));

        $this->routes(function (Router $router) {
            $router->get('admin/extensions/sitemap/settings', [
                'uses' => 'SettingsController@form',
                'as' => 'admin.extensions.sitemap.settings'
            ]);
            $router->post('admin/extensions/sitemap/settings', 'SettingsController@store');
            $router->get('sitemap.xml', 'SitemapController@serve');
        });
    }

    public function boot()
    {
        //
    }

}
