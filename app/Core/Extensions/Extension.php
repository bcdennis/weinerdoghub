<?php
namespace Smile\Core\Extensions;

use Illuminate\Foundation\Application;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

abstract class Extension extends ServiceProvider
{
    /**
     * Extension path
     *
     * @var string
     */
    protected $path;

    /**
     * Extension name
     *
     * @var string
     */
    protected $name;

    /**
     * We must know if the given extension si activated
     *
     * @var bool
     */
    protected $isActive = false;

    /**
     * Let module know if it's installed
     *
     * @var bool
     */
    protected $isInstalled = false;

    /**
     * Every extension will have information about author, version and so on
     *
     * @var array
     */
    protected $manifest = null;

    /**
     * Check if extension has setting page
     *
     * @var bool
     */
    public $settingsRoute = false;

    /**
     * @param $path string
     * @param $name
     * @param Application $app
     */
    public function __construct(Application $app, $path, $name)
    {
        parent::__construct($app);

        $this->path = $path;
        $this->name = $name;

        $this->loadManifest();
    }

    /**
     * Get extension name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get extension path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Get extension path to the source code
     *
     * @return string
     */
    public function getSourcePath()
    {
        return $this->getPath().'/src/';
    }

    /**
     * Method called on app booting
     */
    public function boot() {}

    /**
     * Method called on service register
     */
    public function register() {}

    /**
     * Things we do on module installation
     */
    public function onInstall() {}

    /**
     * Things we do on module uninstall
     */
    public function onUninstall() {}

    /**
     * Method called on module install
     */
    public function onActivate() {}

    /**
     * Method called on module uninstall
     */
    public function onDeactivate() {}

    /**
     * Set extension active or no
     *
     * @param bool $val
     * @return bool
     */
    public function setActive($val = true)
    {
        return $this->isActive = $val;
    }

    /**
     * Check if extension is active
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->isActive;
    }

    /**
     * Set the extension state to 'Installed' or not
     *
     * @param bool $val
     * @return bool
     */
    public function setInstalled($val = true)
    {
        return $this->isInstalled = $val;
    }

    /**
     * Check if the module is installed
     *
     * @return bool
     */
    public function isInstalled()
    {
        return $this->isInstalled;
    }

    /**
     * Get extension manifest info
     *
     * @return array
     */
    public function manifest()
    {
        return $this->manifest;
    }

    /**
     * Load resources for the module
     *
     */
    public function loadResources()
    {
        $this->loadViewsFrom($this->path.'/resources/views/', 'ext-'.$this->getName());
        $this->loadTranslationsFrom($this->path.'/resources/lang/', $this->getName());
    }

    /**
     * Source path for assets
     *
     * @return string
     */
    public function assetsFromSource()
    {
        return $this->path.'/resources/assets';
    }

    /**
     * Public path for the assets
     *
     * @return string
     */
    public function assetsFromPublic()
    {
        return public_path('extensions/'.$this->getName().'/assets');
    }

    /**
     * Publish assets
     */
    public function publish()
    {
        $this->publishes([
            $this->assetsFromSource() => $this->assetsFromPublic()
        ], $this->getName());

        \Artisan::call('vendor:publish', ['--tag' => $this->getName(), '--force' => true]);
    }

    /**
     * Unpublish assets
     */
    public function unpublish()
    {
        $dir = public_path('extensions/'.$this->getName());

        if (is_dir($dir)) {
            $this->app['files']->deleteDirectory($dir);
        }
    }

    /**
     * Return the module name in a proper format for using in namespace/autoloading
     *
     * @return string
     */
    public function getFormatedName()
    {
        return studly_case($this->getName());
    }

    /**
     * Register namespace
     *
     * @return string
     */
    public function getNamespace()
    {
        return 'Extensions\\'.$this->getFormatedName().'\\';
    }

    /**
     * Load extension data
     */
    protected function loadManifest()
    {
        if ($this->manifest) {
            return;
        }

        $this->manifest = json_decode(file_get_contents($this->path.'/info.json'));
    }

    /**
     * Get router object
     *
     * @return Router
     */
    protected function router()
    {
        return $this->app['router'];
    }

    /**
     * Register routes in the current namespace
     *
     * @param callable $callback
     * @param string $prefix
     */
    protected function routes(callable $callback, $prefix = '')
    {
        $this->router()->group(['namespace' => $this->getNamespace().'Http\Controllers', 'prefix' => $prefix], $callback);
    }

    /**
     * Register repositories
     *
     * @param array $repositories
     * @param string $driver
     */
    protected function repositories(array $repositories, $driver = 'Eloquent')
    {
        foreach ($repositories as $repository) {
            $this->app->bind(
                sprintf('Extensions\%s\Repositories\%sContract', $this->getFormatedName(), $repository),
                sprintf('Extensions\%s\Repositories\%s\%sRepository', $this->getFormatedName(), $driver, $repository)
            );
        }
    }

}
