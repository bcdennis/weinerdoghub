<?php

use Illuminate\Routing\Router;
use Smile\Core\Extensions\Extension;

class AuthExtension extends Extension {

    public $settingsRoute = 'admin.extensions.auth.settings';

    public function register()
    {
        $this->routes(function (Router $router) {
            $router->get('admin/extensions/auth/settings', [
                'uses' => 'SettingsController@form',
                'as' => 'admin.extensions.auth.settings'
            ]);

            $router->post('admin/extensions/auth/facebook', [
                'uses' => 'SettingsController@facebook',
                'as'   => 'admin.extensions.auth.facebook'
            ]);

            $router->post('admin/extensions/auth/google', [
                'uses' => 'SettingsController@google',
                'as'   => 'admin.extensions.auth.google'
            ]);

        });

        require __DIR__.'/helpers.php';
    }

    public function boot()
    {
        $this->oauth();

        register_widget('modal.register.alternative', [$this, 'alternativeView']);
        register_widget('modal.login.alternative', [$this, 'alternativeView']);
    }

    /**
     * View tht contains fb buttons
     *
     * @return \Illuminate\View\View
     */
    public function alternativeView()
    {
        return view('ext-auth::alternative');
    }

    /**
     * Overwrite configuration for oauth providers
     */
    protected function oauth()
    {
        $providers = ['facebook', 'google'];

        foreach ($providers as $provider) {
            $clientId = 'auth.'.$provider.'.client_id';
            $clientSecret = 'auth.'.$provider.'.client_secret';

            if (setting($clientId)) {
                $this->app['config']['services.'.$provider.'.client_id'] = setting($clientId);
            }

            if (setting($clientSecret)) {
                $this->app['config']['services.'.$provider.'.client_secret'] = setting($clientSecret);
            }
        }
    }
}
