<?php

namespace Smile\Core\Extensions;

use IonutMilica\LaravelSettings\SettingsContract;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;

class Manager
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var SettingsContract
     */
    private $settings;

    /**
     * @var array
     */
    protected $extensions;

    /**
     * @var
     */
    protected $path;

    /**
     * @var Application
     */
    protected $app;

    /**
     * PSR4 loader
     *
     * @var mixed
     */
    protected $loader;

    /**
     * @param Filesystem $filesystem
     * @param SettingsContract $settings
     * @param Application $app
     * @param $path
     */
    public function __construct(Filesystem $filesystem, SettingsContract $settings, Application $app, $path)
    {
        $this->filesystem = $filesystem;
        $this->settings = $settings;
        $this->extensions = new Collection();
        $this->path = $path;
        $this->app = $app;
        $this->loader = require base_path('vendor/autoload.php');
    }

    /**
     * Load extensions in memory
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function loadExtensions()
    {
        $extensions = $this->filesystem->directories($this->path);

        foreach ($extensions as $extension) {
            $name = basename($extension);
            $class = $this->extensionClass($name);

            $this->filesystem->getRequire($extension.'/start.php');
            $extensionInstance = new $class($this->app, $extension, $name);

            if (in_array($name, $this->settings->get('extensions.activated', []))) {
                $extensionInstance->setActive();
            }

            if (in_array($name, $this->settings->get('extensions.installed', []))) {
                $extensionInstance->setInstalled();
            }

            $this->extensions->push($extensionInstance);
        }
    }

    /**
     * Get extension by name
     *
     * @param $name
     * @return Extension|null
     */
    public function findByName($name)
    {
        return $this->extensions->first(function ($idx, Extension $item) use ($name) {
            return $item->getName() == $name;
        });
    }

    /**
     * Register all the modules that has been activated
     */
    public function register()
    {
        foreach ($this->installed() as $module) {
            $this->loader->setPsr4($module->getNamespace(), $module->getSourcePath());
            $module->register();
        }
    }

    /**
     * Boot all the modules that have been activated
     */
    public function boot()
    {
        foreach ($this->installed() as $module) {
            if ($module->isActive()) {
                $module->boot();
            }
            $module->loadResources();
        }
    }

    /**
     * Get active extensions
     *
     * @return Collection|Extension[]
     */
    public function active()
    {
        return $this->extensions->filter(function (Extension $item) {
            return $item->isActive();
        });
    }

    /**
     * Get installed modules
     *
     * @return Collection|Extension[]
     */
    public function installed()
    {
        return $this->extensions->filter(function (Extension $item) {
            return $item->isInstalled();
        });
    }

    /**
     * Get all extensions
     *
     * @return Collection|Extension[]
     */
    public function all()
    {
        return $this->extensions;
    }

    /**
     * Activate extension
     *
     * @param Extension $extension
     */
    public function activate(Extension $extension)
    {
        $extensions = $this->settings->get('extensions.activated', []);
        $extensions[] = $extension->getName();

        $extension->setActive();
        $extension->onActivate();

        $this->settings->set('extensions.activated', $extensions);
    }

    /**
     * Deactivate extension
     *
     * @param Extension $extension
     */
    public function deactivate(Extension $extension)
    {
        $extensions = $this->settings->get('extensions.activated', []);

        $extension->setActive(false);
        $extension->onDeactivate();

        if (($key = array_search($extension->getName(), $extensions)) !== false) {
            unset($extensions[$key]);
        }

        $this->settings->set('extensions.activated', $extensions);
    }

    /**
     * Install the extension
     *
     * @param Extension $extension
     */
    public function install(Extension $extension)
    {
        $extensions = $this->settings->get('extensions.installed', []);
        $extensions[] = $extension->getName();

        $extension->publish();
        $extension->onInstall();

        $this->settings->set('extensions.installed', $extensions);
    }
    /**
     * Uninstall extension
     *
     * @param Extension $extension
     */
    public function uninstall(Extension $extension)
    {
        $extensions = $this->settings->get('extensions.installed', []);
        $activeExtensions = $this->settings->get('extensions.activated', []);

        $extension->unpublish();
        $extension->onUninstall();

        if (($key = array_search($extension->getName(), $extensions)) !== false) {
            unset($extensions[$key]);
        }
        if (($key = array_search($extension->getName(), $activeExtensions)) !== false) {
            unset($activeExtensions[$key]);
        }

        $this->settings->set('extensions.installed', $extensions);
        $this->settings->set('extensions.activated', $extensions);
    }

    /**
     * Change extension name to valid class
     *
     * @param $name
     * @return mixed
     */
    protected function extensionClass($name)
    {
        return studly_case($name.'-extension');
    }

}
