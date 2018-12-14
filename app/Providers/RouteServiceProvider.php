<?php

namespace Smile\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{

    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Smile\Http\Controllers';

    /**
     * @var string
     */
    protected $installerNamespace = 'Smile\Http\Controllers\Installer';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //
        parent::boot();

        Route::bind('post', function ($value) {
            $postRepo = $this->app->make('Smile\Core\Persistence\Repositories\PostContract');
            return $postRepo->findWithRelationships($value, auth()->user()) ?? abort(404);
        });

        Route::bind('user', function ($value) {
            $userService = $this->app->make('Smile\Core\Services\UserService');
            return $userService->getByName($value) ?? abort(404);
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        if (INSTALLED) {
            $this->mapApiRoutes();
        } else {
            $this->mapInstallerRoutes();
        }
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    protected function mapInstallerRoutes()
    {
        Route::namespace($this->installerNamespace)
            ->middleware('web')
            ->group(base_path('routes/installer.php'));
    }
}
