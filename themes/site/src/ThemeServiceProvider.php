<?php

namespace Themes\Site;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{
    private $themeNamespace = 'Themes\Site\Http\Controllers';

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        require __DIR__ . '/helpers.php';
    }

    public function boot()
    {
        Route::middleware('web')
            ->namespace($this->themeNamespace)
            ->group(__DIR__ . '/Http/routes.php');
    }

}
