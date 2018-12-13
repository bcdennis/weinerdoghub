<?php

use Illuminate\Routing\Router;
use Smile\Core\Extensions\Extension;

class StyleExtension extends Extension {

    public $settingsRoute = 'admin.extensions.style.settings';

    public function register()
    {
        $this->routes(function (Router $router) {
            $router->get('admin/extensions/style/settings', [
                'uses' => 'SettingsController@form',
                'as' => 'admin.extensions.style.settings'
            ]);
            $router->post('admin/extensions/style/settings', 'SettingsController@store');
        });
    }

    public function boot()
    {
        register_widget('css-section', function () {
            return view('ext-style::style');
        });
    }

    /**
     * On uninstall make a force deletion over the style setting
     */
    public function onUninstall()
    {
        setting_forget('style.css');
    }

}
