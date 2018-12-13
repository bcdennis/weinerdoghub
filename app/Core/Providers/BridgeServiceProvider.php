<?php

namespace Smile\Core\Providers;

use Illuminate\Support\ServiceProvider;

class BridgeServiceProvider extends ServiceProvider
{

    public function boot()
    {
        if (php_sapi_name() == 'cli' || ! INSTALLED) {
            return;
        }

        $this->language();
        $this->captcha();
        $this->email();
        $this->check();
    }

    /**
     * Set language
     */
    public function language()
    {
        $this->app->setLocale(setting('language', 'en'));
    }

    protected function email()
    {
        if ( ! setting('email.driver')) {
            return;
        }

        $this->app['config']['mail.driver'] = setting('email.driver', 'mail');
        $this->app['config']['mail.host'] = setting('email.host');
        $this->app['config']['mail.encryption'] = setting('email.encryption', 'ssl');
        $this->app['config']['mail.username'] = setting('email.user');
        $this->app['config']['mail.password'] = setting('email.pass');
        $this->app['config']['mail.port'] = setting('email.port');
        $this->app['config']['mail.from.address'] = setting('email.sender-email');
        $this->app['config']['mail.from.name'] = setting('email.sender-name');
    }

    /**
     * Overwrite captcha package settings
     */
    protected function captcha()
    {
        if (setting('captcha.key')) {
            $this->app['config']['captcha.sitekey'] = setting('captcha.key');
        }

        if (setting('captcha.secret')) {
            $this->app['config']['captcha.secret'] = setting('captcha.secret');
        }
    }

    protected function check()
    {
        $this->app['Smile\Core\Updater\Manager']->validate();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        if (php_sapi_name() == 'cli' || ! INSTALLED) {
            return;
        }
    }

}