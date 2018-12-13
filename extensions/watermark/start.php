<?php

use Illuminate\Routing\Router;
use Smile\Core\Extensions\Extension;

class WatermarkExtension extends Extension {

    public $settingsRoute = 'admin.extensions.watermark.settings';

    public function register()
    {
        $this->routes(function (Router $router) {
            $router->get('admin/extensions/watermark/settings', [
                'uses' => 'SettingsController@form',
                'as' => 'admin.extensions.watermark.settings'
            ]);
            $router->post('admin/extensions/watermark/settings', 'SettingsController@store');
        });
    }

    public function boot()
    {
        $events = $this->app['events'];

        $events->listen('Smile\Events\Post\BeforeMediaUpload', 'Extensions\Watermark\Listeners\AttachWatermark');
    }

}
