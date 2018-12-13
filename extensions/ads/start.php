<?php

use Illuminate\Routing\Router;
use Smile\Core\Extensions\Extension;

class AdsExtension extends Extension {

    public $settingsRoute = 'admin.extensions.ads.settings';

    public function register()
    {
        $this->routes(function (Router $router) {
            $router->get('admin/extensions/ads/settings', [
                'uses' => 'SettingsController@form',
                'as' => 'admin.extensions.ads.settings'
            ]);
            $router->post('admin/extensions/ads/settings', 'SettingsController@store');

            $router->post('status', [
                'uses' => 'SettingsController@status',
                'as'   => 'admin.extensions.ads.settings.status'
            ]);
            $router->post('upload', [
                'uses' => 'SettingsController@upload',
                'as'   => 'admin.extensions.ads.settings.upload'
            ], 'admin/extensions/ads/settings');
        });

        require __DIR__.'/helpers.php';
    }

    public function boot()
    {
        register_widget('post.after', [$this, 'rectangleAd']);
        register_widget('right-sidebar.before', [$this, 'squareAd']);
        register_widget('right-sidebar.after', [$this, 'squareAd']);
    }

    /**
     * Generate rectangle ad
     *
     * @return \Illuminate\View\View
     */
    public function rectangleAd()
    {
        return view('ext-ads::rectangle-add');
    }

    /**
     * Generate square ad from sidebars
     *
     * @return \Illuminate\View\View
     */
    public function squareAd()
    {
        return view('ext-ads::square-add');
    }
}
