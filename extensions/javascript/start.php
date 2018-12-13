<?php

use Illuminate\Routing\Router;
use Smile\Core\Extensions\Extension;

class JavascriptExtension extends Extension {

    public $settingsRoute = 'admin.extensions.javascript.settings';

    public function register()
    {
        $this->routes(function (Router $router) {
            $router->get('admin/extensions/javascript/settings', [
                'uses' => 'SettingsController@form',
                'as' => 'admin.extensions.javascript.settings'
            ]);
            $router->post('admin/extensions/javascript/settings', 'SettingsController@store');
        });
    }

    public function boot()
    {
        register_widget('js-section', function () {
            return view('ext-javascript::javascript');
        });
    }

    /**
     * On uninstall make a force deletion over the style setting
     */
    public function onUninstall()
    {
        setting_forget('javascript');
    }

}
