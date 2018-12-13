<?php
namespace Smile\Core\Providers;

use Illuminate\Support\ServiceProvider;

class StartServiceProvider extends ServiceProvider {

    /**
     * Register any application services.
     */
    public function register()
    {
        if (defined('SHARED_HOST')) {
            $this->app['path.public'] = base_path() . '/../'.smile_getBaseDir();
        }
    }

    public function boot()
    {
        $this->app['config']->set('filesystems.disks.local.root', public_path());
    }
}

if (defined('SHARED_HOST')) {
    /**
     * Override public path
     *
     * @param string $path
     * @return string
     */
    function public_path($path = '')
    {
        return base_path() . '/../'.smile_getBaseDir(). ($path ? '/' . $path : $path);
    }
}

function smile_getBaseDir() {
    return trim(basename(dirname($_SERVER['SCRIPT_FILENAME'])), '/');
}
