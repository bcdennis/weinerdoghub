<?php namespace Smile\Providers;

use Illuminate\Support\ServiceProvider;
use Smile\Core\Extensions\ExtensionsServiceProvider;
use Smile\Core\Providers\BridgeServiceProvider;
use Smile\Core\Providers\SmileServiceProvider;
use Smile\Core\Providers\StartServiceProvider;
use Smile\Core\Themes\ThemeServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     * "Registrar" implementation here. You can add your own bindings too!
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(new StartServiceProvider($this->app));
        $this->app->register(new SmileServiceProvider($this->app));
        $this->app->register(new EventServiceProvider($this->app));
        $this->app->register(new RouteServiceProvider($this->app));

        $this->app->register(new ExtensionsServiceProvider($this->app));
        $this->app->register(new BridgeServiceProvider($this->app));

        $this->app->register(new ThemeServiceProvider($this->app));
    }
}
