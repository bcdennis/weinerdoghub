<?php

namespace Smile\Core\Themes;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;

class ThemeManager
{
    /**
     * All available themes
     *
     * @var array
     */
    private $themes = null;

    /**
     * All the active themes like default site, admin
     *
     * @var array
     */
    private $activeThemes = [];

    /**
     * Root path to the themes
     *
     * @var string
     */
    private $path;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * Composer autoloader
     *
     * @var
     */
    private $loader = null;
    /**
     * @var Application
     */
    private $app;

    /**
     * ThemeManager constructor.
     * @param Filesystem $filesystem
     * @param Application $app
     */
    public function __construct(Filesystem $filesystem, Application $app)
    {
        $this->path = base_path('themes');
        $this->filesystem = $filesystem;
        $this->app = $app;

        $this->loadThemes();
    }

    /**
     * Activate a specific theme
     *
     * @param $name
     * @return bool
     */
    public function activate($name)
    {
        if (!isset($this->themes[$name])) {
            return false;
        }

        $theme = new Theme($this->path, $name);
        $provider = $theme->getServiceProvider();

        $this->loadPsr4($theme->getNamespace(), $theme->getPath().'/src/');
        $this->app->register(new $provider($this->app));

        $this->activeThemes[$name] = $theme;

        return $theme;
    }

    /**
     * Autoload theme classes
     *
     * @param $namespace
     * @param $path
     */
    protected function loadPsr4($namespace, $path)
    {
        if ($this->loader == null) {
            $this->loader = require base_path() . '/vendor/autoload.php';
        }

        $this->loader->setPsr4($namespace . "\\", $path);
    }

    /**
     * Active themes
     *
     * @return mixed
     */
    public function getActiveThemes()
    {
        return $this->activeThemes;
    }

    /**
     * Load in the memory all the available themes
     *
     * @return array
     */
    protected function loadThemes()
    {
        $directories = $this->filesystem->directories($this->path);

        foreach ($directories as $directory) {
            $theme = basename($directory);
            $this->themes[$theme] = $theme;
        }

        return $this->themes;
    }

}
