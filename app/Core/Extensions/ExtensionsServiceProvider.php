<?php
namespace Smile\Core\Extensions;

use Illuminate\Support\ServiceProvider;

class ExtensionsServiceProvider extends ServiceProvider
{
    /**
     * Extensions manager
     *
     * @var Manager
     */
    protected $manager;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    	if ( ! INSTALLED) {
    		return;
    	}

        $this->app->singleton('extensions.hook', function ($app) {
            return new Hook();
        });

        $this->app->singleton('extensions.manager', function ($app) {
            $settings = 'IonutMilica\LaravelSettings\SettingsContract';
            return new Manager($app['files'], $app[$settings], $app, base_path('extensions'));
        });

        $this->app->singleton('extensions.widgets', function ($app) {
            return new WidgetContainer();
        });

        $this->manager = $this->app['extensions.manager'];
        $this->manager->loadExtensions();
        $this->manager->register();

        require __DIR__ . '/helpers.php';
        require __DIR__ . '/routes.php';

    }

    /**
     * Boot all the extensions
     */
    public function boot()
    {
    	if ( ! INSTALLED) {
    		return;
    	}

        $bladeCompiler = $this->app['view']->getEngineResolver()->resolve('blade')->getCompiler();

        $bladeCompiler->extend(function ($view, $compiler) {
            $pattern = $compiler->createMatcher('widget');

            return preg_replace($pattern, '<?php echo render_widget$2; ?>', $view);
        });

        $this->manager->boot();
    }

}
