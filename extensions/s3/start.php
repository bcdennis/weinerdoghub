<?php

use Illuminate\Routing\Router;
use Smile\Core\Extensions\Extension;

class S3Extension extends Extension {

    public $settingsRoute = 'admin.extensions.s3.settings';

    public function register()
    {
        $this->routes(function (Router $router) {
            $router->get('admin/extensions/s3/settings', [
                'uses' => 'SettingsController@form',
                'as' => 'admin.extensions.s3.settings'
            ]);
            $router->post('admin/extensions/s3/settings', 'SettingsController@store');
        });

        // Don't activate if there are no settings for s3
        if (!setting('extensions.s3.secret', false)) {
            return;
        }

        $this->app['config']['filesystems.default'] = 's3';
        $this->app['config']['filesystems.disks.s3.key'] = setting('extensions.s3.key');
        $this->app['config']['filesystems.disks.s3.secret'] = setting('extensions.s3.secret');
        $this->app['config']['filesystems.disks.s3.region'] = setting('extensions.s3.region');
        $this->app['config']['filesystems.disks.s3.bucket'] = setting('extensions.s3.bucket');
    }

    public function boot()
    {
        // Don't activate if there are no settings for s3
        if (!setting('extensions.s3.secret', false)) {
            return;
        }

        $this->app['events']->listen('media_url', function ($media) {
            return trim(setting('extensions.s3.url'), '/') . '/' . trim($media, '/');
        });
    }

}
